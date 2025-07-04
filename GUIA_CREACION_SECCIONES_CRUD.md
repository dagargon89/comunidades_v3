# Guía Completa para Crear Nuevas Secciones CRUD

## Cambios importantes (2024-07)

- **No agregar títulos grandes (`<h1>`) en las vistas CRUD** (`index.php`, `create.php`, `edit.php`). El diseño debe ser limpio y los encabezados visuales se gestionan desde el layout o los componentes.
- **No incluir bloques de mensajes flash (éxito/error) en las vistas CRUD**. Los mensajes flash deben ser gestionados únicamente desde el layout principal (`app.php`).
- **Solo debe haber tabla y formularios en las vistas**. Si se requiere un título, debe ser discreto y gestionado por el layout o el componente de tabla.

## Índice

1. [Análisis Previo](#análisis-previo)
2. [Paso 1: Definir Rutas](#paso-1-definir-rutas)
3. [Paso 2: Registrar en el Router Principal](#paso-2-registrar-en-el-router-principal)
4. [Paso 3: Crear el Modelo](#paso-3-crear-el-modelo)
5. [Paso 4: Crear el Controlador](#paso-4-crear-el-controlador)
6. [Paso 5: Crear las Vistas](#paso-5-crear-las-vistas)
7. [Paso 6: Agregar al Sidebar](#paso-6-agregar-al-sidebar)
8. [Paso 7: Verificación y Pruebas](#paso-7-verificación-y-pruebas)
9. [Patrones y Convenciones](#patrones-y-convenciones)
10. [Ejemplo Completo](#ejemplo-completo)
11. [Uso obligatorio de componentes en todas las secciones CRUD](#uso-obligatorio-de-componentes-en-todas-las-secciones-crud)
12. [Lógica de filtrado en el backend (¡Obligatorio!)](#lógica-de-filtrado-en-el-backend-¡obligatorio!)
13. [Uso obligatorio del componente de formulario en CRUD](#uso-obligatorio-del-componente-de-formulario-en-crud)
14. [Eliminación de columnas de acciones duplicadas (¡Obligatorio!)](#eliminación-de-columnas-de-acciones-duplicadas-¡obligatorio!)

## Nota importante sobre organización de carpetas (nueva convención)

A partir de la refactorización:

- **Componentes reutilizables de UI** (como table, form, button, etc.) deben estar en la carpeta:
  - `src/Views/ui_components/`
- **Vistas del CRUD de la entidad Componentes** deben estar en:
  - `src/Views/components/`

Esto evita confusiones y errores, ya que "components" puede referirse tanto a la entidad de negocio como a los elementos visuales reutilizables. **Sigue este patrón para todas las nuevas secciones y componentes.**

## Nota sobre la barra de filtros

La barra de filtros (`filter_bar.php`) ya está incluida automáticamente en el layout principal (`app.php`). **No debes incluirla manualmente en cada archivo index.php de los listados CRUD**. Solo define las variables `$filters` y `$buttons` en la vista y el layout se encargará de renderizar la barra de filtros.

---

## Análisis Previo

Antes de comenzar, analiza la tabla de la base de datos:

- **Nombre de la tabla**: `nombre_tabla`
- **Campos principales**: Identifica los campos que se mostrarán en el listado
- **Relaciones**: Identifica foreign keys y tablas relacionadas
- **Campos únicos**: Para validaciones
- **Campos requeridos**: Para validaciones de formularios

---

## Paso 1: Definir Rutas

### 1.1 Editar `routes/web.php`

Agregar las rutas siguiendo el patrón establecido:

```php
// [NOMBRE_SECCION] (nombre_tabla)
$router->get('nombre_seccion', 'NombreSeccionController@index');
$router->get('nombre_seccion/view', 'NombreSeccionController@view');
$router->get('nombre_seccion/create', 'NombreSeccionController@create');
$router->post('nombre_seccion/store', 'NombreSeccionController@store');
$router->get('nombre_seccion/edit', 'NombreSeccionController@edit');
$router->post('nombre_seccion/update', 'NombreSeccionController@update');
$router->get('nombre_seccion/delete', 'NombreSeccionController@delete');
```

**Ejemplo real (Programas):**

```php
// Programas (Program)
$router->get('programs', 'ProgramController@index');
$router->get('programs/view', 'ProgramController@view');
$router->get('programs/create', 'ProgramController@create');
$router->post('programs/store', 'ProgramController@store');
$router->get('programs/edit', 'ProgramController@edit');
$router->post('programs/update', 'ProgramController@update');
$router->get('programs/delete', 'ProgramController@delete');
```

---

## Paso 2: Registrar en el Router Principal

### 2.1 Editar `public/index.php`

Buscar el array `$routes` y agregar la nueva sección:

```php
// Rutas de [nombre_seccion] (nombre_tabla)
'nombre_seccion' => ['controller' => 'NombreSeccionController', 'action' => 'index'],
'nombre_seccion/create' => ['controller' => 'NombreSeccionController', 'action' => 'create'],
'nombre_seccion/store' => ['controller' => 'NombreSeccionController', 'action' => 'store'],
'nombre_seccion/edit' => ['controller' => 'NombreSeccionController', 'action' => 'edit'],
'nombre_seccion/update' => ['controller' => 'NombreSeccionController', 'action' => 'update'],
'nombre_seccion/delete' => ['controller' => 'NombreSeccionController', 'action' => 'delete'],
'nombre_seccion/view' => ['controller' => 'NombreSeccionController', 'action' => 'view'],
```

**Ejemplo real (Programas):**

```php
// Rutas de programas (programs)
'programs' => ['controller' => 'ProgramController', 'action' => 'index'],
'programs/create' => ['controller' => 'ProgramController', 'action' => 'create'],
'programs/store' => ['controller' => 'ProgramController', 'action' => 'store'],
'programs/edit' => ['controller' => 'ProgramController', 'action' => 'edit'],
'programs/update' => ['controller' => 'ProgramController', 'action' => 'update'],
'programs/delete' => ['controller' => 'ProgramController', 'action' => 'delete'],
'programs/view' => ['controller' => 'ProgramController', 'action' => 'view'],
```

---

## Paso 3: Crear el Modelo

### 3.1 Crear archivo `src/Models/NombreSeccion.php`

```php
<?php
namespace Src\Models;

use Src\Core\Database;

class NombreSeccion {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM nombre_tabla ORDER BY nombre_campo ASC");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllPaginated($perPage = 10, $offset = 0, $search = '') {
        $whereClause = '';
        $params = [];

        if (!empty($search)) {
            $whereClause = "WHERE campo_busqueda LIKE ?";
            $params = ["%$search%"];
        }

        $stmt = $this->db->prepare("
            SELECT * FROM nombre_tabla
            $whereClause
            ORDER BY nombre_campo ASC
            LIMIT ? OFFSET ?
        ");

        $params[] = $perPage;
        $params[] = $offset;
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getTotalCount($search = '') {
        $whereClause = '';
        $params = [];

        if (!empty($search)) {
            $whereClause = "WHERE campo_busqueda LIKE ?";
            $params = ["%$search%"];
        }

        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total
            FROM nombre_tabla
            $whereClause
        ");
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result['total'];
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM nombre_tabla WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO nombre_tabla (campo1, campo2) VALUES (?, ?)");
        return $stmt->execute([$data['campo1'], $data['campo2']]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE nombre_tabla SET campo1 = ?, campo2 = ? WHERE id = ?");
        return $stmt->execute([$data['campo1'], $data['campo2'], $id]);
    }

    public function delete($id) {
        // Verificar integridad referencial si es necesario
        $stmt = $this->db->prepare("DELETE FROM nombre_tabla WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
```

**Ejemplo real (Program):**

```php
<?php
namespace Src\Models;

use Src\Core\Database;

class Program {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $stmt = $this->db->prepare("
            SELECT p.*, a.name as axis_name
            FROM mydb.Program p
            LEFT JOIN project_management.axes a ON p.axes_id = a.id
            ORDER BY p.name ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getAllPaginated($perPage = 10, $offset = 0, $search = '') {
        $whereClause = '';
        $params = [];

        if (!empty($search)) {
            $whereClause = "WHERE p.name LIKE ? OR a.name LIKE ?";
            $params = ["%$search%", "%$search%"];
        }

        $stmt = $this->db->prepare("
            SELECT p.*, a.name as axis_name
            FROM mydb.Program p
            LEFT JOIN project_management.axes a ON p.axes_id = a.id
            $whereClause
            ORDER BY p.name ASC
            LIMIT ? OFFSET ?
        ");

        $params[] = $perPage;
        $params[] = $offset;
        $stmt->execute($params);
        return $stmt->fetchAll();
    }

    public function getTotalCount($search = '') {
        $whereClause = '';
        $params = [];

        if (!empty($search)) {
            $whereClause = "WHERE p.name LIKE ? OR a.name LIKE ?";
            $params = ["%$search%", "%$search%"];
        }

        $stmt = $this->db->prepare("
            SELECT COUNT(*) as total
            FROM mydb.Program p
            LEFT JOIN project_management.axes a ON p.axes_id = a.id
            $whereClause
        ");
        $stmt->execute($params);
        $result = $stmt->fetch();
        return $result['total'];
    }

    public function findById($id) {
        $stmt = $this->db->prepare("
            SELECT p.*, a.name as axis_name
            FROM mydb.Program p
            LEFT JOIN project_management.axes a ON p.axes_id = a.id
            WHERE p.id = ?
        ");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO mydb.Program (name, axes_id) VALUES (?, ?)");
        return $stmt->execute([$data['name'], $data['axes_id']]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE mydb.Program SET name = ?, axes_id = ? WHERE id = ?");
        return $stmt->execute([$data['name'], $data['axes_id'], $id]);
    }

    public function delete($id) {
        // Verificar si hay líneas de acción asociadas
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM mydb.action_lines WHERE Program_id = ?");
        $stmt->execute([$id]);
        $result = $stmt->fetch();

        if ($result['count'] > 0) {
            return false; // No se puede eliminar porque tiene líneas de acción asociadas
        }

        $stmt = $this->db->prepare("DELETE FROM mydb.Program WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
```

---

## Paso 4: Crear el Controlador

### 4.1 Crear archivo `src/Controllers/NombreSeccionController.php`

```php
<?php
namespace Src\Controllers;

use Src\Models\NombreSeccion;
use Src\Core\Request;

class NombreSeccionController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function index() {
        $model = new NombreSeccion($this->db);

        // Obtener parámetros de paginación
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
        $search = isset($_GET['search']) ? $_GET['search'] : '';

        // Obtener datos paginados
        $offset = ($page - 1) * $perPage;
        $data = $model->getAllPaginated($perPage, $offset, $search);
        $total = $model->getTotalCount($search);
        $totalPages = ceil($total / $perPage);

        // Incluir la vista
        include __DIR__ . '/../Views/nombre_seccion/index.php';
    }

    public function create() {
        include __DIR__ . '/../Views/nombre_seccion/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'campo1' => $_POST['campo1'] ?? '',
                'campo2' => $_POST['campo2'] ?? ''
            ];

            $model = new NombreSeccion($this->db);

            if ($model->create($data)) {
                header('Location: /nombre_seccion?success=1');
                exit;
            } else {
                header('Location: /nombre_seccion/create?error=1');
                exit;
            }
        }
    }

    public function edit() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /nombre_seccion?error=invalid_id');
            exit;
        }

        $model = new NombreSeccion($this->db);
        $item = $model->findById($id);

        if (!$item) {
            header('Location: /nombre_seccion?error=not_found');
            exit;
        }

        include __DIR__ . '/../Views/nombre_seccion/edit.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if (!$id) {
                header('Location: /nombre_seccion?error=invalid_id');
                exit;
            }

            $data = [
                'campo1' => $_POST['campo1'] ?? '',
                'campo2' => $_POST['campo2'] ?? ''
            ];

            $model = new NombreSeccion($this->db);

            if ($model->update($id, $data)) {
                header('Location: /nombre_seccion?success=2');
                exit;
            } else {
                header('Location: /nombre_seccion/edit?id=' . $id . '&error=1');
                exit;
            }
        }
    }

    public function delete() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /nombre_seccion?error=invalid_id');
            exit;
        }

        $model = new NombreSeccion($this->db);

        if ($model->delete($id)) {
            header('Location: /nombre_seccion?success=3');
            exit;
        } else {
            header('Location: /nombre_seccion?error=delete_failed');
            exit;
        }
    }

    public function view() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /nombre_seccion?error=invalid_id');
            exit;
        }

        $model = new NombreSeccion($this->db);
        $item = $model->findById($id);

        if (!$item) {
            header('Location: /nombre_seccion?error=not_found');
            exit;
        }

        include __DIR__ . '/../Views/nombre_seccion/view.php';
    }
}
```

**Ejemplo real (ProgramController):**

```php
<?php
namespace Src\Controllers;

use Src\Models\Program;
use Src\Models\Axis;
use Src\Core\Request;

class ProgramController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function index() {
        $programModel = new Program($this->db);
        $axisModel = new Axis($this->db);

        // Obtener parámetros de paginación
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $perPage = isset($_GET['per_page']) ? (int)$_GET['per_page'] : 10;
        $search = isset($_GET['search']) ? $_GET['search'] : '';

        // Obtener datos paginados
        $offset = ($page - 1) * $perPage;
        $programs = $programModel->getAllPaginated($perPage, $offset, $search);
        $total = $programModel->getTotalCount($search);
        $totalPages = ceil($total / $perPage);

        // Obtener ejes para el formulario
        $axes = $axisModel->getAll();

        // Incluir la vista
        include __DIR__ . '/../Views/programs/index.php';
    }

    public function create() {
        $axisModel = new Axis($this->db);
        $axes = $axisModel->getAll();

        include __DIR__ . '/../Views/programs/create.php';
    }

    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'axes_id' => $_POST['axes_id'] ?? ''
            ];

            $programModel = new Program($this->db);

            if ($programModel->create($data)) {
                header('Location: /programs?success=1');
                exit;
            } else {
                header('Location: /programs/create?error=1');
                exit;
            }
        }
    }

    public function edit() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /programs?error=invalid_id');
            exit;
        }

        $programModel = new Program($this->db);
        $axisModel = new Axis($this->db);

        $program = $programModel->findById($id);
        $axes = $axisModel->getAll();

        if (!$program) {
            header('Location: /programs?error=not_found');
            exit;
        }

        include __DIR__ . '/../Views/programs/edit.php';
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if (!$id) {
                header('Location: /programs?error=invalid_id');
                exit;
            }

            $data = [
                'name' => $_POST['name'] ?? '',
                'axes_id' => $_POST['axes_id'] ?? ''
            ];

            $programModel = new Program($this->db);

            if ($programModel->update($id, $data)) {
                header('Location: /programs?success=2');
                exit;
            } else {
                header('Location: /programs/edit?id=' . $id . '&error=1');
                exit;
            }
        }
    }

    public function delete() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /programs?error=invalid_id');
            exit;
        }

        $programModel = new Program($this->db);

        if ($programModel->delete($id)) {
            header('Location: /programs?success=3');
            exit;
        } else {
            header('Location: /programs?error=delete_failed');
            exit;
        }
    }

    public function view() {
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /programs?error=invalid_id');
            exit;
        }

        $programModel = new Program($this->db);
        $program = $programModel->findById($id);

        if (!$program) {
            header('Location: /programs?error=not_found');
            exit;
        }

        include __DIR__ . '/../Views/programs/view.php';
    }
}
```

---

## Paso 5: Crear las Vistas

### 5.1 Crear la carpeta de vistas

```bash
mkdir -p src/Views/nombre_seccion
```

### 5.2 Vista `index.php` (Listado)

```php
<?php
ob_start();
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">[NOMBRE_SECCION]</h1>
        <a href="/nombre_seccion/create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Nuevo [NOMBRE_SECCION]
        </a>
    </div>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?php
            $message = '';
            switch ($_GET['success']) {
                case '1':
                    $message = '[NOMBRE_SECCION] creado exitosamente.';
                    break;
                case '2':
                    $message = '[NOMBRE_SECCION] actualizado exitosamente.';
                    break;
                case '3':
                    $message = '[NOMBRE_SECCION] eliminado exitosamente.';
                    break;
            }
            echo $message;
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?php
            $message = '';
            switch ($_GET['error']) {
                case 'delete_failed':
                    $message = 'No se pudo eliminar el [NOMBRE_SECCION].';
                    break;
                case 'invalid_id':
                    $message = 'ID de [NOMBRE_SECCION] inválido.';
                    break;
                case 'not_found':
                    $message = '[NOMBRE_SECCION] no encontrado.';
                    break;
                default:
                    $message = 'Ha ocurrido un error.';
            }
            echo $message;
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php
    // Configurar variables para el componente de tabla
    $tableId = 'nombre_seccion-table';
    $columns = [
        'ID' => 'id',
        'Campo 1' => 'campo1',
        'Campo 2' => 'campo2',
        'Acciones' => 'actions'
    ];
    $data = $data;
    $currentPage = $page;
    $totalPages = $totalPages;
    $perPage = $perPage;
    $total = $total;
    $search = $search;
    $baseUrl = '/nombre_seccion';

    include __DIR__ . '/../components/table_options.php';
    ?>

    <?php include __DIR__ . '/../components/table.php'; ?>
</div>

<script>
// Configurar acciones por fila para la tabla
function setupTableActions() {
    const table = document.getElementById('<?php echo $tableId; ?>');
    if (!table) return;

    const rows = table.querySelectorAll('tbody tr');
    rows.forEach(row => {
        const id = row.getAttribute('data-id');
        if (!id) return;

        // Crear botones de acción
        const actionsCell = row.querySelector('.actions-cell');
        if (actionsCell) {
            actionsCell.innerHTML = `
                <div class="btn-group" role="group">
                    <a href="/nombre_seccion/view?id=${id}" class="btn btn-sm btn-info" title="Ver">
                        <i class="fas fa-eye"></i>
                    </a>
                    <a href="/nombre_seccion/edit?id=${id}" class="btn btn-sm btn-warning" title="Editar">
                        <i class="fas fa-edit"></i>
                    </a>
                    <button type="button" class="btn btn-sm btn-danger" title="Eliminar"
                            onclick="deleteItem(${id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>
            `;
        }
    });
}

function deleteItem(id) {
    if (confirm('¿Está seguro de que desea eliminar este [NOMBRE_SECCION]?')) {
        window.location.href = `/nombre_seccion/delete?id=${id}`;
    }
}

// Inicializar acciones cuando se carga la página
document.addEventListener('DOMContentLoaded', function() {
    setupTableActions();
});
</script>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/app.php';
?>
```

### 5.3 Vista `create.php` (Crear)

```php
<?php
ob_start();
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Nuevo [NOMBRE_SECCION]</h1>
        <a href="/nombre_seccion" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Ha ocurrido un error al crear el [NOMBRE_SECCION]. Por favor, inténtelo de nuevo.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Información del [NOMBRE_SECCION]</h6>
        </div>
        <div class="card-body">
            <form action="/nombre_seccion/store" method="POST">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="campo1" class="form-label">Campo 1 *</label>
                            <input type="text" class="form-control" id="campo1" name="campo1" required
                                   value="<?php echo isset($_POST['campo1']) ? htmlspecialchars($_POST['campo1']) : ''; ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="campo2" class="form-label">Campo 2 *</label>
                            <input type="text" class="form-control" id="campo2" name="campo2" required
                                   value="<?php echo isset($_POST['campo2']) ? htmlspecialchars($_POST['campo2']) : ''; ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="/nombre_seccion" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Guardar [NOMBRE_SECCION]
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/app.php';
?>
```

### 5.4 Vista `edit.php` (Editar)

```php
<?php
ob_start();
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Editar [NOMBRE_SECCION]</h1>
        <a href="/nombre_seccion" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Volver
        </a>
    </div>

    <?php if (isset($_GET['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            Ha ocurrido un error al actualizar el [NOMBRE_SECCION]. Por favor, inténtelo de nuevo.
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Información del [NOMBRE_SECCION]</h6>
        </div>
        <div class="card-body">
            <form action="/nombre_seccion/update" method="POST">
                <input type="hidden" name="id" value="<?php echo $item['id']; ?>">

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="campo1" class="form-label">Campo 1 *</label>
                            <input type="text" class="form-control" id="campo1" name="campo1" required
                                   value="<?php echo htmlspecialchars($item['campo1']); ?>">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="campo2" class="form-label">Campo 2 *</label>
                            <input type="text" class="form-control" id="campo2" name="campo2" required
                                   value="<?php echo htmlspecialchars($item['campo2']); ?>">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-12">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="/nombre_seccion" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Actualizar [NOMBRE_SECCION]
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/app.php';
?>
```

### 5.5 Vista `view.php` (Ver)

```php
<?php
ob_start();
?>

<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">Detalles del [NOMBRE_SECCION]</h1>
        <div>
            <a href="/nombre_seccion/edit?id=<?php echo $item['id']; ?>" class="btn btn-warning">
                <i class="fas fa-edit"></i> Editar
            </a>
            <a href="/nombre_seccion" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Información del [NOMBRE_SECCION]</h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">ID:</label>
                        <p class="form-control-plaintext"><?php echo $item['id']; ?></p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Campo 1:</label>
                        <p class="form-control-plaintext"><?php echo htmlspecialchars($item['campo1']); ?></p>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Campo 2:</label>
                        <p class="form-control-plaintext"><?php echo htmlspecialchars($item['campo2']); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include __DIR__ . '/../layouts/app.php';
?>
```

---

## Paso 6: Agregar al Sidebar

### 6.1 Editar `src/Views/layouts/partials/sidebar.php`

Buscar la sección de catálogos y agregar el enlace:

```php
<li><a href="/nombre_seccion" class="<?= is_active('/nombre_seccion') ? 'active' : '' ?>"><i class="fas fa-[ICONO]"></i> [NOMBRE_SECCION]</a>
```

**Ejemplo real:**

```php
<li><a href="/programs" class="<?= is_active('/programs') ? 'active' : '' ?>"><i class="fas fa-project-diagram"></i> Programas</a>
```

---

## Paso 7: Verificación y Pruebas

### 7.1 Verificar sintaxis

```bash
php -l src/Controllers/NombreSeccionController.php
php -l src/Models/NombreSeccion.php
```

### 7.2 Probar funcionalidad

1. Acceder a `/nombre_seccion`
2. Verificar que se muestra el listado
3. Probar crear un nuevo elemento
4. Probar editar un elemento existente
5. Probar eliminar un elemento
6. Verificar paginación y búsqueda
7. Verificar componentes de exportación

---

## Patrones y Convenciones

### Nomenclatura

- **Controlador**: `NombreSeccionController.php` (PascalCase)
- **Modelo**: `NombreSeccion.php` (PascalCase)
- **Vistas**: `nombre_seccion/` (snake_case)
- **Rutas**: `nombre_seccion` (snake_case)

### Namespaces

- **Controladores**: `namespace Src\Controllers;`
- **Modelos**: `namespace Src\Models;`

### Estructura de archivos

```
src/
├── Controllers/
│   └── NombreSeccionController.php
├── Models/
│   └── NombreSeccion.php
└── Views/
    └── nombre_seccion/
        ├── index.php
        ├── create.php
        ├── edit.php
        └── view.php
```

### Componentes reutilizables

- `table.php` - Tabla con paginación
- `table_options.php` - Opciones de exportación y filas por página
- `action_buttons.php` - Botones de acciones por fila

### Mensajes de éxito/error

- **Éxito 1**: Creado exitosamente
- **Éxito 2**: Actualizado exitosamente
- **Éxito 3**: Eliminado exitosamente
- **Error**: Mensajes específicos según el tipo de error

---

## Ejemplo Completo

Para crear una sección "Categorías":

1. **Rutas**: `categorias` en `routes/web.php` y `public/index.php`
2. **Modelo**: `src/Models/Categoria.php` con métodos CRUD
3. **Controlador**: `src/Controllers/CategoriaController.php` con métodos CRUD
4. **Vistas**: `src/Views/categorias/` con 4 archivos PHP
5. **Sidebar**: Enlace en `sidebar.php`
6. **Pruebas**: Verificar toda la funcionalidad

Este patrón asegura consistencia en todo el sistema y facilita el mantenimiento.

---

## Uso obligatorio de componentes en todas las secciones CRUD

Para mantener la consistencia visual y funcional, **todas las secciones CRUD deben usar SIEMPRE los siguientes componentes**:

- `filter_bar.php` para filtros y botones de acción (como "Nuevo ...").
- `table.php` para el listado principal.
- El bloque de paginación estándar al final de la tabla.

### Ejemplo de uso correcto:

```php
$filters = [
    ['type' => 'text', 'name' => 'q', 'placeholder' => 'Buscar...', 'value' => htmlspecialchars($_GET['q'] ?? '')],
];
$buttons = [
    [
        'type' => 'submit',
        'label' => 'Filtrar',
        'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900',
        'icon' => 'fa-search'
    ],
    [
        'type' => 'link',
        'label' => 'Nuevo Elemento',
        'href' => '/seccion/create',
        'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900',
        'icon' => 'fa-plus',
        'title' => 'Crear nuevo'
    ]
];
include __DIR__ . '/../components/filter_bar.php';

$headers = [...];
$fields = [...];
$rows = ...;
$actions_config = [...];
$custom_render = [...];
include __DIR__ . '/../components/table.php';
```

**Nunca** generes los filtros, botones o tablas manualmente en la vista. Usa siempre los componentes para asegurar uniformidad y facilidad de mantenimiento.

---

## Lógica de filtrado en el backend (¡Obligatorio!)

Siempre que una sección CRUD tenga filtros en la vista (por ejemplo, el filtro de búsqueda), el controlador debe:

1. Leer el parámetro de filtro (por ejemplo, `q` para búsqueda).
2. Si el filtro está presente, llamar a un método `search($q)` en el modelo para obtener solo los resultados filtrados.
3. Si no hay filtro, obtener todos los datos normalmente.
4. Pasar los resultados filtrados a la vista.

**Ejemplo en el controlador:**

```php
$q = $_GET['q'] ?? '';
if ($q !== '') {
    $items = Modelo::search($q);
} else {
    $items = Modelo::getAll();
}
```

**Ejemplo en el modelo:**

```php
public static function search($q)
{
    $q = "%$q%";
    return Database::fetchAll("SELECT * FROM tabla WHERE campo LIKE ? ORDER BY campo", [$q]);
}
```

**Nunca** dejes el filtro solo en el frontend. El backend debe filtrar los datos para que el filtro funcione correctamente.

---

## Uso obligatorio del componente de formulario en CRUD

Todos los formularios de creación **y edición** deben usar el componente `form.php` para asegurar uniformidad y facilidad de mantenimiento.

- Define un array `$fields` con la estructura de los campos.
- Define `$action`, `$method` y `$buttons`.
- Incluye el componente `form.php` en la vista.

**Ejemplo:**

```php
$fields = [
    ['name' => 'name', 'label' => 'Nombre', 'type' => 'text', 'value' => '', 'required' => true],
    ['name' => 'tipo', 'label' => 'Tipo', 'type' => 'select', 'options' => ['A' => 'Tipo A', 'B' => 'Tipo B'], 'value' => 'A'],
];
$action = '/ruta/store';
$method = 'post';
$buttons = [
    ['type' => 'submit', 'label' => 'Guardar', 'class' => 'btn-primary'],
    ['type' => 'link', 'label' => 'Cancelar', 'href' => '/ruta', 'class' => 'btn-secondary'],
];
include __DIR__ . '/../components/form.php';
```

**Nunca** escribas el formulario manualmente en la vista. Usa siempre el componente para mantener la coherencia visual y funcional.

---

## Eliminación de columnas de acciones duplicadas (¡Obligatorio!)

**IMPORTANTE**: El componente `table.php` ya maneja automáticamente la columna de acciones cuando se proporciona `$actions_config`. Por lo tanto:

### ❌ INCORRECTO - No hacer esto:

```php
$headers = ['ID', 'Nombre', 'Email', 'Acciones'];  // ❌ No incluir 'Acciones'
$fields = ['id', 'name', 'email', 'actions'];      // ❌ No incluir 'actions'
```

### ✅ CORRECTO - Hacer esto:

```php
$headers = ['ID', 'Nombre', 'Email'];              // ✅ Solo los encabezados de datos
$fields = ['id', 'name', 'email'];                 // ✅ Solo los campos de datos
$actions_config = [
    [
        'type' => 'edit',
        'url' => function ($row) { return '/seccion/edit?id=' . $row['id']; },
        'title' => 'Editar',
        'icon' => 'fa-edit text-yellow-500',
        'class' => 'btn-warning',
    ],
    // ... más acciones
];
```

### ¿Por qué es importante?

1. **Evita duplicación**: Si incluyes 'Acciones' en `$headers` y `$fields`, aparecerán dos columnas de acciones (una vacía y otra con botones).
2. **Consistencia visual**: El componente `table.php` agrega automáticamente la columna de acciones con el estilo correcto.
3. **Mantenimiento**: Si necesitas cambiar el comportamiento de las acciones, solo modificas el componente, no cada vista.

### Verificación rápida:

Antes de crear una nueva vista CRUD, asegúrate de que:

- `$headers` solo contenga encabezados de datos reales
- `$fields` solo contenga campos de datos reales
- `$actions_config` esté definido para las acciones
- No haya referencias a 'Acciones' o 'actions' en los arrays

**Ejemplo de vista correcta:**

```php
$headers = ['ID', 'Nombre', 'Descripción'];
$fields = ['id', 'name', 'description'];
$rows = $data;
$actions_config = [
    [
        'type' => 'edit',
        'url' => function ($row) { return '/seccion/edit?id=' . $row['id']; },
        'title' => 'Editar',
        'icon' => 'fa-edit text-yellow-500',
        'class' => 'btn-warning',
    ],
    [
        'type' => 'delete',
        'url' => function ($row) { return '/seccion/delete?id=' . $row['id']; },
        'title' => 'Eliminar',
        'icon' => 'fa-trash text-red-500',
        'class' => 'btn-danger',
        'onclick' => function ($row) { return "return confirm('¿Seguro?')"; },
    ],
];
include __DIR__ . '/../components/table.php';
```

Esta regla es **obligatoria** para todas las secciones CRUD existentes y futuras.
