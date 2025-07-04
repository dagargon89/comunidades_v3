<!DOCTYPE html>
<html lang="es">
<?php include_once __DIR__ . '/partials/head.php'; ?>

<body class="min-h-screen transition-colors duration-300" id="body">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <?php include_once __DIR__ . '/partials/sidebar.php'; ?>
        <!-- Main content -->
        <div class="flex-1 flex flex-col min-h-screen ml-64">
            <!-- Topbar -->
            <?php include_once __DIR__ . '/partials/topbar.php'; ?>
            <!-- Contenido principal -->
            <main class="flex-1 p-8 transition-colors duration-300" style="background: var(--color-bg);" id="main-content">
                <div class="flex flex-col gap-6 w-[90%] mx-auto">
                    <?php include __DIR__ . '/../ui_components/flash.php'; ?>
                    <?php if (isset($title)): ?>
                        <h1 class="text-2xl font-bold mb-6"><?= htmlspecialchars($title) ?></h1>
                    <?php endif; ?>
                    <?php
                    if (isset($filters) && isset($buttons)) {
                        include __DIR__ . '/../ui_components/filter_bar.php';
                    }
                    ?>
                    <?= $content ?? '' ?>
                    <?php
                    if ((isset($totalPages) && $totalPages > 1 && isset($page)) || (isset($total_paginas) && $total_paginas > 1 && isset($pagina_actual))) {
                        $p = $page ?? $pagina_actual;
                        $tp = $totalPages ?? $total_paginas;
                    ?>
                        <div class="flex justify-between items-center mt-4">
                            <nav class="inline-flex rounded-md shadow-sm" aria-label="Paginación">
                                <?php for ($i = 1; $i <= $tp; $i++): ?>
                                    <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>"
                                        class="px-3 py-1 border <?= $i === $p ? 'bg-primary text-white' : '' ?>">
                                        <?= $i ?>
                                    </a>
                                <?php endfor; ?>
                            </nav>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </main>
            <?php include_once __DIR__ . '/partials/footer.php'; ?>
        </div>
    </div>
    <script>
        // Sidebar móvil (solo visual, sin funcionalidad real)
        function toggleSidebar() {
            alert('Sidebar móvil (demo visual)');
        }
    </script>
</body>

</html>