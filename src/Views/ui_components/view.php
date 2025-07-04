<?php
$title = 'Detalle de Componente';
ob_start();
?>
<div class="w-full max-w-2xl mx-auto mt-6">
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-bold mb-4">Información del Componente</h2>
        <dl class="divide-y divide-gray-200">
            <div class="py-2 flex justify-between">
                <dt class="font-semibold">ID:</dt>
                <dd><?= htmlspecialchars($component['id']) ?></dd>
            </div>
            <div class="py-2 flex justify-between">
                <dt class="font-semibold">Nombre:</dt>
                <dd><?= htmlspecialchars($component['name']) ?></dd>
            </div>
            <div class="py-2 flex justify-between">
                <dt class="font-semibold">Línea de acción:</dt>
                <dd><?= htmlspecialchars($component['action_line_name']) ?></dd>
            </div>
        </dl>
        <div class="mt-6 flex gap-2 justify-end">
            <a href="/components/edit?id=<?= $component['id'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Editar</a>
            <a href="/components" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
