<?php
$title = 'Editar Programa';
ob_start();
$fields = [
    ['name' => 'id', 'label' => '', 'type' => 'hidden', 'value' => $program['id']],
    ['name' => 'name', 'label' => 'Nombre del Programa', 'type' => 'text', 'value' => $program['name'], 'required' => true],
    ['name' => 'axes_id', 'label' => 'Eje', 'type' => 'select', 'options' => array_column($axes, 'name', 'id'), 'value' => $program['axes_id'], 'required' => true],
];
$action = '/programs/update';
$method = 'post';
$buttons = [
    ['type' => 'submit', 'label' => 'Actualizar', 'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900'],
    ['type' => 'link', 'label' => 'Cancelar', 'href' => '/programs', 'class' => 'bg-gray-200 text-gray-800 hover:bg-gray-300'],
];
?>
<div class="max-w-xl mx-auto mt-8 bg-white rounded-xl shadow p-8">
    <h2 class="text-2xl font-bold mb-6">Editar Programa</h2>
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Ha ocurrido un error al actualizar el programa. Por favor, inténtelo de nuevo.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <?php include __DIR__ . '/../components/form.php'; ?>
</div>
<?php $content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
?>