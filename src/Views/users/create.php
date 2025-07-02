<?php
$title = 'Nuevo usuario';
ob_start();
?>
<div class="max-w-2xl mx-auto mt-8 bg-white rounded-xl shadow p-8">
    <h2 class="text-2xl font-bold mb-6">Nuevo usuario</h2>
    <?php if (!empty($_SESSION['flash_error'])): ?>
        <div class="mb-4 p-3 bg-red-100 text-red-700 rounded"> <?= $_SESSION['flash_error'];
                                                                unset($_SESSION['flash_error']); ?> </div>
    <?php endif; ?>
    <?php if (!empty($_SESSION['flash_success'])): ?>
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded"> <?= $_SESSION['flash_success'];
                                                                    unset($_SESSION['flash_success']); ?> </div>
    <?php endif; ?>
    <form method="post" action="/users/store" class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-semibold mb-1">Nombre</label>
                <input type="text" name="first_name" class="form-input w-full rounded-lg border border-gray-300 bg-gray-50 focus:bg-white focus:border-primary focus:ring-primary px-4 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Apellidos</label>
                <input type="text" name="last_name" class="form-input w-full rounded-lg border border-gray-300 bg-gray-50 focus:bg-white focus:border-primary focus:ring-primary px-4 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Email</label>
                <input type="email" name="email" class="form-input w-full rounded-lg border border-gray-300 bg-gray-50 focus:bg-white focus:border-primary focus:ring-primary px-4 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Usuario</label>
                <input type="text" name="username" class="form-input w-full rounded-lg border border-gray-300 bg-gray-50 focus:bg-white focus:border-primary focus:ring-primary px-4 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Contraseña</label>
                <input type="password" name="password" class="form-input w-full rounded-lg border border-gray-300 bg-gray-50 focus:bg-white focus:border-primary focus:ring-primary px-4 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Confirmar contraseña</label>
                <input type="password" name="confirm_password" class="form-input w-full rounded-lg border border-gray-300 bg-gray-50 focus:bg-white focus:border-primary focus:ring-primary px-4 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Rol</label>
                <select name="rol" class="form-select w-full rounded-lg border border-gray-300 bg-gray-50 focus:bg-white focus:border-primary focus:ring-primary px-4 py-2" required>
                    <option value="">Selecciona un rol</option>
                    <?php foreach ($roles as $rol): ?>
                        <option value="<?= $rol['id'] ?>"><?= htmlspecialchars($rol['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-semibold mb-1">Estado</label>
                <select name="is_active" class="form-select w-full rounded-lg border border-gray-300 bg-gray-50 focus:bg-white focus:border-primary focus:ring-primary px-4 py-2">
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>
        </div>
        <div class="flex gap-2 mt-6">
            <button type="submit" class="btn-secondary px-5 py-2">Guardar</button>
            <a href="/users" class="btn-secondary bg-gray-300 text-gray-800 hover:bg-gray-400">Cancelar</a>
        </div>
    </form>
</div>
<?php $content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
