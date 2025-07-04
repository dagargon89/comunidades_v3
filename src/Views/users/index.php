<?php
$title = 'Usuarios';
$filters = [
    ['type' => 'text', 'name' => 'q', 'placeholder' => 'Buscar por nombre, email o usuario...', 'value' => htmlspecialchars($_GET['q'] ?? '')],
    ['type' => 'select', 'name' => 'rol', 'options' => array_merge(['' => 'Todos los roles'], array_column($roles, 'name', 'name')), 'value' => $_GET['rol'] ?? ''],
    ['type' => 'select', 'name' => 'estado', 'options' => ['' => 'Todos', 'activo' => 'Activos', 'inactivo' => 'Inactivos'], 'value' => $_GET['estado'] ?? ''],
];
$buttons = [
    [
        'type' => 'submit',
        'label' => 'Filtrar',
        'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900',
        'icon' => 'fa-search'
    ]
];
if (current_user() && current_user()->hasPermission('user.create')) {
    $buttons[] = [
        'type' => 'link',
        'label' => 'Nuevo usuario',
        'href' => '/users/create',
        'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900',
        'icon' => 'fa-plus',
        'title' => 'Crear un nuevo usuario'
    ];
}
$headers = ['Nombre', 'Apellidos', 'Email', 'Usuario', 'Rol', 'Estado'];
$fields = ['first_name', 'last_name', 'email', 'username', 'rol', 'is_active'];
$rows = $usuarios;
$actions_config = [
    [
        'type' => 'view',
        'url' => function ($row) {
            return '/users/view?id=' . $row['id'];
        },
        'title' => 'Ver',
        'icon' => 'fa-eye text-blue-500',
        'class' => 'btn-info',
        'permission' => 'user.view',
    ],
    [
        'type' => 'edit',
        'url' => function ($row) {
            return '/users/edit?id=' . $row['id'];
        },
        'title' => 'Editar',
        'icon' => 'fa-edit text-yellow-500',
        'class' => 'btn-warning',
        'permission' => 'user.edit',
    ],
    [
        'type' => 'delete',
        'url' => function ($row) {
            return '/users/delete?id=' . $row['id'];
        },
        'title' => 'Eliminar',
        'icon' => 'fa-trash text-red-500',
        'class' => 'btn-danger',
        'permission' => 'user.delete',
        'onclick' => function ($row) {
            return "return confirm('¿Seguro que deseas eliminar este usuario?')";
        },
    ],
];
$custom_render = [
    'is_active' => function ($value, $row) {
        $class = $value ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
        $text = $value ? 'Activo' : 'Inactivo';
        return "<span class='px-2 inline-flex text-xs leading-5 font-semibold rounded-full $class'>$text</span>";
    },
    'rol' => function ($value, $row) {
        return htmlspecialchars($value);
    }
];
ob_start();
include __DIR__ . '/../ui_components/table.php';
$content = ob_get_clean();
$page = $pagina_actual;
$totalPages = $total_paginas;
require_once __DIR__ . '/../layouts/app.php';
