<?php

namespace Src\Controllers;

use Src\Core\Request;
use Models\User;

class UserController
{
    // Vista principal de usuarios
    public function index()
    {
        // Renderiza la vista, los datos se cargan por AJAX
        require_once __DIR__ . '/../Views/users/index.php';
    }

    // Endpoint AJAX para búsqueda y paginación
    public function buscar()
    {
        $query = $_GET['q'] ?? '';
        $rol = $_GET['rol'] ?? '';
        $estado = $_GET['estado'] ?? '';
        $page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
        $perPage = isset($_GET['per_page']) ? intval($_GET['per_page']) : 10;

        $result = User::buscarUsuarios($query, $rol, $estado, $page, $perPage);

        // Adaptar los datos para el componente
        $headers = ['Nombre', 'Email', 'Rol(es)', 'Estado', 'Fecha registro', 'Último acceso'];
        $fields = ['nombre', 'email', 'roles', 'estado', 'fecha_registro', 'ultimo_acceso'];
        $rows = array_map(function ($u) {
            return [
                'nombre' => $u['first_name'] . ' ' . $u['last_name'],
                'email' => $u['email'],
                'roles' => (isset($u['roles']) && is_array($u['roles']) && count($u['roles'])) ? implode(', ', array_column($u['roles'], 'name')) : '-',
                'estado' => $u['estado'],
                'fecha_registro' => $u['created_at'] ? explode(' ', $u['created_at'])[0] : '-',
                'ultimo_acceso' => $u['updated_at'] ? explode(' ', $u['updated_at'])[0] : '-',
                'raw' => $u
            ];
        }, $result['usuarios']);
        $actions = ['ver', 'editar', 'eliminar', 'reset', 'rol', 'correo', 'bloquear'];
        ob_start();
        include __DIR__ . '/../Views/components/table.php';
        $tablaHtml = ob_get_clean();
        echo $tablaHtml;
        exit;
    }

    // Guardar nuevo usuario (AJAX)
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            exit;
        }
        $data = $_POST;
        $required = ['first_name', 'last_name', 'email', 'username', 'password', 'confirm_password', 'rol'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                echo json_encode(['success' => false, 'message' => 'Todos los campos son obligatorios']);
                exit;
            }
        }
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['success' => false, 'message' => 'Email no válido']);
            exit;
        }
        if ($data['password'] !== $data['confirm_password']) {
            echo json_encode(['success' => false, 'message' => 'Las contraseñas no coinciden']);
            exit;
        }
        if (strlen($data['password']) < 6) {
            echo json_encode(['success' => false, 'message' => 'La contraseña debe tener al menos 6 caracteres']);
            exit;
        }
        require_once __DIR__ . '/../Models/User.php';
        require_once __DIR__ . '/../Models/Role.php';
        try {
            $user = \Models\User::create([
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => $data['password'],
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'is_active' => isset($data['is_active']) ? (int)$data['is_active'] : 1
            ]);
            // Asignar rol
            $role = $data['rol'];
            $userId = $user->getId();
            $roleRow = \Models\Role::getByName($role);
            if ($roleRow) {
                \Core\Database::query("INSERT INTO user_roles (user_id, role_id) VALUES (?, ?)", [$userId, $roleRow['id']]);
            }
            echo json_encode(['success' => true, 'message' => 'Usuario creado correctamente']);
        } catch (\Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }
}
