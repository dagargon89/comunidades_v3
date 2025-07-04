<?php

namespace Src\Models;

use Src\Core\Database;

class Project
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $stmt = $this->db->prepare("
            SELECT p.*, f.name as financier_name
            FROM project_management.projects p
            LEFT JOIN mydb.financiers f ON p.financiers_id = f.id
            ORDER BY p.name ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllPaginated($perPage = 10, $offset = 0, $search = '')
    {
        $whereClause = '';
        $params = [];

        if (!empty($search)) {
            $whereClause = "WHERE p.name LIKE ? OR f.name LIKE ?";
            $params = ["%$search%", "%$search%"];
        }

        $stmt = $this->db->prepare("
            SELECT p.*, f.name as financier_name
            FROM project_management.projects p
            LEFT JOIN mydb.financiers f ON p.financiers_id = f.id
            $whereClause
            ORDER BY p.name ASC
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
            $whereClause = "WHERE p.name LIKE ? OR f.name LIKE ?";
            $params = ["%$search%", "%$search%"];
        }

        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total
            FROM project_management.projects p
            LEFT JOIN mydb.financiers f ON p.financiers_id = f.id
            $whereClause
        ");
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result['total'];
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("
            SELECT p.*, f.name as financier_name
            FROM project_management.projects p
            LEFT JOIN mydb.financiers f ON p.financiers_id = f.id
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO project_management.projects 
            (name, background, justification, general_objective, financiers_id) 
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([
            $data['name'],
            $data['background'],
            $data['justification'],
            $data['general_objective'],
            $data['financiers_id']
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE project_management.projects 
            SET name = ?, background = ?, justification = ?, general_objective = ?, financiers_id = ?
            WHERE id = ?
        ");
        return $stmt->execute([
            $data['name'],
            $data['background'],
            $data['justification'],
            $data['general_objective'],
            $data['financiers_id'],
            $id
        ]);
    }

    public function delete($id)
    {
        // Verificar si hay objetivos específicos asociados
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM project_management.specific_objectives WHERE projects_id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();

        if ($result['count'] > 0) {
            return false; // No se puede eliminar porque tiene objetivos específicos asociados
        }

        $stmt = $this->db->prepare("DELETE FROM project_management.projects WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
