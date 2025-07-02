<?php
$title = 'Usuarios';
ob_start(); ?>
<div class="flex flex-col gap-6 w-[90%] mx-auto">
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
    <div id="tabla-usuarios"></div>
    <div class="flex justify-between items-center mt-4" id="paginacion"></div>
</div>
<script>
    const tablaUsuarios = document.getElementById('tabla-usuarios');
    const paginacion = document.getElementById('paginacion');
    const busqueda = document.getElementById('busqueda');
    const filtroRol = document.getElementById('filtro-rol');
    const filtroEstado = document.getElementById('filtro-estado');
    let paginaActual = 1;
    let totalPaginas = 1;
    let timeoutBusqueda;

    function renderTablaUsuarios(html) {
        tablaUsuarios.innerHTML = html;
    }

    function cargarUsuarios(page = 1) {
        const q = busqueda.value.trim();
        const rol = filtroRol.value;
        const estado = filtroEstado.value;
        fetch(`/users/buscar?q=${encodeURIComponent(q)}&rol=${encodeURIComponent(rol)}&estado=${encodeURIComponent(estado)}&page=${page}`)
            .then(r => r.text())
            .then(html => {
                renderTablaUsuarios(html);
                // La paginación se mantiene igual, pero si quieres paginación AJAX, deberás ajustarla también
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
