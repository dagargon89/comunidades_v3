<?php

namespace Src\Controllers;

class RoleController
{
    public function index()
    {
        $roles = \Models\Role::getAll();
        require __DIR__ . '/../Views/roles/index.php';
    }

    public function create()
    {
        require __DIR__ . '/../Views/roles/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /roles');
            exit;
        }
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        if ($name === '') {
            $_SESSION['flash_error'] = 'El nombre es obligatorio';
            header('Location: /roles/create');
            exit;
        }
        if (\Models\Role::getByName($name)) {
            $_SESSION['flash_error'] = 'El nombre del rol ya existe';
            header('Location: /roles/create');
            exit;
        }
        \Core\Database::query("INSERT INTO roles (name, description) VALUES (?, ?)", [$name, $description]);
        $_SESSION['flash_success'] = 'Rol creado correctamente';
        header('Location: /roles');
        exit;
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /roles');
            exit;
        }
        $role = \Core\Database::fetch("SELECT * FROM roles WHERE id = ?", [$id]);
        if (!$role) {
            $_SESSION['flash_error'] = 'Rol no encontrado';
            header('Location: /roles');
            exit;
        }
        require __DIR__ . '/../Views/roles/edit.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /roles');
            exit;
        }
        $id = $_POST['id'] ?? null;
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        if (!$id || $name === '') {
            $_SESSION['flash_error'] = 'Datos incompletos';
            header('Location: /roles/edit?id=' . $id);
            exit;
        }
        $existing = \Models\Role::getByName($name);
        if ($existing && $existing['id'] != $id) {
            $_SESSION['flash_error'] = 'El nombre del rol ya existe';
            header('Location: /roles/edit?id=' . $id);
            exit;
        }
        \Core\Database::query("UPDATE roles SET name = ?, description = ? WHERE id = ?", [$name, $description, $id]);
        $_SESSION['flash_success'] = 'Rol actualizado correctamente';
        header('Location: /roles');
        exit;
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /roles');
            exit;
        }
        \Core\Database::query("DELETE FROM roles WHERE id = ?", [$id]);
        $_SESSION['flash_success'] = 'Rol eliminado correctamente';
        header('Location: /roles');
        exit;
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
