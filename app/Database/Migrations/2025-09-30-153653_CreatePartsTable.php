<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePartsTable extends Migration
{
    protected $DBGroup = 'visual_cache';
    public function up()
    {
        
        /*
         * Designed for PostgreSQL via CodeIgniter 4 forge.
         * - Primary key: id (bigint auto increment)
         * - item_id: varchar for SKU/part number (fill from your data)
         * - Flags that contain 'Y'/'N' are stored as CHAR(1) with default 'N'
         * - Monetary values use DECIMAL(14,4) or DECIMAL(12,2) as appropriate
         * - Quantities use INTEGER
         * - Timestamps are nullable
         *
         * Edit constraints/lengths/precision to suit your needs.
         */


        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'part_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'description' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'stock_um' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
            ],
            'planning_leadtime' => [
                'type'       => 'SMALLINT',
                'null'       => true,
            ],
            'order_policy' => [
                'type'       => 'CHAR',
                'constraint' => 1,
                'default'    => 'N',
            ],
            'order_point' => [
                'type'       => 'INTEGER',
                'null'       => true,
            ],
            'safety_stock_qty' => [
                'type'       => 'INTEGER',
                'null'       => true,
                'default'    => 0,
            ],
            'fixed_order_qty' => [
                'type'       => 'INTEGER',
                'null'       => true,
            ],
            'days_of_supply' => [
                'type'       => 'INTEGER',
                'null'       => true,
            ],
            'minimum_order_qty' => [
                'type'       => 'INTEGER',
                'null'       => true,
            ],
            'maximum_order_qty' => [
                'type'       => 'INTEGER',
                'null'       => true,
            ],
            'engineering_mstr' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'product_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => true,
            ],
            'commodity_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'mfg_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'mfg_part_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            /* flags Y/N */
            'fabricated' => [
                'type'       => 'CHAR',
                'constraint' => 1,
                'default'    => 'N',
            ],
            'purchased' => [
                'type'       => 'CHAR',
                'constraint' => 1,
                'default'    => 'N',
            ],
            'stocked' => [
                'type'       => 'CHAR',
                'constraint' => 1,
                'default'    => 'N',
            ],
            'detail_only' => [
                'type'       => 'CHAR',
                'constraint' => 1,
                'default'    => 'N',
            ],
            'demand_history' => [
                'type'       => 'CHAR',
                'constraint' => 1,
                'default'    => 'N',
            ],
            'tool_or_fixture' => [
                'type'       => 'CHAR',
                'constraint' => 1,
                'default'    => 'N',
            ],
            'inspection_reqd' => [
                'type'       => 'CHAR',
                'constraint' => 1,
                'default'    => 'N',
            ],
            'weight' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,3',
                'null'       => true,
            ],
            'weight_um' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
            ],
            'drawing_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 100,
                'null'       => true,
            ],
            'drawing_rev_no' => [
                'type'       => 'VARCHAR',
                'constraint' => 40,
                'null'       => true,
            ],
            'pref_vendor_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'null'       => true,
            ],
            'primary_whs_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'null'       => true,
            ],
            'primary_loc_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'null'       => true,
            ],
            'backflush_whs_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'null'       => true,
            ],
            'backflush_loc_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'null'       => true,
            ],
            'inspect_whs_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'null'       => true,
            ],
            'inspect_loc_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'null'       => true,
            ],
            'mrp_required' => [
                'type'       => 'CHAR',
                'constraint' => 1,
                'default'    => 'N',
            ],
            'mrp_exceptions' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'private_um_conv' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'auto_backflush' => [
                'type'       => 'CHAR',
                'constraint' => 1,
                'default'    => 'N',
            ],
            'planner_user_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'null'       => true,
            ],
            'buyer_user_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'null'       => true,
            ],
            'abc_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
            ],
            'annual_usage_qty' => [
                'type'       => 'INTEGER',
                'null'       => true,
            ],
            'inventory_locked' => [
                'type'       => 'CHAR',
                'constraint' => 1,
                'default'    => 'N',
            ],
            /* pricing & cost fields */
            'unit_price' => [
                'type'       => 'DECIMAL',
                'constraint' => '14,4',
                'null'       => true,
            ],
            'unit_material_cost' => [
                'type'       => 'DECIMAL',
                'constraint' => '14,4',
                'null'       => true,
            ],
            'unit_labor_cost' => [
                'type'       => 'DECIMAL',
                'constraint' => '14,4',
                'null'       => true,
            ],
            'whsale_unit_cost' => [
                'type'       => 'DECIMAL',
                'constraint' => '14,4',
                'null'       => true,
            ],
            'burden_percent' => [
                'type'       => 'DECIMAL',
                'constraint' => '7,4',
                'null'       => true,
                'default'    => 0,
            ],
            'excise_unit_price' => [
                'type'       => 'DECIMAL',
                'constraint' => '14,4',
                'null'       => true,
            ],
            'purc_bur_percent' => [
                'type'       => 'DECIMAL',
                'constraint' => '7,4',
                'null'       => true,
                'default'    => 0,
            ],
            'unit_burden_cost' => [
                'type'       => 'DECIMAL',
                'constraint' => '14,4',
                'null'       => true,
            ],
            'fixed_cost' => [
                'type'       => 'DECIMAL',
                'constraint' => '14,4',
                'null'       => true,
            ],
            'unit_service_cost' => [
                'type'       => 'DECIMAL',
                'constraint' => '14,4',
                'null'       => true,
            ],
            /* new_* cost fields */
            'new_material_cost' => [
                'type'       => 'DECIMAL',
                'constraint' => '14,4',
                'null'       => true,
            ],
            'new_labor_cost' => [
                'type'       => 'DECIMAL',
                'constraint' => '14,4',
                'null'       => true,
            ],
            'new_burden_cost' => [
                'type'       => 'DECIMAL',
                'constraint' => '14,4',
                'null'       => true,
            ],
            'new_service_cost' => [
                'type'       => 'DECIMAL',
                'constraint' => '14,4',
                'null'       => true,
            ],
            'new_burden_percent' => [
                'type'       => 'DECIMAL',
                'constraint' => '7,4',
                'null'       => true,
            ],
            'purc_bur_per_unit' => [
                'type'       => 'DECIMAL',
                'constraint' => '14,4',
                'null'       => true,
            ],
            'new_fixed_cost' => [
                'type'       => 'DECIMAL',
                'constraint' => '14,4',
                'null'       => true,
            ],
            /* GL accounts */
            'mat_gl_acct_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'null'       => true,
            ],
            'lab_gl_acct_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'null'       => true,
            ],
            'bur_gl_acct_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'null'       => true,
            ],
            'ser_gl_acct_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'null'       => true,
            ],
            /* inventory quantities */
            'qty_on_hand' => [
                'type'       => 'INTEGER',
                'null'       => true,
                'default'    => 0,
            ],
            'qty_available_iss' => [
                'type'       => 'INTEGER',
                'null'       => true,
                'default'    => 0,
            ],
            'qty_available_mrp' => [
                'type'       => 'INTEGER',
                'null'       => true,
                'default'    => 0,
            ],
            'qty_on_order' => [
                'type'       => 'INTEGER',
                'null'       => true,
                'default'    => 0,
            ],
            'qty_in_demand' => [
                'type'       => 'INTEGER',
                'null'       => true,
                'default'    => 0,
            ],
            /* user-defined fields */
            'user_1' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'user_2' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'user_3' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'user_4' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'user_5' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'user_6' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'user_7' => [
                'type'       => 'VARCHAR',
                'constraint' => 80,
                'null'       => true,
            ],
            'user_8' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'user_9' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            'user_10' => [
                'type'       => 'VARCHAR',
                'constraint' => 150,
                'null'       => true,
            ],
            /* other attributes */
            'nmfc_code_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'null'       => true,
            ],
            'package_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'null'       => true,
            ],
            'label_um' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
            ],
            'mrp_exception_info' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'multiple_order_qty' => [
                'type'       => 'INTEGER',
                'null'       => true,
            ],
            'add_forecast' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'udf_layout_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'null'       => true,
            ],
            'piece_tracked' => [
                'type'       => 'CHAR',
                'constraint' => 1,
                'default'    => 'N',
            ],
            'length_reqd' => [
                'type'       => 'CHAR',
                'constraint' => 1,
                'default'    => 'N',
            ],
            'width_reqd' => [
                'type'       => 'CHAR',
                'constraint' => 1,
                'default'    => 'N',
            ],
            'height_reqd' => [
                'type'       => 'CHAR',
                'constraint' => 1,
                'default'    => 'N',
            ],
            'dimensions_um' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
            ],
            'ship_dimensions' => [
                'type'       => 'VARCHAR',
                'constraint' => 200,
                'null'       => true,
            ],
            'drawing_file' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'tariff_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 80,
                'null'       => true,
            ],
            'tariff_type' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'null'       => true,
            ],
            'orig_country_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'null'       => true,
            ],
            'net_weight_2' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,3',
                'null'       => true,
            ],
            'gross_weight_2' => [
                'type'       => 'DECIMAL',
                'constraint' => '10,3',
                'null'       => true,
            ],
            'weight_um_2' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
            ],
            'volume' => [
                'type'       => 'DECIMAL',
                'constraint' => '12,4',
                'null'       => true,
            ],
            'volume_um' => [
                'type'       => 'VARCHAR',
                'constraint' => 10,
                'null'       => true,
            ],
            'new_burden_perunit' => [
                'type'       => 'DECIMAL',
                'constraint' => '14,4',
                'null'       => true,
                'default'    => 0,
            ],
            'vat_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'null'       => true,
            ],
            'demand_fence_1' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'demand_fence_2' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'roll_forecast' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'consumable' => [
                'type'       => 'CHAR',
                'constraint' => 1,
                'default'    => 'N',
            ],
            'primary_source' => [
                'type'       => 'VARCHAR',
                'constraint' => 120,
                'null'       => true,
            ],
            'def_lbl_format_id' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'null'       => true,
            ],
            'burden_per_unit' => [
                'type'       => 'DECIMAL',
                'constraint' => '14,4',
                'null'       => true,
                'default'    => 0,
            ],
            'hts_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'null'       => true,
            ],
            'def_orig_country' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'null'       => true,
            ],
            'material_code' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'null'       => true,
            ],
            'volatile_leadtime' => [
                'type'       => 'SMALLINT',
                'null'       => true,
            ],
            'lt_plus_days' => [
                'type'       => 'SMALLINT',
                'null'       => true,
            ],
            'lt_minus_days' => [
                'type'       => 'SMALLINT',
                'null'       => true,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 60,
                'null'       => true,
            ],
            'use_supply_bef_lt' => [
                'type'       => 'CHAR',
                'constraint' => 1,
                'default'    => 'N',
            ],
            'qty_committed' => [
                'type'       => 'INTEGER',
                'null'       => true,
                'default'    => 0,
            ],
            /* audit timestamps */
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
            ],
        ]);

        // primary key
        $this->forge->addKey('id', true);

        // useful indexes
        $this->forge->addKey('item_id');
        $this->forge->addKey('pref_vendor_id');
        $this->forge->addKey('primary_whs_id');

        // create table
        $this->forge->createTable('part', true);
    }

    public function down()
    {
        $this->forge->dropTable('part', true); 
    }
}
