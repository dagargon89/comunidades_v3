<?php
// ... existing code ...
use function current_user;
?>
<?php include __DIR__ . '/../layouts/app.php'; ?>
<div class="w-[90%] max-w-full mx-auto bg-white rounded shadow p-6 mt-8">
    <h1 class="text-2xl font-bold mb-4">Ejes</h1>
    <?php include __DIR__ . '/../components/filter_bar.php'; ?>
    <?php include __DIR__ . '/../components/flash.php'; ?>
    <div class="flex justify-end mb-2">
        <?php if (current_user() && current_user()->hasPermission('axis.create')): ?>
            <a href="/axes/create" class="btn btn-primary">Nuevo Eje</a>
        <?php endif; ?>
    </div>
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border rounded">
            <thead>
                <tr>
                    <th class="px-4 py-2 uppercase">ID</th>
                    <th class="px-4 py-2 uppercase">Nombre</th>
                    <th class="px-4 py-2 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($axes as $axis): ?>
                    <tr>
                        <td class="border px-4 py-2"><?= htmlspecialchars($axis['id']) ?></td>
                        <td class="border px-4 py-2"><?= htmlspecialchars($axis['name']) ?></td>
                        <td class="border px-4 py-2">
                            <?php include __DIR__ . '/../components/action_buttons.php'; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php include __DIR__ . '/../components/pagination.php'; ?>
</div>