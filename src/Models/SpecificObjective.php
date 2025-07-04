<?php

namespace Src\Models;

use Src\Core\Database;

class SpecificObjective
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $stmt = $this->db->prepare("
            SELECT so.*, p.name as project_name
            FROM project_management.specific_objectives so
            LEFT JOIN project_management.projects p ON so.projects_id = p.id
            ORDER BY so.description ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllPaginated($perPage = 10, $offset = 0, $search = '')
    {
        $whereClause = '';
        $params = [];

        if (!empty($search)) {
            $whereClause = "WHERE so.description LIKE ? OR p.name LIKE ?";
            $params = ["%$search%", "%$search%"];
        }

        $stmt = $this->db->prepare("
            SELECT so.*, p.name as project_name
            FROM project_management.specific_objectives so
            LEFT JOIN project_management.projects p ON so.projects_id = p.id
            $whereClause
            ORDER BY so.description ASC
            LIMIT ? OFFSET ?
        ");

        $params[] = $perPage;
        $params[] = $offset;
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getTotalCount($search = '')
    {
        $whereClause = '';
        $params = [];

        if (!empty($search)) {
            $whereClause = "WHERE so.description LIKE ? OR p.name LIKE ?";
            $params = ["%$search%", "%$search%"];
        }

        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total
            FROM project_management.specific_objectives so
            LEFT JOIN project_management.projects p ON so.projects_id = p.id
            $whereClause
        ");
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result['total'];
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("
            SELECT so.*, p.name as project_name
            FROM project_management.specific_objectives so
            LEFT JOIN project_management.projects p ON so.projects_id = p.id
            WHERE so.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO project_management.specific_objectives 
            (description, projects_id) 
            VALUES (?, ?)
        ");
        return $stmt->execute([
            $data['description'],
            $data['projects_id']
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE project_management.specific_objectives 
            SET description = ?, projects_id = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['description'],
            $data['projects_id'],
            $id
        ]);
    }

    public function delete($id)
    {
        // Verificar si hay actividades asociadas
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM project_management.activities WHERE specific_objective_id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();

        if ($result['count'] > 0) {
            return false; // No se puede eliminar porque tiene actividades asociadas
        }

        $stmt = $this->db->prepare("DELETE FROM project_management.specific_objectives WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
