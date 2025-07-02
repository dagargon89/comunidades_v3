<?php

namespace Src\Controllers;

class PermissionController
{
    public function index()
    {
        $permissions = \Models\Permission::getAll();
        require __DIR__ . '/../Views/permissions/index.php';
    }

    public function create()
    {
        require __DIR__ . '/../Views/permissions/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /permissions');
            exit;
        }
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        if ($name === '') {
            $_SESSION['flash_error'] = 'El nombre es obligatorio';
            header('Location: /permissions/create');
            exit;
        }
        if (\Models\Permission::getByName($name)) {
            $_SESSION['flash_error'] = 'El nombre del permiso ya existe';
            header('Location: /permissions/create');
            exit;
        }
        \Models\Permission::create($name, $description);
        $_SESSION['flash_success'] = 'Permiso creado correctamente';
        header('Location: /permissions');
        exit;
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /permissions');
            exit;
        }
        $permission = \Models\Permission::getById($id);
        if (!$permission) {
            $_SESSION['flash_error'] = 'Permiso no encontrado';
            header('Location: /permissions');
            exit;
        }
        require __DIR__ . '/../Views/permissions/edit.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /permissions');
            exit;
        }
        $id = $_POST['id'] ?? null;
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        if (!$id || $name === '') {
            $_SESSION['flash_error'] = 'Datos incompletos';
            header('Location: /permissions/edit?id=' . $id);
            exit;
        }
        $existing = \Models\Permission::getByName($name);
        if ($existing && $existing['id'] != $id) {
            $_SESSION['flash_error'] = 'El nombre del permiso ya existe';
            header('Location: /permissions/edit?id=' . $id);
            exit;
        }
        \Models\Permission::update($id, $name, $description);
        $_SESSION['flash_success'] = 'Permiso actualizado correctamente';
        header('Location: /permissions');
        exit;
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /permissions');
            exit;
        }
        \Models\Permission::delete($id);
        $_SESSION['flash_success'] = 'Permiso eliminado correctamente';
        header('Location: /permissions');
        exit;
    }
}
