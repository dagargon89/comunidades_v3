<?php

namespace Src\Controllers;

use Models\Axis;

class AxisController
{
    private $db;
    private $axisModel;
    public function __construct($db)
    {
        $this->db = $db;
        $this->axisModel = new Axis($db);
    }
    private function checkPermission($perm)
    {
        if (!current_user() || !current_user()->hasPermission($perm)) {
            $_SESSION['flash_error'] = 'No tienes permiso para realizar esta acción.';
            header('Location: /');
            exit;
        }
    }
    public function index()
    {
        $this->checkPermission('axis.view');
        $search = $_GET['q'] ?? '';
        $page = max(1, (int)($_GET['page'] ?? 1));
        $perPage = 20;
        $offset = ($page - 1) * $perPage;
        $total = $this->axisModel->count($search);
        $axes = $search ? $this->axisModel->search($search, $perPage, $offset) : $this->axisModel->all($perPage, $offset);
        $totalPages = ceil($total / $perPage);
        require __DIR__ . '/../Views/axes/index.php';
    }
    public function view()
    {
        $this->checkPermission('axis.view');
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $_SESSION['flash_error'] = 'Eje no encontrado.';
            header('Location: /axes');
            exit;
        }
        $axis = $this->axisModel->findById($id);
        if (!$axis) {
            $_SESSION['flash_error'] = 'Eje no encontrado.';
            header('Location: /axes');
            exit;
        }
        require __DIR__ . '/../Views/axes/view.php';
    }
    public function create()
    {
        $this->checkPermission('axis.create');
        require __DIR__ . '/../Views/axes/create.php';
    }
    public function store()
    {
        $this->checkPermission('axis.create');
        $name = trim($_POST['name'] ?? '');
        if (!$name) {
            $_SESSION['flash_error'] = 'El nombre es obligatorio.';
            header('Location: /axes/create');
            exit;
        }
        $this->axisModel->create(['name' => $name]);
        $_SESSION['flash_success'] = 'Eje creado correctamente.';
        header('Location: /axes');
        exit;
    }
    public function edit()
    {
        $this->checkPermission('axis.edit');
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $_SESSION['flash_error'] = 'Eje no encontrado.';
            header('Location: /axes');
            exit;
        }
        $axis = $this->axisModel->findById($id);
        if (!$axis) {
            $_SESSION['flash_error'] = 'Eje no encontrado.';
            header('Location: /axes');
            exit;
        }
        require __DIR__ . '/../Views/axes/edit.php';
    }
    public function update()
    {
        $this->checkPermission('axis.edit');
        $id = $_POST['id'] ?? null;
        $name = trim($_POST['name'] ?? '');
        if (!$id || !$name) {
            $_SESSION['flash_error'] = 'Datos incompletos.';
            header('Location: /axes/edit?id=' . $id);
            exit;
        }
        $this->axisModel->update($id, ['name' => $name]);
        $_SESSION['flash_success'] = 'Eje actualizado correctamente.';
        header('Location: /axes');
        exit;
    }
    public function delete()
    {
        $this->checkPermission('axis.delete');
        $id = $_GET['id'] ?? null;
        if (!$id) {
            $_SESSION['flash_error'] = 'Eje no encontrado.';
            header('Location: /axes');
            exit;
        }
        $this->axisModel->delete($id);
        $_SESSION['flash_success'] = 'Eje eliminado correctamente.';
        header('Location: /axes');
        exit;
    }
}
