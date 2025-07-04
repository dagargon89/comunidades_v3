<?php
$title = 'Líneas de acción';
$filters = [
    ['type' => 'text', 'name' => 'q', 'placeholder' => 'Buscar por nombre o programa...', 'value' => htmlspecialchars($_GET['q'] ?? '')],
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
        'label' => 'Nueva Línea de acción',
        'href' => '/action_lines/create',
        'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900',
        'icon' => 'fa-plus',
        'title' => 'Crear nueva'
    ]
];
$headers = ['ID', 'Nombre', 'Programa'];
$fields = ['id', 'name', 'program_name'];
$rows = $actionLines;
$actions_config = [
    [
        'type' => 'view',
        'url' => function ($row) {
            return '/action_lines/view?id=' . $row['id'];
        },
        'title' => 'Ver',
        'icon' => 'fa-eye text-blue-500',
        'class' => 'btn-info',
    ],
    [
        'type' => 'edit',
        'url' => function ($row) {
            return '/action_lines/edit?id=' . $row['id'];
        },
        'title' => 'Editar',
        'icon' => 'fa-edit text-yellow-500',
        'class' => 'btn-warning',
    ],
    [
        'type' => 'delete',
        'url' => function ($row) {
            return '/action_lines/delete?id=' . $row['id'];
        },
        'title' => 'Eliminar',
        'icon' => 'fa-trash text-red-500',
        'class' => 'btn-danger',
        'onclick' => function ($row) {
            return "return confirm('¿Seguro que deseas eliminar esta línea de acción?')";
        },
    ],
];
ob_start();
include __DIR__ . '/../ui_components/table.php';
$content = ob_get_clean();
$page = $page ?? 1;
$totalPages = $totalPages ?? 1;
require_once __DIR__ . '/../layouts/app.php';
