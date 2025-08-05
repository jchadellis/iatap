<?php

namespace App\Commands;

use CodeIgniter\Shield\Commands\UserCreate;
use CodeIgniter\Shield\Entities\User;
use CodeIgniter\Shield\Models\UserModel;

class CustomUserCreate extends User
{
    protected $name = 'custom:user:create'; // New command name

    public function run(array $params)
    {
        $email    = $this->prompt('Email');
        $password = $this->prompt('Password', null, 'required|min_length[8]');
        $username = $this->prompt('Username (optional)', '', 'alpha_numeric_space');

        $users = model(UserModel::class);

        $userData = [
            'email'    => $email,
            'password' => $password,
        ];

        if (!empty($username)) {
            $userData['username'] = $username;
        }

        // Custom field (example)
        $userData['custom_field'] = 'Custom Value';

        $user = new User($userData);
        $users->save($user);

        $this->write('User created successfully!', 'green');
    }
}