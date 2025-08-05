<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;
use CodeIgniter\Validation\StrictRules\CreditCardRules;
use CodeIgniter\Validation\StrictRules\FileRules;
use CodeIgniter\Validation\StrictRules\FormatRules;
use CodeIgniter\Validation\StrictRules\Rules;

class Validation extends BaseConfig
{
    // --------------------------------------------------------------------
    // Setup
    // --------------------------------------------------------------------

    /**
     * Stores the classes that contain the
     * rules that are available.
     *
     * @var list<string>
     */
    public array $ruleSets = [
        Rules::class,
        FormatRules::class,
        FileRules::class,
        CreditCardRules::class,
    ];

    /**
     * Specifies the views that are used to display the
     * errors.
     *
     * @var array<string, string>
     */
    public array $templates = [
        'list'   => 'CodeIgniter\Validation\Views\list',
        'single' => 'CodeIgniter\Validation\Views\single',
    ];

    // --------------------------------------------------------------------
    // Rules
    // --------------------------------------------------------------------

    public $registration = [
        'username' => [
            'label' => 'Auth.username',
            'rules' => [
                'required',
                'max_length[30]',
                'min_length[3]',
                'regex_match[/\A[a-zA-Z0-9\.]+\z/]',
                'is_unique[users.username]',
            ],
        ],
        'email' => [
            'label' => 'Auth.email',
            'rules' => [
                'required',
                'max_length[254]',
                'valid_email',
                'is_unique[auth_identities.secret]',
            ],
        ],
        'password' => [
            'label' => 'Auth.password',
            'rules' => 'required|max_byte[72]|strong_password[]',
            'errors' => [
                'max_byte' => 'Auth.errorPasswordTooLongBytes'
            ]
        ],
        'password_confirm' => [
            'label' => 'Auth.passwordConfirm',
            'rules' => 'required|matches[password]',
        ],
        'first_name' => [
            'label'  => 'Auth.firstName', 
            'rules' => 'permit_empty',
        ],
        'last_name' => [
            'label'  => 'Auth.lastName', 
            'rules' => 'permit_empty',
        ],
        'date_of_birth' => [
            'label' => 'Auth.dob', 
            'rules' => 'permit_empty',
        ],
        'extension' => [
            'label' => 'Auth.xten', 
            'rules' => 'permit_empty'
        ],
        'extension_ip' => [
            'label' => 'Auth.xten_ip', 
            'rules' => 'permit_empty', 
        ],
        'personal_email'    => [
            'label' => 'Auth.personalEmail', 
            'rules' => 'permit_empty', 
        ],
        'street'    => [
            'label' => 'Auth.street', 
            'rules' => 'permit_empty',
        ],
        'city'      => [
            'label' => 'Auth.city', 
            'rules' => 'permit_empty', 
        ],
        'state'     => [
            'label' => 'Auth.state', 
            'rules' => 'permit_empty', 
        ],
        'zip'       => [
            'label' => 'Auth.zip', 
            'rules' => 'permit_empty',
        ],
        'avatar'    => [
            'label' => 'Auth.icon', 
            'rules' => 'permit_emtpy',
        ],
        'emergency_contact' => [
            'label' => 'Auth.emgContact', 
            'rules' => 'permit_empty', 
        ],
        'emergency_contact_relationship' => [
            'label' => 'Auth.emgConRelation', 
            'rules' => 'permit_empty'
        ],
        'emergency_contact_cell'    => [
            'label' => 'Auth.emgConCell', 
            'rules' => 'permit_empty', 
        ],
        'emergency_contact_work'    => [
            'label' => 'Auth.emgConWork', 
            'rules' => 'permit_empty', 
        ],
        'emergency_contact_home'    => [
            'label' => 'Auth.emgConHome', 
            'rules' => 'permit_empty', 
        ],
        'primary_number'    => [
            'label' => 'Auth.phone1', 
            'rules' => 'permit_empty', 
        ],
        'secondary_number'    => [
            'label' => 'Auth.phone2', 
            'rules' => 'permit_empty', 
        ],
        'host_id'   => [
            'label' => 'Auth.host', 
            'rules' => 'permit_empty', 
        ],
        'dept_id'   => [
            'label' => 'Auth.dept', 
            'rules' => 'permit_empty',
        ],
        'bldg_id'   => [
            'label' => 'Auth.bldg', 
            'rules' => 'permit_empty', 
        ],
    ];
}
