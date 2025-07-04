<?php
ob_start();
?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Líneas de acción</h1>
    </div>
    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php
            $message = '';
            switch ($_GET['success']) {
                case '1':
                    $message = 'Línea de acción creada exitosamente.';
                    break;
                case '2':
                    $message = 'Línea de acción actualizada exitosamente.';
                    break;
                case '3':
                    $message = 'Línea de acción eliminada exitosamente.';
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
                    $message = 'No se pudo eliminar la línea de acción.';
                    break;
                case 'invalid_id':
                    $message = 'ID de línea de acción inválido.';
                    break;
                case 'not_found':
                    $message = 'Línea de acción no encontrada.';
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
    $filters = [
        ['type' => 'text', 'name' => 'q', 'placeholder' => 'Buscar por nombre o programa...', 'value' => htmlspecialchars($_GET['q'] ?? '')],
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
            'label' => 'Nueva Línea de acción',
            'href' => '/action_lines/create',
            'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900',
            'icon' => 'fa-plus',
            'title' => 'Crear nueva'
        ]
    ];
    include __DIR__ . '/../components/filter_bar.php';
    $headers = [
        'ID',
        'Nombre',
        'Programa',
        'Acciones'
    ];
    $fields = [
        'id',
        'name',
        'program_name',
        'actions'
    ];
    $rows = $actionLines;
    $actions_config = [
        'view' => '/action_lines/view?id=',
        'edit' => '/action_lines/edit?id=',
        'delete' => '/action_lines/delete?id=',
    ];
    $custom_render = [];
    include __DIR__ . '/../components/table.php';
    ?>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/app.php';
