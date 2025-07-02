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
}
