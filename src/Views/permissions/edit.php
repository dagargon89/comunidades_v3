<?php
$title = 'Editar permiso';
ob_start();
$fields = [
    ['name' => 'id', 'label' => '', 'type' => 'hidden', 'value' => $permission['id']],
    ['name' => 'name', 'label' => 'Nombre', 'type' => 'text', 'value' => $permission['name'], 'required' => true],
    ['name' => 'description', 'label' => 'Descripción', 'type' => 'text', 'value' => $permission['description']],
];
$action = '/permissions/update';
$method = 'post';
$buttons = [
    ['type' => 'submit', 'label' => 'Actualizar', 'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900'],
    ['type' => 'link', 'label' => 'Cancelar', 'href' => '/permissions', 'class' => 'bg-gray-200 text-gray-800 hover:bg-gray-300'],
];
?>
<div class="max-w-xl mx-auto mt-8 bg-white rounded-xl shadow p-8">
    <h2 class="text-2xl font-bold mb-6">Editar permiso</h2>
    <?php include __DIR__ . '/../components/flash.php'; ?>
    <?php if (isset($permission['is_active'])): ?>
        <?php
        $badge = [
            'text' => $permission['is_active'] ? 'Activo' : 'Inactivo',
            'color' => $permission['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800',
        ];
        include __DIR__ . '/../components/badge.php';
        ?>
    <?php endif; ?>
    <?php include __DIR__ . '/../components/form.php'; ?>
</div>
<?php $content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
