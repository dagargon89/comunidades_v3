<?php

return [
    'name' => 'Comunidades V3',
    'url' => 'http://localhost',
    'env' => 'development',
    'debug' => true,
    'colors' => [
        'primary' => '#00a8a9',
        'secondary' => '#a30078',
        'danger' => '#fa3966',
        'warning' => '#ffc107',
        'info' => '#2a345a',
        'success' => '#00a8a9',
        'background' => '#f4f8ff',
        'dark_bg' => '#181c2a',
        'white' => '#fff',
    ],
    'session' => [
        'lifetime' => 3600,
        'path' => '/',
        'domain' => null,
        'secure' => false,
        'httponly' => true,
        'samesite' => 'Lax'
    ],
    'upload' => [
        'path' => 'public/uploads',
        'max_size' => 10485760, // 10MB
        'allowed_types' => ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx', 'xls', 'xlsx']
    ],
    'pagination' => [
        'per_page' => 20
    ]
];
