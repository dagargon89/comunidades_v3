<?php
$title = 'Editar rol';
$useCard = true;
$fields = [
    ['name' => 'id', 'label' => '', 'type' => 'hidden', 'value' => $role['id']],
    ['name' => 'name', 'label' => 'Nombre', 'type' => 'text', 'value' => $role['name'], 'required' => true],
    ['name' => 'description', 'label' => 'Descripción', 'type' => 'text', 'value' => $role['description']],
];
$action = '/roles/update';
$method = 'post';
$buttons = [
    ['type' => 'submit', 'label' => 'Actualizar', 'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900'],
    ['type' => 'link', 'label' => 'Cancelar', 'href' => '/roles', 'class' => 'bg-gray-200 text-gray-800 hover:bg-gray-300'],
];
ob_start();
include __DIR__ . '/../ui_components/form.php';
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
