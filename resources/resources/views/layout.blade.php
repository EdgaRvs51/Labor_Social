<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistema Administrativo | Labor Social')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --brand: #0b5d7a;
            --brand-dark: #08384b;
            --brand-soft: #e8f4f8;
            --surface: #ffffff;
            --ink: #17303b;
            --muted: #5d7280;
        }

        body {
            min-height: 100vh;
            color: var(--ink);
            font-family: "Trebuchet MS", "Tahoma", sans-serif;
            background:
                radial-gradient(circle at top left, rgba(241, 178, 74, 0.22), transparent 32%),
                linear-gradient(135deg, #f4f8fb 0%, #e7f0f4 48%, #dce8ee 100%);
        }

        .auth-shell {
            min-height: 100vh;
            padding: 2rem 0;
        }

        .auth-card {
            border: 0;
            overflow: hidden;
            border-radius: 1.25rem;
            box-shadow: 0 22px 60px rgba(8, 56, 75, 0.16);
        }

        .brand-panel {
            height: 100%;
            color: #ffffff;
            padding: 2.5rem;
            background: linear-gradient(160deg, var(--brand-dark) 0%, var(--brand) 70%, #1492b7 100%);
        }

        .brand-panel small {
            letter-spacing: 0.18em;
            text-transform: uppercase;
            opacity: 0.8;
        }

        .brand-panel h1 {
            margin: 1rem 0;
            font-size: clamp(1.9rem, 4vw, 2.7rem);
        }

        .brand-panel p {
            color: rgba(255, 255, 255, 0.84);
        }

        .soft-badge {
            display: inline-flex;
            gap: 0.5rem;
            align-items: center;
            padding: 0.45rem 0.9rem;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 999px;
            background: rgba(255, 255, 255, 0.14);
        }

        .form-panel {
            padding: 2.5rem;
            background: var(--surface);
        }

        .form-control,
        .form-select {
            padding: 0.8rem 1rem;
            border-color: #cfdae1;
            border-radius: 0.85rem;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--brand);
            box-shadow: 0 0 0 0.25rem rgba(11, 93, 122, 0.15);
        }

        .btn-brand {
            border: 0;
            color: #ffffff;
            font-weight: 700;
            padding: 0.85rem 1rem;
            border-radius: 0.9rem;
            background: linear-gradient(135deg, var(--brand) 0%, #137da0 100%);
        }

        .btn-brand:hover {
            color: #ffffff;
            background: linear-gradient(135deg, #094b63 0%, #116985 100%);
        }

        .dashboard-nav {
            background: linear-gradient(135deg, var(--brand-dark), var(--brand));
        }

        .dashboard-card {
            border: 0;
            border-radius: 1rem;
            box-shadow: 0 18px 40px rgba(8, 56, 75, 0.1);
        }

        .metric-icon {
            width: 3rem;
            height: 3rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: var(--brand);
            font-weight: 700;
            border-radius: 0.9rem;
            background: var(--brand-soft);
        }

        .text-muted-soft {
            color: var(--muted);
        }

        a {
            color: var(--brand);
        }

        @media (max-width: 991.98px) {
            .brand-panel,
            .form-panel {
                padding: 2rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body class="@yield('body_class')">
    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
