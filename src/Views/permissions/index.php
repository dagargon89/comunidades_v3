<?php
$title = 'Permisos';
ob_start();
?>
<?php include __DIR__ . '/../components/flash.php'; ?>
<div class="max-w-3xl mx-auto mt-8 bg-white rounded-xl shadow p-8">
    <h2 class="text-2xl font-bold mb-6">Permisos</h2>
    <?php if (!empty($_SESSION['flash_error'])): ?>
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded"> <?= $_SESSION['flash_error'];
                                                                unset($_SESSION['flash_error']); ?> </div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['flash_success'])): ?>
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded"> <?= $_SESSION['flash_success'];
                                                                    unset($_SESSION['flash_success']); ?> </div>
    <?php endif; ?>
    <div class="mb-4 flex justify-end">
        <?php if (current_user() && current_user()->hasPermission('permission.create')): ?>
            <a href="/permissions/create" class="btn-secondary px-4 py-2"><i class="fas fa-plus mr-1"></i>Nuevo permiso</a>
        <?php endif; ?>
    </div>
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                <th class="px-6 py-3 text-left"></th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($permissions as $perm): ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-left"> <?= htmlspecialchars($perm['name']) ?> </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-left"> <?= htmlspecialchars($perm['description']) ?> </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex gap-2 text-left">
                        <?php if (current_user() && current_user()->hasPermission('permission.edit')): ?>
                            <a href="/permissions/edit?id=<?= $perm['id'] ?>" class="text-blue-600 hover:text-blue-900" title="Editar"><i class="fas fa-edit"></i></a>
                        <?php endif; ?>
                        <?php if (current_user() && current_user()->hasPermission('permission.delete')): ?>
                            <a href="/permissions/delete?id=<?= $perm['id'] ?>" class="text-red-600 hover:text-red-900" title="Eliminar" onclick="return confirm('¿Seguro que deseas eliminar este permiso?')"><i class="fas fa-trash"></i></a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php $content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
