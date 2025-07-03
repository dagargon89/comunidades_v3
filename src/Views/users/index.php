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
    <?php
    $filters = [
        ['type' => 'text', 'name' => 'q', 'placeholder' => 'Buscar por nombre, email o usuario...', 'value' => htmlspecialchars($_GET['q'] ?? '')],
        ['type' => 'select', 'name' => 'rol', 'options' => array_merge(['' => 'Todos los roles'], array_column($roles, 'name', 'name')), 'value' => $_GET['rol'] ?? ''],
        ['type' => 'select', 'name' => 'estado', 'options' => ['' => 'Todos', 'activo' => 'Activos', 'inactivo' => 'Inactivos'], 'value' => $_GET['estado'] ?? ''],
    ];
    $buttons = [
        [
            'type' => 'submit',
            'label' => 'Filtrar',
            'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900',
            'icon' => 'fa-search'
        ]
    ];
    if (current_user() && current_user()->hasPermission('user.create')) {
        $buttons[] = [
            'type' => 'link',
            'label' => 'Nuevo usuario',
            'href' => '/users/create',
            'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900',
            'icon' => 'fa-plus',
            'title' => 'Crear un nuevo usuario'
        ];
    }
    include __DIR__ . '/../components/filter_bar.php';
    ?>
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
