<div class="min-h-screen flex items-center justify-center bg-transparent py-12 px-4 sm:px-6 lg:px-8">
    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-xl px-8 py-10">
            <!-- Logo y título -->
            <div class="text-center mb-6">
                <div class="mx-auto h-16 w-16 bg-primary flex items-center justify-center rounded-full shadow-md">
                    <i class="fas fa-users text-white text-2xl"></i>
                </div>
                <h2 class="mt-4 text-3xl font-extrabold text-info">Comunidades V3</h2>
                <p class="mt-1 text-sm text-gray-500">Inicia sesión en tu cuenta</p>
            </div>

            <!-- Mensajes de error/success -->
            <?php if ($error): ?>
                <div class="alert alert-danger mb-4 px-4 py-3 rounded flex items-center gap-2" role="alert">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span><?= htmlspecialchars($error) ?></span>
                </div>
            <?php endif; ?>

            <!-- Enlaces adicionales -->
            <div class="flex items-center justify-between mt-4">
                <div class="text-sm">
                    <a href="<?= base_url('auth/register') ?>"
                        class="font-medium text-primary hover:text-secondary transition-colors duration-200">
                        ¿No tienes cuenta? Regístrate
                    </a>
                </div>
            </div>

            <!-- Enlaces adicionales -->
            <p class="text-xs text-gray-400 mb-2">URL actual: <?= htmlspecialchars($_SERVER['REQUEST_URI']) ?> | Método: <?= htmlspecialchars($_SERVER['REQUEST_METHOD']) ?></p>
            <p class="text-xs text-blue-400 mb-2">Action generado: <?= base_url('auth/login') ?></p>

            <!-- Formulario de login -->
            <form class="space-y-5" action="<?= base_url('auth/login') ?>" method="POST">
                <div class="space-y-4">
                    <!-- Username -->
                    <div class="relative">
                        <label for="username" class="sr-only">Usuario</label>
                        <input id="username" name="username" type="text" required
                            class="form-input block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary text-gray-900 placeholder-gray-400"
                            placeholder="Usuario"
                            value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-400"></i>
                        </div>
                    </div>
                    <!-- Password -->
                    <div class="relative">
                        <label for="password" class="sr-only">Contraseña</label>
                        <input id="password" name="password" type="password" required
                            class="form-input block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-primary focus:border-primary text-gray-900 placeholder-gray-400"
                            placeholder="Contraseña">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" onclick="togglePassword('password', 'password-icon')"
                                class="text-gray-400 hover:text-primary focus:outline-none">
                                <i id="password-icon" class="fas fa-eye"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Botón de login -->
                <div>
                    <button type="submit"
                        class="btn-primary w-full flex justify-center items-center gap-2 py-3 px-4 rounded-lg font-semibold text-base shadow hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-2 transition">
                        <i class="fas fa-sign-in-alt"></i>
                        Iniciar Sesión
                    </button>
                </div>
            </form>
        </div>
        <!-- Footer -->
        <div class="text-center mt-8">
            <p class="text-xs text-gray-400">
                &copy; <?= date('Y') ?> Comunidades V3. Todos los derechos reservados.
            </p>
        </div>
    </div>
</div>