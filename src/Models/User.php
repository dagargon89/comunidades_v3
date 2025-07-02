<?php

namespace Models;

use Core\Database;

class User
{
    private $id;
    private $username;
    private $email;
    private $password_hash;
    private $first_name;
    private $last_name;
    private $is_active;
    private $created_at;
    private $updated_at;

    public function __construct($data = [])
    {
        if (!empty($data)) {
            $this->fill($data);
        }
    }

    public function fill($data)
    {
        $this->id = $data['id'] ?? null;
        $this->username = $data['username'] ?? '';
        $this->email = $data['email'] ?? '';
        $this->password_hash = $data['password_hash'] ?? '';
        $this->first_name = $data['first_name'] ?? '';
        $this->last_name = $data['last_name'] ?? '';
        $this->is_active = $data['is_active'] ?? 1;
        $this->created_at = $data['created_at'] ?? null;
        $this->updated_at = $data['updated_at'] ?? null;
    }

    // Getters
    public function getId()
    {
        return $this->id;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getFirstName()
    {
        return $this->first_name;
    }
    public function getLastName()
    {
        return $this->last_name;
    }
    public function getFullName()
    {
        return trim($this->first_name . ' ' . $this->last_name);
    }
    public function isActive()
    {
        return (bool)$this->is_active;
    }
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }
    public function getPasswordHash()
    {
        return $this->password_hash;
    }

    /**
     * Buscar usuario por ID
     */
    public static function findById($id, $incluirInactivos = false)
    {
        $sql = "SELECT * FROM users WHERE id = ?";
        $params = [$id];
        if (!$incluirInactivos) {
            $sql .= " AND is_active = 1";
        }
        $data = Database::fetch($sql, $params);
        return $data ? new self($data) : null;
    }

    /**
     * Buscar usuario por username
     */
    public static function findByUsername($username)
    {
        $data = Database::fetch(
            "SELECT * FROM users WHERE username = ? AND is_active = 1",
            [$username]
        );

        return $data ? new self($data) : null;
    }

    /**
     * Buscar usuario por email
     */
    public static function findByEmail($email)
    {
        $data = Database::fetch(
            "SELECT * FROM users WHERE email = ? AND is_active = 1",
            [$email]
        );

        return $data ? new self($data) : null;
    }

    /**
     * Autenticar usuario
     */
    public static function authenticate($username, $password)
    {
        $user = self::findByUsername($username);

        if (!$user) {
            return null;
        }

        if (password_verify($password, $user->getPasswordHash())) {
            return $user;
        }

        return null;
    }

    /**
     * Crear nuevo usuario
     */
    public static function create($data)
    {
        // Validar datos requeridos
        if (empty($data['username']) || empty($data['email']) || empty($data['password'])) {
            throw new \Exception('Username, email y password son requeridos');
        }

        // Verificar si el username ya existe
        if (self::findByUsername($data['username'])) {
            throw new \Exception('El username ya está en uso');
        }

        // Verificar si el email ya existe
        if (self::findByEmail($data['email'])) {
            throw new \Exception('El email ya está en uso');
        }

        // Hash de la contraseña
        $password_hash = password_hash($data['password'], PASSWORD_DEFAULT);

        $sql = "INSERT INTO users (username, email, password_hash, first_name, last_name, is_active) 
                VALUES (?, ?, ?, ?, ?, ?)";

        Database::query($sql, [
            $data['username'],
            $data['email'],
            $password_hash,
            $data['first_name'] ?? '',
            $data['last_name'] ?? '',
            1
        ]);

        $id = Database::lastInsertId();
        return self::findById($id);
    }

    /**
     * Actualizar usuario
     */
    public function update($data)
    {
        if (!$this->id) {
            throw new \Exception('No se puede actualizar un usuario sin ID');
        }

        $updates = [];
        $params = [];

        if (isset($data['first_name'])) {
            $updates[] = 'first_name = ?';
            $params[] = $data['first_name'];
        }

        if (isset($data['last_name'])) {
            $updates[] = 'last_name = ?';
            $params[] = $data['last_name'];
        }

        if (isset($data['email'])) {
            // Verificar que el email no esté en uso por otro usuario
            $existing = self::findByEmail($data['email']);
            if ($existing && $existing->getId() != $this->id) {
                throw new \Exception('El email ya está en uso');
            }
            $updates[] = 'email = ?';
            $params[] = $data['email'];
        }

        if (isset($data['password'])) {
            $updates[] = 'password_hash = ?';
            $params[] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        if (isset($data['is_active'])) {
            $updates[] = 'is_active = ?';
            $params[] = $data['is_active'];
        }

        if (empty($updates)) {
            return $this;
        }

        $params[] = $this->id;

        $sql = "UPDATE users SET " . implode(', ', $updates) . " WHERE id = ?";
        Database::query($sql, $params);

        // Recargar datos
        $updated = self::findById($this->id);
        if ($updated) {
            $this->fill($updated->toArray());
        }

        return $this;
    }

    /**
     * Obtener roles del usuario
     */
    public function getRoles()
    {
        $sql = "SELECT r.* FROM roles r 
                JOIN user_roles ur ON r.id = ur.role_id 
                WHERE ur.user_id = ?";

        return Database::fetchAll($sql, [$this->id]);
    }

    /**
     * Verificar si el usuario tiene un rol específico
     */
    public function hasRole($roleName)
    {
        $sql = "SELECT COUNT(*) as count FROM roles r 
                JOIN user_roles ur ON r.id = ur.role_id 
                WHERE ur.user_id = ? AND r.name = ?";

        $result = Database::fetch($sql, [$this->id, $roleName]);
        return $result && $result['count'] > 0;
    }

    /**
     * Obtener permisos del usuario
     */
    public function getPermissions()
    {
        $sql = "SELECT DISTINCT p.* FROM permissions p 
                JOIN role_permissions rp ON p.id = rp.permission_id 
                JOIN user_roles ur ON rp.role_id = ur.role_id 
                WHERE ur.user_id = ?";

        return Database::fetchAll($sql, [$this->id]);
    }

    /**
     * Verificar si el usuario tiene un permiso específico
     */
    public function hasPermission($permissionName)
    {
        $sql = "SELECT COUNT(*) as count FROM permissions p 
                JOIN role_permissions rp ON p.id = rp.permission_id 
                JOIN user_roles ur ON rp.role_id = ur.role_id 
                WHERE ur.user_id = ? AND p.name = ?";

        $result = Database::fetch($sql, [$this->id, $permissionName]);
        return $result && $result['count'] > 0;
    }

    /**
     * Convertir a array
     */
    public function toArray()
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'full_name' => $this->getFullName(),
            'is_active' => $this->is_active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }

    /**
     * Obtener todos los usuarios activos
     */
    public static function getAllActive()
    {
        $data = Database::fetchAll("SELECT * FROM users WHERE is_active = 1 ORDER BY username");
        return array_map(function ($userData) {
            return new self($userData);
        }, $data);
    }

    /**
     * Buscar usuarios con filtros y paginación
     */
    public static function buscarUsuarios($query = '', $rol = '', $estado = '', $page = 1, $perPage = 10)
    {
        $where = [];
        $params = [];

        if ($query) {
            $where[] = "(first_name LIKE ? OR last_name LIKE ? OR email LIKE ? OR username LIKE ?)";
            $params[] = "%$query%";
            $params[] = "%$query%";
            $params[] = "%$query%";
            $params[] = "%$query%";
        }
        if ($rol) {
            $where[] = "id IN (SELECT user_id FROM user_roles ur JOIN roles r ON ur.role_id = r.id WHERE r.name = ?)";
            $params[] = $rol;
        }
        if ($estado !== '') {
            $where[] = "is_active = ?";
            $params[] = $estado === 'activo' ? 1 : 0;
        }
        $whereSql = $where ? ('WHERE ' . implode(' AND ', $where)) : '';

        // Total
        $total = Database::fetch("SELECT COUNT(*) as total FROM users $whereSql", $params);
        $total = $total ? (int)$total['total'] : 0;

        // Paginación
        $offset = ($page - 1) * $perPage;
        $sql = "SELECT * FROM users $whereSql ORDER BY created_at DESC LIMIT $perPage OFFSET $offset";
        $rows = Database::fetchAll($sql, $params);
        $usuarios = [];
        foreach ($rows as $row) {
            $user = new self($row);
            $userArr = $user->toArray();
            $userArr['roles'] = $user->getRoles();
            $userArr['estado'] = $user->isActive() ? 'Activo' : 'Inactivo';
            $usuarios[] = $userArr;
        }
        return [
            'usuarios' => $usuarios,
            'total' => $total,
            'page' => $page,
            'per_page' => $perPage,
            'pages' => ceil($total / $perPage)
        ];
    }
}
