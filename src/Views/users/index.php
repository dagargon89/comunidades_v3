<?php
$title = 'Usuarios';
ob_start(); ?>
<div class="flex flex-col gap-6">
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div class="flex gap-2 items-center w-full md:w-auto">
            <input type="text" id="busqueda" class="form-input w-full md:w-64 rounded-lg border-gray-300 focus:ring-primary focus:border-primary" placeholder="Buscar por nombre, email o usuario...">
            <select id="filtro-rol" class="form-select rounded-lg border-gray-300 focus:ring-primary focus:border-primary">
                <option value="">Todos los roles</option>
            </select>
            <select id="filtro-estado" class="form-select rounded-lg border-gray-300 focus:ring-primary focus:border-primary">
                <option value="">Todos</option>
                <option value="activo">Activos</option>
                <option value="inactivo">Inactivos</option>
            </select>
        </div>
        <button class="btn-secondary px-5 py-2" id="btn-nuevo"><i class="fas fa-user-plus mr-2"></i>Nuevo usuario</button>
    </div>
    <div class="overflow-x-auto rounded-xl shadow">
        <table class="min-w-full divide-y divide-gray-200 bg-white dark:bg-[#23263a]">
            <thead>
                <tr class="text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">
                    <th class="px-4 py-3">Nombre</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Rol(es)</th>
                    <th class="px-4 py-3">Estado</th>
                    <th class="px-4 py-3">Fecha registro</th>
                    <th class="px-4 py-3">Último acceso</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>
            <tbody id="usuarios-tbody" class="bg-white dark:bg-[#23263a] divide-y divide-gray-100 dark:divide-gray-700">
                <tr>
                    <td colspan="7" class="text-center py-8 text-muted">Cargando usuarios...</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="flex justify-between items-center mt-4" id="paginacion"></div>
</div>
<script>
    const tbody = document.getElementById('usuarios-tbody');
    const paginacion = document.getElementById('paginacion');
    const busqueda = document.getElementById('busqueda');
    const filtroRol = document.getElementById('filtro-rol');
    const filtroEstado = document.getElementById('filtro-estado');
    let paginaActual = 1;
    let totalPaginas = 1;
    let timeoutBusqueda;

    function cargarUsuarios(page = 1) {
        const q = busqueda.value.trim();
        const rol = filtroRol.value;
        const estado = filtroEstado.value;
        fetch(`/usuarios/buscar?q=${encodeURIComponent(q)}&rol=${encodeURIComponent(rol)}&estado=${encodeURIComponent(estado)}&page=${page}`)
            .then(r => r.json())
            .then(data => {
                tbody.innerHTML = '';
                if (data.usuarios.length === 0) {
                    tbody.innerHTML = `<tr><td colspan='7' class='text-center py-8 text-muted'>No se encontraron usuarios.</td></tr>`;
                } else {
                    data.usuarios.forEach(u => {
                        tbody.innerHTML += `
                        <tr>
                            <td class='px-4 py-3 whitespace-nowrap font-semibold'>${u.first_name} ${u.last_name}</td>
                            <td class='px-4 py-3'>${u.email}</td>
                            <td class='px-4 py-3'>${(u.roles && u.roles.length) ? u.roles.map(r=>r.name).join(', ') : '-'}</td>
                            <td class='px-4 py-3'>
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-bold ${u.estado === 'Activo' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'}">${u.estado}</span>
                            </td>
                            <td class='px-4 py-3'>${u.created_at ? u.created_at.split(' ')[0] : '-'}</td>
                            <td class='px-4 py-3'>${u.updated_at ? u.updated_at.split(' ')[0] : '-'}</td>
                            <td class='px-4 py-3 text-center'>
                                <button class="text-info hover:text-primary mx-1" title="Ver"><i class="fas fa-eye"></i></button>
                                <button class="text-info hover:text-primary mx-1" title="Editar"><i class="fas fa-edit"></i></button>
                                <button class="text-danger hover:text-primary mx-1" title="Eliminar"><i class="fas fa-trash"></i></button>
                                <button class="text-warning hover:text-primary mx-1" title="Resetear contraseña"><i class="fas fa-key"></i></button>
                                <button class="text-info hover:text-primary mx-1" title="Cambiar rol"><i class="fas fa-user-tag"></i></button>
                                <button class="text-info hover:text-primary mx-1" title="Enviar correo"><i class="fas fa-envelope"></i></button>
                                <button class="text-info hover:text-primary mx-1" title="${u.estado === 'Activo' ? 'Bloquear' : 'Desbloquear'}"><i class="fas ${u.estado === 'Activo' ? 'fa-user-lock' : 'fa-user-check'}"></i></button>
                            </td>
                        </tr>
                    `;
                    });
                }
                paginaActual = data.page;
                totalPaginas = data.pages;
                renderPaginacion();
            });
    }

    function renderPaginacion() {
        let html = '';
        if (totalPaginas <= 1) {
            paginacion.innerHTML = '';
            return;
        }
        html += `<nav class="inline-flex rounded-md shadow-sm" aria-label="Paginación">`;
        html += `<button class="px-3 py-1 border rounded-l-md ${paginaActual === 1 ? 'opacity-50 cursor-not-allowed' : ''}" ${paginaActual === 1 ? 'disabled' : ''} onclick="cargarUsuarios(${paginaActual-1})">&laquo;</button>`;
        for (let i = 1; i <= totalPaginas; i++) {
            if (i === paginaActual || (i <= 2 || i > totalPaginas - 2 || Math.abs(i - paginaActual) <= 1)) {
                html += `<button class="px-3 py-1 border-t border-b ${i === paginaActual ? 'bg-primary text-white' : ''}" onclick="cargarUsuarios(${i})">${i}</button>`;
            } else if (i === 3 && paginaActual > 4) {
                html += `<span class="px-2">...</span>`;
            } else if (i === totalPaginas - 2 && paginaActual < totalPaginas - 3) {
                html += `<span class="px-2">...</span>`;
            }
        }
        html += `<button class="px-3 py-1 border rounded-r-md ${paginaActual === totalPaginas ? 'opacity-50 cursor-not-allowed' : ''}" ${paginaActual === totalPaginas ? 'disabled' : ''} onclick="cargarUsuarios(${paginaActual+1})">&raquo;</button>`;
        html += `</nav>`;
        paginacion.innerHTML = html;
    }

    busqueda.addEventListener('input', () => {
        clearTimeout(timeoutBusqueda);
        timeoutBusqueda = setTimeout(() => cargarUsuarios(1), 300);
    });
    filtroRol.addEventListener('change', () => cargarUsuarios(1));
    filtroEstado.addEventListener('change', () => cargarUsuarios(1));

    document.addEventListener('DOMContentLoaded', () => {
        cargarUsuarios();
        // Cargar roles para el filtro (AJAX opcional)
        fetch('/api/roles')
            .then(r => r.json())
            .then(roles => {
                filtroRol.innerHTML = '<option value="">Todos los roles</option>' + roles.map(r => `<option value="${r.name}">${r.name}</option>`).join('');
            });
    });
</script>
<?php $content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
