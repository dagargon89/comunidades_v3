<?php
ob_start();
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Programas</h1>
        <a href="/programs/create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo Programa
        </a>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php
            $message = '';
            switch ($_GET['success']) {
                case '1':
                    $message = 'Programa creado exitosamente.';
                    break;
                case '2':
                    $message = 'Programa actualizado exitosamente.';
                    break;
                case '3':
                    $message = 'Programa eliminado exitosamente.';
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
                    $message = 'No se pudo eliminar el programa. Verifique que no tenga líneas de acción asociadas.';
                    break;
                case 'invalid_id':
                    $message = 'ID de programa inválido.';
                    break;
                case 'not_found':
                    $message = 'Programa no encontrado.';
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
    // Configurar variables para el componente de tabla
    $tableId = 'programs-table';
    $columns = [
        'ID' => 'id',
        'Nombre' => 'name',
        'Eje' => 'axis_name',
        'Acciones' => 'actions'
    ];
    $data = $programs;
    $currentPage = $page;
    $totalPages = $totalPages;
    $perPage = $perPage;
    $total = $total;
    $search = $search;
    $baseUrl = '/programs';

    include __DIR__ . '/../components/table_options.php';
    ?>

    <?php include __DIR__ . '/../components/table.php'; ?>
</div>

<script>
    // Configurar acciones por fila para la tabla de programas
    function setupTableActions() {
        const table = document.getElementById('<?php echo $tableId; ?>');
        if (!table) return;

        const rows = table.querySelectorAll('tbody tr');
        rows.forEach(row => {
            const id = row.getAttribute('data-id');
            if (!id) return;

            // Crear botones de acción
            const actionsCell = row.querySelector('.actions-cell');
            if (actionsCell) {
                actionsCell.innerHTML = `
                <div class="btn-group" role="group">
                    <a href="/programs/view?id=${id}" class="btn btn-sm btn-info" title="Ver">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="/programs/edit?id=${id}" class="btn btn-sm btn-warning" title="Editar">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button type="button" class="btn btn-sm btn-danger" title="Eliminar" 
                            onclick="deleteProgram(${id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
            }
        });
    }

    function deleteProgram(id) {
        if (confirm('¿Está seguro de que desea eliminar este programa?')) {
            window.location.href = `/programs/delete?id=${id}`;
        }
    }

    // Inicializar acciones cuando se carga la página
    document.addEventListener('DOMContentLoaded', function() {
        setupTableActions();
    });
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/app.php';
?>