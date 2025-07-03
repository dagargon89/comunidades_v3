<?php
$title = 'Nuevo permiso';
ob_start();
$fields = [
    ['name' => 'name', 'label' => 'Nombre', 'type' => 'text', 'value' => '', 'required' => true],
    ['name' => 'description', 'label' => 'Descripción', 'type' => 'text', 'value' => ''],
];
$action = '/permissions/store';
$method = 'post';
$buttons = [
    ['type' => 'submit', 'label' => 'Guardar', 'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900'],
    ['type' => 'link', 'label' => 'Cancelar', 'href' => '/permissions', 'class' => 'bg-gray-200 text-gray-800 hover:bg-gray-300'],
];
?>
<div class="max-w-xl mx-auto mt-8 bg-white rounded-xl shadow p-8">
    <h2 class="text-2xl font-bold mb-6">Nuevo permiso</h2>
    <?php include __DIR__ . '/../components/flash.php'; ?>
    <?php include __DIR__ . '/../components/form.php'; ?>
</div>
<?php $content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
