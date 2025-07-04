<?php

namespace Src\Models;

use Src\Core\Database;

class Financier
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        $stmt = $this->db->prepare("
            SELECT * FROM mydb.financiers
            ORDER BY name ASC
        ");
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
            SELECT * FROM mydb.financiers
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
            FROM mydb.financiers
            $whereClause
        ");
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result['total'];
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM mydb.financiers WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data)
    {
        $stmt = $this->db->prepare("
            INSERT INTO mydb.financiers (name) 
            VALUES (?)
        ");
        return $stmt->execute([$data['name']]);
    }

    public function update($id, $data)
    {
        $stmt = $this->db->prepare("
            UPDATE mydb.financiers 
            SET name = ?
            WHERE id = ?
        ");
        return $stmt->execute([$data['name'], $id]);
    }

    public function delete($id)
    {
        // Verificar si hay proyectos asociados
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM project_management.projects WHERE financiers_id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();

        if ($result['count'] > 0) {
            return false; // No se puede eliminar porque tiene proyectos asociados
        }

        $stmt = $this->db->prepare("DELETE FROM mydb.financiers WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
