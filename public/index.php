<?php

file_put_contents(__DIR__ . '/../session_debug.txt', 'INDEX: ' . print_r($_SERVER, true) . print_r($_POST, true));

// Incluir el bootstrap
require_once __DIR__ . '/../bootstrap.php';

// Definir la conexión PDO global para los controladores
$db = \Core\Database::getConnection();

// Obtener la URL solicitada
$request_uri = $_SERVER['REQUEST_URI'];
$base_path = dirname($_SERVER['SCRIPT_NAME']);

// Remover el path base de la URL
$path = str_replace($base_path, '', $request_uri);
$path = parse_url($path, PHP_URL_PATH);
$path = trim($path, '/');

// Log para depuración de rutas
file_put_contents(__DIR__ . '/../session_debug.txt', "PATH: $path\nMETHOD: {$_SERVER['REQUEST_METHOD']}\nURI: $request_uri\nPOST: " . print_r($_POST, true), FILE_APPEND);

// DEPURACIÓN EXTRA PARA AXES
if (strpos($path, 'axes') === 0) {
    file_put_contents(__DIR__ . '/../session_debug.txt', "[DEBUG AXES] path: $path\n", FILE_APPEND);
    if (isset($routes[$path])) {
        file_put_contents(__DIR__ . '/../session_debug.txt', "[DEBUG AXES] Ruta encontrada en routes: $path\n", FILE_APPEND);
    } else {
        file_put_contents(__DIR__ . '/../session_debug.txt', "[DEBUG AXES] Ruta NO encontrada en routes: $path\n", FILE_APPEND);
    }
}

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

    // Rutas de ejes (axes)
    'axes' => ['controller' => 'AxisController', 'action' => 'index'],
    'axes/create' => ['controller' => 'AxisController', 'action' => 'create'],
    'axes/store' => ['controller' => 'AxisController', 'action' => 'store'],
    'axes/edit' => ['controller' => 'AxisController', 'action' => 'edit'],
    'axes/update' => ['controller' => 'AxisController', 'action' => 'update'],
    'axes/delete' => ['controller' => 'AxisController', 'action' => 'delete'],
    'axes/view' => ['controller' => 'AxisController', 'action' => 'view'],

    // Rutas de programas (programs)
    'programs' => ['controller' => 'ProgramController', 'action' => 'index'],
    'programs/create' => ['controller' => 'ProgramController', 'action' => 'create'],
    'programs/store' => ['controller' => 'ProgramController', 'action' => 'store'],
    'programs/edit' => ['controller' => 'ProgramController', 'action' => 'edit'],
    'programs/update' => ['controller' => 'ProgramController', 'action' => 'update'],
    'programs/delete' => ['controller' => 'ProgramController', 'action' => 'delete'],
    'programs/view' => ['controller' => 'ProgramController', 'action' => 'view'],

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

    // Rutas de líneas de acción (action_lines)
    'action_lines' => ['controller' => 'ActionLineController', 'action' => 'index'],
    'action_lines/create' => ['controller' => 'ActionLineController', 'action' => 'create'],
    'action_lines/store' => ['controller' => 'ActionLineController', 'action' => 'store'],
    'action_lines/edit' => ['controller' => 'ActionLineController', 'action' => 'edit'],
    'action_lines/update' => ['controller' => 'ActionLineController', 'action' => 'update'],
    'action_lines/delete' => ['controller' => 'ActionLineController', 'action' => 'delete'],
    'action_lines/view' => ['controller' => 'ActionLineController', 'action' => 'view'],

    // Rutas de componentes (components)
    'components' => ['controller' => 'ComponentController', 'action' => 'index'],
    'components/create' => ['controller' => 'ComponentController', 'action' => 'create'],
    'components/store' => ['controller' => 'ComponentController', 'action' => 'store'],
    'components/edit' => ['controller' => 'ComponentController', 'action' => 'edit'],
    'components/update' => ['controller' => 'ComponentController', 'action' => 'update'],
    'components/delete' => ['controller' => 'ComponentController', 'action' => 'delete'],
    'components/view' => ['controller' => 'ComponentController', 'action' => 'view'],

    // Rutas de organizaciones (organizations)
    'organizations' => ['controller' => 'OrganizationController', 'action' => 'index'],
    'organizations/create' => ['controller' => 'OrganizationController', 'action' => 'create'],
    'organizations/store' => ['controller' => 'OrganizationController', 'action' => 'store'],
    'organizations/edit' => ['controller' => 'OrganizationController', 'action' => 'edit'],
    'organizations/update' => ['controller' => 'OrganizationController', 'action' => 'update'],
    'organizations/delete' => ['controller' => 'OrganizationController', 'action' => 'delete'],
    'organizations/view' => ['controller' => 'OrganizationController', 'action' => 'view'],

    // Rutas de metas (goals)
    'goals' => ['controller' => 'GoalController', 'action' => 'index'],
    'goals/create' => ['controller' => 'GoalController', 'action' => 'create'],
    'goals/store' => ['controller' => 'GoalController', 'action' => 'store'],
    'goals/edit' => ['controller' => 'GoalController', 'action' => 'edit'],
    'goals/update' => ['controller' => 'GoalController', 'action' => 'update'],
    'goals/delete' => ['controller' => 'GoalController', 'action' => 'delete'],
    'goals/view' => ['controller' => 'GoalController', 'action' => 'view'],

    // Rutas de financiadores (financiers)
    'financiers' => ['controller' => 'FinancierController', 'action' => 'index'],
    'financiers/create' => ['controller' => 'FinancierController', 'action' => 'create'],
    'financiers/store' => ['controller' => 'FinancierController', 'action' => 'store'],
    'financiers/edit' => ['controller' => 'FinancierController', 'action' => 'edit'],
    'financiers/update' => ['controller' => 'FinancierController', 'action' => 'update'],
    'financiers/delete' => ['controller' => 'FinancierController', 'action' => 'delete'],
    'financiers/view' => ['controller' => 'FinancierController', 'action' => 'view'],

    // Rutas de proyectos (projects)
    'projects' => ['controller' => 'ProjectController', 'action' => 'index'],
    'projects/create' => ['controller' => 'ProjectController', 'action' => 'create'],
    'projects/store' => ['controller' => 'ProjectController', 'action' => 'store'],
    'projects/edit' => ['controller' => 'ProjectController', 'action' => 'edit'],
    'projects/update' => ['controller' => 'ProjectController', 'action' => 'update'],
    'projects/delete' => ['controller' => 'ProjectController', 'action' => 'delete'],
    'projects/view' => ['controller' => 'ProjectController', 'action' => 'view'],

    // Rutas de objetivos específicos (specific_objectives)
    'specific_objectives' => ['controller' => 'SpecificObjectiveController', 'action' => 'index'],
    'specific_objectives/create' => ['controller' => 'SpecificObjectiveController', 'action' => 'create'],
    'specific_objectives/store' => ['controller' => 'SpecificObjectiveController', 'action' => 'store'],
    'specific_objectives/edit' => ['controller' => 'SpecificObjectiveController', 'action' => 'edit'],
    'specific_objectives/update' => ['controller' => 'SpecificObjectiveController', 'action' => 'update'],
    'specific_objectives/delete' => ['controller' => 'SpecificObjectiveController', 'action' => 'delete'],
    'specific_objectives/view' => ['controller' => 'SpecificObjectiveController', 'action' => 'view'],
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

    $reflection = new ReflectionClass($controller_class);
    $constructor = $reflection->getConstructor();
    if ($constructor && $constructor->getNumberOfParameters() > 0) {
        $controller = $reflection->newInstance($db);
    } else {
        $controller = $reflection->newInstance();
    }

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
