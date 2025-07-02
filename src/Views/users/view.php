<?php
$title = 'Detalles de usuario';
ob_start();
?>
<div class="max-w-2xl mx-auto mt-8 bg-white rounded-xl shadow p-8">
    <h2 class="text-2xl font-bold mb-6">Detalles de usuario</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
            <span class="block text-xs text-gray-500">Nombre</span>
            <span class="block text-lg font-semibold text-gray-900"><?= htmlspecialchars($usuario->getFirstName() . ' ' . $usuario->getLastName()) ?></span>
        </div>
        <div>
            <span class="block text-xs text-gray-500">Usuario</span>
            <span class="block text-lg font-semibold text-gray-900"><?= htmlspecialchars($usuario->getUsername()) ?></span>
        </div>
        <div>
            <span class="block text-xs text-gray-500">Email</span>
            <span class="block text-lg font-semibold text-gray-900"><?= htmlspecialchars($usuario->getEmail()) ?></span>
        </div>
        <div>
            <span class="block text-xs text-gray-500">Rol</span>
            <span class="block text-lg font-semibold text-gray-900"><?= isset($roles_usuario[0]['name']) ? htmlspecialchars($roles_usuario[0]['name']) : '-' ?></span>
        </div>
        <div>
            <span class="block text-xs text-gray-500">Estado</span>
            <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold <?= $usuario->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                <?= $usuario->isActive() ? 'Activo' : 'Inactivo' ?>
            </span>
        </div>
        <div>
            <span class="block text-xs text-gray-500">Fecha de registro</span>
            <span class="block text-lg font-semibold text-gray-900"><?= htmlspecialchars($usuario->getCreatedAt()) ?></span>
        </div>
        <div>
            <span class="block text-xs text-gray-500">Último acceso</span>
            <span class="block text-lg font-semibold text-gray-900"><?= htmlspecialchars($usuario->getUpdatedAt()) ?></span>
        </div>
    </div>
    <div class="flex flex-wrap gap-2 mt-6">
        <a href="/users" class="btn-secondary bg-gray-300 text-gray-800 hover:bg-gray-400">Volver al listado</a>
        <?php if (isset($_SESSION['user']) && isset($_SESSION['user']['rol']) && $_SESSION['user']['rol'] === 'admin'): ?>
            <a href="/users/edit?id=<?= $usuario->getId() ?>" class="btn-secondary px-4 py-2"><i class="fas fa-edit mr-1"></i>Editar</a>
            <a href="/users/delete?id=<?= $usuario->getId() ?>" class="btn-secondary bg-red-600 text-white hover:bg-red-700 px-4 py-2" onclick="return confirm('¿Seguro que deseas eliminar este usuario?')"><i class="fas fa-trash mr-1"></i>Eliminar</a>
            <?php if ($usuario->isActive()): ?>
                <a href="/users/block?id=<?= $usuario->getId() ?>" class="btn-secondary bg-yellow-500 text-white hover:bg-yellow-600 px-4 py-2"><i class="fas fa-ban mr-1"></i>Bloquear</a>
            <?php else: ?>
                <a href="/users/unblock?id=<?= $usuario->getId() ?>" class="btn-secondary bg-green-600 text-white hover:bg-green-700 px-4 py-2"><i class="fas fa-unlock mr-1"></i>Desbloquear</a>
                <a href="/users/reactivate?id=<?= $usuario->getId() ?>" class="btn-secondary bg-green-600 text-white hover:bg-green-700 px-4 py-2"><i class="fas fa-undo mr-1"></i>Reactivar</a>
            <?php endif; ?>
            <a href="/users/reset-password?id=<?= $usuario->getId() ?>" class="btn-secondary bg-indigo-600 text-white hover:bg-indigo-700 px-4 py-2"><i class="fas fa-key mr-1"></i>Resetear contraseña</a>
        <?php endif; ?>
        <a href="mailto:<?= htmlspecialchars($usuario->getEmail()) ?>" class="btn-secondary bg-blue-600 text-white hover:bg-blue-700 px-4 py-2"><i class="fas fa-envelope mr-1"></i>Enviar correo</a>
    </div>
</div>
<?php $content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
