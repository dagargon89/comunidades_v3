<?php
$title = 'Nuevo rol';
ob_start();
$fields = [
    ['name' => 'name', 'label' => 'Nombre', 'type' => 'text', 'value' => '', 'required' => true],
    ['name' => 'description', 'label' => 'Descripción', 'type' => 'text', 'value' => ''],
];
$action = '/roles/store';
$method = 'post';
$buttons = [
    ['type' => 'submit', 'label' => 'Guardar', 'class' => 'btn-secondary px-5 py-2'],
    ['type' => 'link', 'label' => 'Cancelar', 'href' => '/roles', 'class' => 'btn-secondary bg-gray-300 text-gray-800 hover:bg-gray-400'],
];
?>
<div class="max-w-xl mx-auto mt-8 bg-white rounded-xl shadow p-8">
    <h2 class="text-2xl font-bold mb-6">Nuevo rol</h2>
    <?php include __DIR__ . '/../components/flash.php'; ?>
    <?php include __DIR__ . '/../components/form.php'; ?>
</div>
<?php $content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
