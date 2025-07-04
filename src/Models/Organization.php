<?php

namespace Src\Models;

use Src\Core\Database;

class Organization
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
    public function getAll()
    {
        $stmt = $this->db->prepare("SELECT * FROM mydb.organizations ORDER BY name ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    public function getAllPaginated($perPage = 10, $offset = 0, $search = '')
    {
        $whereClause = '';
        $params = [];
        if (!empty($search)) {
            $whereClause = "WHERE name LIKE ?";
            $params = ["%$search%"];
        }
        $stmt = $this->db->prepare("
            SELECT * FROM mydb.organizations
            $whereClause
            ORDER BY name ASC
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
            $whereClause = "WHERE name LIKE ?";
            $params = ["%$search%"];
        }
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total
            FROM mydb.organizations
            $whereClause
        ");
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result['total'];
    }
    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM mydb.organizations WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    public function create($data)
    {
        $stmt = $this->db->prepare("INSERT INTO mydb.organizations (name) VALUES (?)");
        return $stmt->execute([$data['name']]);
    }
    public function update($id, $data)
    {
        $stmt = $this->db->prepare("UPDATE mydb.organizations SET name = ? WHERE id = ?");
        return $stmt->execute([$data['name'], $id]);
    }
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM mydb.organizations WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
