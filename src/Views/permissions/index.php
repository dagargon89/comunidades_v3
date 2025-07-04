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
    <?php
    $headers = ['Nombre', 'Descripción'];
    $fields = ['name', 'description'];
    $rows = $permissions;
    $actions_config = [
        [
            'type' => 'edit',
            'url' => function ($row) {
                return '/permissions/edit?id=' . $row['id'];
            },
            'title' => 'Editar',
            'icon' => 'fa-edit text-yellow-500',
            'class' => 'btn-warning',
            'permission' => 'permission.edit',
        ],
        [
            'type' => 'delete',
            'url' => function ($row) {
                return '/permissions/delete?id=' . $row['id'];
            },
            'title' => 'Eliminar',
            'icon' => 'fa-trash text-red-500',
            'class' => 'btn-danger',
            'permission' => 'permission.delete',
            'onclick' => function ($row) {
                return "return confirm('¿Seguro que deseas eliminar este permiso?')";
            },
        ],
    ];
    $custom_render = [];
    include __DIR__ . '/../components/table.php';
    ?>
</div>
<?php if (isset($total_paginas) && $total_paginas > 1): ?>
    <div class="flex justify-between items-center mt-4">
        <?php
        $pagination = [
            'current' => $pagina_actual,
            'total' => $total_paginas,
            'base_url' => '?' . http_build_query(array_merge($_GET, ['page' => '']))
        ];
        ?>
        <nav class="inline-flex rounded-md shadow-sm" aria-label="Paginación">
            <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>" class="px-3 py-1 border <?= $i === $pagina_actual ? 'bg-primary text-white' : '' ?>"> <?= $i ?> </a>
            <?php endfor; ?>
        </nav>
    </div>
<?php endif; ?>
<?php $content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
