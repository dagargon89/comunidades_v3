<?php

// Incluir el bootstrap
require_once 'bootstrap.php';

try {

    echo "<h2>Prueba de Conexión a Base de Datos</h2>";

    // Probar conexión a project_management
    echo "<h3>Probando conexión a project_management:</h3>";
    $pdo = \Core\Database::getConnection('project_management');
    echo "✅ Conexión exitosa a project_management<br>";

    // Verificar tablas
    $tables = \Core\Database::fetchAll("SHOW TABLES");
    echo "📋 Tablas encontradas en project_management:<br>";
    foreach ($tables as $table) {
        $tableName = array_values($table)[0];
        echo "- {$tableName}<br>";
    }

    echo "<br>";

    // Probar conexión a mydb
    echo "<h3>Probando conexión a mydb:</h3>";
    $pdo = \Core\Database::getConnection('mydb');
    echo "✅ Conexión exitosa a mydb<br>";

    // Verificar tablas
    $tables = \Core\Database::fetchAll("SHOW TABLES");
    echo "📋 Tablas encontradas en mydb:<br>";
    foreach ($tables as $table) {
        $tableName = array_values($table)[0];
        echo "- {$tableName}<br>";
    }

    echo "<br><strong>🎉 Todas las conexiones funcionan correctamente!</strong>";
} catch (Exception $e) {
    echo "<h2>❌ Error de Conexión</h2>";
    echo "<p><strong>Error:</strong> " . $e->getMessage() . "</p>";
    echo "<p><strong>Archivo:</strong> " . $e->getFile() . "</p>";
    echo "<p><strong>Línea:</strong> " . $e->getLine() . "</p>";
}
