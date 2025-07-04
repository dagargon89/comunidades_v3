<?php
ob_start();
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Nuevo Proyecto</h1>
    </div>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Ha ocurrido un error al crear el proyecto. Por favor, inténtelo de nuevo.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php
    $fields = [
        ['name' => 'name', 'label' => 'Nombre', 'type' => 'text', 'value' => isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '', 'required' => true],
        ['name' => 'financiers_id', 'label' => 'Financiador', 'type' => 'select', 'options' => array_column($financiers, 'name', 'id'), 'value' => isset($_POST['financiers_id']) ? $_POST['financiers_id'] : '', 'required' => true],
        ['name' => 'background', 'label' => 'Antecedentes', 'type' => 'textarea', 'value' => isset($_POST['background']) ? htmlspecialchars($_POST['background']) : ''],
        ['name' => 'justification', 'label' => 'Justificación', 'type' => 'textarea', 'value' => isset($_POST['justification']) ? htmlspecialchars($_POST['justification']) : ''],
        ['name' => 'general_objective', 'label' => 'Objetivo General', 'type' => 'textarea', 'value' => isset($_POST['general_objective']) ? htmlspecialchars($_POST['general_objective']) : ''],
    ];
    $action = '/projects/store';
    $method = 'post';
    $buttons = [
        ['type' => 'submit', 'label' => 'Guardar', 'class' => 'btn-primary'],
        ['type' => 'link', 'label' => 'Cancelar', 'href' => '/projects', 'class' => 'btn-secondary'],
    ];
    include __DIR__ . '/../ui_components/form.php';
    ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/app.php';
?>