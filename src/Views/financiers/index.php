<?php
ob_start();
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Financiadores</h1>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php
            $message = '';
            switch ($_GET['success']) {
                case '1':
                    $message = 'Financiador creado exitosamente.';
                    break;
                case '2':
                    $message = 'Financiador actualizado exitosamente.';
                    break;
                case '3':
                    $message = 'Financiador eliminado exitosamente.';
                    break;
            }
            echo $message;
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php
            $message = '';
            switch ($_GET['error']) {
                case 'delete_failed':
                    $message = 'No se pudo eliminar el financiador porque tiene proyectos asociados.';
                    break;
                case 'invalid_id':
                    $message = 'ID de financiador inválido.';
                    break;
                case 'not_found':
                    $message = 'Financiador no encontrado.';
                    break;
                default:
                    $message = 'Ha ocurrido un error.';
            }
            echo $message;
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php
    // Configurar variables para el componente de filtros
    $filters = [
        ['type' => 'text', 'name' => 'search', 'placeholder' => 'Buscar financiador...', 'value' => htmlspecialchars($search ?? '')],
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
            'label' => 'Nuevo Financiador',
            'href' => '/financiers/create',
            'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900',
            'icon' => 'fa-plus',
            'title' => 'Crear nuevo financiador'
        ]
    ];

    // Configurar variables para el componente de tabla
    $headers = ['ID', 'Nombre'];
    $fields = ['id', 'name'];
    $rows = $data;
    $actions_config = [
        [
            'type' => 'view',
            'url' => function ($row) {
                return '/financiers/view?id=' . $row['id'];
            },
            'title' => 'Ver',
            'icon' => 'fa-eye text-blue-500',
            'class' => 'btn-info',
        ],
        [
            'type' => 'edit',
            'url' => function ($row) {
                return '/financiers/edit?id=' . $row['id'];
            },
            'title' => 'Editar',
            'icon' => 'fa-edit text-yellow-500',
            'class' => 'btn-warning',
        ],
        [
            'type' => 'delete',
            'url' => function ($row) {
                return '/financiers/delete?id=' . $row['id'];
            },
            'title' => 'Eliminar',
            'icon' => 'fa-trash text-red-500',
            'class' => 'btn-danger',
            'onclick' => function ($row) {
                return "return confirm('¿Está seguro de que desea eliminar este financiador?')";
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