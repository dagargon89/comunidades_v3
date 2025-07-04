<?php
$title = 'Nueva Organización';
$fields = [
    ['name' => 'name', 'label' => 'Nombre', 'type' => 'text', 'value' => '', 'required' => true],
];
$action = '/organizations/store';
$method = 'post';
$buttons = [
    ['type' => 'submit', 'label' => 'Guardar', 'class' => 'btn-primary'],
    ['type' => 'link', 'label' => 'Cancelar', 'href' => '/organizations', 'class' => 'btn-secondary'],
];
ob_start();
$useCard = true;
include __DIR__ . '/../ui_components/form.php';
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
