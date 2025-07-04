<?php
$title = 'Editar Componente';
$fields = [
    ['name' => 'name', 'label' => 'Nombre', 'type' => 'text', 'value' => $component['name'] ?? '', 'required' => true],
    [
        'name' => 'action_lines_id',
        'label' => 'Línea de acción',
        'type' => 'select',
        'options' => array_column($actionLines, 'name', 'id'),
        'value' => $component['action_lines_id'] ?? '',
        'required' => true
    ],
    ['name' => 'id', 'type' => 'hidden', 'value' => $component['id'] ?? ''],
];
$action = '/components/update';
$method = 'post';
$buttons = [
    ['type' => 'submit', 'label' => 'Actualizar', 'class' => 'btn-primary'],
    ['type' => 'link', 'label' => 'Cancelar', 'href' => '/components', 'class' => 'btn-secondary'],
];
ob_start();
$useCard = true;
include __DIR__ . '/../ui_components/form.php';
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
