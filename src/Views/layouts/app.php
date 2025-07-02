<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Comunidades V3' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#00a8a9',
                        secondary: '#a30078',
                        danger: '#fa3966',
                        warning: '#ffc107',
                        info: '#2a345a',
                        success: '#00a8a9',
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --color-primary: #00a8a9;
            --color-secondary: #a30078;
            --color-danger: #fa3966;
            --color-warning: #ffc107;
            --color-info: #2a345a;
            --color-success: #00a8a9;
            --color-bg: #f4f8ff;
            --color-dark-bg: #181c2a;
            --color-sidebar: #222b45;
            --color-sidebar-dark: #181c2a;
            --color-topbar: #fff;
            --color-topbar-dark: #23263a;
            --color-card: #fff;
            --color-card-dark: #23263a;
            --color-text: #222b45;
            --color-text-dark: #e5e7eb;
            --color-muted: #8f9bb3;
            --color-muted-dark: #b0b3c6;
            --color-separator: #e4e9f2;
            --color-separator-dark: #23263a;
        }

        body {
            background: var(--color-bg);
            color: var(--color-text);
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
            transition: background 0.3s, color 0.3s;
        }

        .sidebar {
            background: var(--color-sidebar);
            color: #fff;
            border-right: 1px solid var(--color-separator);
            transition: background 0.3s, color 0.3s;
        }

        .sidebar .logo {
            font-size: 1.5rem;
            font-weight: bold;
            letter-spacing: 1px;
            color: var(--color-primary);
        }

        .sidebar nav ul {
            margin-top: 2rem;
        }

        .sidebar a {
            color: #fff;
            opacity: 0.85;
            font-weight: 500;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: background 0.2s, color 0.2s, opacity 0.2s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: var(--color-primary);
            color: #fff !important;
            opacity: 1;
        }

        .sidebar .separator {
            height: 1px;
            background: var(--color-separator);
            margin: 1.5rem 0;
        }

        .topbar {
            background: var(--color-topbar);
            color: var(--color-text);
            border-bottom: 1px solid var(--color-separator);
            transition: background 0.3s, color 0.3s;
        }

        .topbar .user-btn {
            background: var(--color-primary);
            color: #fff;
            font-weight: 600;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: background 0.2s;
        }

        .topbar .user-btn:hover {
            background: #007c7d;
        }

        .card {
            background: var(--color-card);
            color: var(--color-text);
            border-radius: 1.25rem;
            box-shadow: 0 4px 24px 0 rgba(34, 43, 69, 0.08);
            padding: 2.5rem;
            margin-top: 3rem;
            transition: background 0.3s, color 0.3s;
        }

        .dark-mode {
            background: var(--color-dark-bg) !important;
            color: var(--color-text-dark) !important;
        }

        .dark-mode .sidebar {
            background: var(--color-sidebar-dark) !important;
            color: #fff !important;
            border-right: 1px solid var(--color-separator-dark);
        }

        .dark-mode .sidebar a {
            color: #fff;
            opacity: 0.8;
        }

        .dark-mode .sidebar a:hover,
        .dark-mode .sidebar a.active {
            background: var(--color-primary);
            color: #fff !important;
            opacity: 1;
        }

        .dark-mode .topbar {
            background: var(--color-topbar-dark) !important;
            color: var(--color-text-dark) !important;
            border-bottom: 1px solid var(--color-separator-dark);
        }

        .dark-mode .card {
            background: var(--color-card-dark) !important;
            color: var(--color-text-dark) !important;
        }

        .dark-mode .text-muted {
            color: var(--color-muted-dark) !important;
        }

        .btn-secondary {
            background: var(--color-secondary);
            color: #fff;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: background 0.2s;
        }

        .btn-secondary:hover {
            background: #7a005a;
        }
    </style>
</head>

<body class="min-h-screen transition-colors duration-300" id="body">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="sidebar w-64 flex flex-col py-6 px-4 fixed left-0 top-0 z-20 min-h-screen">
            <div class="logo flex items-center gap-2 mb-10">
                <div class="h-10 w-10 bg-primary rounded-full flex items-center justify-center text-white text-2xl font-bold">
                    <i class="fas fa-users"></i>
                </div>
                <span>Comunidades V3</span>
            </div>
            <nav class="flex-1">
                <ul class="space-y-1">
                    <li><a href="#" class="active"><i class="fas fa-home"></i> Dashboard</a></li>
                    <li><a href="#"><i class="fas fa-project-diagram"></i> Proyectos</a></li>
                    <li><a href="#"><i class="fas fa-tasks"></i> Actividades</a></li>
                    <li><a href="#"><i class="fas fa-users-cog"></i> Usuarios</a></li>
                    <li><a href="#"><i class="fas fa-user-shield"></i> Roles</a></li>
                    <li><a href="#"><i class="fas fa-list"></i> Catálogos</a></li>
                </ul>
                <div class="separator"></div>
            </nav>
        </aside>
        <!-- Main content -->
        <div class="flex-1 flex flex-col min-h-screen ml-64">
            <!-- Topbar -->
            <header class="topbar w-full flex items-center justify-between px-6 py-3 shadow-sm sticky top-0 z-10">
                <div class="flex items-center gap-2">
                    <button class="md:hidden text-info focus:outline-none" onclick="toggleSidebar()">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
                <div class="flex items-center gap-4">
                    <button id="darkModeBtn" class="text-info hover:text-primary focus:outline-none text-xl" title="Modo nocturno">
                        <i class="fas fa-moon"></i>
                    </button>
                    <div class="relative group">
                        <button class="user-btn">
                            <i class="fas fa-user-circle text-2xl"></i>
                            <span class="hidden md:inline">Usuario</span>
                            <i class="fas fa-chevron-down text-xs"></i>
                        </button>
                        <div class="absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-lg py-2 opacity-0 group-hover:opacity-100 pointer-events-none group-hover:pointer-events-auto transition-all duration-200 z-20">
                            <a href="#" class="block px-4 py-2 text-info hover:bg-gray-100">Ver perfil</a>
                            <a href="#" class="block px-4 py-2 text-info hover:bg-gray-100">Cerrar sesión</a>
                        </div>
                    </div>
                </div>
            </header>
            <!-- Contenido principal -->
            <main class="flex-1 p-8 transition-colors duration-300" style="background: var(--color-bg);" id="main-content">
                <div class="card max-w-2xl mx-auto rounded-2xl shadow-xl p-10 text-center">
                    <?= $content ?? '' ?>
                </div>
            </main>
        </div>
    </div>
    <script>
        // Modo nocturno
        const darkModeBtn = document.getElementById('darkModeBtn');
        const body = document.getElementById('body');
        const sidebar = document.querySelector('.sidebar');
        const topbar = document.querySelector('.topbar');
        const mainContent = document.getElementById('main-content');
        const card = document.querySelector('.card');
        darkModeBtn.addEventListener('click', function() {
            body.classList.toggle('dark-mode');
            sidebar.classList.toggle('dark-mode');
            topbar.classList.toggle('dark-mode');
            mainContent.style.background = body.classList.contains('dark-mode') ? 'var(--color-dark-bg)' : 'var(--color-bg)';
            if (card) card.classList.toggle('dark-mode');
        });
        // Sidebar móvil (solo visual, sin funcionalidad real)
        function toggleSidebar() {
            alert('Sidebar móvil (demo visual)');
        }
    </script>
</body>

</html>