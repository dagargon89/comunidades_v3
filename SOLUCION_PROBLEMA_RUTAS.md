# Solución al Problema de Rutas - Sección Ejes

## Problema Identificado

La sección `/axes` mostraba un error 404, lo que indicaba que las rutas no estaban configuradas correctamente en el sistema de enrutamiento.

## Análisis del Problema

### 1. Rutas Definidas pero No Registradas

**Ubicación del problema:** `routes/web.php`

- Las rutas de ejes estaban definidas correctamente en el archivo de rutas
- Sin embargo, no estaban incluidas en el array `$routes` del router principal

**Archivo afectado:** `public/index.php`

```php
// Array de rutas que el router reconoce
$routes = [
    'users' => 'UsersController',
    'roles' => 'RolesController',
    'permissions' => 'PermissionsController',
    // FALTABA: 'axes' => 'AxisController'
];
```

### 2. Namespace Incorrecto en el Controlador

**Problema:** El controlador `AxisController.php` tenía un namespace incorrecto

```php
// INCORRECTO
namespace Controllers;

// CORRECTO
namespace Src\Controllers;
```

### 3. Falta de Inyección de Dependencias

**Problema:** El controlador requería la conexión `$db` en su constructor, pero no se estaba pasando automáticamente.

## Soluciones Implementadas

### 1. Registro de Rutas en el Router Principal

**Archivo:** `public/index.php`

```php
// Agregar la ruta de ejes al array de rutas
$routes = [
    'users' => 'UsersController',
    'roles' => 'RolesController',
    'permissions' => 'PermissionsController',
    'axes' => 'AxisController'  // ← AGREGADO
];
```

### 2. Corrección del Namespace

**Archivo:** `src/Controllers/AxisController.php`

```php
<?php
namespace Src\Controllers;  // ← CORREGIDO

use Src\Models\Axis;
use Src\Core\Request;

class AxisController {
    // ... resto del código
}
```

### 3. Inyección Automática de Dependencias

**Archivo:** `public/index.php`

```php
// Definir la conexión a la base de datos
$db = \Core\Database::getConnection();

// Sistema de inyección automática de dependencias
if (class_exists($controllerClass)) {
    $reflection = new ReflectionClass($controllerClass);
    $constructor = $reflection->getConstructor();

    if ($constructor && $constructor->getNumberOfParameters() > 0) {
        // Si el constructor requiere parámetros, pasar $db
        $controller = $reflection->newInstance($db);
    } else {
        // Si no requiere parámetros, crear instancia normal
        $controller = new $controllerClass();
    }

    // Llamar al método correspondiente
    if (method_exists($controller, $action)) {
        $controller->$action();
    } else {
        http_response_code(404);
        echo "Método no encontrado: $action";
    }
} else {
    http_response_code(404);
    echo "Controlador no encontrado: $controllerClass";
}
```

## Configuración para Futuras Secciones CRUD

### Paso 1: Definir las Rutas en `routes/web.php`

```php
// Rutas para la nueva sección (ejemplo: 'projects')
$router->get('/projects', 'ProjectsController@index');
$router->get('/projects/create', 'ProjectsController@create');
$router->post('/projects', 'ProjectsController@store');
$router->get('/projects/{id}/edit', 'ProjectsController@edit');
$router->post('/projects/{id}', 'ProjectsController@update');
$router->post('/projects/{id}/delete', 'ProjectsController@delete');
```

### Paso 2: Registrar en el Array de Rutas

**Archivo:** `public/index.php`

```php
$routes = [
    'users' => 'UsersController',
    'roles' => 'RolesController',
    'permissions' => 'PermissionsController',
    'axes' => 'AxisController',
    'projects' => 'ProjectsController'  // ← AGREGAR NUEVA SECCIÓN
];
```

### Paso 3: Crear el Controlador

**Archivo:** `src/Controllers/ProjectsController.php`

```php
<?php
namespace Src\Controllers;

use Src\Models\Project;
use Src\Core\Request;

class ProjectsController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function index() {
        // Lógica del listado
    }

    public function create() {
        // Lógica del formulario de creación
    }

    public function store() {
        // Lógica para guardar
    }

    public function edit($id) {
        // Lógica del formulario de edición
    }

    public function update($id) {
        // Lógica para actualizar
    }

    public function delete($id) {
        // Lógica para eliminar
    }
}
```

### Paso 4: Crear el Modelo

**Archivo:** `src/Models/Project.php`

```php
<?php
namespace Src\Models;

use Src\Core\Database;

class Project {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM projects ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM projects WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO projects (name, background, justification, general_objective, financiers_id) VALUES (?, ?, ?, ?, ?)");
        return $stmt->execute([$data['name'], $data['background'], $data['justification'], $data['general_objective'], $data['financiers_id']]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE projects SET name = ?, background = ?, justification = ?, general_objective = ?, financiers_id = ? WHERE id = ?");
        return $stmt->execute([$data['name'], $data['background'], $data['justification'], $data['general_objective'], $data['financiers_id'], $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM projects WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
```

### Paso 5: Crear las Vistas

**Estructura de carpetas:**

```
src/Views/projects/
├── index.php      # Listado con tabla paginada
├── create.php     # Formulario de creación
├── edit.php       # Formulario de edición
└── show.php       # Vista detallada (opcional)
```

**Ejemplo de vista index.php:**

```php
<?php
ob_start();
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Proyectos</h1>
        <a href="/projects/create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo Proyecto
        </a>
    </div>

    <?php include __DIR__ . '/../components/table_options.php'; ?>

    <?php include __DIR__ . '/../components/table.php'; ?>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/app.php';
?>
```

## Checklist para Nuevas Secciones

- [ ] Definir rutas en `routes/web.php`
- [ ] Registrar en array `$routes` de `public/index.php`
- [ ] Crear controlador con namespace correcto (`Src\Controllers`)
- [ ] Implementar constructor que reciba `$db`
- [ ] Crear modelo con métodos CRUD básicos
- [ ] Crear vistas siguiendo el esquema de usuarios/ejes
- [ ] Incluir componentes de tabla y opciones
- [ ] Probar navegación y funcionalidad CRUD

## Notas Importantes

1. **Namespace:** Siempre usar `Src\Controllers` para controladores
2. **Inyección de Dependencias:** El sistema automáticamente inyecta `$db` si el constructor lo requiere
3. **Estructura de Vistas:** Seguir el patrón de usuarios/ejes para consistencia
4. **Componentes:** Reutilizar `table.php` y `table_options.php` para paginación y exportación
5. **Rutas:** Siempre registrar en ambos lugares (web.php y array de rutas)

## Verificación

Para verificar que una nueva sección funciona correctamente:

1. Acceder a la URL `/nueva-seccion`
2. Verificar que no hay errores 404
3. Comprobar que la tabla se muestra con paginación
4. Probar las operaciones CRUD (crear, editar, eliminar)
5. Verificar que los componentes de exportación funcionan

Este documento sirve como guía para implementar futuras secciones CRUD siguiendo el patrón establecido y evitando los problemas encontrados en la sección de ejes.
