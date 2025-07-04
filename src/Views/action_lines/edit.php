<?php
$title = 'Editar Línea de acción';
$useCard = true;
$fields = [
    ['name' => 'name', 'label' => 'Nombre', 'type' => 'text', 'value' => $actionLine['name'] ?? '', 'required' => true],
    ['name' => 'Program_id', 'label' => 'Programa', 'type' => 'select', 'options' => array_column($programs, 'name', 'id'), 'value' => $actionLine['Program_id'] ?? '', 'required' => true],
];
$action = '/action_lines/update';
$method = 'post';
$buttons = [
    ['type' => 'submit', 'label' => 'Actualizar', 'class' => 'btn-primary'],
    ['type' => 'link', 'label' => 'Cancelar', 'href' => '/action_lines', 'class' => 'btn-secondary'],
];
$hidden = [
    ['name' => 'id', 'value' => $actionLine['id'] ?? '']
];
ob_start();
include __DIR__ . '/../components/form.php';
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
