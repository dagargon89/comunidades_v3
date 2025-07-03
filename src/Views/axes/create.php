<?php
ob_start();
// ... existing code ...
use function current_user;
?>
<div class="w-[90%] max-w-full mx-auto bg-white rounded shadow p-6 mt-8">
    <h1 class="text-2xl font-bold mb-4">Nuevo Eje</h1>
    <?php include __DIR__ . '/../components/flash.php'; ?>
    <form action="/axes/store" method="POST" class="space-y-4">
        <div>
            <label for="name" class="block font-semibold">Nombre</label>
            <input type="text" name="name" id="name" class="input w-full" required maxlength="500">
        </div>
        <div class="flex justify-end">
            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="/axes" class="btn btn-secondary ml-2">Cancelar</a>
        </div>
    </form>
</div>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
