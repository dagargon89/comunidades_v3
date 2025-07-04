<?php

namespace Src\Controllers;

use Src\Models\Financier;
use Src\Core\Request;

class FinancierController
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function index()
    {
        $model = new Financier($this->db);

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
        include __DIR__ . '/../Views/financiers/index.php';
    }

    public function create()
    {
        include __DIR__ . '/../Views/financiers/create.php';
    }

    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? ''
            ];

            $model = new Financier($this->db);

            if ($model->create($data)) {
                header('Location: /financiers?success=1');
                exit;
            } else {
                header('Location: /financiers/create?error=1');
                exit;
            }
        }
    }

    public function edit()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /financiers?error=invalid_id');
            exit;
        }

        $model = new Financier($this->db);
        $item = $model->findById($id);

        if (!$item) {
            header('Location: /financiers?error=not_found');
            exit;
        }

        include __DIR__ . '/../Views/financiers/edit.php';
    }

    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if (!$id) {
                header('Location: /financiers?error=invalid_id');
                exit;
            }

            $data = [
                'name' => $_POST['name'] ?? ''
            ];

            $model = new Financier($this->db);

            if ($model->update($id, $data)) {
                header('Location: /financiers?success=2');
                exit;
            } else {
                header('Location: /financiers/edit?id=' . $id . '&error=1');
                exit;
            }
        }
    }

    public function delete()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /financiers?error=invalid_id');
            exit;
        }

        $model = new Financier($this->db);

        if ($model->delete($id)) {
            header('Location: /financiers?success=3');
            exit;
        } else {
            header('Location: /financiers?error=delete_failed');
            exit;
        }
    }

    public function view()
    {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /financiers?error=invalid_id');
            exit;
        }

        $model = new Financier($this->db);
        $item = $model->findById($id);

        if (!$item) {
            header('Location: /financiers?error=not_found');
            exit;
        }

        include __DIR__ . '/../Views/financiers/view.php';
    }
}
