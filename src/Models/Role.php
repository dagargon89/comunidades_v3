<?php

namespace Models;

use Core\Database;

class Role
{
    public static function getAll()
    {
        return Database::fetchAll("SELECT * FROM roles ORDER BY name");
    }

    public static function getByName($name)
    {
        return Database::fetch("SELECT * FROM roles WHERE name = ?", [$name]);
    }

    public static function getPermissions($role_id)
    {
        $sql = "SELECT p.* FROM permissions p INNER JOIN role_permissions rp ON p.id = rp.permission_id WHERE rp.role_id = ? ORDER BY p.name";
        return \Core\Database::fetchAll($sql, [$role_id]);
    }

    public static function setPermissions($role_id, $permission_ids)
    {
        // Eliminar permisos actuales
        \Core\Database::query("DELETE FROM role_permissions WHERE role_id = ?", [$role_id]);
        // Insertar los nuevos permisos
        if (!empty($permission_ids)) {
            foreach ($permission_ids as $pid) {
                \Core\Database::query("INSERT INTO role_permissions (role_id, permission_id) VALUES (?, ?)", [$role_id, $pid]);
            }
        }
    }
}
