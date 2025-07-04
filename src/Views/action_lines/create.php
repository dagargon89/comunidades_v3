<?php
$title = 'Nueva Línea de acción';
$useCard = true;
$fields = [
    ['name' => 'name', 'label' => 'Nombre', 'type' => 'text', 'value' => '', 'required' => true],
    ['name' => 'Program_id', 'label' => 'Programa', 'type' => 'select', 'options' => array_column($programs, 'name', 'id'), 'value' => '', 'required' => true],
];
$action = '/action_lines/store';
$method = 'post';
$buttons = [
    ['type' => 'submit', 'label' => 'Guardar', 'class' => 'btn-primary'],
    ['type' => 'link', 'label' => 'Cancelar', 'href' => '/action_lines', 'class' => 'btn-secondary'],
];
ob_start();
include __DIR__ . '/../ui_components/form.php';
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
