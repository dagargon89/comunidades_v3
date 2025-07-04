<?php

namespace Src\Controllers;

use Src\Models\Component;
use Src\Models\ActionLine;
use Src\Core\Request;

class ComponentController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function index()
    {
        $componentModel = new Component($this->db);
        $actionLineModel = new ActionLine($this->db);

        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
        $search = isset($_GET['q']) ? $_GET['q'] : '';

        $offset = ($page - 1) * $perPage;
        $components = $componentModel->getAllPaginated($perPage, $offset, $search);
        $total = $componentModel->getTotalCount($search);
        $totalPages = ceil($total / $perPage);

        $actionLines = $actionLineModel->getAll();

        include __DIR__ . '/../Views/components/index.php';
    }

    public function create()
    {
        $actionLineModel = new ActionLine($this->db);
        $actionLines = $actionLineModel->getAll();

        include __DIR__ . '/../Views/components/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'action_lines_id' => $_POST['action_lines_id'] ?? ''
            ];

            $componentModel = new Component($this->db);

            if ($componentModel->create($data)) {
                header('Location: /components?success=1');
                exit;
            } else {
                header('Location: /components/create?error=1');
                exit;
            }
        }
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /components?error=invalid_id');
            exit;
        }

        $componentModel = new Component($this->db);
        $actionLineModel = new ActionLine($this->db);

        $component = $componentModel->findById($id);
        $actionLines = $actionLineModel->getAll();

        if (!$component) {
            header('Location: /components?error=not_found');
            exit;
        }

        include __DIR__ . '/../Views/components/edit.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if (!$id) {
                header('Location: /components?error=invalid_id');
                exit;
            }

            $data = [
                'name' => $_POST['name'] ?? '',
                'action_lines_id' => $_POST['action_lines_id'] ?? ''
            ];

            $componentModel = new Component($this->db);

            if ($componentModel->update($id, $data)) {
                header('Location: /components?success=2');
                exit;
            } else {
                header('Location: /components/edit?id=' . $id . '&error=1');
                exit;
            }
        }
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /components?error=invalid_id');
            exit;
        }

        $componentModel = new Component($this->db);

        if ($componentModel->delete($id)) {
            header('Location: /components?success=3');
            exit;
        } else {
            header('Location: /components?error=delete_failed');
            exit;
        }
    }

    public function view()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /components?error=invalid_id');
            exit;
        }

        $componentModel = new Component($this->db);
        $component = $componentModel->findById($id);

        if (!$component) {
            header('Location: /components?error=not_found');
            exit;
        }

        include __DIR__ . '/../Views/components/view.php';
    }
}
