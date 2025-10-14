<?php

namespace App\Models;

use CodeIgniter\Model;

class ServiceTicketModel extends Model
{
    protected $table            = 'tbl_service_tickets';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id', 
        'type', 
        'title', 
        'description', 
        'need_date', 
        'priority', 
        //'status',
        'reference_id',
        'num_of_updates',  
        'work_performed', 
        'first_name', 
        'last_name',
        'email', 
        'closed_by', 
        'dept_id', 
        'updated_by', 
        'created_by', 
        'assigned_to', 
        'created_at', 
        'updated_at', 
        'deleted_at'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    public function getPerformance($type, $start_date, $end_date)
    {
               
        $today = (new \DateTime())->format('Y-m-d'); 

        $end_date = (!isset($end_date)) ? new \DateTime() : new \DateTime($end_date); 
        $end_date = $end_date->format('Y-m-d');
        $start_date = (!isset($start_date) ) ? (new \DateTime())->modify('-90 days') : new \DateTime($start_date) ; 
        $start_date = $start_date->format('Y-m-d'); 

        $tickets = $this
            ->where('type', $type)
            ->where("created_at BETWEEN '{$start_date}' AND '{$end_date}'")
            ->withDeleted()
            ->findAll(); 

        $total = count($tickets); 
        $total_on_time = 0; 
        $total_early = 0;
        $total_late = 0; 
        $total_not_due = 0; 

        foreach ($tickets as $ticket) {
            $expected_date = (new \DateTime($ticket->need_date))->format('Y-m-d');
            $completed_date = $ticket->deleted_at ? (new \DateTime($ticket->deleted_at))->format('Y-m-d') : null;

            if ($completed_date) {
                // Completed: check if on time or late
                if ($completed_date <= $expected_date) {
                    $total_on_time++;
                } else {
                    $total_late++;
                }
            } elseif ($expected_date > $today) {
                // Not Due: due in the future, not completed
                $total_not_due++;
            } else {
                // Not completed and due date has passed or is today: late
                $total_late++;
            }
        }

        $hasData = ($total_on_time + $total_late + $total_not_due ) > 0; 
        return [
            'hasData' => $hasData, 

            'end_date' => $end_date,
            'start_date' => $start_date,
            //'tickets' => $tickets,
            'message'   => $hasData ? '' : 'No data available', 
            'labels' => ['On Time', 'Late', 'Not Due'],
            'datasetLabel' => "Performace {$start_date} - {$end_date}",
            'data' => [$total_on_time, $total_late, $total_not_due],
            'backgroundColor'  => ['#3396D3','#EBCB90', '#9ECAD6'],
            'total' => $total,
            'percentage_on_time' => $total != 0 ? ($total_on_time / $total ) * 100 : 0,
        ];
    }

    public function getTotalTickets($type="maintenance")
    {
        //$model = new ServiceTicketModel();
        $monthlyData = [];
        $months = [];
        $counts = [];
        
        // Get last 3 months
        for ($i = 2; $i >= 0; $i--) {
            $date = new \DateTime();
            $date->sub(new \DateInterval('P' . $i . 'M'));
            
            // Get start and end of month
            $startOfMonth = clone $date;
            $startOfMonth->modify('first day of this month')->setTime(0, 0, 0);
            
            $endOfMonth = clone $date;
            $endOfMonth->modify('last day of this month')->setTime(23, 59, 59);
            
            // Query tickets for this month
            $ticketCount = $this
                ->where('type', $type)
                ->where('created_at >=', $startOfMonth->format('Y-m-d H:i:s'))
                ->where('created_at <=', $endOfMonth->format('Y-m-d H:i:s'))
                ->withDeleted()
                ->countAllResults();
            
            $months[] = $date->format('M'); // Short month name (Jan, Feb, etc.)
            $counts[] = $ticketCount;
        }
        
        $hasData = array_sum($counts) > 0;
        
        return [
            'hasData' => $hasData,
            'message' => $hasData ? '' : 'No tickets found for the last 3 months',
            'labels' => array_reverse($months),
            'data' => array_reverse($counts),
            'backgroundColor' => ['#AADEA7', '#64C2A6', '#2D87BB']
        ];       
    }

}
