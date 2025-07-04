<?php
$title = 'Nuevo Programa';
$useCard = true;
$fields = [
    ['name' => 'name', 'label' => 'Nombre del Programa', 'type' => 'text', 'value' => isset($_POST['name']) ? $_POST['name'] : '', 'required' => true],
    ['name' => 'axes_id', 'label' => 'Eje', 'type' => 'select', 'options' => array_column($axes, 'name', 'id'), 'value' => isset($_POST['axes_id']) ? $_POST['axes_id'] : '', 'required' => true],
];
$action = '/programs/store';
$method = 'post';
$buttons = [
    ['type' => 'submit', 'label' => 'Guardar', 'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900'],
    ['type' => 'link', 'label' => 'Cancelar', 'href' => '/programs', 'class' => 'bg-gray-200 text-gray-800 hover:bg-gray-300'],
];
ob_start();
include __DIR__ . '/../ui_components/form.php';
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
