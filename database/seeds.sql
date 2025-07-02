-- Datos de prueba para Comunidades V3 - Solo usuarios, roles y permisos

-- Insertar roles básicos
INSERT INTO
    `project_management`.`roles` (`name`, `description`)
VALUES (
        'admin',
        'Administrador del sistema'
    ),
    (
        'manager',
        'Gerente de proyecto'
    ),
    (
        'coordinator',
        'Coordinador de actividades'
    ),
    (
        'collector',
        'Recolector de datos'
    ),
    (
        'viewer',
        'Solo visualización'
    );

-- Insertar permisos básicos
INSERT INTO
    `project_management`.`permissions` (`name`, `description`)
VALUES ('user.view', 'Ver usuarios'),
    (
        'user.create',
        'Crear usuarios'
    ),
    (
        'user.edit',
        'Editar usuarios'
    ),
    (
        'user.delete',
        'Eliminar usuarios'
    ),
    (
        'project.view',
        'Ver proyectos'
    ),
    (
        'project.create',
        'Crear proyectos'
    ),
    (
        'project.edit',
        'Editar proyectos'
    ),
    (
        'project.delete',
        'Eliminar proyectos'
    ),
    (
        'activity.view',
        'Ver actividades'
    ),
    (
        'activity.create',
        'Crear actividades'
    ),
    (
        'activity.edit',
        'Editar actividades'
    ),
    (
        'activity.delete',
        'Eliminar actividades'
    ),
    (
        'dashboard.view',
        'Ver dashboard'
    ),
    (
        'catalog.view',
        'Ver catálogos'
    ),
    (
        'catalog.edit',
        'Editar catálogos'
    );

-- Asignar permisos a roles
-- Admin tiene todos los permisos
INSERT INTO
    `project_management`.`role_permissions` (`role_id`, `permission_id`)
SELECT r.id, p.id
FROM `project_management`.`roles` r, `project_management`.`permissions` p
WHERE
    r.name = 'admin';

-- Manager tiene permisos de proyecto y actividad
INSERT INTO
    `project_management`.`role_permissions` (`role_id`, `permission_id`)
SELECT r.id, p.id
FROM `project_management`.`roles` r, `project_management`.`permissions` p
WHERE
    r.name = 'manager'
    AND p.name IN (
        'project.view',
        'project.create',
        'project.edit',
        'activity.view',
        'activity.create',
        'activity.edit',
        'dashboard.view',
        'catalog.view'
    );

-- Coordinator tiene permisos de actividad
INSERT INTO
    `project_management`.`role_permissions` (`role_id`, `permission_id`)
SELECT r.id, p.id
FROM `project_management`.`roles` r, `project_management`.`permissions` p
WHERE
    r.name = 'coordinator'
    AND p.name IN (
        'activity.view',
        'activity.create',
        'activity.edit',
        'dashboard.view',
        'catalog.view'
    );

-- Collector tiene permisos limitados
INSERT INTO
    `project_management`.`role_permissions` (`role_id`, `permission_id`)
SELECT r.id, p.id
FROM `project_management`.`roles` r, `project_management`.`permissions` p
WHERE
    r.name = 'collector'
    AND p.name IN (
        'activity.view',
        'activity.edit',
        'dashboard.view'
    );

-- Viewer solo puede ver
INSERT INTO
    `project_management`.`role_permissions` (`role_id`, `permission_id`)
SELECT r.id, p.id
FROM `project_management`.`roles` r, `project_management`.`permissions` p
WHERE
    r.name = 'viewer'
    AND p.name IN (
        'project.view',
        'activity.view',
        'dashboard.view',
        'catalog.view'
    );

-- Insertar usuarios de prueba
INSERT INTO
    `project_management`.`users` (
        `username`,
        `email`,
        `password_hash`,
        `first_name`,
        `last_name`,
        `is_active`
    )
VALUES (
        'admin',
        'admin@comunidades.com',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'Administrador',
        'Sistema',
        1
    ),
    (
        'manager1',
        'manager1@comunidades.com',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'Juan',
        'Pérez',
        1
    ),
    (
        'coordinator1',
        'coordinator1@comunidades.com',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'María',
        'García',
        1
    ),
    (
        'collector1',
        'collector1@comunidades.com',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'Carlos',
        'López',
        1
    ),
    (
        'viewer1',
        'viewer1@comunidades.com',
        '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
        'Ana',
        'Martínez',
        1
    );

-- Asignar roles a usuarios
INSERT INTO
    `project_management`.`user_roles` (`user_id`, `role_id`)
VALUES (1, 1), -- admin -> admin
    (2, 2), -- manager1 -> manager
    (3, 3), -- coordinator1 -> coordinator
    (4, 4), -- collector1 -> collector
    (5, 5);
-- viewer1 -> viewer

-- Nota: La contraseña para todos los usuarios de prueba es 'password'