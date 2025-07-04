<?php
ob_start();
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Editar Financiador</h1>
    </div>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Ha ocurrido un error al actualizar el financiador. Por favor, inténtelo de nuevo.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php
    $fields = [
        ['name' => 'id', 'type' => 'hidden', 'value' => $item['id']],
        ['name' => 'name', 'label' => 'Nombre', 'type' => 'text', 'value' => htmlspecialchars($item['name']), 'required' => true],
    ];
    $action = '/financiers/update';
    $method = 'post';
    $buttons = [
        ['type' => 'submit', 'label' => 'Actualizar', 'class' => 'btn-primary'],
        ['type' => 'link', 'label' => 'Cancelar', 'href' => '/financiers', 'class' => 'btn-secondary'],
    ];
    include __DIR__ . '/../ui_components/form.php';
    ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/app.php';
?>