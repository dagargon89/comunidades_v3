<?php
$title = 'Editar Meta';
$fields = [
    ['name' => 'description', 'label' => 'Descripción', 'type' => 'textarea', 'value' => $goal['description'] ?? '', 'required' => true],
    ['name' => 'number', 'label' => 'Número', 'type' => 'number', 'value' => $goal['number'] ?? '', 'required' => false],
    [
        'name' => 'components_id',
        'label' => 'Componente',
        'type' => 'select',
        'options' => array_column($components, 'name', 'id'),
        'value' => $goal['components_id'] ?? '',
        'required' => true
    ],
    [
        'name' => 'organizations_id',
        'label' => 'Organización',
        'type' => 'select',
        'options' => array_column($organizations, 'name', 'id'),
        'value' => $goal['organizations_id'] ?? '',
        'required' => true
    ],
    ['name' => 'id', 'type' => 'hidden', 'value' => $goal['id'] ?? ''],
];
$action = '/goals/update';
$method = 'post';
$buttons = [
    ['type' => 'submit', 'label' => 'Actualizar', 'class' => 'btn-primary'],
    ['type' => 'link', 'label' => 'Cancelar', 'href' => '/goals', 'class' => 'btn-secondary'],
];
ob_start();
$useCard = true;
include __DIR__ . '/../ui_components/form.php';
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
