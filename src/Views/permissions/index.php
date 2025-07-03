<?php
$title = 'Permisos';
ob_start();
?>
<?php include __DIR__ . '/../components/flash.php'; ?>
<h2 class="text-2xl font-bold mb-6">Permisos</h2>
<div class="w-[90%] max-w-full mx-auto mt-4">
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
    if (current_user() && current_user()->hasPermission('permission.create')) {
        $buttons[] = [
            'type' => 'link',
            'label' => 'Nuevo permiso',
            'href' => '/permissions/create',
            'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900',
            'icon' => 'fa-plus',
            'title' => 'Crear un nuevo permiso'
        ];
    }
    include __DIR__ . '/../components/filter_bar.php';
    ?>
</div>
<div class="bg-white rounded-lg shadow overflow-hidden w-[90%] max-w-full mx-auto mt-4">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Descripción</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            <?php foreach ($permissions as $perm): ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-left"> <?= htmlspecialchars($perm['name']) ?> </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-left"> <?= htmlspecialchars($perm['description']) ?> </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex gap-2 text-left">
                        <?php if (isset($perm['is_active'])): ?>
                            <?php
                            $badge = [
                                'text' => $perm['is_active'] ? 'Activo' : 'Inactivo',
                                'color' => $perm['is_active'] ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800',
                            ];
                            include __DIR__ . '/../components/badge.php';
                            ?>
                        <?php endif; ?>
                        <?php
                        $actions = [];
                        if (current_user() && current_user()->hasPermission('permission.edit')) {
                            $actions[] = [
                                'type' => 'edit',
                                'url' => "/permissions/edit?id={$perm['id']}",
                                'permission' => 'permission.edit',
                                'title' => 'Editar',
                                'class' => 'text-blue-600 hover:text-blue-900',
                            ];
                        }
                        if (current_user() && current_user()->hasPermission('permission.delete')) {
                            $actions[] = [
                                'type' => 'delete',
                                'url' => "/permissions/delete?id={$perm['id']}",
                                'permission' => 'permission.delete',
                                'title' => 'Eliminar',
                                'class' => 'text-red-600 hover:text-red-900',
                                'onclick' => "return confirm('¿Seguro que deseas eliminar este permiso?')",
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
