<!doctype html>
<html lang="es" dir="ltr">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Acceso restringido</title>
  <meta name="description" content="Acceso denegado: Debes iniciar sesión para continuar." />
  <style>
    :root {
      --color-1: #0726D9;
      --color-2: #031240;
      --color-3: #1760BF;
      --color-4: #3D9DF2;
      --color-5: #52C5F2;
      --bg: linear-gradient(180deg, #030E33 0%, #020B29 100%);
    }

    * { box-sizing: border-box; }
    html, body { height: 100%; }
    body {
      margin: 0;
      color: #EAF1FF;
      background: var(--bg);
      font: 16px/1.5 system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, Noto Sans, "Helvetica Neue", Arial;
      display: grid;
      place-items: center;
    }

    .card {
      text-align: center;
      background: linear-gradient(180deg, rgba(3,12,56,0.75), rgba(3,12,56,0.55));
      border: 1px solid rgba(82,197,242,0.25);
      border-radius: 24px;
      padding: 40px;
      box-shadow: 0 10px 40px rgba(7,38,217,0.25);
      max-width: 600px;
    }

    .code {
      font-size: clamp(64px, 16vw, 140px);
      font-weight: 800;
      margin: 0;
      background: conic-gradient(from 120deg,
                  var(--color-5), var(--color-4), var(--color-3), var(--color-1), var(--color-4));
      background-size: 200% 200%;
      -webkit-background-clip: text;
      background-clip: text;
      color: transparent;
      animation: sheen 8s ease-in-out infinite;
      text-shadow: 0 8px 30px rgba(7,38,217,0.35);
    }

    @keyframes sheen { 0%,100%{ background-position: 0% 50% } 50%{ background-position: 100% 50% } }

    h1 {
      margin: 0 0 12px;
      font-size: 24px;
    }
    p { margin: 0 0 24px; color: #C7D6FF; }

    .actions { display: flex; justify-content: center; gap: 12px; flex-wrap: wrap; }

    .btn {
      --bg: var(--color-1);
      --fg: white;
      display: inline-flex; align-items: center; gap: 10px;
      padding: 12px 18px; border-radius: 14px; border: 0;
      background: var(--bg);
      color: var(--fg); font-weight: 700; cursor: pointer;
      text-decoration: none;
      transition: transform .12s ease;
    }
    .btn:hover { transform: translateY(-2px); }

    .btn.secondary {
      --bg: #0B1B57;
      --fg: #EAF1FF;
      border: 1px solid rgba(82,197,242,0.35);
    }

    .mini {
      margin-top: 20px;
      font-size: 12px;
      color: #9FB6FF;
    }

    @media (prefers-reduced-motion: reduce) {
      .code { animation: none; }
    }
  </style>
</head>
<body>
  <main class="card" role="main">
    <h2 class="code">401</h2>
    <h1>Acceso restringido</h1>
    <p>Debes iniciar sesión para acceder a esta página.</p>

    <div class="actions">
      <a href="/login" class="btn">Iniciar sesión</a>
      <a href="/" class="btn secondary">Ir al inicio</a>
    </div>

    <div class="mini">Pulsa <kbd>Esc</kbd> para ir al inicio</div>
  </main>

  <script>
    window.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') window.location.assign('/');
    });
  </script>
</body>
</html>
