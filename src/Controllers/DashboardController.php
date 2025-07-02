<?php

namespace Controllers;

class DashboardController
{
    public function index()
    {
        if (!is_authenticated()) {
            redirect('login');
        }
        $user = current_user();
        $title = 'Dashboard';
        ob_start();
        include __DIR__ . '/../Views/dashboard/index.php';
        $content = ob_get_clean();
        include __DIR__ . '/../Views/layouts/base.php';
    }
}
