<?php

namespace Src\Controllers;

use Src\Models\Goal;
use Src\Models\Component;
use Src\Models\Organization;
use Src\Core\Request;

class GoalController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function index()
    {
        $goalModel = new Goal($this->db);
        $componentModel = new Component($this->db);
        $organizationModel = new Organization($this->db);

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
        $search = isset($_GET['q']) ? $_GET['q'] : '';

        $offset = ($page - 1) * $perPage;
        $goals = $goalModel->getAllPaginated($perPage, $offset, $search);
        $total = $goalModel->getTotalCount($search);
        $totalPages = ceil($total / $perPage);

        $components = $componentModel->getAll();
        $organizations = $organizationModel->getAll();

        include __DIR__ . '/../Views/goals/index.php';
    }

    public function create()
    {
        $componentModel = new Component($this->db);
        $organizationModel = new Organization($this->db);
        $components = $componentModel->getAll();
        $organizations = $organizationModel->getAll();

        include __DIR__ . '/../Views/goals/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'description' => $_POST['description'] ?? '',
                'number' => $_POST['number'] ?? '',
                'components_id' => $_POST['components_id'] ?? '',
                'organizations_id' => $_POST['organizations_id'] ?? ''
            ];

            $goalModel = new Goal($this->db);

            if ($goalModel->create($data)) {
                header('Location: /goals?success=1');
                exit;
            } else {
                header('Location: /goals/create?error=1');
                exit;
            }
        }
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /goals?error=invalid_id');
            exit;
        }

        $goalModel = new Goal($this->db);
        $componentModel = new Component($this->db);
        $organizationModel = new Organization($this->db);

        $goal = $goalModel->findById($id);
        $components = $componentModel->getAll();
        $organizations = $organizationModel->getAll();

        if (!$goal) {
            header('Location: /goals?error=not_found');
            exit;
        }

        include __DIR__ . '/../Views/goals/edit.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if (!$id) {
                header('Location: /goals?error=invalid_id');
                exit;
            }

            $data = [
                'description' => $_POST['description'] ?? '',
                'number' => $_POST['number'] ?? '',
                'components_id' => $_POST['components_id'] ?? '',
                'organizations_id' => $_POST['organizations_id'] ?? ''
            ];

            $goalModel = new Goal($this->db);

            if ($goalModel->update($id, $data)) {
                header('Location: /goals?success=2');
                exit;
            } else {
                header('Location: /goals/edit?id=' . $id . '&error=1');
                exit;
            }
        }
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /goals?error=invalid_id');
            exit;
        }

        $goalModel = new Goal($this->db);

        if ($goalModel->delete($id)) {
            header('Location: /goals?success=3');
            exit;
        } else {
            header('Location: /goals?error=delete_failed');
            exit;
        }
    }

    public function view()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /goals?error=invalid_id');
            exit;
        }

        $goalModel = new Goal($this->db);
        $goal = $goalModel->findById($id);

        if (!$goal) {
            header('Location: /goals?error=not_found');
            exit;
        }

        include __DIR__ . '/../Views/goals/view.php';
    }
}
