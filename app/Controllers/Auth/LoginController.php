<?php

namespace App\Controllers\Auth;

use CodeIgniter\Shield\Controllers\LoginController as ShieldLogin;
use CodeIgniter\HTTP\RedirectResponse;

class LoginController extends ShieldLogin
{
    public function loginAction(): RedirectResponse
    {
        $rules = [
            'login' => [
                'label' => 'Email/Username',
                'rules' => 'required',
            ],
            'password' => [
                'label' => 'Auth.password',
                'rules' => 'required',
            ],
        ];

        if (! $this->validateData($this->request->getPost(), $rules, [], config('Auth')->DBGroup)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $identifier = $this->request->getPost('login');
        $password = $this->request->getPost('password');
        $remember = (bool) $this->request->getPost('remember');

        // Determine if identifier is email or username
        $credentials = [];
        if (filter_var($identifier, FILTER_VALIDATE_EMAIL)) {
            $credentials['email'] = $identifier;
        } else {
            $credentials['username'] = $identifier;
        }
        $credentials['password'] = $password;

        /** @var \CodeIgniter\Shield\Authentication\Authenticators\Session $authenticator */
        $authenticator = auth('session')->getAuthenticator();

        if ($authenticator->remember($remember)->attempt($credentials)) {
            return redirect()->to(setting('Auth.redirects')['login']);
        }

        return redirect()->route('login')->withInput()->with('error', lang('Auth.badAttempt'));
    }

    protected function getValidationRules(): array
    {
        return [
            'login' => [
                'label' => 'Email/Username',
                'rules' => 'required',
            ],
            'password' => [
                'label' => 'Auth.password',
                'rules' => 'required',
            ],
        ];
    }
}