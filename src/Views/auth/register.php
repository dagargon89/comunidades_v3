<div class="min-h-screen flex items-center justify-center bg-transparent py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-xl px-8 py-10">
            <!-- Logo y título -->
            <div class="text-center mb-6">
                <div class="mx-auto h-16 w-16 bg-secondary flex items-center justify-center rounded-full shadow-md">
                    <i class="fas fa-user-plus text-white text-2xl"></i>
                </div>
                <h2 class="mt-4 text-3xl font-extrabold text-info">Crear Cuenta</h2>
                <p class="mt-1 text-sm text-gray-500">Regístrate para acceder al sistema</p>
            </div>

            <!-- Mensajes de error/success -->
            <?php if ($error): ?>
                <div class="alert alert-danger mb-4 px-4 py-3 rounded flex items-center gap-2" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span><?= htmlspecialchars($error) ?></span>
                </div>
            <?php endif; ?>
            <?php if ($success): ?>
                <div class="alert alert-success mb-4 px-4 py-3 rounded flex items-center gap-2" role="alert">
                    <i class="fas fa-check-circle"></i>
                    <span><?= htmlspecialchars($success) ?></span>
                </div>
            <?php endif; ?>

            <!-- Formulario de registro -->
            <form class="space-y-5" action="<?= base_url('auth/register') ?>" method="POST">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="first_name" class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                        <input id="first_name" name="first_name" type="text" required
                            class="form-input block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-secondary focus:border-secondary text-gray-900 placeholder-gray-400"
                            placeholder="Tu nombre"
                            value="<?= htmlspecialchars($_POST['first_name'] ?? '') ?>">
                    </div>
                    <div>
                        <label for="last_name" class="block text-sm font-medium text-gray-700 mb-1">Apellido</label>
                        <input id="last_name" name="last_name" type="text" required
                            class="form-input block w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-secondary focus:border-secondary text-gray-900 placeholder-gray-400"
                            placeholder="Tu apellido"
                            value="<?= htmlspecialchars($_POST['last_name'] ?? '') ?>">
                    </div>
                </div>
                <div class="relative">
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-1">Usuario</label>
                    <input id="username" name="username" type="text" required
                        class="form-input block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-secondary focus:border-secondary text-gray-900 placeholder-gray-400"
                        placeholder="Nombre de usuario"
                        value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-user text-gray-400"></i>
                    </div>
                </div>
                <div class="relative">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input id="email" name="email" type="email" required
                        class="form-input block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-secondary focus:border-secondary text-gray-900 placeholder-gray-400"
                        placeholder="tu@email.com"
                        value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-envelope text-gray-400"></i>
                    </div>
                </div>
                <div class="relative">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                    <input id="password" name="password" type="password" required
                        class="form-input block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-secondary focus:border-secondary text-gray-900 placeholder-gray-400"
                        placeholder="Mínimo 6 caracteres">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <button type="button" onclick="togglePassword('password', 'password-icon')"
                            class="text-gray-400 hover:text-secondary focus:outline-none">
                            <i id="password-icon" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <div class="relative">
                    <label for="confirm_password" class="block text-sm font-medium text-gray-700 mb-1">Confirmar Contraseña</label>
                    <input id="confirm_password" name="confirm_password" type="password" required
                        class="form-input block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-secondary focus:border-secondary text-gray-900 placeholder-gray-400"
                        placeholder="Repite tu contraseña">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <i class="fas fa-lock text-gray-400"></i>
                    </div>
                    <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                        <button type="button" onclick="togglePassword('confirm_password', 'confirm-password-icon')"
                            class="text-gray-400 hover:text-secondary focus:outline-none">
                            <i id="confirm-password-icon" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>
                <!-- Botón de registro -->
                <div>
                    <button type="submit"
                        class="btn-secondary w-full flex justify-center items-center gap-2 py-3 px-4 rounded-lg font-semibold text-base shadow hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-secondary focus:ring-offset-2 transition">
                        <i class="fas fa-user-plus"></i>
                        Crear Cuenta
                    </button>
                </div>
            </form>
            <!-- Enlaces adicionales -->
            <div class="text-center mt-4">
                <div class="text-sm">
                    <a href="<?= base_url('auth/login') ?>"
                        class="font-medium text-secondary hover:text-primary transition-colors duration-200">
                        ¿Ya tienes cuenta? Inicia sesión
                    </a>
                </div>
            </div>
        </div>
        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-xs text-gray-400">
                &copy; <?= date('Y') ?> Comunidades V3. Todos los derechos reservados.
            </p>
        </div>
    </div>
</div>