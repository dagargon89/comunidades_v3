<?php
$title = 'Editar Eje';
$useCard = true;
$fields = [
    ['name' => 'id', 'label' => '', 'type' => 'hidden', 'value' => $axis['id']],
    ['name' => 'name', 'label' => 'Nombre', 'type' => 'text', 'value' => $axis['name'], 'required' => true],
];
$action = '/axes/update';
$method = 'post';
$buttons = [
    ['type' => 'submit', 'label' => 'Actualizar', 'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900'],
    ['type' => 'link', 'label' => 'Cancelar', 'href' => '/axes', 'class' => 'bg-gray-200 text-gray-800 hover:bg-gray-300'],
];
ob_start();
include __DIR__ . '/../components/form.php';
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
