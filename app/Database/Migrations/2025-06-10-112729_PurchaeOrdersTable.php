<?php


namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVendorOrdersTable extends Migration
{
    protected $DBGroup = 'visual_cache';

    public function up()
    {
        $this->forge->addField([
            'id'                        => ['type' => 'INT', 'unsigned' => true],
            'vendor_id'                 => ['type' => 'VARCHAR', 'constraint' => 20],
            'name'                      => ['type' => 'VARCHAR', 'constraint' => 100],
            'order_date'                => ['type' => 'DATE', 'null' => true],
            'contract_date'             => ['type' => 'DATE', 'null' => true],
            'desired_recv_date'         => ['type' => 'DATE', 'null' => true],
            'true_promise'              => ['type' => 'DATE', 'null' => true],
            // 'start_date'                => ['type' => 'INT', 'unsigned' => true], // Unix timestamp
            // 'end_date'                  => ['type' => 'INT', 'unsigned' => true], // Unix timestamp
            'terms'                     => ['type' => 'INT', 'default' => 0],
            'buyer'                     => ['type' => 'VARCHAR', 'constraint' => 10],
            'status'                    => ['type' => 'CHAR', 'constraint' => 1],
            'phone'                     => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'email'                     => ['type' => 'VARCHAR', 'constraint' => 100, 'null' => true],
            'confirmed'                 => ['type' => 'CHAR', 'constraint' => 1, 'null' => true],
            'contact_first_name'        => ['type' => 'VARCHAR', 'constraint' => 50],
            'contact_last_name'         => ['type' => 'VARCHAR', 'constraint' => 50],
            'followup_25_target_date'   => ['type' => 'DATE', 'null' => true],
            'followup_50_target_date'   => ['type' => 'DATE', 'null' => true],
            'followup_80_target_date'   => ['type' => 'DATE', 'null' => true],
            'followup_90_target_date'   => ['type' => 'DATE', 'null' => true],
            'followup_25_updated_at'    => ['type' => 'TIMESTAMP', 'null' => true],
            'followup_50_updated_at'    => ['type' => 'TIMESTAMP', 'null' => true],
            'followup_80_updated_at'    => ['type' => 'TIMESTAMP', 'null' => true],
            'followup_90_updated_at'    => ['type' => 'TIMESTAMP', 'null' => true],
            'last_vendor_update_at'     => ['type' => 'TIMESTAMP', 'null' => true],
            'next_vendor_update_at'     => ['type' => 'TIMESTAMP', 'null' => true],
            'created_at'                => ['type' => 'DATETIME', 'null' => true],
            'updated_at'                => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'                => ['type' => 'DATETIME', 'null' => true],
            'percentage_complete'       => ['type' => 'INT', 'constraint' => 3, 'default' => 0],   
            'completed'                 => ['type' => 'BOOLEAN', 'default' => false],

        ]);

        $this->forge->addKey('id', true); // Primary key
        $this->forge->createTable('purchase_orders');
    }

    public function down()
    {
        $this->forge->dropTable('purchase_orders');
    }
}

