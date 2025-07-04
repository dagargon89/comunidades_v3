<?php
ob_start();
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4"></div>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Ha ocurrido un error al crear el financiador. Por favor, inténtelo de nuevo.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php
    $fields = [
        ['name' => 'name', 'label' => 'Nombre', 'type' => 'text', 'value' => isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '', 'required' => true],
    ];
    $action = '/financiers/store';
    $method = 'post';
    $buttons = [
        ['type' => 'submit', 'label' => 'Guardar', 'class' => 'btn-primary'],
        ['type' => 'link', 'label' => 'Cancelar', 'href' => '/financiers', 'class' => 'btn-secondary'],
    ];
    include __DIR__ . '/../ui_components/form.php';
    ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/app.php';
?>