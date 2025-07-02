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
}
