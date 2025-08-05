<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Forge; 
use CodeIgniter\Database\Migration;

class AddCustomColumns extends Migration
{
     /**
     * @var string[]
     */
    private array $tables;

    public function __construct(?Forge $forge = null)
    {
        parent::__construct($forge);

        /** @var \Config\Auth $authConfig */
        $authConfig   = config('Auth');
        $this->tables = $authConfig->tables;
    }

    public function up()
    {
        $fields = [
            'first_name' => ['type' => 'VARCHAR', 'constraint' => '25', 'null' => true],
            'last_name' => ['type' => 'VARCHAR', 'constraint' => '25', 'null' => true],
            'date_of_birth' => ['type' => 'DATE', 'null' => true],
            'extension' => ['type' => 'VARCHAR', 'constraint' => '4', 'default' => 'XXX'],
            'extension_ip'  => ['type' => 'VARCHAR', 'constraint' => '15', 'default' => 'XXX.XXX.XXX.XXX'],
            'personal_email'    => ['type' => 'VARCHAR', 'constraint' => '40', 'null' => true],
            'work_email'    => ['type' => 'VARCHAR', 'constraint' => '40', 'null' => true],
            'street'    => ['type' => 'VARCHAR', 'constraint' => '40', 'null' => true],
            'city'    => ['type' => 'VARCHAR', 'constraint' => '25', 'null' => true],
            'state'    => ['type' => 'VARCHAR', 'constraint' => '15', 'null' => true],
            'zip'       => ['type' => 'VARCHAR', 'constraint' => '5', 'null' => true],
            'avatar'    => ['type' => 'VARCHAR', 'constraint' => '60', 'null' => true],
            'emergency_contact' => ['type' => 'VARCHAR', 'constraint' => '25', 'null' => true],
            'emergency_contact_relationship' => ['type' => 'VARCHAR', 'constraint' => '25', 'null' => true],
            'emergency_contact_cell' => ['type' => 'VARCHAR', 'constraint' => '20', 'null' => true],
            'emergency_contact_work' => ['type' => 'VARCHAR', 'constraint' => '20', 'null' => true],
            'emergency_contact_home' => ['type' => 'VARCHAR', 'constraint' => '20', 'null' => true],
            'primary_number' => ['type' => 'VARCHAR', 'constraint' => '20', 'null' => true],
            'secondary_number' => ['type' => 'VARCHAR', 'constraint' => '20', 'null' => true],
            'host_id'       => ['type' => 'INT'],
            'dept_id'       => ['type' => 'INT'],
            'bldg_id'       => ['type' => 'INT'],
            
        ];

        $this->forge->addColumn($this->tables['users'], $fields);
    }

    public function down()
    {
        $fields = [
            'first_name', 'last_name', 'date_of_birth', 'extension', 'extension_ip', 'personal_email', 'work_email', 'street', 'city', 'state', 'zip', 'avatar',
            'avatar', 'emergency_contact', 'emergency_contact_relationship', 'emergency_contact_cell', 'emergency_contact_work', 'emergency_contact_home',
            'primary_number', 'secondary_number', 'host_id', 'dept_id', 'bldg_id',  
        ];
        $this->forge->dropColumn($this->tables['users'], $fields);
    }
}
