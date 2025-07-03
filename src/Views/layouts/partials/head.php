<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Comunidades V3' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --color-primary: #00a8a9;
            --color-secondary: #a30078;
            --color-danger: #fa3966;
            --color-warning: #ffc107;
            --color-info: #2a345a;
            --color-success: #00a8a9;
            --color-bg: #f4f8ff;
            --color-sidebar: #222b45;
            --color-topbar: #fff;
            --color-card: #fff;
            --color-text: #222b45;
            --color-muted: #8f9bb3;
            --color-separator: #e4e9f2;
        }

        body {
            background: var(--color-bg);
            color: var(--color-text);
            font-family: 'Inter', 'Segoe UI', Arial, sans-serif;
            transition: background 0.3s, color 0.3s;
        }

        .sidebar {
            background: var(--color-sidebar);
            color: #fff;
            border-right: 1px solid var(--color-separator);
            transition: background 0.3s, color 0.3s;
        }

        .sidebar .logo {
            font-size: 1.5rem;
            font-weight: bold;
            letter-spacing: 1px;
            color: var(--color-primary);
        }

        .sidebar nav ul {
            margin-top: 2rem;
        }

        .sidebar a {
            color: #fff;
            opacity: 0.85;
            font-weight: 500;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: background 0.2s, color 0.2s, opacity 0.2s;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: var(--color-primary);
            color: #fff !important;
            opacity: 1;
        }

        .sidebar .separator {
            height: 1px;
            background: var(--color-separator);
            margin: 1.5rem 0;
        }

        .topbar {
            background: var(--color-topbar);
            color: var(--color-text);
            border-bottom: 1px solid var(--color-separator);
            transition: background 0.3s, color 0.3s;
        }

        .topbar .user-btn {
            background: var(--color-primary);
            color: #fff;
            font-weight: 600;
            border-radius: 0.5rem;
            padding: 0.5rem 1rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: background 0.2s;
        }

        .topbar .user-btn:hover {
            background: #007c7d;
        }

        .card {
            background: var(--color-card);
            color: var(--color-text);
            border-radius: 1.25rem;
            box-shadow: 0 4px 24px 0 rgba(34, 43, 69, 0.08);
            padding: 2.5rem;
            margin-top: 3rem;
            transition: background 0.3s, color 0.3s;
        }

        .btn-secondary {
            background: var(--color-secondary);
            color: #fff;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: background 0.2s;
        }

        .btn-secondary:hover {
            background: #7a005a;
        }
    </style>
</head>