<?php
return [

    'default' => 'principal',
    'connections' => [
        'principal' => [
            'driver' => 'mysql',
            'host' => 'localhost',
            'database' => 'cobroco_mdn',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ],
       'cliente' => [
            'driver' => 'mysql',
            'host' => '',
            'database' => '',
            'username' => '',
            'password' => '',
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
        ]
    ]
];
