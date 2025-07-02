<?php

namespace Controllers;

use Models\User;

class AuthController
{
    /**
     * Mostrar formulario de login
     */
    public function showLogin()
    {
        // Si ya está autenticado, redirigir al dashboard
        if (is_authenticated()) {
            redirect('dashboard');
        }

        $error = $_SESSION['auth_error'] ?? null;
        unset($_SESSION['auth_error']);

        $title = 'Iniciar Sesión - Comunidades V3';
        ob_start();
        include __DIR__ . '/../Views/auth/login.php';
        $content = ob_get_clean();

        include __DIR__ . '/../Views/layouts/base.php';
    }

    /**
     * Procesar login
     */
    public function login()
    {
        file_put_contents(__DIR__ . '/../../session_debug.txt', 'LOGIN METHOD: ' . $_SERVER['REQUEST_METHOD'] . PHP_EOL, FILE_APPEND);
        // Log de depuración para ver si el POST llega y en qué URL/método
        file_put_contents(__DIR__ . '/../../session_debug.txt', 'POST: ' . print_r($_POST, true) . PHP_EOL . 'URL: ' . $_SERVER['REQUEST_URI'] . ' | Método: ' . $_SERVER['REQUEST_METHOD']);
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('login');
        }

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        // Validaciones básicas
        if (empty($username) || empty($password)) {
            $_SESSION['auth_error'] = 'Username y password son requeridos';
            redirect('login');
        }

        try {
            // Intentar autenticar
            $user = User::authenticate($username, $password);

            if (!$user) {
                $_SESSION['auth_error'] = 'Credenciales inválidas';
                redirect('login');
            }

            // Verificar que el usuario esté activo
            if (!$user->isActive()) {
                $_SESSION['auth_error'] = 'Tu cuenta está desactivada';
                redirect('login');
            }

            // Guardar en sesión
            $_SESSION['user_id'] = $user->getId();
            $_SESSION['user'] = $user->toArray();
            // Log de depuración
            file_put_contents(__DIR__ . '/../../session_debug.txt', print_r($_SESSION, true));

            // Limpiar errores de autenticación
            unset($_SESSION['auth_error']);

            // Redirigir al dashboard
            redirect('dashboard');
        } catch (\Exception $e) {
            $_SESSION['auth_error'] = 'Error durante la autenticación: ' . $e->getMessage();
            redirect('login');
        }
    }

    /**
     * Cerrar sesión
     */
    public function logout()
    {
        // Destruir sesión
        session_destroy();

        // Redirigir al login
        redirect('login');
    }

    /**
     * Mostrar formulario de registro
     */
    public function showRegister()
    {
        // Si ya está autenticado, redirigir al dashboard
        if (is_authenticated()) {
            redirect('dashboard');
        }

        $error = $_SESSION['auth_error'] ?? null;
        $success = $_SESSION['auth_success'] ?? null;
        unset($_SESSION['auth_error'], $_SESSION['auth_success']);

        $title = 'Registro - Comunidades V3';
        ob_start();
        include __DIR__ . '/../Views/auth/register.php';
        $content = ob_get_clean();

        include __DIR__ . '/../Views/layouts/base.php';
    }

    /**
     * Procesar registro
     */
    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('register');
        }

        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        $first_name = trim($_POST['first_name'] ?? '');
        $last_name = trim($_POST['last_name'] ?? '');

        // Validaciones
        if (empty($username) || empty($email) || empty($password)) {
            $_SESSION['auth_error'] = 'Todos los campos son requeridos';
            redirect('register');
        }

        if ($password !== $confirm_password) {
            $_SESSION['auth_error'] = 'Las contraseñas no coinciden';
            redirect('register');
        }

        if (strlen($password) < 6) {
            $_SESSION['auth_error'] = 'La contraseña debe tener al menos 6 caracteres';
            redirect('register');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['auth_error'] = 'El email no es válido';
            redirect('register');
        }

        try {
            // Crear usuario
            $user = User::create([
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'first_name' => $first_name,
                'last_name' => $last_name
            ]);

            $_SESSION['auth_success'] = 'Usuario registrado exitosamente. Puedes iniciar sesión.';
            redirect('login');
        } catch (\Exception $e) {
            $_SESSION['auth_error'] = $e->getMessage();
            redirect('register');
        }
    }

    /**
     * Mostrar perfil del usuario
     */
    public function showProfile()
    {
        if (!is_authenticated()) {
            redirect('login');
        }

        $user = User::findById($_SESSION['user_id']);
        if (!$user) {
            session_destroy();
            redirect('login');
        }

        $error = $_SESSION['profile_error'] ?? null;
        $success = $_SESSION['profile_success'] ?? null;
        unset($_SESSION['profile_error'], $_SESSION['profile_success']);

        include __DIR__ . '/../Views/auth/profile.php';
    }

    /**
     * Actualizar perfil
     */
    public function updateProfile()
    {
        if (!is_authenticated()) {
            redirect('login');
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('profile');
        }

        $user = User::findById($_SESSION['user_id']);
        if (!$user) {
            session_destroy();
            redirect('login');
        }

        $first_name = trim($_POST['first_name'] ?? '');
        $last_name = trim($_POST['last_name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $current_password = $_POST['current_password'] ?? '';
        $new_password = $_POST['new_password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';

        // Validaciones
        if (empty($first_name) || empty($last_name) || empty($email)) {
            $_SESSION['profile_error'] = 'Nombre, apellido y email son requeridos';
            redirect('profile');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['profile_error'] = 'El email no es válido';
            redirect('profile');
        }

        $updateData = [
            'first_name' => $first_name,
            'last_name' => $last_name,
            'email' => $email
        ];

        // Si se quiere cambiar la contraseña
        if (!empty($new_password)) {
            if (empty($current_password)) {
                $_SESSION['profile_error'] = 'Debes ingresar tu contraseña actual';
                redirect('profile');
            }

            if ($new_password !== $confirm_password) {
                $_SESSION['profile_error'] = 'Las nuevas contraseñas no coinciden';
                redirect('profile');
            }

            if (strlen($new_password) < 6) {
                $_SESSION['profile_error'] = 'La nueva contraseña debe tener al menos 6 caracteres';
                redirect('profile');
            }

            // Verificar contraseña actual
            if (!password_verify($current_password, $user->getPasswordHash())) {
                $_SESSION['profile_error'] = 'La contraseña actual es incorrecta';
                redirect('profile');
            }

            $updateData['password'] = $new_password;
        }

        try {
            $user->update($updateData);

            // Actualizar datos en sesión
            $_SESSION['user'] = $user->toArray();

            $_SESSION['profile_success'] = 'Perfil actualizado exitosamente';
            redirect('profile');
        } catch (\Exception $e) {
            $_SESSION['profile_error'] = $e->getMessage();
            redirect('profile');
        }
    }
}
