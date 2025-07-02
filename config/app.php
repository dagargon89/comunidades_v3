<?php

return [
    'name' => 'Comunidades V3',
    'url' => 'http://localhost',
    'env' => 'development',
    'debug' => true,

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
