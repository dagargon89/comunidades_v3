<?php
ob_start();
// ... existing code ...
use function current_user;
?>
<div class="w-[90%] max-w-full mx-auto bg-white rounded shadow p-6 mt-8">
    <h1 class="text-2xl font-bold mb-4">Editar Eje</h1>
    <?php include __DIR__ . '/../components/flash.php'; ?>
    <form action="/axes/update" method="POST" class="space-y-4">
        <input type="hidden" name="id" value="<?= htmlspecialchars($axis['id']) ?>">
        <div>
            <label for="name" class="block font-semibold">Nombre</label>
            <input type="text" name="name" id="name" class="input w-full" required maxlength="500" value="<?= htmlspecialchars($axis['name']) ?>">
        </div>
        <div class="flex justify-end">
            <button type="submit" class="btn btn-primary">Actualizar</button>
            <a href="/axes" class="btn btn-secondary ml-2">Cancelar</a>
        </div>
    </form>
</div>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
