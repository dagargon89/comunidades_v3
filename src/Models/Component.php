<?php

namespace Src\Models;

use Src\Core\Database;

class Component
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $stmt = $this->db->prepare("
            SELECT c.*, al.name as action_line_name
            FROM mydb.components c
            LEFT JOIN mydb.action_lines al ON c.action_lines_id = al.id
            ORDER BY c.name ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllPaginated($perPage = 10, $offset = 0, $search = '')
    {
        $whereClause = '';
        $params = [];

        if (!empty($search)) {
            $whereClause = "WHERE c.name LIKE ? OR al.name LIKE ?";
            $params = ["%$search%", "%$search%"];
        }

        $stmt = $this->db->prepare("
            SELECT c.*, al.name as action_line_name
            FROM mydb.components c
            LEFT JOIN mydb.action_lines al ON c.action_lines_id = al.id
            $whereClause
            ORDER BY c.name ASC
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
            $whereClause = "WHERE c.name LIKE ? OR al.name LIKE ?";
            $params = ["%$search%", "%$search%"];
        }

        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total
            FROM mydb.components c
            LEFT JOIN mydb.action_lines al ON c.action_lines_id = al.id
            $whereClause
        ");
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result['total'];
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("
            SELECT c.*, al.name as action_line_name
            FROM mydb.components c
            LEFT JOIN mydb.action_lines al ON c.action_lines_id = al.id
            WHERE c.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO mydb.components (name, action_lines_id) VALUES (?, ?)");
        return $stmt->execute([$data['name'], $data['action_lines_id']]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE mydb.components SET name = ?, action_lines_id = ? WHERE id = ?");
        return $stmt->execute([$data['name'], $data['action_lines_id'], $id]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM mydb.components WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
