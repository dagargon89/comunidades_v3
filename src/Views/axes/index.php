<?php
$title = 'Ejes';
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
        ['type' => 'text', 'name' => 'q', 'placeholder' => 'Buscar por nombre de eje...', 'value' => htmlspecialchars($_GET['q'] ?? '')],
    ];
    $buttons = [
        [
            'type' => 'submit',
            'label' => 'Filtrar',
            'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900',
            'icon' => 'fa-search'
        ]
    ];
    if (current_user() && current_user()->hasPermission('axis.create')) {
        $buttons[] = [
            'type' => 'link',
            'label' => 'Nuevo Eje',
            'href' => '/axes/create',
            'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900',
            'icon' => 'fa-plus',
            'title' => 'Crear un nuevo eje'
        ];
    }
    include __DIR__ . '/../components/filter_bar.php';
    ?>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <?php
        $headers = ['ID', 'Nombre'];
        $fields = ['id', 'name'];
        $rows = $axes;
        $actions_config = [
            [
                'type' => 'view',
                'url' => function ($row) {
                    return '/axes/view?id=' . $row['id'];
                },
                'title' => 'Ver',
                'icon' => 'fa-eye text-blue-500',
                'class' => 'btn-info',
                'permission' => 'axis.view',
            ],
            [
                'type' => 'edit',
                'url' => function ($row) {
                    return '/axes/edit?id=' . $row['id'];
                },
                'title' => 'Editar',
                'icon' => 'fa-edit text-yellow-500',
                'class' => 'btn-warning',
                'permission' => 'axis.edit',
            ],
            [
                'type' => 'delete',
                'url' => function ($row) {
                    return '/axes/delete?id=' . $row['id'];
                },
                'title' => 'Eliminar',
                'icon' => 'fa-trash text-red-500',
                'class' => 'btn-danger',
                'permission' => 'axis.delete',
                'onclick' => function ($row) {
                    return "return confirm('¿Seguro que deseas eliminar este eje?')";
                },
            ],
        ];
        $custom_render = [];
        include __DIR__ . '/../components/table.php';
        ?>
    </div>
    <?php if (isset($totalPages) && $totalPages > 1): ?>
        <div class="flex justify-between items-center mt-4">
            <nav class="inline-flex rounded-md shadow-sm" aria-label="Paginación">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>" class="px-3 py-1 border <?= $i === $page ? 'bg-primary text-white' : '' ?>"> <?= $i ?> </a>
                <?php endfor; ?>
            </nav>
        </div>
    <?php endif; ?>
</div>
<?php $content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
