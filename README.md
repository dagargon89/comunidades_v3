# Comunidades V3

Sistema de Gestión de Comunidades V3 - Plataforma para la gestión de proyectos comunitarios, actividades y recolección de datos.

## 🚀 Características

- **Autenticación de usuarios** con roles y permisos
- **Gestión de proyectos** comunitarios
- **Gestión de actividades** y calendario
- **Recolección de datos** y métricas
- **Catálogos** de ubicaciones y recursos
- **Dashboard** con estadísticas
- **Diseño responsive** con Tailwind CSS
- **Sistema de roles** y permisos granular

## 📋 Requisitos

- PHP 7.4 o superior
- MySQL 5.7 o superior
- Apache/Nginx con mod_rewrite habilitado
- Composer

## 🛠️ Instalación

### 1. Clonar el repositorio

```bash
git clone <url-del-repositorio>
cd comunidades_v3
```

### 2. Instalar dependencias

```bash
composer install
```

### 3. Configurar la base de datos

#### Crear las bases de datos:

```sql
CREATE DATABASE project_management CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE DATABASE mydb CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### Ejecutar el esquema:

```bash
mysql -u root -p project_management < database/schema.sql
mysql -u root -p mydb < database/schema.sql
```

#### Insertar datos de prueba:

```bash
mysql -u root -p project_management < database/seeds.sql
mysql -u root -p mydb < database/seeds.sql
```

### 4. Configurar el servidor web

#### Para Apache:

Asegúrate de que el directorio `public/` sea el document root de tu servidor web.

#### Para Laragon:

- Coloca el proyecto en `C:\laragon\www\comunidades_v3`
- El proyecto estará disponible en `http://comunidades_v3.test`

### 5. Verificar la instalación

Ejecuta el script de prueba de conexión:

```bash
php test_connection.php
```

## 👥 Usuarios de Prueba

Se han creado los siguientes usuarios para pruebas:

| Usuario      | Contraseña | Rol         | Descripción                |
| ------------ | ---------- | ----------- | -------------------------- |
| admin        | password   | Admin       | Administrador del sistema  |
| manager1     | password   | Manager     | Gerente de proyecto        |
| coordinator1 | password   | Coordinator | Coordinador de actividades |
| collector1   | password   | Collector   | Recolector de datos        |
| viewer1      | password   | Viewer      | Solo visualización         |

## 🏗️ Estructura del Proyecto

```
comunidades_v3/
├── config/                 # Configuraciones
│   ├── app.php            # Configuración general
│   └── database.php       # Configuración de BD
├── database/              # Base de datos
│   ├── schema.sql         # Esquema de BD
│   └── seeds.sql          # Datos de prueba
├── public/                # Directorio público
│   ├── index.php          # Punto de entrada
│   ├── .htaccess          # Rewrite rules
│   ├── assets/            # Archivos estáticos
│   └── uploads/           # Archivos subidos
├── src/                   # Código fuente
│   ├── Controllers/       # Controladores
│   ├── Core/              # Clases base
│   ├── Models/            # Modelos
│   └── Views/             # Vistas
├── bootstrap.php          # Inicialización
├── composer.json          # Dependencias
└── README.md              # Este archivo
```

## 🔧 Configuración

### Base de Datos

Edita `config/database.php` para configurar las conexiones a la base de datos:

```php
'connections' => [
    'project_management' => [
        'host' => 'localhost',
        'port' => 3306,
        'username' => 'root',
        'password' => '',
        'database' => 'project_management',
    ],
    'mydb' => [
        'host' => 'localhost',
        'port' => 3306,
        'username' => 'root',
        'password' => '',
        'database' => 'mydb',
    ]
]
```

### Aplicación

Edita `config/app.php` para configurar la aplicación:

```php
'name' => 'Comunidades V3',
'url' => 'http://localhost',
'env' => 'development',
'debug' => true,
```

## 🚀 Uso

### Acceso al sistema

1. Abre tu navegador y ve a `http://localhost` (o tu URL configurada)
2. Inicia sesión con uno de los usuarios de prueba
3. Explora las diferentes funcionalidades según tu rol

### Funcionalidades principales

#### Dashboard

- Vista general de proyectos y actividades
- Estadísticas y métricas
- Acceso rápido a funciones principales

#### Gestión de Proyectos

- Crear, editar y eliminar proyectos
- Asignar objetivos específicos
- Gestionar metas y componentes

#### Gestión de Actividades

- Crear y programar actividades
- Asignar responsables y ubicaciones
- Gestionar calendario de actividades

#### Recolección de Datos

- Registrar beneficiarios
- Capturar métricas planificadas
- Subir archivos de evidencia

#### Catálogos

- Gestionar ubicaciones y polígonos
- Administrar responsables y recolectores
- Configurar organizaciones y financiadores

## 🔒 Seguridad

- Contraseñas hasheadas con `password_hash()`
- Validación de entrada en todos los formularios
- Protección CSRF implícita
- Control de acceso basado en roles
- Sanitización de datos de salida

## 🎨 Tecnologías

- **Backend**: PHP 7.4+
- **Base de Datos**: MySQL 5.7+
- **Frontend**: HTML5, CSS3, JavaScript
- **Framework CSS**: Tailwind CSS (CDN)
- **Iconos**: Font Awesome
- **Gestión de Dependencias**: Composer

## 📝 Licencia

Este proyecto está bajo la Licencia MIT. Ver el archivo `LICENSE` para más detalles.

## 🤝 Contribución

1. Fork el proyecto
2. Crea una rama para tu feature (`git checkout -b feature/AmazingFeature`)
3. Commit tus cambios (`git commit -m 'Add some AmazingFeature'`)
4. Push a la rama (`git push origin feature/AmazingFeature`)
5. Abre un Pull Request

## 📞 Soporte

Para soporte técnico o preguntas, contacta al equipo de desarrollo.

## 🧩 Componentes reutilizables

### Componente de Botón (`src/Views/components/button.php`)

Permite crear botones y enlaces uniformes en todo el sistema, con soporte para íconos, tooltips, atributos extra y clases personalizadas.

**Uso básico:**

```php
$btn = [
    'type' => 'submit' | 'button' | 'reset' | 'link',
    'label' => 'Texto',
    'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900', // Solo color, el resto es uniforme
    'icon' => 'fa-save', // opcional, FontAwesome
    'href' => '/ruta',   // solo para type=link
    'title' => 'Tooltip', // opcional
    'attrs' => 'data-extra="1"', // opcional
];
include __DIR__ . '/../components/button.php';
```

**Ejemplo en formulario:**

```php
$buttons = [
    [
        'type' => 'submit',
        'label' => 'Guardar',
        'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900'
    ],
    [
        'type' => 'link',
        'label' => 'Cancelar',
        'href' => '/usuarios',
        'class' => 'bg-gray-200 text-gray-800 hover:bg-gray-300'
    ],
];
```

**Características:**

- Clase base uniforme: padding, borde, fuente, transición, etc.
- Solo necesitas definir el color y hover.
- Soporta íconos FontAwesome.
- Soporta tooltips y atributos extra.
- Compatible con formularios y acciones generales.

**Ejemplo de botón con ícono y confirmación:**

```php
$btn = [
    'type' => 'link',
    'label' => 'Eliminar',
    'href' => '/ruta/eliminar',
    'class' => 'bg-red-600 text-white hover:bg-red-700',
    'icon' => 'fa-trash',
    'attrs' => 'onclick="return confirm(\'¿Seguro?\');"'
];
include __DIR__ . '/../components/button.php';
```

**Recomendación:**
Define una clase base de color para cada tipo de acción (guardar, cancelar, eliminar, etc.) y reutilízala en todos los botones para mantener la coherencia visual.

---

**Comunidades V3** - Construyendo comunidades más fuertes juntos.

## 🏆 Funcionalidades implementadas

| Módulo             | Descripción                                                                                   |
| ------------------ | --------------------------------------------------------------------------------------------- |
| Autenticación      | Login, registro, cierre de sesión, control de sesión seguro                                   |
| Usuarios           | CRUD completo, filtro, validaciones, control de estado, roles y permisos                      |
| Roles              | CRUD completo, asignación de permisos, integración con control de acceso                      |
| Permisos           | CRUD completo, asignación a roles, integración en menú y controladores                        |
| Dashboard          | Vista de bienvenida, estadísticas, acceso rápido, control de errores                          |
| Menú de navegación | Agrupación por secciones, visibilidad según permisos, diseño moderno y responsive             |
| Componentes        | Flash, tabla, formulario, botones de acción y generales, reutilizables y personalizables      |
| Seguridad          | Control de acceso centralizado, validación, sanitización, hashing de contraseñas              |
| Vistas SQL         | Vistas para reportes y dashboards: resumen de actividades, población y productos planificados |
| Debugging          | Manejo de errores, logs, try/catch, mensajes claros                                           |

## 🛡️ Política de permisos

- Toda nueva sección, controlador o funcionalidad debe implementar control de permisos en controladores, vistas y menú.
- El menú y los botones solo se muestran si el usuario tiene el permiso correspondiente.
- Permisos gestionados desde las tablas `permissions` y `role_permissions`.
- Métodos clave: `User::hasPermission()`, función global `current_user()`.

## 🧩 Componentes reutilizables

### Flash (`src/Views/components/flash.php`)

Muestra mensajes de éxito o error en cualquier vista. Solo incluye el archivo y usa las variables de sesión `flash_success` o `flash_error`.

```php
<?php include __DIR__ . '/../components/flash.php'; ?>
```

### Formulario (`src/Views/components/form.php`)

Genera formularios dinámicos a partir de un array de campos y botones. Soporta inputs, selects, textarea, validaciones y botones personalizados.

```php
$fields = [
    ['name' => 'email', 'label' => 'Email', 'type' => 'email', 'value' => '', 'required' => true],
    ['name' => 'rol', 'label' => 'Rol', 'type' => 'select', 'options' => ['admin' => 'Admin', 'user' => 'Usuario'], 'value' => 'user'],
];
$buttons = [
    ['type' => 'submit', 'label' => 'Guardar', 'class' => 'bg-fuchsia-800 text-white hover:bg-fuchsia-900'],
    ['type' => 'link', 'label' => 'Cancelar', 'href' => '/ruta', 'class' => 'bg-gray-200 text-gray-800 hover:bg-gray-300'],
];
include __DIR__ . '/../components/form.php';
```

### Tabla (`src/Views/components/table.php`)

Componente para mostrar listados de datos con alineación y acciones flexibles. Personalizable por columnas y acciones.

### Botón (`src/Views/components/button.php`)

Permite crear botones y enlaces uniformes, con íconos, tooltips, atributos extra y clases personalizadas. (Ver ejemplos en sección anterior)

### Botones de acción (`src/Views/components/action_buttons.php`)

Botones rápidos para acciones por fila en tablas (editar, eliminar, etc.), con control de permisos y estilos consistentes.

## 🗄️ Vistas SQL

- `vw_activity_summary`: Resumen de actividades por proyecto
- `vw_planned_population`: Población planificada por actividad
- `vw_planned_products`: Productos planificados por actividad

## 👨‍💻 Buenas prácticas y recomendaciones

- Usa siempre los componentes reutilizables para mantener coherencia visual y funcional.
- Implementa control de permisos en controladores, vistas y menú para toda nueva funcionalidad.
- Documenta cada nuevo componente o helper en este README.
- Mantén los mensajes flash claros y visibles para el usuario.
- Usa try/catch y logs para facilitar el debugging.
- Personaliza solo los colores de los botones, el resto del estilo es uniforme.
