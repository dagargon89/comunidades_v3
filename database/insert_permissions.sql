-- Script para insertar permisos faltantes y asignarlos al rol administrador
-- Ejecutar este script si ya tienes una base de datos con datos existentes

-- Insertar permisos faltantes (solo si no existen)
INSERT IGNORE INTO
    `project_management`.`permissions` (`name`, `description`)
VALUES
    -- Permisos para Roles (si no existen)
    ('role.view', 'Ver roles'),
    ('role.create', 'Crear roles'),
    ('role.edit', 'Editar roles'),
    (
        'role.delete',
        'Eliminar roles'
    ),
    -- Permisos para Permisos (si no existen)
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

-- Asignar todos los permisos al rol administrador (solo si no están ya asignados)
INSERT IGNORE INTO
    `project_management`.`role_permissions` (`role_id`, `permission_id`)
SELECT r.id, p.id
FROM `project_management`.`roles` r, `project_management`.`permissions` p
WHERE
    r.name = 'admin';

-- Mostrar resumen de permisos insertados
SELECT 'Permisos totales en el sistema:' as info, COUNT(*) as total
FROM `project_management`.`permissions`
UNION ALL
SELECT 'Permisos del administrador:' as info, COUNT(*) as total
FROM `project_management`.`role_permissions` rp
    JOIN `project_management`.`roles` r ON rp.role_id = r.id
WHERE
    r.name = 'admin';