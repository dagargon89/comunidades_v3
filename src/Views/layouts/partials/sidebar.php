<aside class="sidebar w-64 flex flex-col py-6 px-4 fixed left-0 top-0 z-20 min-h-screen">
    <div class="logo flex items-center gap-2 mb-10">
        <div class="h-10 w-10 bg-primary rounded-full flex items-center justify-center text-white text-2xl font-bold">
            <i class="fas fa-users"></i>
        </div>
        <span>Comunidades V3</span>
    </div>
    <nav class="flex-1">
        <ul class="space-y-1">
            <li><a href="/" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="#"><i class="fas fa-project-diagram"></i> Proyectos</a></li>
            <li><a href="#"><i class="fas fa-tasks"></i> Actividades</a></li>
            <li class="mt-6 mb-1 text-xs uppercase tracking-wider text-gray-400 px-2">Administración</li>
            <?php if (current_user() && current_user()->hasPermission('user.view')): ?>
                <li><a href="/users"><i class="fas fa-users-cog"></i> Usuarios</a></li>
            <?php endif; ?>
            <?php if (current_user() && current_user()->hasPermission('role.view')): ?>
                <li><a href="/roles"><i class="fas fa-user-shield"></i> Roles</a></li>
            <?php endif; ?>
            <?php if (current_user() && current_user()->hasPermission('permission.view')): ?>
                <li><a href="/permissions"><i class="fas fa-key"></i> Permisos</a></li>
            <?php endif; ?>
            <li><a href="#"><i class="fas fa-list"></i> Catálogos</a></li>
        </ul>
        <div class="separator"></div>
    </nav>
</aside>