<?php
$title = 'Programas';
$filters = [
    ['type' => 'text', 'name' => 'q', 'placeholder' => 'Buscar por nombre de programa o eje...', 'value' => htmlspecialchars($_GET['q'] ?? '')],
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
        'label' => 'Nuevo Programa',
        'href' => '/programs/create',
        'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900',
        'icon' => 'fa-plus',
        'title' => 'Crear nuevo programa'
    ]
];
$headers = ['ID', 'Nombre', 'Eje'];
$fields = ['id', 'name', 'axis_name'];
$rows = $programs;
$actions_config = [
    [
        'type' => 'view',
        'url' => function ($row) {
            return '/programs/view?id=' . $row['id'];
        },
        'title' => 'Ver',
        'icon' => 'fa-eye text-blue-500',
        'class' => 'btn-info',
    ],
    [
        'type' => 'edit',
        'url' => function ($row) {
            return '/programs/edit?id=' . $row['id'];
        },
        'title' => 'Editar',
        'icon' => 'fa-edit text-yellow-500',
        'class' => 'btn-warning',
    ],
    [
        'type' => 'delete',
        'url' => function ($row) {
            return '/programs/delete?id=' . $row['id'];
        },
        'title' => 'Eliminar',
        'icon' => 'fa-trash text-red-500',
        'class' => 'btn-danger',
        'onclick' => function ($row) {
            return "return confirm('¿Seguro que deseas eliminar este programa?')";
        },
    ],
];
ob_start();
include __DIR__ . '/../ui_components/table.php';
$content = ob_get_clean();
$page = $pagina_actual ?? 1;
$totalPages = $total_paginas ?? 1;
require_once __DIR__ . '/../layouts/app.php';
