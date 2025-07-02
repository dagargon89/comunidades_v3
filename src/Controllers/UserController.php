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

    // Guardar nuevo usuario (AJAX)
    public function store()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            exit;
        }

        // Obtener datos JSON
        $input = json_decode(file_get_contents('php://input'), true);
        if (!$input) {
            $input = $_POST; // Fallback para datos de formulario
        }

        $required = ['first_name', 'last_name', 'email', 'username', 'password', 'confirm_password', 'rol'];
        foreach ($required as $field) {
            if (empty($input[$field])) {
                echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
                exit;
            }
        }

        if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'Email no válido']);
            exit;
        }

        if ($input['password'] !== $input['confirm_password']) {
            echo json_encode(['success' => false, 'message' => 'Las contraseñas no coinciden']);
            exit;
        }

        if (strlen($input['password']) < 6) {
            echo json_encode(['success' => false, 'message' => 'La contraseña debe tener al menos 6 caracteres']);
            exit;
        }

        try {
            $user = User::create([
                'username' => $input['username'],
                'email' => $input['email'],
                'password' => $input['password'],
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                'is_active' => isset($input['is_active']) ? (int)$input['is_active'] : 1
            ]);

            // Asignar rol
            $roleId = $input['rol'];
            $userId = $user->getId();
            \Core\Database::query("INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)", [$userId, $roleId]);

            echo json_encode(['success' => true, 'message' => 'Usuario creado correctamente']);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    // Actualizar usuario
    public function update($id)
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            exit;
        }

        // Obtener datos JSON
        $input = json_decode(file_get_contents('php://input'), true);

        $required = ['first_name', 'last_name', 'email', 'username', 'rol'];
        foreach ($required as $field) {
            if (empty($input[$field])) {
                echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
                exit;
            }
        }

        if (!filter_var($input['email'], FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'Email no válido']);
            exit;
        }

        // Validar contraseña si se proporciona
        if (!empty($input['password'])) {
            if ($input['password'] !== $input['confirm_password']) {
                echo json_encode(['success' => false, 'message' => 'Las contraseñas no coinciden']);
                exit;
            }
            if (strlen($input['password']) < 6) {
                echo json_encode(['success' => false, 'message' => 'La contraseña debe tener al menos 6 caracteres']);
                exit;
            }
        }

        try {
            $user = User::findById($id);
            if (!$user) {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
                exit;
            }

            // Actualizar datos básicos
            $updateData = [
                'first_name' => $input['first_name'],
                'last_name' => $input['last_name'],
                'email' => $input['email'],
                'username' => $input['username'],
                'is_active' => (int)$input['is_active']
            ];

            // Actualizar contraseña si se proporciona
            if (!empty($input['password'])) {
                $updateData['password'] = $input['password'];
            }

            $user->update($updateData);

            // Actualizar rol
            $roleId = $input['rol'];
            \Core\Database::query("DELETE FROM user_roles WHERE user_id = ?", [$id]);
            \Core\Database::query("INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)", [$id, $roleId]);

            echo json_encode(['success' => true, 'message' => 'Usuario actualizado correctamente']);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }

    // Eliminar usuario
    public function destroy($id)
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'DELETE') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            exit;
        }

        try {
            $user = User::findById($id);
            if (!$user) {
                http_response_code(404);
                echo json_encode(['success' => false, 'message' => 'Usuario no encontrado']);
                exit;
            }

            // Eliminar roles del usuario
            \Core\Database::query("DELETE FROM user_roles WHERE user_id = ?", [$id]);

            // Eliminar usuario (marcar como inactivo en lugar de eliminar físicamente)
            \Core\Database::query("UPDATE users SET is_active = 0 WHERE id = ?", [$id]);

            echo json_encode(['success' => true, 'message' => 'Usuario eliminado correctamente']);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
