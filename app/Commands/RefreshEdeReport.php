<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\EdeReportModel; 
use App\Models\SqlbaseModel; 

class RefreshEdeReport extends BaseCommand
{
    /**
     * The Command's Group
     *
     * @var string
     */
    protected $group = 'Custom';

    /**
     * The Command's Name
     *
     * @var string
     */
    protected $name = 'refresh:edereport';

    /**
     * The Command's Description
     *
     * @var string
     */
    protected $description = 'Refresh the data in ede_report table';

    /**
     * The Command's Usage
     *
     * @var string
     */
    protected $usage = 'command:name [arguments] [options]';

    /**
     * The Command's Arguments
     *
     * @var array
     */
    protected $arguments = [];

    /**
     * The Command's Options
     *
     * @var array
     */
    protected $options = [];

    /**
     * Actually execute a command.
     *
     * @param array $params
     */

    public function run(array $params)
    {
        CLI::write("Updating EDE Report Data", 'cyan');

        try {
            $model = new EdeReportModel();
            $remote = new SqlbaseModel();

            // Get existing order IDs as associative array for O(1) lookup
            $existing_orders = $model->select('order_id')->findAll();
            $existing_ids = array_flip(array_column($existing_orders, 'order_id'));
            
            $stats = [
                'new' => 0,
                'updated' => 0,
                'deleted' => 0
            ];
            
            $incoming_ids = [];
            $data = $remote->getData('http://vatap/mvc/public/api/getsrcreport/');
            
            if (empty($data)) {
                CLI::write("No data received from remote source", 'yellow');
                return;
            }

            // Prepare batch operations
            $updates = [];
            $inserts = [];

            foreach ($data as $row) {

                $incoming_ids[] = $row->order_id;

                if (isset($existing_ids[$row->order_id])) {
                    // Mark for update
                    $updates[] = $row;
                } else {
                    // Mark for insert
                    $inserts[] = $row;
                }
            }

            // Batch insert new records
            if (!empty($inserts)) {
                $model->insertBatch($inserts);
                $stats['new'] = count($inserts);
            }

            // Batch update existing records
            if (!empty($updates)) {
                foreach ($updates as $row) {
                    $existing = $model->select('id')->where('order_id', $row->order_id)->first();
                    $row->id = $existing->id;
                    $model->save($row);
                }
                $stats['updated'] = count($updates);
            }

            // Delete records not in incoming data
            if (!empty($incoming_ids)) {
                $model->whereNotIn('order_id', $incoming_ids)->delete();
                $stats['deleted'] = $model->db->affectedRows();
            }

            CLI::write(sprintf(
                "Total Existing: %d | Added: %d | Updated: %d | Deleted: %d",
                count($existing_ids),
                $stats['new'],
                $stats['updated'],
                $stats['deleted']
            ), 'green');
            
            CLI::write("EDE Report Updated Successfully", 'cyan');
            
        } catch (Exception $e) {
            CLI::write("Error updating EDE Report: " . $e->getMessage(), 'red');
            log_message('error', 'RefreshEdeReport command failed: ' . $e->getMessage());
        }
    }
}
