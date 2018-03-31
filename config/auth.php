<?php

return [

    'multi' => [
        
        'user' => [
                    'driver' => 'eloquent',
                    'model'  => App\User::class,
                    'table'  => 'users'
        ],

        'admin' => [
                    'driver' => 'eloquent',
                    'model'  => App\Admin::class,
                    'table'  => 'admins'
        ],
        'supplier' => [
                    'driver' => 'eloquent',
                    'model'  => App\Supplier::class,
                    'table'  => 'supplier'
        ],
        'demo' => [
                    'driver' => 'eloquent',
                    'model'  => App\Models\Demo::class,
                    'table'  => 'demo'
        ]
    ],

    'password' => [
        'email' => 'emails.password',
        'table' => 'password_resets',
        'expire' => 60,
    ],

];
