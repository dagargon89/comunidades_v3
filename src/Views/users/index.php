<?php
$title = 'Usuarios';
ob_start(); ?>
<?php include __DIR__ . '/../components/flash.php'; ?>
<div class="flex flex-col gap-6 w-[90%] mx-auto">
    <?php if (!empty($_SESSION['flash_error'])): ?>
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded"> <?= $_SESSION['flash_error'];
                                                                unset($_SESSION['flash_error']); ?> </div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['flash_success'])): ?>
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded"> <?= $_SESSION['flash_success'];
                                                                    unset($_SESSION['flash_success']); ?> </div>
    <?php endif; ?>
    <form method="get" class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-4 bg-white p-4 rounded-xl shadow">
        <div class="flex flex-col sm:flex-row gap-2 items-center w-full md:w-auto">
            <input type="text" name="q" value="<?= htmlspecialchars($_GET['q'] ?? '') ?>" class="form-input w-full md:w-64 rounded-lg border border-gray-300 bg-gray-50 focus:bg-white focus:border-primary focus:ring-primary px-4 py-2" placeholder="Buscar por nombre, email o usuario...">
            <select name="rol" class="form-select w-full md:w-48 rounded-lg border border-gray-300 bg-gray-50 focus:bg-white focus:border-primary focus:ring-primary px-4 py-2">
                <option value="">Todos los roles</option>
                <?php foreach ($roles as $rol): ?>
                    <option value="<?= htmlspecialchars($rol['name']) ?>" <?= (($_GET['rol'] ?? '') === $rol['name']) ? 'selected' : '' ?>><?= htmlspecialchars($rol['name']) ?></option>
                <?php endforeach; ?>
            </select>
            <select name="estado" class="form-select w-full md:w-32 rounded-lg border border-gray-300 bg-gray-50 focus:bg-white focus:border-primary focus:ring-primary px-4 py-2">
                <option value="">Todos</option>
                <option value="activo" <?= (($_GET['estado'] ?? '') === 'activo') ? 'selected' : '' ?>>Activos</option>
                <option value="inactivo" <?= (($_GET['estado'] ?? '') === 'inactivo') ? 'selected' : '' ?>>Inactivos</option>
            </select>
        </div>
        <div class="flex gap-2 items-center justify-end w-full md:w-auto">
            <?php
            $btn = [
                'type' => 'submit',
                'label' => 'Filtrar',
                'class' => 'btn-secondary px-5 py-2',
                'icon' => 'fa-search'
            ];
            include __DIR__ . '/../components/button.php';
            ?>
            <div class="mb-4 flex justify-end">
                <?php if (current_user() && current_user()->hasPermission('user.create')): ?>
                    <?php
                    $btn = [
                        'type' => 'link',
                        'label' => 'Nuevo usuario',
                        'href' => '/users/create',
                        'class' => 'btn-secondary px-4 py-2',
                        'icon' => 'fa-plus'
                    ];
                    include __DIR__ . '/../components/button.php';
                    ?>
                <?php endif; ?>
            </div>
        </div>
    </form>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Apellidos</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Usuario</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Rol</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (empty($usuarios)): ?>
                    <tr>
                        <td colspan="6" class="text-center py-8 text-gray-500">No se encontraron usuarios</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-left"> <?= htmlspecialchars($usuario['first_name']) ?> </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-left"> <?= htmlspecialchars($usuario['last_name']) ?> </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-left"> <?= htmlspecialchars($usuario['email']) ?> </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-left"> <?= htmlspecialchars($usuario['username']) ?> </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-left"> <?= htmlspecialchars($usuario['rol']) ?> </td>
                            <td class="px-6 py-4 whitespace-nowrap text-left">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $usuario['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                    <?= $usuario['is_active'] ? 'Activo' : 'Inactivo' ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex gap-2 text-left">
                                <?php
                                $actions = [];
                                if (current_user() && current_user()->hasPermission('user.edit')) {
                                    $actions[] = [
                                        'type' => 'edit',
                                        'url' => "users/edit?id={$usuario['id']}",
                                        'permission' => 'user.edit',
                                        'title' => 'Editar',
                                        'class' => 'text-blue-600 hover:text-blue-900',
                                    ];
                                }
                                if (current_user() && current_user()->hasPermission('user.delete')) {
                                    $actions[] = [
                                        'type' => 'delete',
                                        'url' => "users/delete?id={$usuario['id']}",
                                        'permission' => 'user.delete',
                                        'title' => 'Eliminar',
                                        'class' => 'text-red-600 hover:text-red-900',
                                        'onclick' => "return confirm('¿Seguro que deseas eliminar este usuario?')",
                                    ];
                                }
                                include __DIR__ . '/../components/action_buttons.php';
                                ?>
                                <!-- Acciones rápidas ocultas temporalmente -->
                                <!--
                                <a href="users/view?id=<?= $usuario['id'] ?>" class="text-gray-600 hover:text-primary" title="Ver detalles"><i class="fas fa-eye"></i></a>
                                <?php if (!$usuario['is_active']): ?>
                                    <a href="users/reactivate?id=<?= $usuario['id'] ?>" class="text-green-600 hover:text-green-800" title="Reactivar"><i class="fas fa-undo"></i></a>
                                <?php endif; ?>
                                <a href="users/reset-password?id=<?= $usuario['id'] ?>" class="text-yellow-600 hover:text-yellow-800" title="Resetear contraseña"><i class="fas fa-key"></i></a>
                                <span class="relative">
                                    <a href="#" class="text-purple-600 hover:text-purple-800" title="Cambiar rol" onclick="event.preventDefault(); document.getElementById('select-rol-<?= $usuario['id'] ?>').classList.toggle('hidden');"><i class="fas fa-user-shield"></i></a>
                                    <form method="post" action="users/change-role" class="absolute left-0 mt-2 z-10 hidden" id="select-rol-<?= $usuario['id'] ?>" style="min-width:120px;">
                                        <input type="hidden" name="id" value="<?= $usuario['id'] ?>">
                                        <select name="rol" class="text-xs border rounded px-1 py-0.5 bg-white shadow" onchange="this.form.submit()">
                                            <?php foreach ($roles as $rol): ?>
                                                <option value="<?= $rol['name'] ?>" <?= ($usuario['rol'] === $rol['name']) ? 'selected' : '' ?>><?= htmlspecialchars($rol['name']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </form>
                                </span>
                                <?php if ($usuario['is_active']): ?>
                                    <a href="users/block?id=<?= $usuario['id'] ?>" class="text-gray-500 hover:text-black" title="Bloquear"><i class="fas fa-ban"></i></a>
                                <?php else: ?>
                                    <a href="users/unblock?id=<?= $usuario['id'] ?>" class="text-gray-500 hover:text-black" title="Desbloquear"><i class="fas fa-unlock"></i></a>
                                <?php endif; ?>
                                <a href="mailto:<?= htmlspecialchars($usuario['email']) ?>" class="text-indigo-600 hover:text-indigo-900" title="Enviar correo"><i class="fas fa-envelope"></i></a>
                                -->
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if ($total_paginas > 1): ?>
        <div class="flex justify-between items-center mt-4">
            <nav class="inline-flex rounded-md shadow-sm" aria-label="Paginación">
                <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                    <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>" class="px-3 py-1 border <?= $i === $pagina_actual ? 'bg-primary text-white' : '' ?>"> <?= $i ?> </a>
                <?php endfor; ?>
            </nav>
        </div>
    <?php endif; ?>
</div>
<script>
    function closeAllRoleSelects() {
        document.querySelectorAll('[id^=select-rol-]').forEach(function(el) {
            el.classList.add('hidden');
        });
    }
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.fa-user-shield') && !e.target.closest('form[action="/users/change-role"]')) {
            closeAllRoleSelects();
        }
    });
</script>
<?php $content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
