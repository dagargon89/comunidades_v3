<?php

namespace Src\Models;

use PDO;

class Axis
{
    private $db;
    public function __construct($db)
    {
        $this->db = $db;
    }
    public function all($limit = 20, $offset = 0)
    {
        $stmt = $this->db->prepare('SELECT * FROM axes ORDER BY id DESC LIMIT :limit OFFSET :offset');
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAll()
    {
        $stmt = $this->db->prepare('SELECT * FROM axes ORDER BY name ASC');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function count($search = '')
    {
        if ($search) {
            $stmt = $this->db->prepare('SELECT COUNT(*) FROM axes WHERE name LIKE ?');
            $stmt->execute(["%$search%"]);
        } else {
            $stmt = $this->db->query('SELECT COUNT(*) FROM axes');
        }
        return $stmt->fetchColumn();
    }
    public function search($search, $limit = 20, $offset = 0)
    {
        $stmt = $this->db->prepare('SELECT * FROM axes WHERE name LIKE :search ORDER BY id DESC LIMIT :limit OFFSET :offset');
        $stmt->bindValue(':search', "%$search%", PDO::PARAM_STR);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function findById($id)
    {
        $stmt = $this->db->prepare('SELECT * FROM axes WHERE id = ?');
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function create($data)
    {
        $stmt = $this->db->prepare('INSERT INTO axes (name) VALUES (?)');
        return $stmt->execute([$data['name']]);
    }
    public function update($id, $data)
    {
        $stmt = $this->db->prepare('UPDATE axes SET name = ? WHERE id = ?');
        return $stmt->execute([$data['name'], $id]);
    }
    public function delete($id)
    {
        $stmt = $this->db->prepare('DELETE FROM axes WHERE id = ?');
        return $stmt->execute([$id]);
    }
}
