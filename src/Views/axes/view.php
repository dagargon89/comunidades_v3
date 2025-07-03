<?php
ob_start();
// ... existing code ...
use function current_user;
?>
<div class="w-[90%] max-w-full mx-auto bg-white rounded shadow p-6 mt-8">
    <h1 class="text-2xl font-bold mb-4">Detalle del Eje</h1>
    <?php include __DIR__ . '/../components/flash.php'; ?>
    <div class="mb-4">
        <strong>ID:</strong> <?= htmlspecialchars($axis['id']) ?><br>
        <strong>Nombre:</strong> <?= htmlspecialchars($axis['name']) ?><br>
        <strong>Creado:</strong> <?= htmlspecialchars($axis['created_at']) ?><br>
        <strong>Actualizado:</strong> <?= htmlspecialchars($axis['updated_at']) ?><br>
    </div>
    <div class="flex justify-end space-x-2">
        <?php if (current_user() && current_user()->hasPermission('axis.edit')): ?>
            <a href="/axes/edit?id=<?= $axis['id'] ?>" class="btn btn-warning">Editar</a>
        <?php endif; ?>
        <?php if (current_user() && current_user()->hasPermission('axis.delete')): ?>
            <a href="/axes/delete?id=<?= $axis['id'] ?>" class="btn btn-danger" onclick="return confirm('¿Seguro que deseas eliminar este eje?')">Eliminar</a>
        <?php endif; ?>
        <a href="/axes" class="btn btn-secondary">Volver</a>
    </div>
</div>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
