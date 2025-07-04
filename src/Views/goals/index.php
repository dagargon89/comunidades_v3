<?php
$title = 'Metas';
$filters = [
    ['type' => 'text', 'name' => 'q', 'placeholder' => 'Buscar por descripción, componente u organización...', 'value' => htmlspecialchars($_GET['q'] ?? '')],
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
        'label' => 'Nueva Meta',
        'href' => '/goals/create',
        'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900',
        'icon' => 'fa-plus',
        'title' => 'Crear nueva meta'
    ]
];
$headers = ['ID', 'Descripción', 'Número', 'Componente', 'Organización'];
$fields = ['id', 'description', 'number', 'component_name', 'organization_name'];
$rows = $goals;
$actions_config = [
    [
        'type' => 'view',
        'url' => function ($row) {
            return '/goals/view?id=' . $row['id'];
        },
        'title' => 'Ver',
        'icon' => 'fa-eye text-blue-500',
        'class' => 'btn-info',
    ],
    [
        'type' => 'edit',
        'url' => function ($row) {
            return '/goals/edit?id=' . $row['id'];
        },
        'title' => 'Editar',
        'icon' => 'fa-edit text-yellow-500',
        'class' => 'btn-warning',
    ],
    [
        'type' => 'delete',
        'url' => function ($row) {
            return '/goals/delete?id=' . $row['id'];
        },
        'title' => 'Eliminar',
        'icon' => 'fa-trash text-red-500',
        'class' => 'btn-danger',
        'onclick' => function ($row) {
            return "return confirm('¿Seguro que deseas eliminar esta meta?')";
        },
    ],
];
ob_start();
include __DIR__ . '/../ui_components/table.php';
$content = ob_get_clean();
$page = $page ?? 1;
$totalPages = $totalPages ?? 1;
require_once __DIR__ . '/../layouts/app.php';
