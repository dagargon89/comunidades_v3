<?php

// Configuración de errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Configuración de zona horaria
date_default_timezone_set('America/Mexico_City');

// Incluir el autoloader de Composer
require_once __DIR__ . '/vendor/autoload.php';

// Inicializar la base de datos
\Core\Database::init();

// Configuración de sesiones
$appConfig = require_once __DIR__ . '/config/app.php';
session_set_cookie_params([
    'lifetime' => $appConfig['session']['lifetime'],
    'path' => $appConfig['session']['path'],
    'domain' => $_SERVER['HTTP_HOST'],
    'secure' => false,
    'httponly' => true,
    'samesite' => 'Lax'
]);

// Iniciar sesión
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Función helper para obtener configuración
function config($key, $default = null)
{
    static $config = null;

    if ($config === null) {
        $config = require_once __DIR__ . '/config/app.php';
    }

    return $config[$key] ?? $default;
}

// Función helper para redireccionar
function redirect($url)
{
    if (strpos($url, 'http') !== 0) {
        $url = base_url($url);
    }
    header("Location: $url");
    exit;
}

// Función helper para obtener la URL base
function base_url($path = '')
{
    // Detectar el esquema (http o https)
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    // Detectar el path base automáticamente
    $scriptName = $_SERVER['SCRIPT_NAME'];
    $scriptDir = rtrim(dirname($scriptName), '/\\');
    $basePath = ($scriptDir === '/' || $scriptDir === '\\') ? '' : $scriptDir;
    // Unir todo
    $url = $scheme . '://' . $host . $basePath;
    // Unir el path solicitado
    return rtrim($url, '/') . '/' . ltrim($path, '/');
}

// Función helper para verificar si el usuario está autenticado
function is_authenticated()
{
    return isset($_SESSION['user_id']);
}

// Función helper para obtener el usuario actual
function current_user()
{
    if (!isset($_SESSION['user_id'])) {
        return null;
    }
    static $user = null;
    if ($user === null || ($user && $user->getId() != $_SESSION['user_id'])) {
        $user = \Models\User::findById($_SESSION['user_id'], true);
    }
    return $user;
}
