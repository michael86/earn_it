<?php

namespace Framework\Middleware\Auth;

class Register {

    public static function validate ($data) {
        
        $errors = [];

        $required = [
            'email',
            'type',
            'password',
            'password-confirm',
            'firstname',
            'lastname',
            'terms',
        ];

        foreach ($required as $field) {
            if (empty($data[$field])) {
                $errors[] = ucfirst(str_replace('-', ' ', $field)) . ' is required';
            }
        }

        if (!empty($data['password']) && !empty($data['password-confirm'])) {
            if ($data['password'] !== $data['password-confirm']) {
                $errors[] = 'Passwords do not match';
            }
        }

        if (!empty($data['email']) && !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Email address is not valid';
        }

        if (!empty($data['password']) && strlen($data['password']) < 8) {
            $errors[] = 'Password must be at least 8 characters';
        }

        return $errors;
        
    }

}