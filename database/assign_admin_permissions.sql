-- Script para asignar TODOS los permisos existentes al rol administrador
-- Ejecutar este script después de haber insertado los permisos faltantes

-- Asignar todos los permisos al rol administrador (solo si no están ya asignados)
INSERT IGNORE INTO
    `project_management`.`role_permissions` (`role_id`, `permission_id`)
SELECT r.id, p.id
FROM `project_management`.`roles` r, `project_management`.`permissions` p
WHERE
    r.name = 'admin';

-- Mostrar resumen de permisos asignados al administrador
SELECT 'Permisos totales en el sistema:' as info, COUNT(*) as total
FROM `project_management`.`permissions`
UNION ALL
SELECT 'Permisos del administrador:' as info, COUNT(*) as total
FROM `project_management`.`role_permissions` rp
    JOIN `project_management`.`roles` r ON rp.role_id = r.id
WHERE
    r.name = 'admin'
UNION ALL
SELECT 'Permisos faltantes del admin:' as info, (
        SELECT COUNT(*)
        FROM `project_management`.`permissions`
    ) - (
        SELECT COUNT(*)
        FROM `project_management`.`role_permissions` rp
            JOIN `project_management`.`roles` r ON rp.role_id = r.id
        WHERE
            r.name = 'admin'
    ) as total;

-- Mostrar permisos específicos del administrador (opcional)
SELECT p.name as permiso, p.description as descripcion
FROM `project_management`.`role_permissions` rp
    JOIN `project_management`.`roles` r ON rp.role_id = r.id
    JOIN `project_management`.`permissions` p ON rp.permission_id = p.id
WHERE
    r.name = 'admin'
ORDER BY p.name;