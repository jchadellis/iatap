<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateEdeReportTable extends Migration
{
    protected $DBGroup = 'visual_cache';

    public function up()
    {
        $this->forge->addField([
            'id'                           => ['type' => 'INT', 'null' => false],
            'order_id'                     => ['type' => 'VARCHAR', 'constraint' => 15, 'null' => false],
            'order_clin'                   => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => false],
            'order_no_mod'                 => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => false],
            'requisition_no'               => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'nsn_no'                       => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => true],
            'order_qty'                    => ['type' => 'INT', 'null' => false],
            'unit_price'                   => ['type' => 'NUMERIC', 'constraint' => '12,2', 'null' => false],
            'order_date'                   => ['type' => 'TIMESTAMP', 'null' => false],
            'due_date'                     => ['type' => 'TIMESTAMP', 'null' => true],
            'recovery_date'                => ['type' => 'TIMESTAMP', 'null' => true],
            'ship_date'                    => ['type' => 'TIMESTAMP', 'null' => true],
            'deliver_loc'                  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'shipment'                     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'tracking_no'                  => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'comments'                     => ['type' => 'TEXT', 'null' => true],
            'noun'                         => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'part_no'                      => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => false],
            'vendor_name'                  => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => false],
            'vendor_cage_code'             => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => false],
            'vendor_bus_size'              => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => false],
            'qty_shipped'                  => ['type' => 'INT', 'null' => true],
            'oc'                           => ['type' => 'VARCHAR', 'constraint' => 5, 'null' => true],
            'sir'                          => ['type' => 'VARCHAR', 'constraint' => 25, 'null' => true],
            'sir_request_date'             => ['type' => 'VARCHAR', 'null' => true],
            'sir_instructions_received_date'=> ['type' => 'VARCHAR', 'null' => true],
            'tcn_tracking'                 => ['type' => 'VARCHAR', 'null' => true],
            'invoice_no'                   => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => true],
            'finacial_impact'              => ['type' => 'VARCHAR', 'constraint' => 30, 'null' => false],
            'config_control_data'          => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'N/A', 'null' => false],
            'quality_control_data'         => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'N/A', 'null' => false],
            'risk_assessment_complete'     => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'YES', 'null' => false],
            'on_time_delivery'             => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'MEDIUM', 'null' => false],
            'labor_capacity'               => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'LOW', 'null' => false],
            'facility_capacity'            => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'LOW', 'null' => false],
            'supplier'                     => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'LOW', 'null' => false],
            'product_liability'            => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'LOW', 'null' => false],
            'mitig_strat_a'                => ['type' => 'VARCHAR', 'constraint' => 150, 'default' => 'Notify expeditor to pay special attention to these orders and visit supplier as necessary.', 'null' => false],
            'mitig_strat_b'                => ['type' => 'VARCHAR', 'constraint' => 150, 'null' => false],
            'mitig_strat_c'                => ['type' => 'VARCHAR', 'constraint' => 150, 'default' => 'No internal ATAP labor required except for packaging/shipping.', 'null' => false],
            'mitig_strat_d'                => ['type' => 'VARCHAR', 'constraint' => 255, 'default' => 'ATAP facility adequate for this work.', 'null' => false],
            'mitig_strat_e'                => ['type' => 'VARCHAR', 'constraint' => 255, 'default' => 'Known, approved vendor. Specified by customer', 'null' => false],
            'mitig_strat_f'                => ['type' => 'VARCHAR', 'constraint' => 255, 'default' => 'Product and vendor approved and specified by customer. Not a new item.', 'null' => false],
            'risk_rating_after_mit_a'      => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'LOW', 'null' => false],
            'risk_rating_after_mit_b'      => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'LOW', 'null' => false],
            'risk_rating_after_mit_c'      => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'LOW', 'null' => false],
            'risk_rating_after_mit_d'      => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'LOW', 'null' => false],
            'risk_rating_after_mit_e'      => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'LOW', 'null' => false],
            'risk_rating_after_mit_f'      => ['type' => 'VARCHAR', 'constraint' => 30, 'default' => 'LOW', 'null' => false],
            'created_at'                   => ['type' => 'TIMESTAMP', 'null' => true],
            'updated_at'                   => ['type' => 'TIMESTAMP', 'null' => true],
            'deleted_at'                   => ['type' => 'TIMESTAMP', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->createTable('ede_report');
    }

    public function down()
    {
        $this->forge->dropTable('ede_report');
    }
}
