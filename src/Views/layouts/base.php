<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Comunidades V3' ?></title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Configuración de Tailwind -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#00a8a9',
                        secondary: '#a30078',
                        danger: '#fa3966',
                        warning: '#ffc107',
                        info: '#2a345a',
                        success: '#00a8a9',
                    }
                }
            }
        }
    </script>

    <!-- Font Awesome para iconos -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Estilos adicionales -->
    <style>
        .form-input:focus {
            border-color: #00a8a9;
            box-shadow: 0 0 0 3px rgba(0, 168, 169, 0.1);
        }

        .btn-primary {
            background-color: #00a8a9;
            color: white;
            transition: all 0.2s;
        }

        .btn-primary:hover {
            background-color: #2a345a;
        }

        .btn-secondary {
            background-color: #a30078;
            color: white;
            transition: all 0.2s;
        }

        .btn-secondary:hover {
            background-color: #2a345a;
        }

        .alert-success {
            background: #e6f9f9;
            color: #008080;
            border-left: 5px solid #00a8a9;
        }

        .alert-danger {
            background: #ffe6ee;
            color: #a3002c;
            border-left: 5px solid #fa3966;
        }

        .alert-warning {
            background: #fff8e1;
            color: #a37c00;
            border-left: 5px solid #ffc107;
        }

        .alert-info {
            background: #e6eaf6;
            color: #2a345a;
            border-left: 5px solid #2a345a;
        }
    </style>
</head>

<body class="bg-[#f4f8ff] min-h-screen">
    <?php if (isset($content)): ?>
        <?= $content ?>
    <?php else: ?>
        <div class="container mx-auto px-4 py-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-4">Contenido no definido</h1>
        </div>
    <?php endif; ?>

    <!-- Scripts adicionales -->
    <script>
        // Función para mostrar/ocultar contraseñas
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);

            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Auto-hide alerts después de 5 segundos
        document.addEventListener('DOMContentLoaded', function() {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(function(alert) {
                setTimeout(function() {
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.remove();
                    }, 300);
                }, 5000);
            });
        });
    </script>
</body>

</html>