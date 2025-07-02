<?php
$title = 'Editar permiso';
ob_start();
?>
<div class="max-w-xl mx-auto mt-8 bg-white rounded-xl shadow p-8">
    <h2 class="text-2xl font-bold mb-6">Editar permiso</h2>
    <?php if (!empty($_SESSION['flash_error'])): ?>
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded"> <?= $_SESSION['flash_error'];
                                                                unset($_SESSION['flash_error']); ?> </div>
    <?php endif; ?>
    <form method="post" action="/permissions/update" class="space-y-4">
        <input type="hidden" name="id" value="<?= $permission['id'] ?>">
        <div>
            <label class="block text-sm font-semibold mb-1">Nombre</label>
            <input type="text" name="name" value="<?= htmlspecialchars($permission['name']) ?>" class="form-input w-full rounded-lg border border-gray-300 bg-gray-50 focus:bg-white focus:border-primary focus:ring-primary px-4 py-2" required>
        </div>
        <div>
            <label class="block text-sm font-semibold mb-1">Descripción</label>
            <input type="text" name="description" value="<?= htmlspecialchars($permission['description']) ?>" class="form-input w-full rounded-lg border border-gray-300 bg-gray-50 focus:bg-white focus:border-primary focus:ring-primary px-4 py-2">
        </div>
        <div class="flex gap-2 mt-6">
            <button type="submit" class="btn-secondary px-5 py-2">Actualizar</button>
            <a href="/permissions" class="btn-secondary bg-gray-300 text-gray-800 hover:bg-gray-400">Cancelar</a>
        </div>
    </form>
</div>
<?php $content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
