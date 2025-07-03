<?php
$title = 'Editar rol';
ob_start();
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
?>
<div class="max-w-xl mx-auto mt-8 bg-white rounded-xl shadow p-8">
    <h2 class="text-2xl font-bold mb-6">Editar rol</h2>
    <?php include __DIR__ . '/../components/flash.php'; ?>
    <?php include __DIR__ . '/../components/form.php'; ?>
    <div class="mt-8">
        <label class="block text-sm font-semibold mb-1">Permisos</label>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-2 bg-gray-50 rounded p-3 border border-gray-200 max-h-64 overflow-y-auto">
            <?php foreach ($all_permissions as $perm): ?>
                <label class="flex items-center gap-2 text-sm">
                    <input type="checkbox" name="permissions[]" value="<?= $perm['id'] ?>" <?= in_array($perm['id'], $role_permissions) ? 'checked' : '' ?>>
                    <span><?= htmlspecialchars($perm['name']) ?> <span class="text-gray-400">(<?= htmlspecialchars($perm['description']) ?>)</span></span>
                </label>
            <?php endforeach; ?>
        </div>
    </div>
</div>
<?php $content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
