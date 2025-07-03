<?php
$title = 'Editar usuario';
ob_start();
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
    ['type' => 'submit', 'label' => 'Actualizar', 'class' => 'btn-secondary px-5 py-2'],
    ['type' => 'link', 'label' => 'Cancelar', 'href' => '/users', 'class' => 'btn-secondary bg-gray-300 text-gray-800 hover:bg-gray-400'],
];
?>
<div class="max-w-xl mx-auto mt-8 bg-white rounded-xl shadow p-8">
    <h2 class="text-2xl font-bold mb-6">Editar usuario</h2>
    <?php include __DIR__ . '/../components/flash.php'; ?>
    <?php include __DIR__ . '/../components/form.php'; ?>
    <?php if (isset($_SESSION['user']) && isset($_SESSION['user']['rol']) && $_SESSION['user']['rol'] === 'admin'): ?>
        <a href="/users/delete?id=<?= $usuario->getId() ?>&force=1" class="btn-secondary bg-red-600 text-white hover:bg-red-700 ml-auto" onclick="return confirm('¿Estás seguro de que deseas eliminar DEFINITIVAMENTE este usuario? Esta acción no se puede deshacer.');">
            <i class="fas fa-trash mr-1"></i> Eliminar definitivamente
        </a>
    <?php endif; ?>
</div>
<?php $content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
