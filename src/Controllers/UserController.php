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
        header('Content-Type: application/json');
        echo json_encode($result);
        exit;
    }
}
