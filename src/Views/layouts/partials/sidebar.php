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
<style>
    .sidebar .accordion-header {
        transition: background 0.2s, color 0.2s;
        padding-top: 0.4rem;
        padding-bottom: 0.4rem;
        border-radius: 0.5rem;
    }

    .sidebar .accordion-header:hover,
    .sidebar .accordion-header:focus {
        background: #06b6d4;
        /* Color activo (ejemplo: tailwind cyan-500) */
        color: #fff;
    }

    .sidebar .accordion-header .accordion-icon {
        transition: transform 0.2s;
    }

    .sidebar .accordion-header .accordion-icon.rotate-180 {
        transform: rotate(180deg);
    }

    .sidebar .accordion-content ul>li {
        margin-bottom: 0.15rem;
        margin-top: 0.15rem;
    }

    .sidebar .accordion-content ul>li>a {
        padding-left: 0.5rem;
        border-radius: 0.375rem;
        font-size: 0.97rem;
    }

    .sidebar .accordion-content ul>li>a.active,
    .sidebar .accordion-content ul>li>a:hover {
        background: #06b6d4;
        color: #fff;
    }

    .sidebar .separator {
        height: 1px;
        background: #06b6d4;
        margin: 0.3rem 0 0.3rem 0;
        border: none;
        opacity: 0.7;
    }

    .sidebar ul.space-y-1>li {
        margin-bottom: 0.1rem;
        margin-top: 0.1rem;
    }

    .sidebar .sidebar-group-label {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.05em;
        color: #a0aec0;
        padding-left: 0.5rem;
        margin-top: 0.5rem;
        margin-bottom: 0.1rem;
    }
</style>
<aside class="sidebar w-64 flex flex-col py-6 px-4 fixed left-0 top-0 z-20 min-h-screen">
    <div class="logo flex items-center gap-2 mb-6">
        <div class="h-10 w-10 bg-primary rounded-full flex items-center justify-center text-white text-2xl font-bold">
            <i class="fas fa-users"></i>
        </div>
        <span>Comunidades V3</span>
    </div>
    <nav class="flex-1 overflow-y-auto">
        <ul class="space-y-1">
            <!-- Dashboard -->
            <li><a href="/" class="<?= is_active('/') ? 'active' : '' ?>"><i class="fas fa-home"></i> Dashboard</a></li>
            <div class="separator"></div>
            <!-- Gestión de Proyectos -->
            <li class="accordion-item">
                <button class="accordion-header w-full flex items-center justify-between text-left">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-project-diagram"></i>
                        <span>Gestión de Proyectos</span>
                    </span>
                    <i class="fas fa-chevron-down accordion-icon transition-transform"></i>
                </button>
                <div class="accordion-content hidden">
                    <ul class="ml-4 mt-1">
                        <li><a href="/projects" class="<?= is_active('/projects') ? 'active' : '' ?>"><i class="fas fa-folder"></i> Proyectos</a></li>
                        <li><a href="/specific_objectives" class="<?= is_active('/specific_objectives') ? 'active' : '' ?>"><i class="fas fa-bullseye"></i> Objetivos Específicos</a></li>
                    </ul>
                </div>
            </li>
            <div class="separator"></div>
            <!-- Estructura Programática -->
            <li class="accordion-item">
                <button class="accordion-header w-full flex items-center justify-between text-left">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-sitemap"></i>
                        <span>Estructura Programática</span>
                    </span>
                    <i class="fas fa-chevron-down accordion-icon transition-transform"></i>
                </button>
                <div class="accordion-content hidden">
                    <ul class="ml-4 mt-1">
                        <li><a href="/axes" class="<?= is_active('/axes') ? 'active' : '' ?>"><i class="fas fa-chart-line"></i> Ejes</a></li>
                        <li><a href="/programs" class="<?= is_active('/programs') ? 'active' : '' ?>"><i class="fas fa-project-diagram"></i> Programas</a></li>
                        <li><a href="/action_lines" class="<?= is_active('/action_lines') ? 'active' : '' ?>"><i class="fas fa-stream"></i> Líneas de Acción</a></li>
                        <li><a href="/components" class="<?= is_active('/components') ? 'active' : '' ?>"><i class="fas fa-puzzle-piece"></i> Componentes</a></li>
                        <li><a href="/goals" class="<?= is_active('/goals') ? 'active' : '' ?>"><i class="fas fa-target"></i> Metas</a></li>
                    </ul>
                </div>
            </li>
            <div class="separator"></div>
            <!-- Gestión de Actividades -->
            <li class="accordion-item">
                <button class="accordion-header w-full flex items-center justify-between text-left">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-tasks"></i>
                        <span>Gestión de Actividades</span>
                    </span>
                    <i class="fas fa-chevron-down accordion-icon transition-transform"></i>
                </button>
                <div class="accordion-content hidden">
                    <ul class="ml-4 mt-1">
                        <li><a href="/activities" class="<?= is_active('/activities') ? 'active' : '' ?>"><i class="fas fa-clipboard-list"></i> Actividades</a></li>
                        <li><a href="/activity_calendar" class="<?= is_active('/activity_calendar') ? 'active' : '' ?>"><i class="fas fa-calendar-alt"></i> Calendario</a></li>
                        <li><a href="/activity_files" class="<?= is_active('/activity_files') ? 'active' : '' ?>"><i class="fas fa-file-alt"></i> Archivos</a></li>
                    </ul>
                </div>
            </li>
            <div class="separator"></div>
            <!-- Gestión de Recursos -->
            <li class="accordion-item">
                <button class="accordion-header w-full flex items-center justify-between text-left">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-users-cog"></i>
                        <span>Gestión de Recursos</span>
                    </span>
                    <i class="fas fa-chevron-down accordion-icon transition-transform"></i>
                </button>
                <div class="accordion-content hidden">
                    <ul class="ml-4 mt-1">
                        <li><a href="/responsibles" class="<?= is_active('/responsibles') ? 'active' : '' ?>"><i class="fas fa-user-tie"></i> Responsables</a></li>
                        <li><a href="/data_collectors" class="<?= is_active('/data_collectors') ? 'active' : '' ?>"><i class="fas fa-user-graduate"></i> Recolectores</a></li>
                        <li><a href="/organizations" class="<?= is_active('/organizations') ? 'active' : '' ?>"><i class="fas fa-building"></i> Organizaciones</a></li>
                        <li><a href="/financiers" class="<?= is_active('/financiers') ? 'active' : '' ?>"><i class="fas fa-money-bill-wave"></i> Financiadores</a></li>
                    </ul>
                </div>
            </li>
            <div class="separator"></div>
            <!-- Gestión Geográfica -->
            <li class="accordion-item">
                <button class="accordion-header w-full flex items-center justify-between text-left">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-map-marked-alt"></i>
                        <span>Gestión Geográfica</span>
                    </span>
                    <i class="fas fa-chevron-down accordion-icon transition-transform"></i>
                </button>
                <div class="accordion-content hidden">
                    <ul class="ml-4 mt-1">
                        <li><a href="/locations" class="<?= is_active('/locations') ? 'active' : '' ?>"><i class="fas fa-map-pin"></i> Ubicaciones</a></li>
                        <li><a href="/polygons" class="<?= is_active('/polygons') ? 'active' : '' ?>"><i class="fas fa-draw-polygon"></i> Polígonos</a></li>
                    </ul>
                </div>
            </li>
            <div class="separator"></div>
            <!-- Seguimiento y Métricas -->
            <li class="accordion-item">
                <button class="accordion-header w-full flex items-center justify-between text-left">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-chart-bar"></i>
                        <span>Seguimiento y Métricas</span>
                    </span>
                    <i class="fas fa-chevron-down accordion-icon transition-transform"></i>
                </button>
                <div class="accordion-content hidden">
                    <ul class="ml-4 mt-1">
                        <li><a href="/planned_metrics" class="<?= is_active('/planned_metrics') ? 'active' : '' ?>"><i class="fas fa-chart-line"></i> Métricas Planificadas</a></li>
                        <li><a href="/beneficiary_registry" class="<?= is_active('/beneficiary_registry') ? 'active' : '' ?>"><i class="fas fa-user-friends"></i> Registro de Beneficiarios</a></li>
                    </ul>
                </div>
            </li>
            <div class="separator"></div>
            <!-- Administración del Sistema (Acordeón) -->
            <li class="accordion-item">
                <button class="accordion-header w-full flex items-center justify-between text-left">
                    <span class="flex items-center gap-2">
                        <i class="fas fa-cogs"></i>
                        <span>Administración</span>
                    </span>
                    <i class="fas fa-chevron-down accordion-icon transition-transform"></i>
                </button>
                <div class="accordion-content hidden">
                    <ul class="ml-4 mt-1">
                        <?php if (current_user() && current_user()->hasPermission('user.view')): ?>
                            <li><a href="/users" class="<?= is_active('/users') ? 'active' : '' ?>"><i class="fas fa-users-cog"></i> Usuarios</a></li>
                        <?php endif; ?>
                        <?php if (current_user() && current_user()->hasPermission('role.view')): ?>
                            <li><a href="/roles" class="<?= is_active('/roles') ? 'active' : '' ?>"><i class="fas fa-user-shield"></i> Roles</a></li>
                        <?php endif; ?>
                        <?php if (current_user() && current_user()->hasPermission('permission.view')): ?>
                            <li><a href="/permissions" class="<?= is_active('/permissions') ? 'active' : '' ?>"><i class="fas fa-key"></i> Permisos</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </li>
        </ul>
    </nav>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Funcionalidad del acordeón
        const accordionHeaders = document.querySelectorAll('.accordion-header');

        accordionHeaders.forEach(header => {
            header.addEventListener('click', function() {
                const content = this.nextElementSibling;
                const icon = this.querySelector('.accordion-icon');

                // Cerrar otros acordeones
                accordionHeaders.forEach(otherHeader => {
                    if (otherHeader !== this) {
                        const otherContent = otherHeader.nextElementSibling;
                        const otherIcon = otherHeader.querySelector('.accordion-icon');
                        otherContent.classList.add('hidden');
                        otherIcon.classList.remove('rotate-180');
                    }
                });

                // Toggle del acordeón actual
                content.classList.toggle('hidden');
                icon.classList.toggle('rotate-180');
            });
        });

        // Abrir automáticamente el acordeón que contiene la página activa
        const activeLink = document.querySelector('.sidebar a.active');
        if (activeLink) {
            const accordionItem = activeLink.closest('.accordion-item');
            if (accordionItem) {
                const header = accordionItem.querySelector('.accordion-header');
                const content = accordionItem.querySelector('.accordion-content');
                const icon = accordionItem.querySelector('.accordion-icon');

                content.classList.remove('hidden');
                icon.classList.add('rotate-180');
            }
        }
    });
</script>