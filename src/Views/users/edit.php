<?php
$title = 'Editar usuario';
$fields = [
    ['name' => 'id', 'label' => '', 'type' => 'hidden', 'value' => $usuario->getId()],
    ['name' => 'first_name', 'label' => 'Nombre', 'type' => 'text', 'value' => $usuario->getFirstName(), 'required' => true],
    ['name' => 'last_name', 'label' => 'Apellidos', 'type' => 'text', 'value' => $usuario->getLastName(), 'required' => true],
    ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'value' => $usuario->getEmail(), 'required' => true],
    ['name' => 'username', 'label' => 'Usuario', 'type' => 'text', 'value' => $usuario->getUsername(), 'required' => true],
    ['name' => 'password', 'label' => 'Contraseña (dejar vacío para no cambiar)', 'type' => 'password', 'value' => ''],
    ['name' => 'confirm_password', 'label' => 'Confirmar contraseña', 'type' => 'password', 'value' => ''],
    ['name' => 'rol', 'label' => 'Rol', 'type' => 'select', 'options' => array_column($roles, 'name', 'id'), 'value' => $rol_actual],
    ['name' => 'is_active', 'label' => 'Estado', 'type' => 'select', 'options' => ['1' => 'Activo', '0' => 'Inactivo'], 'value' => $usuario->isActive() ? '1' : '0'],
];
$action = '/users/update';
$method = 'post';
$buttons = [
    ['type' => 'submit', 'label' => 'Actualizar', 'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900'],
    ['type' => 'link', 'label' => 'Cancelar', 'href' => '/users', 'class' => 'bg-gray-200 text-gray-800 hover:bg-gray-300'],
];
ob_start();
include __DIR__ . '/../components/form.php';
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
