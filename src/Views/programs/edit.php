<?php
$title = 'Editar Programa';
$fields = [
    ['name' => 'id', 'label' => '', 'type' => 'hidden', 'value' => $program['id']],
    ['name' => 'name', 'label' => 'Nombre del Programa', 'type' => 'text', 'value' => $program['name'], 'required' => true],
    ['name' => 'axes_id', 'label' => 'Eje', 'type' => 'select', 'options' => array_column($axes, 'name', 'id'), 'value' => $program['axes_id'], 'required' => true],
];
$action = '/programs/update';
$method = 'post';
$buttons = [
    ['type' => 'submit', 'label' => 'Actualizar', 'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900'],
    ['type' => 'link', 'label' => 'Cancelar', 'href' => '/programs', 'class' => 'bg-gray-200 text-gray-800 hover:bg-gray-300'],
];
ob_start();
include __DIR__ . '/../components/form.php';
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
