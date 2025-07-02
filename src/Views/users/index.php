<?php
$title = 'Usuarios';
ob_start(); ?>
<div class="flex flex-col gap-6 w-[90%] mx-auto">
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
            <button type="submit" class="btn-secondary px-5 py-2"><i class="fas fa-search mr-2"></i>Filtrar</button>
            <a href="users/create" class="btn-secondary px-5 py-2"><i class="fas fa-user-plus mr-2"></i>Nuevo usuario</a>
        </div>
    </form>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
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
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 text-left"><?= htmlspecialchars($usuario['first_name'] . ' ' . $usuario['last_name']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-left"><?= htmlspecialchars($usuario['email']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-left"><?= htmlspecialchars($usuario['username']) ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-left"><?= htmlspecialchars($usuario['rol'] ?? '-') ?></td>
                            <td class="px-6 py-4 whitespace-nowrap text-left">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full <?= $usuario['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                                    <?= $usuario['is_active'] ? 'Activo' : 'Inactivo' ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-left">
                                <a href="users/edit?id=<?= $usuario['id'] ?>" class="text-blue-600 hover:text-blue-900 mr-3"><i class="fas fa-edit"></i></a>
                                <a href="users/delete?id=<?= $usuario['id'] ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('¿Seguro que deseas eliminar este usuario?')"><i class="fas fa-trash"></i></a>
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
<?php $content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
