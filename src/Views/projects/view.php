<?php
ob_start();
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detalles del Proyecto</h1>
        <div>
            <a href="/projects/edit?id=<?php echo $item['id']; ?>" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="/projects" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Información del Proyecto</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">ID:</label>
                        <p class="form-control-plaintext"><?php echo $item['id']; ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Financiador:</label>
                        <p class="form-control-plaintext"><?php echo htmlspecialchars($item['financier_name']); ?></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Nombre:</label>
                        <p class="form-control-plaintext"><?php echo htmlspecialchars($item['name']); ?></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Antecedentes:</label>
                        <p class="form-control-plaintext"><?php echo nl2br(htmlspecialchars($item['background'])); ?></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Justificación:</label>
                        <p class="form-control-plaintext"><?php echo nl2br(htmlspecialchars($item['justification'])); ?></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Objetivo General:</label>
                        <p class="form-control-plaintext"><?php echo nl2br(htmlspecialchars($item['general_objective'])); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/app.php';
?>