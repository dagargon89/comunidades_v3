# RECORDATORIO IMPORTANTE: REACTIVAR PERMISOS

Actualmente, la lógica de permisos y roles está DESACTIVADA temporalmente para facilitar el desarrollo y las pruebas.

Antes de finalizar el proyecto y pasar a producción, es OBLIGATORIO:

1. Restaurar la lógica original de permisos en:

   - `src/Models/User.php` → método `hasPermission`
   - `src/Core/Auth.php` → método `hasPermission` (si aplica)

2. Verificar que los roles y permisos estén correctamente asignados a los usuarios.
3. Probar que las restricciones de acceso funcionen según lo esperado en todas las secciones.

**NO OLVIDAR:**

- Si los permisos quedan desactivados, cualquier usuario podrá acceder a todas las funciones del sistema.
- Eliminar este archivo cuando el sistema esté seguro.

---

_¡No pasar a producción sin reactivar los permisos!_
