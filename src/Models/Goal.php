<?php

namespace Src\Models;

use Src\Core\Database;

class Goal
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $stmt = $this->db->prepare("
            SELECT g.*, c.name as component_name, o.name as organization_name
            FROM project_management.goals g
            LEFT JOIN mydb.components c ON g.components_id = c.id
            LEFT JOIN mydb.organizations o ON g.organizations_id = o.id
            ORDER BY g.id DESC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllPaginated($perPage = 10, $offset = 0, $search = '')
    {
        $whereClause = '';
        $params = [];
        if (!empty($search)) {
            $whereClause = "WHERE g.description LIKE ? OR c.name LIKE ? OR o.name LIKE ?";
            $params = ["%$search%", "%$search%", "%$search%"];
        }
        $stmt = $this->db->prepare("
            SELECT g.*, c.name as component_name, o.name as organization_name
            FROM project_management.goals g
            LEFT JOIN mydb.components c ON g.components_id = c.id
            LEFT JOIN mydb.organizations o ON g.organizations_id = o.id
            $whereClause
            ORDER BY g.id DESC
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
            $whereClause = "WHERE g.description LIKE ? OR c.name LIKE ? OR o.name LIKE ?";
            $params = ["%$search%", "%$search%", "%$search%"];
        }
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total
            FROM project_management.goals g
            LEFT JOIN mydb.components c ON g.components_id = c.id
            LEFT JOIN mydb.organizations o ON g.organizations_id = o.id
            $whereClause
        ");
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result['total'];
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("
            SELECT g.*, c.name as component_name, o.name as organization_name
            FROM project_management.goals g
            LEFT JOIN mydb.components c ON g.components_id = c.id
            LEFT JOIN mydb.organizations o ON g.organizations_id = o.id
            WHERE g.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO project_management.goals (description, number, components_id, organizations_id) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $data['description'],
            $data['number'],
            $data['components_id'],
            $data['organizations_id']
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE project_management.goals SET description = ?, number = ?, components_id = ?, organizations_id = ? WHERE id = ?");
        return $stmt->execute([
            $data['description'],
            $data['number'],
            $data['components_id'],
            $data['organizations_id'],
            $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM project_management.goals WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
