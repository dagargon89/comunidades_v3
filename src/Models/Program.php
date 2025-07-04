<?php

namespace Src\Models;

use Src\Core\Database;

class Program
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $stmt = $this->db->prepare("
            SELECT p.*, a.name as axis_name 
            FROM mydb.Program p 
            LEFT JOIN project_management.axes a ON p.axes_id = a.id 
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
            $whereClause = "WHERE p.name LIKE ? OR a.name LIKE ?";
            $params = ["%$search%", "%$search%"];
        }

        $stmt = $this->db->prepare("
            SELECT p.*, a.name as axis_name 
            FROM mydb.Program p 
            LEFT JOIN project_management.axes a ON p.axes_id = a.id 
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
            $whereClause = "WHERE p.name LIKE ? OR a.name LIKE ?";
            $params = ["%$search%", "%$search%"];
        }

        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total 
            FROM mydb.Program p 
            LEFT JOIN project_management.axes a ON p.axes_id = a.id 
            $whereClause
        ");
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result['total'];
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("
            SELECT p.*, a.name as axis_name 
            FROM mydb.Program p 
            LEFT JOIN project_management.axes a ON p.axes_id = a.id 
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO mydb.Program (name, axes_id) VALUES (?, ?)");
        return $stmt->execute([$data['name'], $data['axes_id']]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE mydb.Program SET name = ?, axes_id = ? WHERE id = ?");
        return $stmt->execute([$data['name'], $data['axes_id'], $id]);
    }

    public function delete($id)
    {
        // Verificar si hay líneas de acción asociadas
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM mydb.action_lines WHERE Program_id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();

        if ($result['count'] > 0) {
            return false; // No se puede eliminar porque tiene líneas de acción asociadas
        }

        $stmt = $this->db->prepare("DELETE FROM mydb.Program WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function getByAxisId($axisId)
    {
        $stmt = $this->db->prepare("
            SELECT p.*, a.name as axis_name 
            FROM mydb.Program p 
            LEFT JOIN project_management.axes a ON p.axes_id = a.id 
            WHERE p.axes_id = ?
            ORDER BY p.name ASC
        ");
        $stmt->execute([$axisId]);
        return $stmt->fetchAll();
    }
}
