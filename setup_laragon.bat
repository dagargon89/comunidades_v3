@echo off
echo ========================================
echo Configuracion Automatica de Laragon
echo ========================================
echo.

echo Verificando que Laragon este instalado...
if not exist "C:\laragon\bin\apache\httpd.exe" (
    echo ERROR: Laragon no encontrado en C:\laragon
    echo Por favor, instala Laragon primero
    pause
    exit /b 1
)

echo Laragon encontrado. Configurando...

echo.
echo 1. Deteniendo Apache...
taskkill /f /im httpd.exe 2>nul
timeout /t 2 /nobreak >nul

echo.
echo 2. Configurando DocumentRoot...
set APACHE_CONF=C:\laragon\bin\apache\httpd-2.4.62-win64-VS16\conf\httpd.conf

if not exist "%APACHE_CONF%" (
    echo ERROR: Archivo de configuracion de Apache no encontrado
    echo Buscando archivo de configuracion...
    for /r "C:\laragon\bin\apache" %%i in (httpd.conf) do (
        set APACHE_CONF=%%i
        goto :found_conf
    )
    echo ERROR: No se pudo encontrar httpd.conf
    pause
    exit /b 1
)

:found_conf
echo Archivo de configuracion encontrado: %APACHE_CONF%

echo.
echo 3. Creando backup de la configuracion...
copy "%APACHE_CONF%" "%APACHE_CONF%.backup" >nul

echo.
echo 4. Configurando DocumentRoot para el proyecto...
powershell -Command "(Get-Content '%APACHE_CONF%') -replace 'DocumentRoot \"C:/laragon/www\"', 'DocumentRoot \"C:/laragon/www/comunidades_v3/public\"' | Set-Content '%APACHE_CONF%'"

echo.
echo 5. Verificando que mod_rewrite este habilitado...
findstr /C:"mod_rewrite" "%APACHE_CONF%" >nul
if errorlevel 1 (
    echo ADVERTENCIA: mod_rewrite no encontrado en la configuracion
    echo Es posible que necesites habilitarlo manualmente
) else (
    echo mod_rewrite encontrado en la configuracion
)

echo.
echo 6. Iniciando Apache...
start "" "C:\laragon\bin\apache\httpd.exe"

echo.
echo 7. Esperando que Apache inicie...
timeout /t 3 /nobreak >nul

echo.
echo ========================================
echo Configuracion completada!
echo ========================================
echo.
echo Ahora puedes acceder a:
echo http://comunidades_v3.test/
echo.
echo Si tienes problemas, verifica:
echo 1. Que el dominio comunidades_v3.test este en tu archivo hosts
echo 2. Que Laragon este ejecutandose
echo 3. Que Apache este iniciado
echo.
echo Para verificar la configuracion, accede a:
echo http://comunidades_v3.test/laragon_config_check.php
echo.
pause 