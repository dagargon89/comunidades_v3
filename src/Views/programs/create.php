<?php
ob_start();
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Nuevo Programa</h1>
        <a href="/programs" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Ha ocurrido un error al crear el programa. Por favor, inténtelo de nuevo.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Información del Programa</h6>
        </div>
        <div class="card-body">
            <form action="/programs/store" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nombre del Programa *</label>
                            <input type="text" class="form-control" id="name" name="name" required
                                value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="axes_id" class="form-label">Eje *</label>
                            <select class="form-select" id="axes_id" name="axes_id" required>
                                <option value="">Seleccione un eje</option>
                                <?php foreach ($axes as $axis): ?>
                                    <option value="<?php echo $axis['id']; ?>"
                                        <?php echo (isset($_POST['axes_id']) && $_POST['axes_id'] == $axis['id']) ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($axis['name']); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="/programs" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Guardar Programa
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/app.php';
?>