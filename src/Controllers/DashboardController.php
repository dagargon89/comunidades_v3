<?php

namespace Src\Controllers;

class DashboardController
{
    public function index()
    {
        try {
            file_put_contents(__DIR__ . '/../../session_debug.txt', "DASHBOARD current_user: " . var_export(current_user(), true) . "\nSESSION: " . var_export($_SESSION, true) . "\n", FILE_APPEND);
            if (!is_authenticated()) {
                redirect('login');
            }
            $user = current_user();
            $title = 'Dashboard';
            ob_start();
            include __DIR__ . '/../Views/dashboard/index.php';
            $content = ob_get_clean();
            include __DIR__ . '/../Views/layouts/base.php';
        } catch (\Throwable $e) {
            file_put_contents(__DIR__ . '/../../session_debug.txt', "DASHBOARD ERROR: " . $e->getMessage() . "\nTRACE: " . $e->getTraceAsString() . "\n", FILE_APPEND);
            echo '<div style="color:red; font-weight:bold;">Ocurrió un error inesperado en el dashboard. Consulta al administrador.</div>';
            exit;
        }
    }
}
