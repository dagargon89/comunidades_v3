<?php

namespace Src\Controllers;

use Src\Models\Project;
use Src\Models\Financier;
use Src\Core\Request;

class ProjectController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function index()
    {
        $model = new Project($this->db);

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
        include __DIR__ . '/../Views/projects/index.php';
    }

    public function create()
    {
        $financierModel = new Financier($this->db);
        $financiers = $financierModel->getAll();

        include __DIR__ . '/../Views/projects/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'background' => $_POST['background'] ?? '',
                'justification' => $_POST['justification'] ?? '',
                'general_objective' => $_POST['general_objective'] ?? '',
                'financiers_id' => $_POST['financiers_id'] ?? ''
            ];

            $model = new Project($this->db);

            if ($model->create($data)) {
                header('Location: /projects?success=1');
                exit;
            } else {
                header('Location: /projects/create?error=1');
                exit;
            }
        }
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /projects?error=invalid_id');
            exit;
        }

        $model = new Project($this->db);
        $financierModel = new Financier($this->db);

        $item = $model->findById($id);
        $financiers = $financierModel->getAll();

        if (!$item) {
            header('Location: /projects?error=not_found');
            exit;
        }

        include __DIR__ . '/../Views/projects/edit.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if (!$id) {
                header('Location: /projects?error=invalid_id');
                exit;
            }

            $data = [
                'name' => $_POST['name'] ?? '',
                'background' => $_POST['background'] ?? '',
                'justification' => $_POST['justification'] ?? '',
                'general_objective' => $_POST['general_objective'] ?? '',
                'financiers_id' => $_POST['financiers_id'] ?? ''
            ];

            $model = new Project($this->db);

            if ($model->update($id, $data)) {
                header('Location: /projects?success=2');
                exit;
            } else {
                header('Location: /projects/edit?id=' . $id . '&error=1');
                exit;
            }
        }
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /projects?error=invalid_id');
            exit;
        }

        $model = new Project($this->db);

        if ($model->delete($id)) {
            header('Location: /projects?success=3');
            exit;
        } else {
            header('Location: /projects?error=delete_failed');
            exit;
        }
    }

    public function view()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /projects?error=invalid_id');
            exit;
        }

        $model = new Project($this->db);
        $item = $model->findById($id);

        if (!$item) {
            header('Location: /projects?error=not_found');
            exit;
        }

        include __DIR__ . '/../Views/projects/view.php';
    }
}
