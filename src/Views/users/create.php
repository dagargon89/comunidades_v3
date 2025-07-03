<?php
$title = 'Nuevo usuario';
ob_start();
$fields = [
    ['name' => 'first_name', 'label' => 'Nombre', 'type' => 'text', 'value' => '', 'required' => true],
    ['name' => 'last_name', 'label' => 'Apellidos', 'type' => 'text', 'value' => '', 'required' => true],
    ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'value' => '', 'required' => true],
    ['name' => 'username', 'label' => 'Usuario', 'type' => 'text', 'value' => '', 'required' => true],
    ['name' => 'password', 'label' => 'Contraseña', 'type' => 'password', 'value' => '', 'required' => true],
    ['name' => 'confirm_password', 'label' => 'Confirmar contraseña', 'type' => 'password', 'value' => '', 'required' => true],
    ['name' => 'rol', 'label' => 'Rol', 'type' => 'select', 'options' => array_column($roles, 'name', 'id'), 'value' => ''],
    ['name' => 'is_active', 'label' => 'Estado', 'type' => 'select', 'options' => ['1' => 'Activo', '0' => 'Inactivo'], 'value' => '1'],
];
$action = '/users/store';
$method = 'post';
$buttons = [
    ['type' => 'submit', 'label' => 'Guardar', 'class' => 'btn-secondary px-5 py-2'],
    ['type' => 'link', 'label' => 'Cancelar', 'href' => '/users', 'class' => 'btn-secondary bg-gray-300 text-gray-800 hover:bg-gray-400'],
];
?>
<div class="max-w-xl mx-auto mt-8 bg-white rounded-xl shadow p-8">
    <h2 class="text-2xl font-bold mb-6">Nuevo usuario</h2>
    <?php include __DIR__ . '/../components/flash.php'; ?>
    <?php include __DIR__ . '/../components/form.php'; ?>
</div>
<?php $content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
