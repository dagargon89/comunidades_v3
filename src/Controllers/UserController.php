<?php

namespace Src\Controllers;

use Src\Core\Request;
use Models\User;

class UserController
{
    // Vista principal de usuarios
    public function index()
    {
        // Filtros desde GET
        $q = $_GET['q'] ?? '';
        $rol = $_GET['rol'] ?? '';
        $estado = $_GET['estado'] ?? '';
        $pagina_actual = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $por_pagina = 10;

        // Obtener usuarios filtrados y paginados
        $result = \Models\User::buscarUsuarios($q, $rol, $estado, $pagina_actual, $por_pagina);
        $usuarios = [];
        foreach ($result['usuarios'] as $u) {
            $usuarios[] = [
                'id' => $u['id'],
                'first_name' => $u['first_name'],
                'last_name' => $u['last_name'],
                'email' => $u['email'],
                'username' => $u['username'],
                'rol' => isset($u['roles'][0]['name']) ? $u['roles'][0]['name'] : '-',
                'is_active' => $u['is_active'],
            ];
        }
        $total_paginas = $result['pages'];

        // Obtener todos los roles para el filtro
        $roles = \Core\Database::fetchAll('SELECT id, name FROM roles ORDER BY name');

        require __DIR__ . '/../Views/users/index.php';
    }

    // Endpoint AJAX para búsqueda y paginación
    public function buscar()
    {
        header('Content-Type: application/json');

        $query = $_GET['q'] ?? '';
        $rol = $_GET['rol'] ?? '';
        $estado = $_GET['estado'] ?? '';
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $perPage = isset($_GET['per_page']) ? intval($_GET['per_page']) : 10;

        try {
            $result = User::buscarUsuarios($query, $rol, $estado, $page, $perPage);

            // Adaptar los datos para la tabla
            $rows = array_map(function ($u) {
                return [
                    'id' => $u['id'],
                    'nombre' => $u['first_name'] . ' ' . $u['last_name'],
                    'email' => $u['email'],
                    'usuario' => $u['username'],
                    'roles' => (isset($u['roles']) && is_array($u['roles']) && count($u['roles'])) ? implode(', ', array_column($u['roles'], 'name')) : '-',
                    'estado' => $u['is_active'] ? 'Activo' : 'Inactivo',
                    'fecha_registro' => $u['created_at'] ? explode(' ', $u['created_at'])[0] : '-',
                    'ultimo_acceso' => $u['updated_at'] ? explode(' ', $u['updated_at'])[0] : '-'
                ];
            }, $result['usuarios']);

            echo json_encode([
                'success' => true,
                'data' => $rows,
                'total' => $result['total'],
                'page' => $page,
                'per_page' => $perPage,
                'total_pages' => ceil($result['total'] / $perPage)
            ]);
        } catch (\Exception $e) {
            echo json_encode([
                'success' => false,
                'message' => 'Error al buscar usuarios'
            ]);
        }
    }

    // Obtener un usuario específico
    public function show($id)
    {
        header('Content-Type: application/json');

        try {
            $user = User::findById($id);
            if (!$user) {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
                exit;
            }

            // Obtener el rol del usuario
            $rol = \Core\Database::query(
                "SELECT r.id, r.name FROM roles r 
                 INNER JOIN user_roles ur ON r.id = ur.role_id 
                 WHERE ur.user_id = ?",
                [$id]
            );

            $userData = [
                'id' => $user->getId(),
                'first_name' => $user->getFirstName(),
                'last_name' => $user->getLastName(),
                'email' => $user->getEmail(),
                'username' => $user->getUsername(),
                'is_active' => $user->isActive() ? 1 : 0,
                'rol_id' => $rol ? $rol[0]['id'] : null
            ];

            echo json_encode(['success' => true, 'user' => $userData]);
        } catch (\Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error al obtener usuario']);
        }
    }

    // Mostrar formulario de alta
    public function create()
    {
        $roles = \Core\Database::fetchAll('SELECT id, name FROM roles ORDER BY name');
        require __DIR__ . '/../Views/users/create.php';
    }

    // Guardar usuario (POST)
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /users');
            exit;
        }
        $data = $_POST;
        $required = ['first_name', 'last_name', 'email', 'username', 'password', 'confirm_password', 'rol'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                $_SESSION['flash_error'] = 'Todos los campos son obligatorios';
                header('Location: /users/create');
                exit;
            }
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash_error'] = 'Email no válido';
            header('Location: /users/create');
            exit;
        }
        if ($data['password'] !== $data['confirm_password']) {
            $_SESSION['flash_error'] = 'Las contraseñas no coinciden';
            header('Location: /users/create');
            exit;
        }
        if (strlen($data['password']) < 6) {
            $_SESSION['flash_error'] = 'La contraseña debe tener al menos 6 caracteres';
            header('Location: /users/create');
            exit;
        }
        // Validar unicidad de username y email antes de crear
        if (\Models\User::findByUsername($data['username'])) {
            $_SESSION['flash_error'] = 'El nombre de usuario ya está en uso.';
            header('Location: /users/create');
            exit;
        }
        if (\Models\User::findByEmail($data['email'])) {
            $_SESSION['flash_error'] = 'El email ya está en uso.';
            header('Location: /users/create');
            exit;
        }
        try {
            $user = \Models\User::create([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => $data['password'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'is_active' => isset($data['is_active']) ? (int)$data['is_active'] : 1
            ]);
            $roleId = $data['rol'];
            $userId = $user->getId();
            \Core\Database::query("INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)", [$userId, $roleId]);
            $_SESSION['flash_success'] = 'Usuario creado correctamente';
            header('Location: /users');
            exit;
        } catch (\Exception $e) {
            $_SESSION['flash_error'] = 'Ocurrió un error al guardar el usuario. Por favor, revisa los datos ingresados.';
            header('Location: /users/create');
            exit;
        }
    }

    // Mostrar formulario de edición
    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /users');
            exit;
        }
        $usuario = \Models\User::findById($id, true);
        if (!$usuario) {
            $_SESSION['flash_error'] = 'Usuario no encontrado';
            header('Location: /users');
            exit;
        }
        $roles = \Core\Database::fetchAll('SELECT id, name FROM roles ORDER BY name');
        // Obtener rol actual
        $rol_actual = null;
        $roles_usuario = $usuario->getRoles();
        if (!empty($roles_usuario)) {
            $rol_actual = $roles_usuario[0]['id'];
        }
        require __DIR__ . '/../Views/users/edit.php';
    }

    // Actualizar usuario (POST)
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /users');
            exit;
        }
        $id = $_POST['id'] ?? null;
        if (!$id) {
            $_SESSION['flash_error'] = 'ID de usuario faltante';
            header('Location: /users');
            exit;
        }
        $usuario = \Models\User::findById($id, true);
        if (!$usuario) {
            $_SESSION['flash_error'] = 'Usuario no encontrado';
            header('Location: /users');
            exit;
        }
        $data = $_POST;
        $required = ['first_name', 'last_name', 'email', 'username', 'rol'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                $_SESSION['flash_error'] = 'Todos los campos son obligatorios';
                header('Location: /users/edit?id=' . $id);
                exit;
            }
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash_error'] = 'Email no válido';
            header('Location: /users/edit?id=' . $id);
            exit;
        }
        if (!empty($data['password'])) {
            if ($data['password'] !== $data['confirm_password']) {
                $_SESSION['flash_error'] = 'Las contraseñas no coinciden';
                header('Location: /users/edit?id=' . $id);
                exit;
            }
            if (strlen($data['password']) < 6) {
                $_SESSION['flash_error'] = 'La contraseña debe tener al menos 6 caracteres';
                header('Location: /users/edit?id=' . $id);
                exit;
            }
        }
        try {
            $updateData = [
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'username' => $data['username'],
                'is_active' => isset($data['is_active']) ? (int)$data['is_active'] : 1
            ];
            if (!empty($data['password'])) {
                $updateData['password'] = $data['password'];
            }
            $usuario->update($updateData);
            // Actualizar rol
            $roleId = $data['rol'];
            \Core\Database::query("DELETE FROM user_roles WHERE user_id = ?", [$id]);
            \Core\Database::query("INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)", [$id, $roleId]);
            $_SESSION['flash_success'] = 'Usuario actualizado correctamente';
            header('Location: /users');
            exit;
        } catch (\Exception $e) {
            $_SESSION['flash_error'] = $e->getMessage();
            header('Location: /users/edit?id=' . $id);
            exit;
        }
    }

    // Eliminar usuario (GET o POST)
    public function delete()
    {
        $id = $_GET['id'] ?? null;
        $force = isset($_GET['force']) && $_GET['force'] == 1;
        if (!$id) {
            header('Location: /users');
            exit;
        }
        $usuario = \Models\User::findById($id);
        if (!$usuario) {
            $_SESSION['flash_error'] = 'Usuario no encontrado';
            header('Location: /users');
            exit;
        }
        // Verificar si el usuario actual es admin para eliminación física
        $esAdmin = (isset($_SESSION['user']) && isset($_SESSION['user']['rol']) && $_SESSION['user']['rol'] === 'admin');
        try {
            if ($force && $esAdmin) {
                // Eliminación física
                \Core\Database::query("DELETE FROM user_roles WHERE user_id = ?", [$id]);
                \Core\Database::query("DELETE FROM users WHERE id = ?", [$id]);
                $_SESSION['flash_success'] = 'Usuario eliminado definitivamente.';
            } else {
                // Eliminación lógica
                \Core\Database::query("DELETE FROM user_roles WHERE user_id = ?", [$id]);
                \Core\Database::query("UPDATE users SET is_active = 0 WHERE id = ?", [$id]);
                $_SESSION['flash_success'] = 'Usuario desactivado correctamente.';
            }
        } catch (\Exception $e) {
            $_SESSION['flash_error'] = $e->getMessage();
        }
        header('Location: /users');
        exit;
    }

    // Ver detalles de usuario
    public function view()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /users');
            exit;
        }
        $usuario = \Models\User::findById($id);
        if (!$usuario) {
            $_SESSION['flash_error'] = 'Usuario no encontrado';
            header('Location: /users');
            exit;
        }
        $roles = \Core\Database::fetchAll('SELECT id, name FROM roles ORDER BY name');
        $rol_actual = null;
        $roles_usuario = $usuario->getRoles();
        if (!empty($roles_usuario)) {
            $rol_actual = $roles_usuario[0]['id'];
        }
        require __DIR__ . '/../Views/users/view.php';
    }

    // Reactivar usuario
    public function reactivate()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /users');
            exit;
        }
        try {
            \Core\Database::query("UPDATE users SET is_active = 1 WHERE id = ?", [$id]);
            $_SESSION['flash_success'] = 'Usuario reactivado correctamente.';
        } catch (\Exception $e) {
            $_SESSION['flash_error'] = $e->getMessage();
        }
        header('Location: /users');
        exit;
    }

    // Resetear contraseña (asigna una temporal y muestra en mensaje flash)
    public function resetPassword()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /users');
            exit;
        }
        $usuario = \Models\User::findById($id);
        if (!$usuario) {
            $_SESSION['flash_error'] = 'Usuario no encontrado';
            header('Location: /users');
            exit;
        }
        $tempPass = substr(bin2hex(random_bytes(4)), 0, 8);
        try {
            \Core\Database::query("UPDATE users SET password_hash = ? WHERE id = ?", [password_hash($tempPass, PASSWORD_DEFAULT), $id]);
            $_SESSION['flash_success'] = 'Contraseña temporal: ' . $tempPass;
        } catch (\Exception $e) {
            $_SESSION['flash_error'] = $e->getMessage();
        }
        header('Location: /users');
        exit;
    }

    // Cambiar rol
    public function changeRole()
    {
        $id = $_POST['id'] ?? null;
        $rol = $_POST['rol'] ?? null;
        if (!$id || !$rol) {
            header('Location: /users');
            exit;
        }
        try {
            $rolRow = \Core\Database::fetch("SELECT id FROM roles WHERE name = ?", [$rol]);
            if (!$rolRow) throw new \Exception('Rol no válido');
            \Core\Database::query("DELETE FROM user_roles WHERE user_id = ?", [$id]);
            \Core\Database::query("INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)", [$id, $rolRow['id']]);
            $_SESSION['flash_success'] = 'Rol actualizado correctamente.';
        } catch (\Exception $e) {
            $_SESSION['flash_error'] = $e->getMessage();
        }
        header('Location: /users');
        exit;
    }

    // Bloquear usuario (is_active = 0)
    public function block()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /users');
            exit;
        }
        try {
            \Core\Database::query("UPDATE users SET is_active = 0 WHERE id = ?", [$id]);
            $_SESSION['flash_success'] = 'Usuario bloqueado.';
        } catch (\Exception $e) {
            $_SESSION['flash_error'] = $e->getMessage();
        }
        header('Location: /users');
        exit;
    }

    // Desbloquear usuario (is_active = 1)
    public function unblock()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /users');
            exit;
        }
        try {
            \Core\Database::query("UPDATE users SET is_active = 1 WHERE id = ?", [$id]);
            $_SESSION['flash_success'] = 'Usuario desbloqueado.';
        } catch (\Exception $e) {
            $_SESSION['flash_error'] = $e->getMessage();
        }
        header('Location: /users');
        exit;
    }
}
