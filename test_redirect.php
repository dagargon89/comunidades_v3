<?php
/**
 * Archivo de prueba para verificar redirecciones
 */

echo "<h1>Prueba de Redirección</h1>";
echo "<p>Si puedes ver este mensaje, el archivo index.php en la raíz está funcionando.</p>";
echo "<p>Ahora deberías poder acceder a:</p>";
echo "<ul>";
echo "<li><a href='/login'>Login</a></li>";
echo "<li><a href='/register'>Register</a></li>";
echo "<li><a href='/dashboard'>Dashboard</a></li>";
echo "</ul>";

echo "<h2>Información del servidor:</h2>";
echo "<p>REQUEST_URI: " . $_SERVER['REQUEST_URI'] . "</p>";
echo "<p>SCRIPT_NAME: " . $_SERVER['SCRIPT_NAME'] . "</p>";
echo "<p>DOCUMENT_ROOT: " . $_SERVER['DOCUMENT_ROOT'] . "</p>";
?> 