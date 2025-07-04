<?php
$title = 'Roles';
ob_start();
?>
<?php include __DIR__ . '/../components/flash.php'; ?>
<div class="flex flex-col gap-6 w-[90%] mx-auto">
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
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <?php
        $headers = ['Nombre', 'Descripción'];
        $fields = ['name', 'description'];
        $rows = $roles;
        $actions_config = [
            [
                'type' => 'edit',
                'url' => function ($row) {
                    return '/roles/edit?id=' . $row['id'];
                },
                'title' => 'Editar',
                'icon' => 'fa-edit text-yellow-500',
                'class' => 'btn-warning',
                'permission' => 'role.edit',
            ],
            [
                'type' => 'delete',
                'url' => function ($row) {
                    return '/roles/delete?id=' . $row['id'];
                },
                'title' => 'Eliminar',
                'icon' => 'fa-trash text-red-500',
                'class' => 'btn-danger',
                'permission' => 'role.delete',
                'onclick' => function ($row) {
                    return "return confirm('¿Seguro que deseas eliminar este rol?')";
                },
            ],
        ];
        $custom_render = [];
        include __DIR__ . '/../components/table.php';
        ?>
    </div>
    <?php if (isset($total_paginas) && $total_paginas > 1): ?>
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
