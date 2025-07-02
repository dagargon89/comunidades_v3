<?php

file_put_contents(__DIR__ . '/../session_debug.txt', 'INDEX: ' . print_r($_SERVER, true) . print_r($_POST, true));

// Incluir el bootstrap
require_once __DIR__ . '/../bootstrap.php';

// Obtener la URL solicitada
$request_uri = $_SERVER['REQUEST_URI'];
$base_path = dirname($_SERVER['SCRIPT_NAME']);

// Remover el path base de la URL
$path = str_replace($base_path, '', $request_uri);
$path = parse_url($path, PHP_URL_PATH);
$path = trim($path, '/');

// Log para depuración de rutas
file_put_contents(__DIR__ . '/../session_debug.txt', "PATH: $path\nMETHOD: {$_SERVER['REQUEST_METHOD']}\nURI: $request_uri\nPOST: " . print_r($_POST, true), FILE_APPEND);

// Si no hay path, usar 'login' como default
if (empty($path)) {
    $path = 'login';
}

// Separar la ruta en partes
$route_parts = explode('/', $path);
$controller_name = $route_parts[0] ?? 'auth';
$action_name = $route_parts[1] ?? 'showLogin';

// Mapeo de rutas
$routes = [
    // Rutas de autenticación
    'login' => ['controller' => 'AuthController', 'action' => 'showLogin'],
    'auth/login' => ['controller' => 'AuthController', 'action' => 'login'],
    'auth/logout' => ['controller' => 'AuthController', 'action' => 'logout'],
    'register' => ['controller' => 'AuthController', 'action' => 'showRegister'],
    'auth/register' => ['controller' => 'AuthController', 'action' => 'register'],
    'profile' => ['controller' => 'AuthController', 'action' => 'showProfile'],
    'auth/profile' => ['controller' => 'AuthController', 'action' => 'showProfile'],
    'auth/update-profile' => ['controller' => 'AuthController', 'action' => 'updateProfile'],

    // Rutas del dashboard (requieren autenticación)
    'dashboard' => ['controller' => 'DashboardController', 'action' => 'index'],

    // Rutas de proyectos
    'projects' => ['controller' => 'ProjectController', 'action' => 'index'],
    'projects/create' => ['controller' => 'ProjectController', 'action' => 'create'],
    'projects/store' => ['controller' => 'ProjectController', 'action' => 'store'],
    'projects/edit' => ['controller' => 'ProjectController', 'action' => 'edit'],
    'projects/update' => ['controller' => 'ProjectController', 'action' => 'update'],
    'projects/delete' => ['controller' => 'ProjectController', 'action' => 'delete'],

    // Rutas de actividades
    'activities' => ['controller' => 'ActivityController', 'action' => 'index'],
    'activities/create' => ['controller' => 'ActivityController', 'action' => 'create'],
    'activities/store' => ['controller' => 'ActivityController', 'action' => 'store'],
    'activities/edit' => ['controller' => 'ActivityController', 'action' => 'edit'],
    'activities/update' => ['controller' => 'ActivityController', 'action' => 'update'],
    'activities/delete' => ['controller' => 'ActivityController', 'action' => 'delete'],

    // Rutas de usuarios
    'users' => ['controller' => 'UserController', 'action' => 'index'],
    'users/buscar' => ['controller' => 'UserController', 'action' => 'buscar'],
    'users/create' => ['controller' => 'UserController', 'action' => 'create'],
    'users/store' => ['controller' => 'UserController', 'action' => 'store'],
    'users/edit' => ['controller' => 'UserController', 'action' => 'edit'],
    'users/update' => ['controller' => 'UserController', 'action' => 'update'],
    'users/delete' => ['controller' => 'UserController', 'action' => 'delete'],

    // Rutas de roles
    'roles' => ['controller' => 'RoleController', 'action' => 'index'],
    'roles/create' => ['controller' => 'RoleController', 'action' => 'create'],
    'roles/store' => ['controller' => 'RoleController', 'action' => 'store'],
    'roles/edit' => ['controller' => 'RoleController', 'action' => 'edit'],
    'roles/update' => ['controller' => 'RoleController', 'action' => 'update'],
    'roles/delete' => ['controller' => 'RoleController', 'action' => 'delete'],

    // Rutas de permisos
    'permissions' => ['controller' => 'PermissionController', 'action' => 'index'],
    'permissions/create' => ['controller' => 'PermissionController', 'action' => 'create'],
    'permissions/store' => ['controller' => 'PermissionController', 'action' => 'store'],
    'permissions/edit' => ['controller' => 'PermissionController', 'action' => 'edit'],
    'permissions/update' => ['controller' => 'PermissionController', 'action' => 'update'],
    'permissions/delete' => ['controller' => 'PermissionController', 'action' => 'delete'],

    // Rutas de catálogos
    'catalogs' => ['controller' => 'CatalogController', 'action' => 'index'],
    'catalogs/locations' => ['controller' => 'LocationController', 'action' => 'index'],
    'catalogs/locations/create' => ['controller' => 'LocationController', 'action' => 'create'],
    'catalogs/locations/store' => ['controller' => 'LocationController', 'action' => 'store'],
    'catalogs/locations/edit' => ['controller' => 'LocationController', 'action' => 'edit'],
    'catalogs/locations/update' => ['controller' => 'LocationController', 'action' => 'update'],
    'catalogs/locations/delete' => ['controller' => 'LocationController', 'action' => 'delete'],

    // Rutas de API de roles
    'api/roles' => ['controller' => 'RoleController', 'action' => 'apiRoles'],

    // Rutas de API de usuarios
    'api/users' => ['controller' => 'UserController', 'action' => 'index'],
    'api/users/buscar' => ['controller' => 'UserController', 'action' => 'buscar'],
    'api/users/store' => ['controller' => 'UserController', 'action' => 'store'],
    'api/users/show' => ['controller' => 'UserController', 'action' => 'show'],
    'api/users/update' => ['controller' => 'UserController', 'action' => 'update'],
    'api/users/destroy' => ['controller' => 'UserController', 'action' => 'destroy'],
];

// Verificar si la ruta existe
if (!isset($routes[$path])) {
    // Si no existe la ruta exacta, intentar con el patrón controller/action
    $route_key = $controller_name . '/' . $action_name;
    if (!isset($routes[$route_key])) {
        // Verificar si es una ruta API con parámetros dinámicos
        if (strpos($path, 'api/users/') === 0) {
            $path_parts = explode('/', $path);
            if (count($path_parts) >= 4) {
                $action = $path_parts[3]; // show, update, destroy
                $id = $path_parts[2]; // ID del usuario

                // Mapear acciones API
                $api_actions = [
                    'show' => 'show',
                    'update' => 'update',
                    'destroy' => 'destroy'
                ];

                if (isset($api_actions[$action])) {
                    $route = [
                        'controller' => 'UserController',
                        'action' => $api_actions[$action],
                        'params' => [$id]
                    ];
                } else {
                    http_response_code(404);
                    echo '<h1>404 - Página no encontrada</h1>';
                    echo '<p>La ruta solicitada no existe: ' . htmlspecialchars($path) . '</p>';
                    echo '<a href="' . base_url('login') . '">Volver al inicio</a>';
                    exit;
                }
            } else {
                http_response_code(404);
                echo '<h1>404 - Página no encontrada</h1>';
                echo '<p>La ruta solicitada no existe: ' . htmlspecialchars($path) . '</p>';
                echo '<a href="' . base_url('login') . '">Volver al inicio</a>';
                exit;
            }
        } else {
            http_response_code(404);
            echo '<h1>404 - Página no encontrada</h1>';
            echo '<p>La ruta solicitada no existe: ' . htmlspecialchars($path) . '</p>';
            echo '<a href="' . base_url('login') . '">Volver al inicio</a>';
            exit;
        }
    } else {
        $route = $routes[$route_key];
    }
} else {
    $route = $routes[$path];
}

// --- MANEJO ESPECIAL PARA LOGIN Y REGISTER ---
if ($path === 'auth/login') {
    $controller_class = 'Src\\Controllers\\AuthController';
    $controller = new $controller_class();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->login();
    } else {
        $controller->showLogin();
    }
    exit;
}
if ($path === 'auth/register') {
    $controller_class = 'Src\\Controllers\\AuthController';
    $controller = new $controller_class();
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller->register();
    } else {
        $controller->showRegister();
    }
    exit;
}
// --- FIN MANEJO ESPECIAL ---

// Verificar autenticación para rutas protegidas
$protected_routes = [
    'dashboard',
    'projects',
    'activities',
    'users',
    'roles',
    'catalogs',
    'profile',
    'auth/profile',
    'auth/update-profile'
];

$is_protected_route = false;
foreach ($protected_routes as $protected) {
    if (strpos($path, $protected) === 0) {
        $is_protected_route = true;
        break;
    }
}

if ($is_protected_route && !is_authenticated()) {
    redirect('login');
}

// Cargar el controlador
$controller_class = 'Src\\Controllers\\' . $route['controller'];
$action = $route['action'];

try {
    if (!class_exists($controller_class)) {
        throw new Exception("Controlador no encontrado: $controller_class");
    }

    $controller = new $controller_class();

    if (!method_exists($controller, $action)) {
        throw new Exception("Método no encontrado: $action en $controller_class");
    }

    // Ejecutar la acción
    if (isset($route['params'])) {
        call_user_func_array([$controller, $action], $route['params']);
    } else {
        $controller->$action();
    }
} catch (Exception $e) {
    http_response_code(500);
    echo '<h1>500 - Error del servidor</h1>';
    echo '<p>Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
    echo '<a href="' . base_url('login') . '">Volver al inicio</a>';
    exit;
}
