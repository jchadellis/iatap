<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEdeReportTable extends Migration
{
    protected $DBGroup = 'visual_cache';
    public function up()
    {
        $this->forge->addField([
            'id'                => [
                'type'           => 'INT',
                'unsigned'      => true,
                'auto_increment' => true,
            ],
            'order_id' => [
                'type'          => 'VARCHAR', 
                'constraint'    => '15', 
            ],
            'order_clin'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '150',
            ],
            'order_no_mod'=> [
                'type'           => 'VARCHAR',
                'constraint'     => '150',
            ],
            'requisition_no'    => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'nsn_no'           => [
                'type'           => 'VARCHAR',
                'constraint'     => '150',
                'null' => true
            ],
            'order_qty'              => [
                'type'           => 'INT',
                'unsigned'      => true,
            ],
            'unit_price'       => [
                'type'           => 'DECIMAL',
                'constraint'     => '12,2',
            ],
            'order_date'       => [
                'type'           => 'DATETIME',
            ],
            'due_date'         => [
                'type'           => 'DATETIME',
                'null' => true
            ],
            'recovery_date'    => [
                'type'           => 'DATETIME',
                'null'           => true, 
            ],
            'ship_date'        => [
                'type'           => 'DATETIME',
                'null' => true
            ],
            'deliver_loc'      => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null' => true
            ],
            'shipment'         => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null' => true
            ],
            'tracking_no'      => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
                'null' => true
            ],
            'comments'         => [
                'type'           => 'TEXT',
                'null'           => true,
            ],
            'noun'             => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'part_no'          => [
                'type'           => 'VARCHAR',
                'constraint'     => '255',
            ],
            'vendor_name'      => [
                'type'           => 'VARCHAR',
                'constraint'     => '150',
            ],
            'vendor_cage_code' => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
            ],
            'vendor_bus_size'  => [
                'type'           => 'VARCHAR',
                'constraint'     => '50',
            ],
            'qty_shipped'      => [
                'type'           => 'INT',
                'unsigned'      => true,
                'null' => true
            ],
            'invoice_no'       => [
                'type'           => 'VARCHAR',
                'constraint'     => '30',
                'null' => true
            ],
            'finacial_impact'  => [
                'type'           => 'VARCHAR',
                'constraint'     => '30', 
            ],
            'config_control_data' => [
                'type'          => 'VARCHAR',
                'constraint'     => '30', 
                'default'      => 'N/A',
            ],
            'quality_control_data' => [
                'type'          => 'VARCHAR',
                'constraint'     => '30', 
                'default'       => 'N/A', 
            ],
            'risk_assessment_complete' => [
                'type'          => 'VARCHAR',
                'constraint'     => '30', 
                'default'       => 'YES'
            ],
            'on_time_delivery'  => [
                'type'          => 'VARCHAR',
                'constraint'     => '30', 
                'default'       => 'MEDIUM'
            ],
            'labor_capacity'  => [
                'type'          => 'VARCHAR',
                'constraint'     => '30', 
                'default'       => 'LOW'
            ],
            'facility_capacity'  => [
                'type'          => 'VARCHAR',
                'constraint'     => '30', 
                'default'       => 'LOW'
            ],
            'supplier'  => [
                'type'          => 'VARCHAR',
                'constraint'     => '30', 
                'default'       => 'LOW'
            ],
            'product_liablity'  => [
                'type'          => 'VARCHAR',
                'constraint'     => '30', 
                'default'       => 'LOW'
            ],
            'mitig_strat_a'  => [
                'type'          => 'VARCHAR',
                'constraint'     => '150', 
                'default'       => 'Notify expeditor to pay special attention to these orders and visit supplier as necessary.'
            ],
            'mitig_strat_b'    => [
                'type'           => 'VARCHAR',
                'constraint'     => '150', 
            ],
            'mitig_strat_c'  => [
                'type'          => 'VARCHAR',
                'constraint'     => '150', 
                'default'       => 'No internal ATAP labor required except for packaging/shipping.'
            ],
            'mitig_strat_d'  => [
                'type'          => 'VARCHAR',
                'constraint'     => '255', 
                'default'       => 'ATAP facility adequate for this work.'
            ],
            'mitig_strat_e'  => [
                'type'          => 'VARCHAR',
                'constraint'     => '255', 
                'default'       => 'Known, approved vendor. Specified by customer'
            ],
            'mitig_strat_f'  => [
                'type'          => 'VARCHAR',
                'constraint'     => '255', 
                'default'       => 'Product and vendor approved and specified by customer. Not a new item.'
            ],
            'risk_rating_after_mit_a'  => [
                'type'          => 'VARCHAR',
                'constraint'     => '30', 
                'default'       => 'LOW'
            ],
            'risk_rating_after_mit_b'  => [
                'type'          => 'VARCHAR',
                'constraint'     => '30', 
                'default'       => 'LOW'
            ],
            'risk_rating_after_mit_c'  => [
                'type'          => 'VARCHAR',
                'constraint'     => '30', 
                'default'       => 'LOW'
            ],
            'risk_rating_after_mit_d'  => [
                'type'          => 'VARCHAR',
                'constraint'     => '30', 
                'default'       => 'LOW'
            ],
            'risk_rating_after_mit_e'  => [
                'type'          => 'VARCHAR',
                'constraint'     => '30', 
                'default'       => 'LOW'
            ],
            'risk_rating_after_mit_f'  => [
                'type'          => 'VARCHAR',
                'constraint'     => '30', 
                'default'       => 'LOW'
            ],
            'created_at'        => [
                'type'          => 'DATETIME', 
                'null' => true
            ],
            'updated_at'        => [
                'type'          => 'DATETIME', 
                'null' => true
            ],
            'deleted_at'        => [
                'type'          => 'DATETIME', 
                'null' => true
            ]

        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('ede_report');
    }

    public function down()
    {
        $this->forge->dropTable('ede_report');
    }
}
