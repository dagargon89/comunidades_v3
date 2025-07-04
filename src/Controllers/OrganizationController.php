<?php

namespace Src\Controllers;

use Src\Models\Organization;
use Src\Core\Request;

class OrganizationController
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
    public function index()
    {
        $organizationModel = new Organization($this->db);
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
        $search = isset($_GET['q']) ? $_GET['q'] : '';
        $offset = ($page - 1) * $perPage;
        $organizations = $organizationModel->getAllPaginated($perPage, $offset, $search);
        $total = $organizationModel->getTotalCount($search);
        $totalPages = ceil($total / $perPage);
        include __DIR__ . '/../Views/organizations/index.php';
    }
    public function create()
    {
        include __DIR__ . '/../Views/organizations/create.php';
    }
    public function store()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? ''
            ];
            $organizationModel = new Organization($this->db);
            if ($organizationModel->create($data)) {
                header('Location: /organizations?success=1');
                exit;
            } else {
                header('Location: /organizations/create?error=1');
                exit;
            }
        }
    }
    public function edit()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /organizations?error=invalid_id');
            exit;
        }
        $organizationModel = new Organization($this->db);
        $organization = $organizationModel->findById($id);
        if (!$organization) {
            header('Location: /organizations?error=not_found');
            exit;
        }
        include __DIR__ . '/../Views/organizations/edit.php';
    }
    public function update()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            if (!$id) {
                header('Location: /organizations?error=invalid_id');
                exit;
            }
            $data = [
                'name' => $_POST['name'] ?? ''
            ];
            $organizationModel = new Organization($this->db);
            if ($organizationModel->update($id, $data)) {
                header('Location: /organizations?success=2');
                exit;
            } else {
                header('Location: /organizations/edit?id=' . $id . '&error=1');
                exit;
            }
        }
    }
    public function delete()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /organizations?error=invalid_id');
            exit;
        }
        $organizationModel = new Organization($this->db);
        if ($organizationModel->delete($id)) {
            header('Location: /organizations?success=3');
            exit;
        } else {
            header('Location: /organizations?error=delete_failed');
            exit;
        }
    }
    public function view()
    {
        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /organizations?error=invalid_id');
            exit;
        }
        $organizationModel = new Organization($this->db);
        $organization = $organizationModel->findById($id);
        if (!$organization) {
            header('Location: /organizations?error=not_found');
            exit;
        }
        include __DIR__ . '/../Views/organizations/view.php';
    }
}
