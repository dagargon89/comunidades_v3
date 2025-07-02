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

<?php
// Modal de nuevo usuario
$id = 'modal-nuevo-usuario';
$title = 'Nuevo usuario';
$content = "<form id=\"form-nuevo-usuario\" class=\"space-y-4\">
    <div class=\"grid grid-cols-1 md:grid-cols-2 gap-4\">
        <div>
            <label class=\"block text-sm font-semibold mb-1\">Nombre</label>
            <input type=\"text\" name=\"first_name\" class=\"form-input w-full rounded-lg border border-gray-300 bg-gray-50 focus:bg-white focus:border-primary focus:ring-primary px-4 py-2\" required>
        </div>
        <div>
            <label class=\"block text-sm font-semibold mb-1\">Apellidos</label>
            <input type=\"text\" name=\"last_name\" class=\"form-input w-full rounded-lg border border-gray-300 bg-gray-50 focus:bg-white focus:border-primary focus:ring-primary px-4 py-2\" required>
        </div>
        <div>
            <label class=\"block text-sm font-semibold mb-1\">Email</label>
            <input type=\"email\" name=\"email\" class=\"form-input w-full rounded-lg border border-gray-300 bg-gray-50 focus:bg-white focus:border-primary focus:ring-primary px-4 py-2\" required>
        </div>
        <div>
            <label class=\"block text-sm font-semibold mb-1\">Usuario</label>
            <input type=\"text\" name=\"username\" class=\"form-input w-full rounded-lg border border-gray-300 bg-gray-50 focus:bg-white focus:border-primary focus:ring-primary px-4 py-2\" required>
        </div>
        <div class=\"relative\">
            <label class=\"block text-sm font-semibold mb-1\">Contraseña</label>
            <input type=\"password\" name=\"password\" id=\"nuevo-password\" class=\"form-input w-full rounded-lg border border-gray-300 bg-gray-50 focus:bg-white focus:border-primary focus:ring-primary px-4 py-2 pr-10\" required>
            <button type=\"button\" tabindex=\"-1\" class=\"absolute right-2 top-8 text-gray-400 hover:text-primary\" onclick=\"togglePassword('nuevo-password', this)\"><i class=\"fas fa-eye\"></i></button>
        </div>
        <div class=\"relative\">
            <label class=\"block text-sm font-semibold mb-1\">Confirmar contraseña</label>
            <input type=\"password\" name=\"confirm_password\" id=\"nuevo-confirm-password\" class=\"form-input w-full rounded-lg border border-gray-300 bg-gray-50 focus:bg-white focus:border-primary focus:ring-primary px-4 py-2 pr-10\" required>
            <button type=\"button\" tabindex=\"-1\" class=\"absolute right-2 top-8 text-gray-400 hover:text-primary\" onclick=\"togglePassword('nuevo-confirm-password', this)\"><i class=\"fas fa-eye\"></i></button>
        </div>
        <div>
            <label class=\"block text-sm font-semibold mb-1\">Rol</label>
            <select name=\"rol\" class=\"form-select w-full rounded-lg border border-gray-300 bg-gray-50 focus:bg-white focus:border-primary focus:ring-primary px-4 py-2\" required id=\"select-rol-nuevo\">
                <option value=\"\">Selecciona un rol</option>
            </select>
        </div>
        <div>
            <label class=\"block text-sm font-semibold mb-1\">Estado</label>
            <select name=\"is_active\" class=\"form-select w-full rounded-lg border border-gray-300 bg-gray-50 focus:bg-white focus:border-primary focus:ring-primary px-4 py-2\">
                <option value=\"1\">Activo</option>
                <option value=\"0\">Inactivo</option>
            </select>
        </div>
    </div>
    <div id=\"nuevo-usuario-error\" class=\"text-danger text-sm mt-2\"></div>
</form>";
$footer = '<button type="submit" form="form-nuevo-usuario" class="btn-secondary px-5 py-2">Guardar</button>
<button type="button" class="btn-secondary bg-gray-300 text-gray-800 hover:bg-gray-400" onclick="closeModal(\'modal-nuevo-usuario\')">Cancelar</button>';
include __DIR__ . '/../components/modal.php';
?>

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

    document.getElementById('btn-nuevo').addEventListener('click', function() {
        openModal('modal-nuevo-usuario');
        // Cargar roles en el select del modal
        fetch('/api/roles')
            .then(r => r.json())
            .then(roles => {
                const select = document.getElementById('select-rol-nuevo');
                select.innerHTML = '<option value="">Selecciona un rol</option>' + roles.map(r => `<option value="${r.name}">${r.name}</option>`).join('');
            });
    });

    document.getElementById('form-nuevo-usuario').addEventListener('submit', function(e) {
        e.preventDefault();
        const form = e.target;
        const data = new FormData(form);
        const errorDiv = document.getElementById('nuevo-usuario-error');
        errorDiv.textContent = '';
        // Validación básica en frontend
        if (data.get('password') !== data.get('confirm_password')) {
            errorDiv.textContent = 'Las contraseñas no coinciden.';
            return;
        }
        fetch('/users/store', {
                method: 'POST',
                body: data
            })
            .then(r => r.json())
            .then(res => {
                if (res.success) {
                    closeModal('modal-nuevo-usuario');
                    form.reset();
                    cargarUsuarios(1);
                } else {
                    errorDiv.textContent = res.message || 'Error al crear usuario';
                }
            })
            .catch(() => {
                errorDiv.textContent = 'Error de red o del servidor.';
            });
    });

    function togglePassword(id, btn) {
        const input = document.getElementById(id);
        if (input.type === 'password') {
            input.type = 'text';
            btn.innerHTML = '<i class="fas fa-eye-slash"></i>';
        } else {
            input.type = 'password';
            btn.innerHTML = '<i class="fas fa-eye"></i>';
        }
    }
</script>
<?php $content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
