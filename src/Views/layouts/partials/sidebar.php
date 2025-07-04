<?php
// Helper para determinar si una ruta está activa (soporta subdirectorios y dashboard)
function is_active($route)
{
    $uri = $_SERVER['REQUEST_URI'] ?? '/';
    $uri = strtok($uri, '?');
    if ($route === '/') {
        return $uri === '/' || $uri === '' || $uri === '/index.php' || $uri === '/dashboard';
    }
    return strpos($uri, $route) === 0;
}
?>
<aside class="sidebar w-64 flex flex-col py-6 px-4 fixed left-0 top-0 z-20 min-h-screen">
    <div class="logo flex items-center gap-2 mb-10">
        <div class="h-10 w-10 bg-primary rounded-full flex items-center justify-center text-white text-2xl font-bold">
            <i class="fas fa-users"></i>
        </div>
        <span>Comunidades V3</span>
    </div>
    <nav class="flex-1">
        <ul class="space-y-1">
            <li><a href="/" class="<?= is_active('/') ? 'active' : '' ?>"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="#" class="<?= is_active('/proyectos') ? 'active' : '' ?>"><i class="fas fa-project-diagram"></i> Proyectos</a></li>
            <li><a href="#" class="<?= is_active('/actividades') ? 'active' : '' ?>"><i class="fas fa-tasks"></i> Actividades</a></li>
            <li class="mt-6 mb-1 text-xs uppercase tracking-wider text-gray-400 px-2">Administración</li>
            <?php if (current_user() && current_user()->hasPermission('user.view')): ?>
                <li><a href="/users" class="<?= is_active('/users') ? 'active' : '' ?>"><i class="fas fa-users-cog"></i> Usuarios</a></li>
            <?php endif; ?>
            <?php if (current_user() && current_user()->hasPermission('role.view')): ?>
                <li><a href="/roles" class="<?= is_active('/roles') ? 'active' : '' ?>"><i class="fas fa-user-shield"></i> Roles</a></li>
            <?php endif; ?>
            <?php if (current_user() && current_user()->hasPermission('permission.view')): ?>
                <li><a href="/permissions" class="<?= is_active('/permissions') ? 'active' : '' ?>"><i class="fas fa-key"></i> Permisos</a></li>
            <?php endif; ?>
            <li class="mt-6 mb-1 text-xs uppercase tracking-wider text-gray-400 px-2">Catálogos</li>
            <?php if (current_user() && current_user()->hasPermission('axis.view')): ?>
                <li><a href="/axes" class="<?= is_active('/axes') ? 'active' : '' ?>"><i class="fas fa-chart-line"></i> Ejes</a></li>
            <?php endif; ?>
            <li><a href="/programs" class="<?= is_active('/programs') ? 'active' : '' ?>"><i class="fas fa-project-diagram"></i> Programas</a></li>
            <li><a href="#" class="<?= is_active('/catalogos') ? 'active' : '' ?>"><i class="fas fa-list"></i> Otros Catálogos</a></li>
        </ul>
        <div class="separator"></div>
    </nav>
</aside>