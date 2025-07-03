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
    ('role.view', 'Ver roles'),
    ('role.create', 'Crear roles'),
    ('role.edit', 'Editar roles'),
    (
        'role.delete',
        'Eliminar roles'
    ),
    (
        'permission.view',
        'Ver permisos'
    ),
    (
        'permission.create',
        'Crear permisos'
    ),
    (
        'permission.edit',
        'Editar permisos'
    ),
    (
        'permission.delete',
        'Eliminar permisos'
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
    ),
    -- Permisos para Ejes (Axes)
    ('axis.view', 'Ver ejes'),
    ('axis.create', 'Crear ejes'),
    ('axis.edit', 'Editar ejes'),
    (
        'axis.delete',
        'Eliminar ejes'
    ),
    -- Permisos para Responsables
    (
        'responsible.view',
        'Ver responsables'
    ),
    (
        'responsible.create',
        'Crear responsables'
    ),
    (
        'responsible.edit',
        'Editar responsables'
    ),
    (
        'responsible.delete',
        'Eliminar responsables'
    ),
    -- Permisos para Polígonos
    (
        'polygon.view',
        'Ver polígonos'
    ),
    (
        'polygon.create',
        'Crear polígonos'
    ),
    (
        'polygon.edit',
        'Editar polígonos'
    ),
    (
        'polygon.delete',
        'Eliminar polígonos'
    ),
    -- Permisos para Recolectores de Datos
    (
        'data_collector.view',
        'Ver recolectores de datos'
    ),
    (
        'data_collector.create',
        'Crear recolectores de datos'
    ),
    (
        'data_collector.edit',
        'Editar recolectores de datos'
    ),
    (
        'data_collector.delete',
        'Eliminar recolectores de datos'
    ),
    -- Permisos para Ubicaciones
    (
        'location.view',
        'Ver ubicaciones'
    ),
    (
        'location.create',
        'Crear ubicaciones'
    ),
    (
        'location.edit',
        'Editar ubicaciones'
    ),
    (
        'location.delete',
        'Eliminar ubicaciones'
    ),
    -- Permisos para Objetivos Específicos
    (
        'specific_objective.view',
        'Ver objetivos específicos'
    ),
    (
        'specific_objective.create',
        'Crear objetivos específicos'
    ),
    (
        'specific_objective.edit',
        'Editar objetivos específicos'
    ),
    (
        'specific_objective.delete',
        'Eliminar objetivos específicos'
    ),
    -- Permisos para Metas
    ('goal.view', 'Ver metas'),
    ('goal.create', 'Crear metas'),
    ('goal.edit', 'Editar metas'),
    (
        'goal.delete',
        'Eliminar metas'
    ),
    -- Permisos para Calendario de Actividades
    (
        'activity_calendar.view',
        'Ver calendario de actividades'
    ),
    (
        'activity_calendar.create',
        'Crear eventos en calendario'
    ),
    (
        'activity_calendar.edit',
        'Editar eventos del calendario'
    ),
    (
        'activity_calendar.delete',
        'Eliminar eventos del calendario'
    ),
    -- Permisos para Archivos de Actividades
    (
        'activity_file.view',
        'Ver archivos de actividades'
    ),
    (
        'activity_file.create',
        'Subir archivos de actividades'
    ),
    (
        'activity_file.edit',
        'Editar archivos de actividades'
    ),
    (
        'activity_file.delete',
        'Eliminar archivos de actividades'
    ),
    -- Permisos para Registro de Beneficiarios
    (
        'beneficiary.view',
        'Ver beneficiarios'
    ),
    (
        'beneficiary.create',
        'Registrar beneficiarios'
    ),
    (
        'beneficiary.edit',
        'Editar beneficiarios'
    ),
    (
        'beneficiary.delete',
        'Eliminar beneficiarios'
    ),
    -- Permisos para Métricas Planificadas
    (
        'planned_metric.view',
        'Ver métricas planificadas'
    ),
    (
        'planned_metric.create',
        'Crear métricas planificadas'
    ),
    (
        'planned_metric.edit',
        'Editar métricas planificadas'
    ),
    (
        'planned_metric.delete',
        'Eliminar métricas planificadas'
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
        'catalog.view',
        'axis.view',
        'responsible.view',
        'polygon.view',
        'data_collector.view',
        'location.view',
        'specific_objective.view',
        'goal.view',
        'activity_calendar.view',
        'activity_calendar.create',
        'activity_calendar.edit',
        'activity_file.view',
        'activity_file.create',
        'beneficiary.view',
        'beneficiary.create',
        'beneficiary.edit',
        'planned_metric.view',
        'planned_metric.create',
        'planned_metric.edit'
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
        'catalog.view',
        'axis.view',
        'responsible.view',
        'polygon.view',
        'data_collector.view',
        'location.view',
        'specific_objective.view',
        'goal.view',
        'activity_calendar.view',
        'activity_calendar.create',
        'activity_calendar.edit',
        'activity_file.view',
        'activity_file.create',
        'beneficiary.view',
        'beneficiary.create',
        'beneficiary.edit',
        'planned_metric.view',
        'planned_metric.create',
        'planned_metric.edit'
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
        'dashboard.view',
        'axis.view',
        'responsible.view',
        'polygon.view',
        'data_collector.view',
        'location.view',
        'activity_calendar.view',
        'activity_calendar.edit',
        'activity_file.view',
        'activity_file.create',
        'beneficiary.view',
        'beneficiary.create',
        'beneficiary.edit',
        'planned_metric.view',
        'planned_metric.edit'
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
        'catalog.view',
        'axis.view',
        'responsible.view',
        'polygon.view',
        'data_collector.view',
        'location.view',
        'specific_objective.view',
        'goal.view',
        'activity_calendar.view',
        'activity_file.view',
        'beneficiary.view',
        'planned_metric.view'
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