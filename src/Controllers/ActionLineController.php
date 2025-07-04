<?php

namespace Src\Controllers;

use Src\Models\ActionLine;
use Src\Models\Program;
use Src\Core\Request;

class ActionLineController
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function index()
    {
        $actionLineModel = new ActionLine($this->db);
        $programModel = new Program($this->db);
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
        $search = isset($_GET['q']) ? $_GET['q'] : '';
        $offset = ($page - 1) * $perPage;
        $actionLines = $actionLineModel->getAllPaginated($perPage, $offset, $search);
        $total = $actionLineModel->getTotalCount($search);
        $totalPages = ceil($total / $perPage);
        $programs = $programModel->getAll();
        include __DIR__ . '/../Views/action_lines/index.php';
    }

    public function create()
    {
        $programModel = new Program($this->db);
        $programs = $programModel->getAll();
        include __DIR__ . '/../Views/action_lines/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'Program_id' => $_POST['Program_id'] ?? ''
            ];
            $actionLineModel = new ActionLine($this->db);
            if ($actionLineModel->create($data)) {
                header('Location: /action_lines?success=1');
                exit;
            } else {
                header('Location: /action_lines/create?error=1');
                exit;
            }
        }
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /action_lines?error=invalid_id');
            exit;
        }
        $actionLineModel = new ActionLine($this->db);
        $programModel = new Program($this->db);
        $actionLine = $actionLineModel->findById($id);
        $programs = $programModel->getAll();
        if (!$actionLine) {
            header('Location: /action_lines?error=not_found');
            exit;
        }
        include __DIR__ . '/../Views/action_lines/edit.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if (!$id) {
                header('Location: /action_lines?error=invalid_id');
                exit;
            }
            $data = [
                'name' => $_POST['name'] ?? '',
                'Program_id' => $_POST['Program_id'] ?? ''
            ];
            $actionLineModel = new ActionLine($this->db);
            if ($actionLineModel->update($id, $data)) {
                header('Location: /action_lines?success=2');
                exit;
            } else {
                header('Location: /action_lines/edit?id=' . $id . '&error=1');
                exit;
            }
        }
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /action_lines?error=invalid_id');
            exit;
        }
        $actionLineModel = new ActionLine($this->db);
        if ($actionLineModel->delete($id)) {
            header('Location: /action_lines?success=3');
            exit;
        } else {
            header('Location: /action_lines?error=delete_failed');
            exit;
        }
    }

    public function view()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /action_lines?error=invalid_id');
            exit;
        }
        $actionLineModel = new ActionLine($this->db);
        $actionLine = $actionLineModel->findById($id);
        if (!$actionLine) {
            header('Location: /action_lines?error=not_found');
            exit;
        }
        include __DIR__ . '/../Views/action_lines/view.php';
    }
}
