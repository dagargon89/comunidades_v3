<?php

namespace Src\Controllers;

use Src\Models\Program;
use Src\Models\Axis;
use Src\Core\Request;

class ProgramController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function index()
    {
        $programModel = new Program($this->db);
        $axisModel = new Axis($this->db);

        // Obtener parámetros de paginación
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
        $search = isset($_GET['q']) ? $_GET['q'] : '';

        // Obtener datos paginados
        $offset = ($page - 1) * $perPage;
        if ($search !== '') {
            $programs = $programModel->search($search, $perPage, $offset);
            $total = $programModel->getTotalCount($search);
        } else {
            $programs = $programModel->getAllPaginated($perPage, $offset);
            $total = $programModel->getTotalCount();
        }
        $totalPages = ceil($total / $perPage);

        // Obtener ejes para el formulario
        $axes = $axisModel->getAll();

        // Incluir la vista
        include __DIR__ . '/../Views/programs/index.php';
    }

    public function create()
    {
        $axisModel = new Axis($this->db);
        $axes = $axisModel->getAll();

        include __DIR__ . '/../Views/programs/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'axes_id' => $_POST['axes_id'] ?? ''
            ];

            $programModel = new Program($this->db);

            if ($programModel->create($data)) {
                header('Location: /programs?success=1');
                exit;
            } else {
                header('Location: /programs/create?error=1');
                exit;
            }
        }
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /programs?error=invalid_id');
            exit;
        }

        $programModel = new Program($this->db);
        $axisModel = new Axis($this->db);

        $program = $programModel->findById($id);
        $axes = $axisModel->getAll();

        if (!$program) {
            header('Location: /programs?error=not_found');
            exit;
        }

        include __DIR__ . '/../Views/programs/edit.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if (!$id) {
                header('Location: /programs?error=invalid_id');
                exit;
            }

            $data = [
                'name' => $_POST['name'] ?? '',
                'axes_id' => $_POST['axes_id'] ?? ''
            ];

            $programModel = new Program($this->db);

            if ($programModel->update($id, $data)) {
                header('Location: /programs?success=2');
                exit;
            } else {
                header('Location: /programs/edit?id=' . $id . '&error=1');
                exit;
            }
        }
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /programs?error=invalid_id');
            exit;
        }

        $programModel = new Program($this->db);

        if ($programModel->delete($id)) {
            header('Location: /programs?success=3');
            exit;
        } else {
            header('Location: /programs?error=delete_failed');
            exit;
        }
    }

    public function view()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /programs?error=invalid_id');
            exit;
        }

        $programModel = new Program($this->db);
        $program = $programModel->findById($id);

        if (!$program) {
            header('Location: /programs?error=not_found');
            exit;
        }

        include __DIR__ . '/../Views/programs/view.php';
    }
}
