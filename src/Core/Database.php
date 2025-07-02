<?php

namespace Core;

use PDO;
use PDOException;

class Database
{
    private static $connections = [];
    private static $config;

    public static function init()
    {
        self::$config = require_once __DIR__ . '/../../config/database.php';
    }

    /**
     * Obtiene una conexión PDO a la base de datos especificada
     * @param string $connection Nombre de la conexión (project_management o mydb)
     * @return PDO
     * @throws PDOException
     */
    public static function getConnection($connection = null)
    {
        if (!self::$config) {
            self::init();
        }

        if (!$connection) {
            $connection = self::$config['default'];
        }

        if (!isset(self::$connections[$connection])) {
            $config = self::$config['connections'][$connection];

            $dsn = "mysql:host={$config['host']};port={$config['port']};dbname={$config['database']};charset={$config['charset']}";

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES {$config['charset']}"
            ];

            try {
                self::$connections[$connection] = new PDO(
                    $dsn,
                    $config['username'],
                    $config['password'],
                    $options
                );
            } catch (PDOException $e) {
                throw new PDOException("Error de conexión a la base de datos: " . $e->getMessage());
            }
        }

        return self::$connections[$connection];
    }

    /**
     * Ejecuta una consulta SQL
     * @param string $sql
     * @param array $params
     * @param string $connection
     * @return \PDOStatement
     */
    public static function query($sql, $params = [], $connection = null)
    {
        $pdo = self::getConnection($connection);
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    /**
     * Obtiene una fila
     * @param string $sql
     * @param array $params
     * @param string $connection
     * @return array|false
     */
    public static function fetch($sql, $params = [], $connection = null)
    {
        $stmt = self::query($sql, $params, $connection);
        return $stmt->fetch();
    }

    /**
     * Obtiene todas las filas
     * @param string $sql
     * @param array $params
     * @param string $connection
     * @return array
     */
    public static function fetchAll($sql, $params = [], $connection = null)
    {
        $stmt = self::query($sql, $params, $connection);
        return $stmt->fetchAll();
    }

    /**
     * Obtiene el último ID insertado
     * @param string $connection
     * @return string
     */
    public static function lastInsertId($connection = null)
    {
        $pdo = self::getConnection($connection);
        return $pdo->lastInsertId();
    }

    /**
     * Inicia una transacción
     * @param string $connection
     * @return bool
     */
    public static function beginTransaction($connection = null)
    {
        $pdo = self::getConnection($connection);
        return $pdo->beginTransaction();
    }

    /**
     * Confirma una transacción
     * @param string $connection
     * @return bool
     */
    public static function commit($connection = null)
    {
        $pdo = self::getConnection($connection);
        return $pdo->commit();
    }

    /**
     * Revierte una transacción
     * @param string $connection
     * @return bool
     */
    public static function rollback($connection = null)
    {
        $pdo = self::getConnection($connection);
        return $pdo->rollback();
    }

    /**
     * Cierra todas las conexiones
     */
    public static function closeConnections()
    {
        self::$connections = [];
    }
}
