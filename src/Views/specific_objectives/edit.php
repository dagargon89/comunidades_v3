<?php
ob_start();
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4"></div>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Ha ocurrido un error al actualizar el objetivo específico. Por favor, inténtelo de nuevo.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php
    $fields = [
        ['name' => 'id', 'type' => 'hidden', 'value' => $item['id']],
        ['name' => 'description', 'label' => 'Descripción', 'type' => 'textarea', 'value' => htmlspecialchars($item['description']), 'required' => true],
        ['name' => 'projects_id', 'label' => 'Proyecto', 'type' => 'select', 'options' => array_column($projects, 'name', 'id'), 'value' => $item['projects_id']],
    ];
    $action = '/specific_objectives/update';
    $method = 'post';
    $buttons = [
        ['type' => 'submit', 'label' => 'Actualizar', 'class' => 'btn-primary'],
        ['type' => 'link', 'label' => 'Cancelar', 'href' => '/specific_objectives', 'class' => 'btn-secondary'],
    ];
    include __DIR__ . '/../ui_components/form.php';
    ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/app.php';
?>