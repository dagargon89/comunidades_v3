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
                <div class="card w-[90%] max-w-full mx-auto rounded-2xl shadow-xl p-10 text-center">
                    <?= $content ?? '' ?>
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