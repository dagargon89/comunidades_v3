<?php
$title = 'Roles';
ob_start();
?>
<?php include __DIR__ . '/../components/flash.php'; ?>
<div class="max-w-3xl mx-auto mt-8 bg-white rounded-xl shadow p-8">
    <h2 class="text-2xl font-bold mb-6">Roles</h2>
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
        ['type' => 'text', 'name' => 'q', 'placeholder' => 'Buscar por nombre o descripción...', 'value' => htmlspecialchars($_GET['q'] ?? '')],
    ];
    $buttons = [
        [
            'type' => 'submit',
            'label' => 'Filtrar',
            'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900',
            'icon' => 'fa-search'
        ]
    ];
    if (current_user() && current_user()->hasPermission('role.create')) {
        $buttons[] = [
            'type' => 'link',
            'label' => 'Nuevo rol',
            'href' => '/roles/create',
            'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900',
            'icon' => 'fa-plus',
            'title' => 'Crear un nuevo rol'
        ];
    }
    include __DIR__ . '/../components/filter_bar.php';
    ?>
    <table class="min-w-full divide-y divide-gray-200">
        <thead>
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                <th class="px-6 py-3 text-left"></th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($roles as $rol): ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-left"> <?= htmlspecialchars($rol['name']) ?> </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-left"> <?= htmlspecialchars($rol['description']) ?> </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex gap-2 text-left">
                        <?php if (isset($rol['is_active'])): ?>
                            <?php
                            $badge = [
                                'text' => $rol['is_active'] ? 'Activo' : 'Inactivo',
                                'color' => $rol['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800',
                            ];
                            include __DIR__ . '/../components/badge.php';
                            ?>
                        <?php endif; ?>
                        <?php
                        $actions = [];
                        if (current_user() && current_user()->hasPermission('role.edit')) {
                            $actions[] = [
                                'type' => 'edit',
                                'url' => "/roles/edit?id={$rol['id']}",
                                'permission' => 'role.edit',
                                'title' => 'Editar',
                                'class' => 'text-blue-600 hover:text-blue-900',
                            ];
                        }
                        if (current_user() && current_user()->hasPermission('role.delete')) {
                            $actions[] = [
                                'type' => 'delete',
                                'url' => "/roles/delete?id={$rol['id']}",
                                'permission' => 'role.delete',
                                'title' => 'Eliminar',
                                'class' => 'text-red-600 hover:text-red-900',
                                'onclick' => "return confirm('¿Seguro que deseas eliminar este rol?')",
                            ];
                        }
                        include __DIR__ . '/../components/action_buttons.php';
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php if (isset($total_paginas) && $total_paginas > 1): ?>
        <div class="flex justify-between items-center mt-4">
            <?php
            $pagination = [
                'current' => $pagina_actual,
                'total' => $total_paginas,
                'base_url' => '?' . http_build_query(array_merge($_GET, ['page' => '']))
            ];
            include __DIR__ . '/../components/pagination.php';
            ?>
        </div>
    <?php endif; ?>
</div>
<?php $content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
