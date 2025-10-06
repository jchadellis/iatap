<?php


namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVendorOrdersTable extends Migration
{
    protected $DBGroup = 'visual_cache';

    public function up()
    {
        $this->forge->addField([
            'id'                     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'vendor_id'              => ['type' => 'TEXT', 'null' => true],
            'name'                   => ['type' => 'TEXT', 'null' => true],
            'order_date'             => ['type' => 'DATE', 'null' => true],
            'contract_date'          => ['type' => 'DATE', 'null' => true],
            'desired_recv_date'      => ['type' => 'DATE', 'null' => true],
            'terms'                  => ['type' => 'INT', 'null' => true],
            'confirmed'              => ['type' => 'TEXT', 'null' => true],
            'buyer'                  => ['type' => 'TEXT', 'null' => true],
            'status'                 => ['type' => 'TEXT', 'null' => true],
            'phone'                  => ['type' => 'TEXT', 'null' => true],
            'email'                  => ['type' => 'TEXT', 'null' => true],
            'contact_first_name'     => ['type' => 'TEXT', 'null' => true],
            'contact_last_name'      => ['type' => 'TEXT', 'null' => true],
            'linear_progress'        => ['type' => 'INT', 'null' => true],
            'lead_time_days'         => ['type' => 'INT', 'null' => true],
            'elapsed_days'           => ['type' => 'INT', 'null' => true],
            'days_left'              => ['type' => 'INT', 'null' => true],
            'true_promise'           => ['type' => 'DATE', 'null' => true],
            'is_late'                => ['type' => 'BOOLEAN', 'null' => true],
            'percentage_complete'    => ['type' => 'INT', 'null' => true],
            'color'                  => ['type' => 'TEXT', 'null' => true],
            'status_label'           => ['type' => 'TEXT', 'null' => true],
            'followup_25_target_date'=> ['type' => 'DATE', 'null' => true],
            'followup_50_target_date'=> ['type' => 'DATE', 'null' => true],
            'followup_90_target_date'=> ['type' => 'DATE', 'null' => true],
            'followup_25_updated_at' => ['type' => 'DATE', 'null' => true],
            'followup_50_updated_at' => ['type' => 'DATE', 'null' => true],
            'followup_90_updated_at' => ['type' => 'DATE', 'null' => true],
            'last_vendor_update_at'  => ['type' => 'DATE', 'null' => true],
            'next_vendor_update_at'  => ['type' => 'DATE', 'null' => true],
            'last_emailed_on'        => ['type' => 'TIMESTAMP', 'null' => true],
            'created_at'             => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at'             => ['type' => 'TIMESTAMP', 'null' => true],
            'deleted_at'             => ['type' => 'TIMESTAMP', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('purchase_orders');
    }

    public function down()
    {
        $this->forge->dropTable('purchase_orders');
    }
}

