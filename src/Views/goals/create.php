<?php
$title = 'Nueva Meta';
$fields = [
    ['name' => 'description', 'label' => 'Descripción', 'type' => 'textarea', 'value' => '', 'required' => true],
    ['name' => 'number', 'label' => 'Número', 'type' => 'number', 'value' => '', 'required' => false],
    [
        'name' => 'components_id',
        'label' => 'Componente',
        'type' => 'select',
        'options' => array_column($components, 'name', 'id'),
        'value' => '',
        'required' => true
    ],
    [
        'name' => 'organizations_id',
        'label' => 'Organización',
        'type' => 'select',
        'options' => array_column($organizations, 'name', 'id'),
        'value' => '',
        'required' => true
    ],
];
$action = '/goals/store';
$method = 'post';
$buttons = [
    ['type' => 'submit', 'label' => 'Guardar', 'class' => 'btn-primary'],
    ['type' => 'link', 'label' => 'Cancelar', 'href' => '/goals', 'class' => 'btn-secondary'],
];
ob_start();
$useCard = true;
include __DIR__ . '/../ui_components/form.php';
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
