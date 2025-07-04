<?php

namespace Models;

use Core\Database;

class Permission
{
    public static function getAll()
    {
        return Database::fetchAll("SELECT * FROM permissions ORDER BY name");
    }

    public static function getById($id)
    {
        return Database::fetch("SELECT * FROM permissions WHERE id = ?", [$id]);
    }

    public static function getByName($name)
    {
        return Database::fetch("SELECT * FROM permissions WHERE name = ?", [$name]);
    }

    public static function create($name, $description)
    {
        Database::query("INSERT INTO permissions (name, description) VALUES (?, ?)", [$name, $description]);
        return Database::lastInsertId();
    }

    public static function update($id, $name, $description)
    {
        Database::query("UPDATE permissions SET name = ?, description = ? WHERE id = ?", [$name, $description, $id]);
    }

    public static function delete($id)
    {
        Database::query("DELETE FROM permissions WHERE id = ?", [$id]);
    }

    public static function search($q)
    {
        $q = "%$q%";
        return Database::fetchAll("SELECT * FROM permissions WHERE name LIKE ? OR description LIKE ? ORDER BY name", [$q, $q]);
    }
}
