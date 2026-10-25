<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('titulo', 'Inventario') · {{ config('app.name') }}</title>
    <style>
        :root { --fondo:#f4f6f8; --tarjeta:#fff; --texto:#1f2933; --suave:#616e7c; --borde:#d9e2ec; --acento:#0b6e4f; --peligro:#b42318; }
        * { box-sizing: border-box; }
        body { margin:0; font-family: system-ui, -apple-system, "Segoe UI", sans-serif; background:var(--fondo); color:var(--texto); }
        header { background:#102a43; color:#fff; padding:14px 24px; display:flex; justify-content:space-between; align-items:center; }
        header a { color:#fff; text-decoration:none; font-weight:600; }
        header small { color:#9fb3c8; }
        main { max-width:1080px; margin:24px auto; padding:0 16px; }
        .tarjeta { background:var(--tarjeta); border:1px solid var(--borde); border-radius:8px; padding:20px; margin-bottom:16px; }
        .resumen { display:grid; grid-template-columns:repeat(auto-fit,minmax(180px,1fr)); gap:12px; margin-bottom:16px; }
        .resumen div { background:var(--tarjeta); border:1px solid var(--borde); border-radius:8px; padding:14px; }
        .resumen b { display:block; font-size:22px; }
        .resumen span { color:var(--suave); font-size:13px; }
        table { width:100%; border-collapse:collapse; }
        th, td { text-align:left; padding:10px 8px; border-bottom:1px solid var(--borde); font-size:14px; }
        th { color:var(--suave); font-weight:600; }
        td.num, th.num { text-align:right; }
        .btn { display:inline-block; padding:8px 14px; border-radius:6px; border:1px solid var(--borde); background:#fff; color:var(--texto); text-decoration:none; font-size:14px; cursor:pointer; }
        .btn.primario { background:var(--acento); border-color:var(--acento); color:#fff; }
        .btn.peligro { color:var(--peligro); border-color:var(--peligro); }
        .barra { display:flex; gap:8px; flex-wrap:wrap; align-items:center; margin-bottom:12px; }
        input, select, textarea { padding:8px; border:1px solid var(--borde); border-radius:6px; font:inherit; width:100%; }
        .barra input, .barra select { width:auto; }
        label { display:block; font-weight:600; margin:12px 0 4px; font-size:14px; }
        .campos { display:grid; grid-template-columns:repeat(auto-fit,minmax(220px,1fr)); gap:0 16px; }
        .aviso { background:#e3f9e5; border:1px solid #8bd89b; padding:10px 14px; border-radius:6px; margin-bottom:16px; }
        .error { color:var(--peligro); font-size:13px; }
        .etiqueta { font-size:12px; padding:2px 8px; border-radius:10px; background:#e6f0ff; }
        .agotado { background:#fde8e8; color:var(--peligro); }
        nav[role=navigation] { margin-top:12px; }
        footer { text-align:center; color:var(--suave); font-size:12px; padding:24px; }
    </style>
</head>
<body>
<header>
    <a href="{{ route('productos.index') }}">{{ config('app.name') }}</a>
    <small>PHP {{ PHP_VERSION }} · Laravel {{ app()->version() }} · MySQL · pod {{ gethostname() }}</small>
</header>
<main>
    @if (session('ok'))
        <div class="aviso">{{ session('ok') }}</div>
    @endif
    @yield('contenido')
</main>
<footer>PaaS multi-tenant · inquilino tenant-alpha</footer>
</body>
</html>
