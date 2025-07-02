<?php

// Incluir el bootstrap
require_once __DIR__ . '/../bootstrap.php';

// Obtener la URL solicitada
$request_uri = $_SERVER['REQUEST_URI'];
$base_path = dirname($_SERVER['SCRIPT_NAME']);

// Remover el path base de la URL
$path = str_replace($base_path, '', $request_uri);
$path = parse_url($path, PHP_URL_PATH);
$path = trim($path, '/');

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

    // Rutas de catálogos
    'catalogs' => ['controller' => 'CatalogController', 'action' => 'index'],
    'catalogs/locations' => ['controller' => 'LocationController', 'action' => 'index'],
    'catalogs/locations/create' => ['controller' => 'LocationController', 'action' => 'create'],
    'catalogs/locations/store' => ['controller' => 'LocationController', 'action' => 'store'],
    'catalogs/locations/edit' => ['controller' => 'LocationController', 'action' => 'edit'],
    'catalogs/locations/update' => ['controller' => 'LocationController', 'action' => 'update'],
    'catalogs/locations/delete' => ['controller' => 'LocationController', 'action' => 'delete'],
];

// Verificar si la ruta existe
if (!isset($routes[$path])) {
    // Si no existe la ruta exacta, intentar con el patrón controller/action
    $route_key = $controller_name . '/' . $action_name;

    if (!isset($routes[$route_key])) {
        // Ruta no encontrada
        http_response_code(404);
        echo '<h1>404 - Página no encontrada</h1>';
        echo '<p>La ruta solicitada no existe: ' . htmlspecialchars($path) . '</p>';
        echo '<a href="' . base_url('login') . '">Volver al inicio</a>';
        exit;
    }

    $route = $routes[$route_key];
} else {
    $route = $routes[$path];
}

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
$controller_class = 'Controllers\\' . $route['controller'];
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
    $controller->$action();
} catch (Exception $e) {
    http_response_code(500);
    echo '<h1>500 - Error del servidor</h1>';
    echo '<p>Error: ' . htmlspecialchars($e->getMessage()) . '</p>';
    echo '<a href="' . base_url('login') . '">Volver al inicio</a>';
    exit;
}
