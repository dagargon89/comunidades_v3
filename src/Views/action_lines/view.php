<?php
ob_start();
?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detalles de la Línea de acción</h1>
        <div>
            <a href="/action_lines/edit?id=<?php echo $actionLine['id']; ?>" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="/action_lines" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>
    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Información de la línea de acción</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">ID:</label>
                        <p class="form-control-plaintext"><?php echo $actionLine['id']; ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre:</label>
                        <p class="form-control-plaintext"><?php echo htmlspecialchars($actionLine['name']); ?></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Programa:</label>
                        <p class="form-control-plaintext"><?php echo htmlspecialchars($actionLine['program_name']); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/app.php';
