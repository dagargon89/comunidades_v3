<?php
ob_start();
?>

<div class="container-fluid">
    <?php
    $filters = [
        ['type' => 'text', 'name' => 'search', 'placeholder' => 'Buscar proyecto o financiador...', 'value' => htmlspecialchars($search ?? '')],
    ];
    $buttons = [
        [
            'type' => 'submit',
            'label' => 'Filtrar',
            'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900',
            'icon' => 'fa-search'
        ],
        [
            'type' => 'link',
            'label' => 'Nuevo Proyecto',
            'href' => '/projects/create',
            'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900',
            'icon' => 'fa-plus',
            'title' => 'Crear nuevo proyecto'
        ]
    ];

    $headers = ['ID', 'Nombre', 'Financiador'];
    $fields = ['id', 'name', 'financier_name'];
    $rows = $data;
    $actions_config = [
        [
            'type' => 'view',
            'url' => function ($row) {
                return '/projects/view?id=' . $row['id'];
            },
            'title' => 'Ver',
            'icon' => 'fa-eye text-blue-500',
            'class' => 'btn-info',
        ],
        [
            'type' => 'edit',
            'url' => function ($row) {
                return '/projects/edit?id=' . $row['id'];
            },
            'title' => 'Editar',
            'icon' => 'fa-edit text-yellow-500',
            'class' => 'btn-warning',
        ],
        [
            'type' => 'delete',
            'url' => function ($row) {
                return '/projects/delete?id=' . $row['id'];
            },
            'title' => 'Eliminar',
            'icon' => 'fa-trash text-red-500',
            'class' => 'btn-danger',
            'onclick' => function ($row) {
                return "return confirm('¿Está seguro de que desea eliminar este proyecto?')";
            },
        ],
    ];

    include __DIR__ . '/../ui_components/table.php';
    ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/app.php';
?>