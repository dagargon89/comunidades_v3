<?php
/**
 * Archivo de entrada principal que maneja las peticiones independientemente de la configuración de Laragon
 */

// Obtener la URL solicitada
$request_uri = $_SERVER['REQUEST_URI'];
$base_path = dirname($_SERVER['SCRIPT_NAME']);

// Remover el path base de la URL
$path = str_replace($base_path, '', $request_uri);
$path = parse_url($path, PHP_URL_PATH);
$path = trim($path, '/');

// Si estamos accediendo directamente a este archivo desde la raíz
if (empty($path) || $path === 'index.php') {
    // Redirigir a la carpeta public
    $new_url = '/public/';
    if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])) {
        $new_url .= '?' . $_SERVER['QUERY_STRING'];
    }
    header('Location: ' . $new_url);
    exit;
}

// Si la URL comienza con 'public/', procesar directamente
if (strpos($path, 'public/') === 0) {
    $public_path = substr($path, 7); // Remover 'public/' del inicio
    $_SERVER['REQUEST_URI'] = '/' . $public_path;
    include __DIR__ . '/public/index.php';
    exit;
}

// Si es un archivo PHP específico en la raíz, incluirlo directamente
if (preg_match('/\.php$/', $path) && file_exists(__DIR__ . '/' . $path)) {
    include __DIR__ . '/' . $path;
    exit;
}

// Si es un archivo estático, redirigir a public
if (preg_match('/\.(css|js|png|jpg|jpeg|gif|ico|svg|woff|woff2|ttf|eot)$/', $path)) {
    $new_url = '/public/' . $path;
    if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])) {
        $new_url .= '?' . $_SERVER['QUERY_STRING'];
    }
    header('Location: ' . $new_url);
    exit;
}

// Para cualquier otra ruta, redirigir a public
$new_url = '/public/' . $path;
if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])) {
    $new_url .= '?' . $_SERVER['QUERY_STRING'];
}
header('Location: ' . $new_url);
exit; 
include __DIR__ . '/public/index.php'; 