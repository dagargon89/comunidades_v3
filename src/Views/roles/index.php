<?php
$title = 'Roles';
$filters = [
    ['type' => 'text', 'name' => 'q', 'placeholder' => 'Buscar por nombre o descripción', 'value' => htmlspecialchars($_GET['q'] ?? '')],
];
$buttons = [
    [
        'type' => 'submit',
        'label' => 'Filtrar',
        'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900',
        'icon' => 'fa-search'
    ],
    [
        'type' => 'link',
        'label' => 'Nuevo rol',
        'href' => '/roles/create',
        'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900',
        'icon' => 'fa-plus',
        'title' => 'Crear nuevo rol'
    ]
];
$headers = ['Nombre', 'Descripción', 'Acciones'];
$fields = ['name', 'description', 'actions'];
$rows = $roles;
$actions_config = [
    [
        'type' => 'edit',
        'url' => function ($row) {
            return '/roles/edit?id=' . $row['id'];
        },
        'title' => 'Editar',
        'icon' => 'fa-edit text-yellow-500',
        'class' => 'btn-warning',
    ],
    [
        'type' => 'delete',
        'url' => function ($row) {
            return '/roles/delete?id=' . $row['id'];
        },
        'title' => 'Eliminar',
        'icon' => 'fa-trash text-red-500',
        'class' => 'btn-danger',
        'onclick' => function ($row) {
            return "return confirm('¿Seguro que deseas eliminar este rol?')";
        },
    ],
];
ob_start();
include __DIR__ . '/../components/table.php';
$content = ob_get_clean();
$page = $pagina_actual ?? 1;
$totalPages = $total_paginas ?? 1;
require_once __DIR__ . '/../layouts/app.php';
