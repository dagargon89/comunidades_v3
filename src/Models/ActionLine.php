<?php

namespace Src\Models;

use Src\Core\Database;
use PDO;

class ActionLine
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT al.*, p.name as program_name FROM mydb.action_lines al LEFT JOIN mydb.Program p ON al.Program_id = p.id ORDER BY al.name ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllPaginated($perPage = 10, $offset = 0, $search = '')
    {
        $whereClause = '';
        $params = [];
        if (!empty($search)) {
            $whereClause = "WHERE al.name LIKE :search OR p.name LIKE :search";
            $params[':search'] = "%$search%";
        }
        $stmt = $this->db->prepare("
            SELECT al.*, p.name as program_name
            FROM mydb.action_lines al
            LEFT JOIN mydb.Program p ON al.Program_id = p.id
            $whereClause
            ORDER BY al.name ASC
            LIMIT :perPage OFFSET :offset
        ");
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, PDO::PARAM_STR);
        }
        $stmt->bindValue(':perPage', $perPage, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalCount($search = '')
    {
        $whereClause = '';
        $params = [];
        if (!empty($search)) {
            $whereClause = "WHERE al.name LIKE :search OR p.name LIKE :search";
            $params[':search'] = "%$search%";
        }
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total
            FROM mydb.action_lines al
            LEFT JOIN mydb.Program p ON al.Program_id = p.id
            $whereClause
        ");
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, PDO::PARAM_STR);
        }
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total'];
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT al.*, p.name as program_name FROM mydb.action_lines al LEFT JOIN mydb.Program p ON al.Program_id = p.id WHERE al.id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO mydb.action_lines (name, Program_id) VALUES (:name, :program_id)");
        return $stmt->execute([
            ':name' => $data['name'],
            ':program_id' => $data['Program_id']
        ]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE mydb.action_lines SET name = :name, Program_id = :program_id WHERE id = :id");
        return $stmt->execute([
            ':name' => $data['name'],
            ':program_id' => $data['Program_id'],
            ':id' => $id
        ]);
    }

    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM mydb.action_lines WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
