<?php
$title = 'Usuarios';
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
        ['type' => 'text', 'name' => 'q', 'placeholder' => 'Buscar por nombre, email o usuario...', 'value' => htmlspecialchars($_GET['q'] ?? '')],
        ['type' => 'select', 'name' => 'rol', 'options' => array_merge(['' => 'Todos los roles'], array_column($roles, 'name', 'name')), 'value' => $_GET['rol'] ?? ''],
        ['type' => 'select', 'name' => 'estado', 'options' => ['' => 'Todos', 'activo' => 'Activos', 'inactivo' => 'Inactivos'], 'value' => $_GET['estado'] ?? ''],
    ];
    $buttons = [
        [
            'type' => 'submit',
            'label' => 'Filtrar',
            'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900',
            'icon' => 'fa-search'
        ]
    ];
    if (current_user() && current_user()->hasPermission('user.create')) {
        $buttons[] = [
            'type' => 'link',
            'label' => 'Nuevo usuario',
            'href' => '/users/create',
            'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900',
            'icon' => 'fa-plus',
            'title' => 'Crear un nuevo usuario'
        ];
    }
    include __DIR__ . '/../components/filter_bar.php';
    ?>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <?php
        $headers = ['Nombre', 'Apellidos', 'Email', 'Usuario', 'Rol', 'Estado'];
        $fields = ['first_name', 'last_name', 'email', 'username', 'rol', 'is_active'];
        $rows = $usuarios;
        $actions_config = [
            [
                'type' => 'view',
                'url' => function ($row) {
                    return '/users/view?id=' . $row['id'];
                },
                'title' => 'Ver',
                'icon' => 'fa-eye text-blue-500',
                'class' => 'btn-info',
                'permission' => 'user.view',
            ],
            [
                'type' => 'edit',
                'url' => function ($row) {
                    return '/users/edit?id=' . $row['id'];
                },
                'title' => 'Editar',
                'icon' => 'fa-edit text-yellow-500',
                'class' => 'btn-warning',
                'permission' => 'user.edit',
            ],
            [
                'type' => 'delete',
                'url' => function ($row) {
                    return '/users/delete?id=' . $row['id'];
                },
                'title' => 'Eliminar',
                'icon' => 'fa-trash text-red-500',
                'class' => 'btn-danger',
                'permission' => 'user.delete',
                'onclick' => function ($row) {
                    return "return confirm('¿Seguro que deseas eliminar este usuario?')";
                },
            ],
        ];
        $custom_render = [
            'is_active' => function ($value, $row) {
                $class = $value ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                $text = $value ? 'Activo' : 'Inactivo';
                return "<span class='px-2 inline-flex text-xs leading-5 font-semibold rounded-full $class'>$text</span>";
            },
            'rol' => function ($value, $row) {
                return htmlspecialchars($value);
            }
        ];
        include __DIR__ . '/../components/table.php';
        ?>
    </div>
    <?php if ($total_paginas > 1): ?>
        <div class="flex justify-between items-center mt-4">
            <nav class="inline-flex rounded-md shadow-sm" aria-label="Paginación">
                <?php for ($i = 1; $i <= $total_paginas; $i++): ?>
                    <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>" class="px-3 py-1 border <?= $i === $pagina_actual ? 'bg-primary text-white' : '' ?>"> <?= $i ?> </a>
                <?php endfor; ?>
            </nav>
        </div>
    <?php endif; ?>
</div>
<script>
    function closeAllRoleSelects() {
        document.querySelectorAll('[id^=select-rol-]').forEach(function(el) {
            el.classList.add('hidden');
        });
    }
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.fa-user-shield') && !e.target.closest('form[action="/users/change-role"]')) {
            closeAllRoleSelects();
        }
    });
</script>
<?php $content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
