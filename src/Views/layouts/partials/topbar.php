<header class="topbar w-full flex items-center justify-between px-6 py-3 shadow-sm sticky top-0 z-10">
    <div class="flex items-center gap-2">
        <button class="md:hidden text-info focus:outline-none" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>
    </div>
    <div class="flex items-center gap-4">
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