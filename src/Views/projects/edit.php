<?php
ob_start();
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4"></div>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Ha ocurrido un error al actualizar el proyecto. Por favor, inténtelo de nuevo.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php
    $fields = [
        ['name' => 'id', 'type' => 'hidden', 'value' => $item['id']],
        ['name' => 'name', 'label' => 'Nombre', 'type' => 'text', 'value' => htmlspecialchars($item['name']), 'required' => true],
        ['name' => 'financiers_id', 'label' => 'Financiador', 'type' => 'select', 'options' => array_column($financiers, 'name', 'id'), 'value' => $item['financiers_id'], 'required' => true],
        ['name' => 'background', 'label' => 'Antecedentes', 'type' => 'textarea', 'value' => htmlspecialchars($item['background'])],
        ['name' => 'justification', 'label' => 'Justificación', 'type' => 'textarea', 'value' => htmlspecialchars($item['justification'])],
        ['name' => 'general_objective', 'label' => 'Objetivo General', 'type' => 'textarea', 'value' => htmlspecialchars($item['general_objective'])],
    ];
    $action = '/projects/update';
    $method = 'post';
    $buttons = [
        ['type' => 'submit', 'label' => 'Actualizar', 'class' => 'btn-primary'],
        ['type' => 'link', 'label' => 'Cancelar', 'href' => '/projects', 'class' => 'btn-secondary'],
    ];
    include __DIR__ . '/../ui_components/form.php';
    ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/app.php';
?>