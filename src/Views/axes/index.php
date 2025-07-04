<?php
$title = 'Ejes';
$filters = [
    ['type' => 'text', 'name' => 'q', 'placeholder' => 'Buscar por nombre de eje...', 'value' => htmlspecialchars($_GET['q'] ?? '')],
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
        'label' => 'Nuevo Eje',
        'href' => '/axes/create',
        'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900',
        'icon' => 'fa-plus',
        'title' => 'Crear nuevo eje'
    ]
];
$headers = ['ID', 'Nombre', 'Acciones'];
$fields = ['id', 'name', 'actions'];
$rows = $axes;
$actions_config = [
    [
        'type' => 'edit',
        'url' => function ($row) {
            return '/axes/edit?id=' . $row['id'];
        },
        'title' => 'Editar',
        'icon' => 'fa-edit text-yellow-500',
        'class' => 'btn-warning',
    ],
    [
        'type' => 'delete',
        'url' => function ($row) {
            return '/axes/delete?id=' . $row['id'];
        },
        'title' => 'Eliminar',
        'icon' => 'fa-trash text-red-500',
        'class' => 'btn-danger',
        'onclick' => function ($row) {
            return "return confirm('¿Seguro que deseas eliminar este eje?')";
        },
    ],
];
ob_start();
include __DIR__ . '/../components/table.php';
$content = ob_get_clean();
$page = $pagina_actual ?? 1;
$totalPages = $total_paginas ?? 1;
require_once __DIR__ . '/../layouts/app.php';
