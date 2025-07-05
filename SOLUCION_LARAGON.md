# Solución para el Error "Not Found" en Laragon

## Problema
Cuando clonas el proyecto `comunidades_v3` en un nuevo equipo con Laragon, aparece el error "Not Found" al intentar acceder al login.

## Causa del Problema
Laragon está configurado con el documento raíz en la carpeta principal del proyecto (`C:/laragon/www/comunidades_v3`) en lugar de la carpeta `public`.

## Soluciones

### Solución 1: Configurar Laragon Correctamente (Recomendada)

1. **Abrir Laragon**
2. **Ir a Menu > www**
3. **Buscar el proyecto `comunidades_v3`**
4. **Hacer clic derecho en la carpeta `public`**
5. **Seleccionar "Set as Document Root"**
6. **Reiniciar Apache** (botón "Stop" y luego "Start")

### Solución 2: Usar el Servidor de Desarrollo de PHP

Si no puedes cambiar la configuración de Laragon:

1. **Abrir terminal/cmd**
2. **Navegar al proyecto:**
   ```bash
   cd C:\laragon\www\comunidades_v3\public
   ```
3. **Iniciar servidor de desarrollo:**
   ```bash
   php -S localhost:8000
   ```
4. **Acceder a:** `http://localhost:8000`

### Solución 3: Configuración Manual de Apache

1. **Abrir Laragon**
2. **Ir a Menu > Apache > httpd.conf**
3. **Buscar la línea que define DocumentRoot**
4. **Cambiar de:**
   ```apache
   DocumentRoot "C:/laragon/www/comunidades_v3"
   ```
   **A:**
   ```apache
   DocumentRoot "C:/laragon/www/comunidades_v3/public"
   ```
5. **Reiniciar Apache**

### Solución 4: Usar Virtual Host (Más Profesional)

1. **Abrir Laragon**
2. **Ir a Menu > Apache > sites-enabled**
3. **Crear archivo `comunidades_v3.conf`:**
   ```apache
   <VirtualHost *:80>
       ServerName comunidades_v3.test
       DocumentRoot "C:/laragon/www/comunidades_v3/public"
       <Directory "C:/laragon/www/comunidades_v3/public">
           AllowOverride All
           Require all granted
       </Directory>
   </VirtualHost>
   ```
4. **Reiniciar Apache**

## Verificación

Después de aplicar cualquiera de las soluciones:

1. **Acceder a:** `http://comunidades_v3.test/`
2. **Debería redirigir automáticamente a:** `http://comunidades_v3.test/login`
3. **Ver la página de login del sistema**

## Archivos de Diagnóstico

- `laragon_config_check.php` - Verifica la configuración del servidor
- `test_redirect.php` - Prueba las redirecciones
- `session_debug.txt` - Logs de depuración

## Comandos Útiles

```bash
# Verificar que PHP está funcionando
php -v

# Verificar que Apache está funcionando
curl -I http://localhost

# Verificar la configuración de Apache
httpd -t
```

## Notas Importantes

- **mod_rewrite debe estar habilitado** en Apache
- **Los archivos .htaccess deben tener permisos de lectura**
- **El proyecto debe estar en la carpeta correcta:** `C:/laragon/www/comunidades_v3/`

## Si Nada Funciona

1. **Reinstalar Laragon**
2. **Verificar que no hay conflictos de puertos**
3. **Verificar que el firewall no está bloqueando**
4. **Usar XAMPP o WAMP como alternativa** 