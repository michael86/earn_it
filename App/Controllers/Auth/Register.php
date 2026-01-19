<?php

namespace App\Controllers\Auth;

use Framework\Middleware\Auth\Register as RegisterValidator;

class Register
{
    public function index(): void
    {
        loadPage('auth/register', [
            'errors' => [],
            'old' => [],
        ]);
    }

    public function create(): void
    {
        $data = $_POST;
        $errors = RegisterValidator::validate($data);
        
        if(count($errors)) {

            loadPage('auth/register', [
                'errors' => $errors,
                'old' => $data,
            ]);
            return;
        }


       

        // continue with user creation
    }
}
