<?php
$title = 'Detalles de usuario';
ob_start();
?>
<div class="max-w-2xl mx-auto mt-8 bg-white rounded-xl shadow p-8">
    <h2 class="text-2xl font-bold mb-6">Detalles de usuario</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
        <div>
            <span class="block text-xs text-gray-500">Nombre</span>
            <span class="block text-lg font-semibold text-gray-900"><?= htmlspecialchars($usuario->getFirstName() . ' ' . $usuario->getLastName()) ?></span>
        </div>
        <div>
            <span class="block text-xs text-gray-500">Usuario</span>
            <span class="block text-lg font-semibold text-gray-900"><?= htmlspecialchars($usuario->getUsername()) ?></span>
        </div>
        <div>
            <span class="block text-xs text-gray-500">Email</span>
            <span class="block text-lg font-semibold text-gray-900"><?= htmlspecialchars($usuario->getEmail()) ?></span>
        </div>
        <div>
            <span class="block text-xs text-gray-500">Rol</span>
            <span class="block text-lg font-semibold text-gray-900"><?= isset($roles_usuario[0]['name']) ? htmlspecialchars($roles_usuario[0]['name']) : '-' ?></span>
        </div>
        <div>
            <span class="block text-xs text-gray-500">Estado</span>
            <span class="inline-block px-2 py-1 rounded-full text-xs font-semibold <?= $usuario->isActive() ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' ?>">
                <?= $usuario->isActive() ? 'Activo' : 'Inactivo' ?>
            </span>
        </div>
        <div>
            <span class="block text-xs text-gray-500">Fecha de registro</span>
            <span class="block text-lg font-semibold text-gray-900"><?= htmlspecialchars($usuario->getCreatedAt()) ?></span>
        </div>
        <div>
            <span class="block text-xs text-gray-500">Último acceso</span>
            <span class="block text-lg font-semibold text-gray-900"><?= htmlspecialchars($usuario->getUpdatedAt()) ?></span>
        </div>
    </div>
    <div class="flex flex-wrap gap-2 mt-6">
        <?php
        $btn = [
            'type' => 'link',
            'label' => 'Volver al listado',
            'href' => '/users',
            'class' => 'btn-secondary bg-gray-300 text-gray-800 hover:bg-gray-400'
        ];
        include __DIR__ . '/../components/button.php';
        ?>
        <?php if (isset($_SESSION['user']) && isset($_SESSION['user']['rol']) && $_SESSION['user']['rol'] === 'admin'): ?>
            <?php
            $btn = [
                'type' => 'link',
                'label' => 'Editar',
                'href' => "/users/edit?id={$usuario->getId()}",
                'class' => 'btn-secondary px-4 py-2',
                'icon' => 'fa-edit'
            ];
            include __DIR__ . '/../components/button.php';

            $btn = [
                'type' => 'link',
                'label' => 'Eliminar',
                'href' => "/users/delete?id={$usuario->getId()}",
                'class' => 'btn-secondary bg-red-600 text-white hover:bg-red-700 px-4 py-2',
                'icon' => 'fa-trash',
                'attrs' => 'onclick="return confirm(\'¿Seguro que deseas eliminar este usuario?\');"'
            ];
            include __DIR__ . '/../components/button.php';

            if ($usuario->isActive()):
                $btn = [
                    'type' => 'link',
                    'label' => 'Bloquear',
                    'href' => "/users/block?id={$usuario->getId()}",
                    'class' => 'btn-secondary bg-yellow-500 text-white hover:bg-yellow-600 px-4 py-2',
                    'icon' => 'fa-ban'
                ];
                include __DIR__ . '/../components/button.php';
            else:
                $btn = [
                    'type' => 'link',
                    'label' => 'Desbloquear',
                    'href' => "/users/unblock?id={$usuario->getId()}",
                    'class' => 'btn-secondary bg-green-600 text-white hover:bg-green-700 px-4 py-2',
                    'icon' => 'fa-unlock'
                ];
                include __DIR__ . '/../components/button.php';

                $btn = [
                    'type' => 'link',
                    'label' => 'Reactivar',
                    'href' => "/users/reactivate?id={$usuario->getId()}",
                    'class' => 'btn-secondary bg-green-600 text-white hover:bg-green-700 px-4 py-2',
                    'icon' => 'fa-undo'
                ];
                include __DIR__ . '/../components/button.php';
            endif;

            $btn = [
                'type' => 'link',
                'label' => 'Resetear contraseña',
                'href' => "/users/reset-password?id={$usuario->getId()}",
                'class' => 'btn-secondary bg-indigo-600 text-white hover:bg-indigo-700 px-4 py-2',
                'icon' => 'fa-key'
            ];
            include __DIR__ . '/../components/button.php';
            ?>
        <?php endif; ?>
        <?php
        $btn = [
            'type' => 'link',
            'label' => 'Enviar correo',
            'href' => "mailto:" . htmlspecialchars($usuario->getEmail()),
            'class' => 'btn-secondary bg-blue-600 text-white hover:bg-blue-700 px-4 py-2',
            'icon' => 'fa-envelope'
        ];
        include __DIR__ . '/../components/button.php';
        ?>
    </div>
</div>
<?php $content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
