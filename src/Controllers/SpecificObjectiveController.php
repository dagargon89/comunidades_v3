<?php

namespace Src\Controllers;

use Src\Models\SpecificObjective;
use Src\Models\Project;
use Src\Core\Request;

class SpecificObjectiveController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function index()
    {
        $model = new SpecificObjective($this->db);

        // Obtener parámetros de paginación
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
        $search = isset($_GET['search']) ? $_GET['search'] : '';

        // Obtener datos paginados
        $offset = ($page - 1) * $perPage;
        $data = $model->getAllPaginated($perPage, $offset, $search);
        $total = $model->getTotalCount($search);
        $totalPages = ceil($total / $perPage);

        // Incluir la vista
        include __DIR__ . '/../Views/specific_objectives/index.php';
    }

    public function create()
    {
        $projectModel = new Project($this->db);
        $projects = $projectModel->getAll();

        include __DIR__ . '/../Views/specific_objectives/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'description' => $_POST['description'] ?? '',
                'projects_id' => $_POST['projects_id'] ?? ''
            ];

            $model = new SpecificObjective($this->db);

            if ($model->create($data)) {
                header('Location: /specific_objectives?success=1');
                exit;
            } else {
                header('Location: /specific_objectives/create?error=1');
                exit;
            }
        }
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /specific_objectives?error=invalid_id');
            exit;
        }

        $model = new SpecificObjective($this->db);
        $projectModel = new Project($this->db);

        $item = $model->findById($id);
        $projects = $projectModel->getAll();

        if (!$item) {
            header('Location: /specific_objectives?error=not_found');
            exit;
        }

        include __DIR__ . '/../Views/specific_objectives/edit.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if (!$id) {
                header('Location: /specific_objectives?error=invalid_id');
                exit;
            }

            $data = [
                'description' => $_POST['description'] ?? '',
                'projects_id' => $_POST['projects_id'] ?? ''
            ];

            $model = new SpecificObjective($this->db);

            if ($model->update($id, $data)) {
                header('Location: /specific_objectives?success=2');
                exit;
            } else {
                header('Location: /specific_objectives/edit?id=' . $id . '&error=1');
                exit;
            }
        }
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /specific_objectives?error=invalid_id');
            exit;
        }

        $model = new SpecificObjective($this->db);

        if ($model->delete($id)) {
            header('Location: /specific_objectives?success=3');
            exit;
        } else {
            header('Location: /specific_objectives?error=delete_failed');
            exit;
        }
    }

    public function view()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /specific_objectives?error=invalid_id');
            exit;
        }

        $model = new SpecificObjective($this->db);
        $item = $model->findById($id);

        if (!$item) {
            header('Location: /specific_objectives?error=not_found');
            exit;
        }

        include __DIR__ . '/../Views/specific_objectives/view.php';
    }
}
