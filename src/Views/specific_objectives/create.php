<?php
ob_start();
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Nuevo Objetivo Específico</h1>
    </div>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Ha ocurrido un error al crear el objetivo específico. Por favor, inténtelo de nuevo.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php
    $fields = [
        ['name' => 'description', 'label' => 'Descripción', 'type' => 'textarea', 'value' => isset($_POST['description']) ? htmlspecialchars($_POST['description']) : '', 'required' => true],
        ['name' => 'projects_id', 'label' => 'Proyecto', 'type' => 'select', 'options' => array_column($projects, 'name', 'id'), 'value' => isset($_POST['projects_id']) ? $_POST['projects_id'] : ''],
    ];
    $action = '/specific_objectives/store';
    $method = 'post';
    $buttons = [
        ['type' => 'submit', 'label' => 'Guardar', 'class' => 'btn-primary'],
        ['type' => 'link', 'label' => 'Cancelar', 'href' => '/specific_objectives', 'class' => 'btn-secondary'],
    ];
    include __DIR__ . '/../ui_components/form.php';
    ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/app.php';
?>