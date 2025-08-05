<?php

namespace App\Services;

use CodeIgniter\Database\BaseConnection;
use Config\Database;
use App\Services\WorkOrderService; 

class WorkOrderService
{
    protected BaseConnection $db;

    public function __construct()
    {
        $this->db = Database::connect('visual_cache');
    }

    /**
     * Return main workorders (sub_id = 0) with status flag based on all sub_ids.
     * Default is 'Ready', overridden by worse states.
     */
    public function getOpenWorkOrders(array $resourceIds = []): array
    {
        $resourceFilterCTE = '';
        $resourceFilterExists = '';
    
        if (!empty($resourceIds)) {
            $escaped = array_map([$this->db, 'escape'], $resourceIds);
            $inList = implode(',', $escaped);
    
            // 1. Restrict ops in CTE
            $resourceFilterCTE = "AND op.resource_id IN ($inList)";
    
            // 2. Ensure base_id has qualifying ops
            $resourceFilterExists = "AND EXISTS (
                SELECT 1
                FROM operations_cache op
                WHERE op.base_id = wo.base_id
                AND op.resource_id IN ($inList)
            )";
        }
    
        $sql = "
            WITH req_flags AS (
                SELECT
                    wo.base_id,
                    MIN(
                        CASE
                            WHEN (COALESCE(r.calc_qty, 0) - COALESCE(r.issued_qty, 0) - COALESCE(r.qty_on_hand, 0) - COALESCE(r.qty_on_order, 0)) > 0
                             AND (r.planner_id IS NULL OR r.planner_id NOT IN ('W', 'C', 'M' ))
                                THEN 1 -- Deficiency
                            WHEN (COALESCE(r.issued_qty, 0) < COALESCE(r.calc_qty, 0)
                                AND COALESCE(r.qty_on_hand, 0) < (COALESCE(r.calc_qty, 0) - COALESCE(r.issued_qty, 0))
                                AND COALESCE(r.qty_on_order, 0) > 0)
                                THEN 2 -- On Order
                            WHEN (COALESCE(r.issued_qty, 0) < COALESCE(r.calc_qty, 0)
                                AND COALESCE(r.qty_on_hand, 0) >= (COALESCE(r.calc_qty, 0) - COALESCE(r.issued_qty, 0)))
                                THEN 3 -- Needs Issued
                            ELSE 4 -- Ready
                        END
                    ) AS min_priority
                FROM workorder_cache wo
                LEFT JOIN operations_cache op
                    ON wo.base_id = op.base_id AND wo.sub_id = op.sub_id
                    $resourceFilterCTE
                LEFT JOIN requirements_cache r
                    ON op.base_id = r.base_id AND op.sub_id = r.sub_id AND op.sequence_no = r.seq_no
                GROUP BY wo.base_id
            )
            SELECT
                wo.*,
                CASE reqs.min_priority
                    WHEN 1 THEN 'Deficient'
                    WHEN 2 THEN 'On Order'
                    WHEN 3 THEN 'Needs Issued'
                    WHEN 4 THEN 'Ready'
                    ELSE 'Ready'
                END AS wo_status
            FROM workorder_cache wo
            LEFT JOIN req_flags reqs ON reqs.base_id = wo.base_id
            WHERE (wo.sub_id = 0 OR wo.sub_id IS NULL)
            $resourceFilterExists
            ORDER BY reqs.min_priority, wo.base_id
        ";
    
        return $this->db->query($sql)->getResult();
    }
    
    public function getWorkOrderDetails(string $id = null, array $resourceIds = []): object
    {
        $colors = [
            'Deficient'     => 'table-danger',
            'On Order'      => 'table-primary',
            'Needs Issued'  => 'table-warning',
            'Ready'         => 'table-green',
            'Issued'        => 'table-lime'
        ];
    
        $db = \Config\Database::connect('visual_cache');
    
        // Get workorder base/sub/seq from ID
        $wo = $db->query("SELECT * FROM workorder_cache WHERE id = '$id'")->getResult();
    
        if (empty($wo)) {
            throw new \RuntimeException("Workorder not found");
        }
    
        foreach ($wo as $item) {
            // Escape and quote each resourceId for use in SQL IN clause
            $escapedIds = array_map(function ($id) use ($db) {
                return $db->escape($id);
            }, $resourceIds);
    
            $inClause = implode(',', $escapedIds);
    
            // Query operations for all matching resourceIds

            if(count($resourceIds) > 0 )
            {
                $item->operations = $db->query("
                SELECT * 
                FROM operations_cache 
                WHERE base_id = '$item->base_id' AND resource_id IN ($inClause)")->getResult();
            }else{
                $item->operations = $db->query("
                SELECT * 
                FROM operations_cache 
                WHERE base_id = '$item->base_id'")->getResult();
            }

    
            foreach ($item->operations as $op) {
                $op->has_service = ($op->resource_id === 'SERVICE');
    
                $op->requirements = $db->query("
                    SELECT * 
                    FROM requirements_cache 
                    WHERE base_id = '$op->base_id' AND sub_id = '$op->sub_id' AND seq_no = '$op->sequence_no'")->getResult();

                // $remoteModel = new SqlbaseModel(); 

                // $op->requirements = $remoteModel->getData('http://vatap/mvc/public/api/getrequirements/'.$item->base_id.'/'.$op->sub_id.'/'.$op->sequence_no ); 
    
                foreach ($op->requirements as &$row) {
                    $issued   = (float) $row->issued_qty;
                    $on_hand  = (float) $row->qty_on_hand;
                    $on_order = (float) $row->qty_on_order;
                    $required = (float) $row->calc_qty;
    
                    if (($issued + $on_hand + $on_order) < $required) {
                        if( $row->planner_id === 'W' || $row->planner_id === 'C' || $row->planner_id === 'M') {
                            $status = "Ready"; 
                        }else{
                            $status = 'Deficient';
                        }
                    } elseif ($issued < $required && $on_hand >= ($required - $issued)) {
                        $status = 'Needs Issued';
                    } elseif ($issued < $required && $on_hand < ($required - $issued) && $on_order > 0) {
                        $status = 'On Order';
                    } elseif ($issued >= $required) {
                        $status = 'Issued';
                    }  else {
                        $status = 'Unknown';
                    }
    
                    $row->wo_status = $status;
                    $row->text_color = $colors[$status] ?? 'text-muted';
                }
            }
        }
    
        return $wo[0];
    }

    public function getGroupedRequirementsByWorkOrder(string $plannerId = 'M'): array
    {
        $wos = $this->db->query("SELECT * FROM workorder_cache WHERE sub_id = '0'")->getResult();

        return $wos; 

        
        $sql = "
            SELECT 
                base_id,
                sub_id,
                part_id,
                description,
                planner_id,
                qty_per,
                issued_qty,
                calc_qty,
                qty_on_hand,
                qty_on_order,
                status,
                piece_no
            FROM requirements_cache
            WHERE status = 'R' 
        ";
    
        if ($plannerId !== null) {
            $sql .= " AND planner_id = '$plannerId'";
        }
    
        $sql .= " ORDER BY base_id, sub_id, seq_no";
        $results = $this->db->query($sql)->getResult();
        //return $results = $this->db->query($sql)->getResult();
    
        // Group by base_id-sub_id
        $grouped = array();
    
        foreach ($results as $row) {
            $key = $row->base_id;
            if (!isset($grouped[$key])) {
                $grouped[$key] = array();
            }
            $grouped[$key][] = $row;
        }
    
        return $grouped;
    }
    

    
}
