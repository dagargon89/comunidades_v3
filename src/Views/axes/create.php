<?php
$title = 'Nuevo Eje';
$useCard = true;
$fields = [
    ['name' => 'name', 'label' => 'Nombre', 'type' => 'text', 'value' => '', 'required' => true],
];
$action = '/axes/store';
$method = 'post';
$buttons = [
    ['type' => 'submit', 'label' => 'Guardar', 'class' => 'btn-secondary px-5 py-2'],
    ['type' => 'link', 'label' => 'Cancelar', 'href' => '/axes', 'class' => 'btn-secondary bg-gray-300 text-gray-800 hover:bg-gray-400'],
];
ob_start();
include __DIR__ . '/../components/form.php';
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
