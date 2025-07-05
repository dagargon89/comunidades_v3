<?php
/**
 * Archivo de diagnóstico para verificar la configuración del servidor
 */

echo "<h1>Diagnóstico de Configuración del Servidor</h1>";

echo "<h2>Información del Servidor:</h2>";
echo "<ul>";
echo "<li><strong>SERVER_SOFTWARE:</strong> " . ($_SERVER['SERVER_SOFTWARE'] ?? 'No disponible') . "</li>";
echo "<li><strong>DOCUMENT_ROOT:</strong> " . ($_SERVER['DOCUMENT_ROOT'] ?? 'No disponible') . "</li>";
echo "<li><strong>REQUEST_URI:</strong> " . ($_SERVER['REQUEST_URI'] ?? 'No disponible') . "</li>";
echo "<li><strong>SCRIPT_NAME:</strong> " . ($_SERVER['SCRIPT_NAME'] ?? 'No disponible') . "</li>";
echo "<li><strong>SCRIPT_FILENAME:</strong> " . ($_SERVER['SCRIPT_FILENAME'] ?? 'No disponible') . "</li>";
echo "<li><strong>HTTP_HOST:</strong> " . ($_SERVER['HTTP_HOST'] ?? 'No disponible') . "</li>";
echo "</ul>";

echo "<h2>Verificación de Archivos:</h2>";
$project_root = __DIR__;
$public_folder = $project_root . '/public';

echo "<ul>";
echo "<li><strong>Directorio actual:</strong> " . $project_root . "</li>";
echo "<li><strong>Carpeta public existe:</strong> " . (is_dir($public_folder) ? 'SÍ' : 'NO') . "</li>";
echo "<li><strong>public/index.php existe:</strong> " . (file_exists($public_folder . '/index.php') ? 'SÍ' : 'NO') . "</li>";
echo "<li><strong>public/.htaccess existe:</strong> " . (file_exists($public_folder . '/.htaccess') ? 'SÍ' : 'NO') . "</li>";
echo "<li><strong>.htaccess en raíz existe:</strong> " . (file_exists($project_root . '/.htaccess') ? 'SÍ' : 'NO') . "</li>";
echo "<li><strong>index.php en raíz existe:</strong> " . (file_exists($project_root . '/index.php') ? 'SÍ' : 'NO') . "</li>";
echo "</ul>";

echo "<h2>Prueba de Rutas:</h2>";
echo "<p>Prueba estos enlaces para verificar el funcionamiento:</p>";
echo "<ul>";
echo "<li><a href='/public/'>Acceder a /public/</a></li>";
echo "<li><a href='/public/login'>Acceder a /public/login</a></li>";
echo "<li><a href='/login'>Acceder a /login</a></li>";
echo "<li><a href='/test_redirect.php'>Acceder a test_redirect.php</a></li>";
echo "</ul>";

echo "<h2>Configuración Recomendada para Laragon:</h2>";
echo "<p>Para que funcione correctamente, necesitas configurar Laragon de la siguiente manera:</p>";
echo "<ol>";
echo "<li>Abre Laragon</li>";
echo "<li>Ve a <strong>Menu > www</strong></li>";
echo "<li>Busca tu proyecto <strong>comunidades_v3</strong></li>";
echo "<li>Haz clic derecho en la carpeta <strong>public</strong></li>";
echo "<li>Selecciona <strong>Set as Document Root</strong></li>";
echo "<li>Reinicia Apache</li>";
echo "</ol>";

echo "<h2>Alternativa - Usar el servidor de desarrollo de PHP:</h2>";
echo "<p>Si no puedes cambiar la configuración de Laragon, puedes usar el servidor de desarrollo de PHP:</p>";
echo "<pre>cd " . $project_root . "/public\nphp -S localhost:8000</pre>";
echo "<p>Luego accede a: <a href='http://localhost:8000'>http://localhost:8000</a></p>";

// Verificar si mod_rewrite está habilitado
if (function_exists('apache_get_modules')) {
    $modules = apache_get_modules();
    echo "<h2>Módulos de Apache:</h2>";
    echo "<ul>";
    echo "<li><strong>mod_rewrite habilitado:</strong> " . (in_array('mod_rewrite', $modules) ? 'SÍ' : 'NO') . "</li>";
    echo "</ul>";
} else {
    echo "<h2>Módulos de Apache:</h2>";
    echo "<p>No se puede verificar mod_rewrite desde PHP. Verifica manualmente en Laragon.</p>";
}
?> 