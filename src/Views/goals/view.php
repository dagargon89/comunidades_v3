<?php
$title = 'Detalle de Meta';
ob_start();
?>
<div class="w-full max-w-2xl mx-auto mt-6">
    <div class="bg-white rounded-xl shadow p-6">
        <h2 class="text-xl font-bold mb-4">Información de la Meta</h2>
        <dl class="divide-y divide-gray-200">
            <div class="py-2 flex justify-between">
                <dt class="font-semibold">ID:</dt>
                <dd><?= htmlspecialchars($goal['id']) ?></dd>
            </div>
            <div class="py-2 flex justify-between">
                <dt class="font-semibold">Descripción:</dt>
                <dd><?= htmlspecialchars($goal['description']) ?></dd>
            </div>
            <div class="py-2 flex justify-between">
                <dt class="font-semibold">Número:</dt>
                <dd><?= htmlspecialchars($goal['number']) ?></dd>
            </div>
            <div class="py-2 flex justify-between">
                <dt class="font-semibold">Componente:</dt>
                <dd><?= htmlspecialchars($goal['component_name']) ?></dd>
            </div>
            <div class="py-2 flex justify-between">
                <dt class="font-semibold">Organización:</dt>
                <dd><?= htmlspecialchars($goal['organization_name']) ?></dd>
            </div>
        </dl>
        <div class="mt-6 flex gap-2 justify-end">
            <a href="/goals/edit?id=<?= $goal['id'] ?>" class="btn btn-warning"><i class="fas fa-edit"></i> Editar</a>
            <a href="/goals" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Volver</a>
        </div>
    </div>
</div>
<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
