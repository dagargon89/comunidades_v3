<?php
ob_start();
?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Nueva Línea de acción</h1>
        <a href="/action_lines" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>
    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Ha ocurrido un error al crear la línea de acción. Por favor, inténtelo de nuevo.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Información de la línea de acción</h6>
        </div>
        <div class="card-body">
            <?php
            $fields = [
                ['name' => 'name', 'label' => 'Nombre', 'type' => 'text', 'value' => '', 'required' => true],
                ['name' => 'Program_id', 'label' => 'Programa', 'type' => 'select', 'options' => array_column($programs, 'name', 'id'), 'value' => '', 'required' => true],
            ];
            $action = '/action_lines/store';
            $method = 'post';
            $buttons = [
                ['type' => 'submit', 'label' => 'Guardar', 'class' => 'btn-primary'],
                ['type' => 'link', 'label' => 'Cancelar', 'href' => '/action_lines', 'class' => 'btn-secondary'],
            ];
            include __DIR__ . '/../components/form.php';
            ?>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/app.php';
