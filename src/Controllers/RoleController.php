<?php

namespace Src\Controllers;

class RoleController
{
    public function index()
    {
        // Aquí irá la lógica del listado de roles
    }

    public function apiRoles()
    {
        require_once __DIR__ . '/../Models/Role.php';
        $roles = \Models\Role::getAll();
        header('Content-Type: application/json');
        echo json_encode($roles);
        exit;
    }

    // Métodos CRUD aquí...
}
