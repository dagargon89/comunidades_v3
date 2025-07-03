<?php
$title = 'Dashboard';
ob_start();
?>
<?php include __DIR__ . '/../components/flash.php'; ?>
<div class="max-w-2xl mx-auto mt-16 bg-white rounded-2xl shadow-xl p-10 text-center">
    <h1 class="text-3xl font-bold text-info mb-4">¡Bienvenido al Dashboard!</h1>
    <p class="text-lg text-gray-600 mb-6">Hola, <span class="font-semibold text-primary">
            <?= htmlspecialchars(current_user() ? current_user()->getFullName() : '') ?>
        </span></p>
    <?php
    $btn = [
        'type' => 'link',
        'label' => 'Cerrar sesión',
        'href' => base_url('auth/logout'),
        'class' => 'btn-secondary inline-block px-6 py-2 rounded-lg font-semibold mt-4',
        'icon' => 'fa-sign-out-alt'
    ];
    include __DIR__ . '/../components/button.php';
    ?>
</div>
<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/app.php';
