<?php
$title = 'Ejes';
ob_start(); ?>
<?php include __DIR__ . '/../components/flash.php'; ?>
<div class="flex flex-col gap-6 w-[90%] mx-auto">
    <?php if (!empty($_SESSION['flash_error'])): ?>
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded"> <?= $_SESSION['flash_error'];
                                                                unset($_SESSION['flash_error']); ?> </div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['flash_success'])): ?>
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded"> <?= $_SESSION['flash_success'];
                                                                    unset($_SESSION['flash_success']); ?> </div>
    <?php endif; ?>
    <?php
    $filters = [
        ['type' => 'text', 'name' => 'q', 'placeholder' => 'Buscar por nombre de eje...', 'value' => htmlspecialchars($_GET['q'] ?? '')],
    ];
    $buttons = [
        [
            'type' => 'submit',
            'label' => 'Filtrar',
            'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900',
            'icon' => 'fa-search'
        ]
    ];
    if (current_user() && current_user()->hasPermission('axis.create')) {
        $buttons[] = [
            'type' => 'link',
            'label' => 'Nuevo Eje',
            'href' => '/axes/create',
            'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900',
            'icon' => 'fa-plus',
            'title' => 'Crear un nuevo eje'
        ];
    }
    include __DIR__ . '/../components/filter_bar.php';
    ?>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                <?php if (empty($axes)): ?>
                    <tr>
                        <td colspan="3" class="text-center py-8 text-gray-500">No hay ejes registrados.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($axes as $axis): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-left"> <?= htmlspecialchars($axis['id']) ?> </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-left"> <?= htmlspecialchars($axis['name']) ?> </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium flex gap-2 text-left">
                                <?php include __DIR__ . '/../components/action_buttons.php'; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if (isset($totalPages) && $totalPages > 1): ?>
        <div class="flex justify-between items-center mt-4">
            <nav class="inline-flex rounded-md shadow-sm" aria-label="Paginación">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>" class="px-3 py-1 border <?= $i === $page ? 'bg-primary text-white' : '' ?>"> <?= $i ?> </a>
                <?php endfor; ?>
            </nav>
        </div>
    <?php endif; ?>
</div>
<?php $content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
