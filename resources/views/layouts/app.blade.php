<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>@yield('title', 'Mi aplicación')</title>

  {{-- Bootstrap (CDN) --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

   {{-- Bootstrap Icons --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">


  <style>
    :root {
      --brand-blue: #174c9bff;
      --band-height: 70px; 
      --footer-bg: #0f2140;
      --footer-text: #e9eef7;
      --footer-accent: linear-gradient(90deg, #0ea5e9, #22c55e, #a855f7);

      /* === SUB-NAVBAR (tokens) === */
      --subnav-bg-strong: #103775;   /* azul intenso */
      --subnav-border: #0c2855;
    }

    html, body {
      height: 100%;
      margin: 0;
    }

    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f8f9fa;
    }

    /* Franjas azules */
    .top-band, .bottom-band {
      background-color: var(--brand-blue);
      height: var(--band-height);
      width: 100%;
      flex-shrink: 0;
      position: relative;
      color: #fff;
    }

    /* === HEADER (FLEXBOX) === */
    .top-band {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    /* Logo */
    .top-band img {
      position: static;
      transform: none;
      height: 50px; 
      object-fit: contain;
      margin-right: 15px;
    }

    /* Título */
    .top-title {
      position: static;
      transform: none;
      color: #ffffff;
      font-size: 1.4rem;      
      font-weight: 600;
      text-align: left;
      white-space: nowrap;
    }

    /* Botón de login */
    .login-btn {
      position: absolute;
      top: 50%;
      right: 30px;
      transform: translateY(-50%);
      padding: 0.25rem 0.75rem;
      font-size: 0.9rem;
    }
    /* ============================================ */


    main {
      flex-grow: 1;
      padding: 2rem;
    }

    /* === Footer === */
    footer {
      background: var(--footer-bg);
      color: var(--footer-text);
      margin-top: 2rem;
    }

    .footer-accent {
      height: 6px;
      background: var(--footer-accent);
    }

    .footer-title {
      text-transform: uppercase;
      font-weight: 700;
      margin-bottom: .75rem;
      color: #ffffff;
    }

    .footer-link {
      color: #d7e3ff;
      text-decoration: underline;
      text-underline-offset: 2px;
    }

    .footer-link:hover {
      color: #ffffff;
    }

    .footer-btn {
      background: rgba(255,255,255,.1);
      color: #ffffff;
      border: 1px solid rgba(255,255,255,.2);
      border-radius: .75rem;
      padding: .6rem .9rem;
      backdrop-filter: blur(4px);
      transition: all .2s ease;
    }

    .footer-btn:hover {
      background: rgba(255,255,255,.18);
      transform: translateY(-1px);
      color: #fff;
    }

    .map-wrapper {
      border: 1px solid rgba(255,255,255,.12);
    }

    .footer-bottom {
      background: linear-gradient(0deg, rgba(255,255,255,.04), rgba(255,255,255,0));
      border-top: 1px solid rgba(255,255,255,.12);
    }

    /* === SUB-NAVBAR AZUL INTENSO === */
    .subnav {
      background-color: var(--subnav-bg-strong);
      border-bottom: 2px solid var(--subnav-border);
    }
    .subnav .container {
      display: flex;
      justify-content: flex-start;
      align-items: center;
      padding-left: 0;
    }
    .subnav .nav {
      margin: 0;
      padding-left: 0;
      gap: 0;
      flex-wrap: nowrap;
      overflow-x: auto;
      width: 100%; 
    }
    .subnav .nav-item { margin: 0; }
    .subnav .nav-link {
      color: #ffffff;
      font-weight: 600;
      background-color: var(--subnav-bg-strong);
      border: none;
      border-radius: 0;
      padding: .8rem 1.4rem;
      transition: background-color .2s ease;
      white-space: nowrap;
    }
    .subnav .nav-link:hover {
      background-color: #0d2c5e;
      color: #ffffff;
    }
    .subnav .nav-link.active {
      background-color: #0a1f45;
      color: #ffffff;
      box-shadow: inset 0 -3px 0 #00c4ff;
    }

/* Contenedor de la foto */
.foto-container {
    position: relative;
    width: fit-content;
    margin: 0 auto; /* Centrar */
}

/* Imagen de perfil */
.profile-img {
    width: 160px;
    height: 160px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #fff;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    display: block;
}

/* Botón de editar (lápiz) */
.btn-edit-foto {
    position: absolute;
    bottom: 10px;
    right: 10px;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    background-color: #0d6efd;
    color: white;
    border: 2px solid white;
    display: flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    transition: all 0.2s ease;
    box-shadow: 0 2px 5px rgba(0,0,0,0.2);
    z-index: 10;
}

.btn-edit-foto:hover {
    background-color: #0b5ed7;
    transform: scale(1.1);
    color: white;

}
</style>
</head>

<body>
  {{-- Franja azul superior --}}
  <div class="top-band">
    <img src="{{ asset('images/LITP.png') }}" alt="Logo">

    {{-- CAMBIO: El título ahora está FUERA del @if para verse siempre --}}
    <div class="top-title">Control de Tutorías ITP</div>

    {{-- El botón "Iniciar sesión" SOLO se ve en la página principal --}}
    @if (Route::currentRouteName() === 'pagina')
      <a href="{{ route('login') }}" class="btn btn-light login-btn">Iniciar sesión</a>
    @endif
  </div>

  {{-- Sub-navbar (aparece solo si la vista define @section('subnav')) --}}
  @hasSection('subnav')
    <nav class="subnav">
      <div class="container">
        <ul class="nav">
          @yield('subnav')
        </ul>
      </div>
    </nav>
  @endif

  {{-- Contenido principal --}}
  <main class="container text-center">
    @yield('content')
  </main>

  {{-- Footer bonito --}}
  <footer class="site-footer text-light">
    <div class="footer-accent"></div>

    <div class="container py-5">
      <div class="row gy-4 align-items-start">
        <!-- Dirección -->
        <div class="col-12 col-md-5">
          <h6 class="footer-title">Dirección</h6>
          <address class="mb-3 opacity-75">
            Carretera México - Pachuca Km. 87.5,<br>
            C.P. 42080, Colonia Venta Prieta,<br>
            Pachuca de Soto, Hidalgo, México.
          </address>

          <h6 class="footer-title">Contacto</h6>
          <p class="mb-1 opacity-75">
            Email: <a class="footer-link" href="mailto:web_pachuca@tecnm.mx">web_pachuca@tecnm.mx</a>
          </p>

          <h6 class="footer-title mt-3">Teléfonos</h6>
          <ul class="list-unstyled mb-0 opacity-75">
            <li>771 711 3073</li>
            <li>771 711 3596</li>
            <li>771 711 5119</li>
            <li>771 711 3399</li>
          </ul>
        </div>

        <!-- Mapa -->
        <div class="col-12 col-md-4">
          <h6 class="footer-title">Ubicación</h6>
          <div class="map-wrapper rounded-3 overflow-hidden shadow-sm">
            <div class="ratio ratio-4x3">
              <iframe
                src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d1873.6068714317553!2d-98.773695!3d20.08335!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d1a1d7c0f1cfa3%3A0x122870c3429e18a8!2sInstituto%20Tecnol%C3%B3gico%20de%20Pachuca%20(ITP)!5e0!3m2!1ses!2smx!4v1748589706571!5m2!1ses!2smx"
                loading="lazy" referrerpolicy="no-referrer-when-downgrade" allowfullscreen>
              </iframe>
            </div>
          </div>
        </div>

        <!-- Redes sociales -->
        <div class="col-12 col-md-3">
          <h6 class="footer-title">Redes Sociales</h6>
          <div class="d-grid gap-2">
            <a href="https://itp.itpachuca.edu.mx/" target="_blank" class="btn footer-btn">⚙️ ITPachuca.com</a>
            <a href="https://www.facebook.com/profile.php?id=61557528505129" target="_blank" class="btn footer-btn">📘 Facebook</a>
            <a href="https://x.com/tecnmpachuca" target="_blank" class="btn footer-btn">🐦 X (Twitter)</a>
            <a href="https://www.youtube.com/@TecNMCampusPachuca" target="_blank" class="btn footer-btn">▶️ YouTube</a>
          </div>

          <div class="mt-4 small opacity-75">
            <span class="me-1">Número de visitas:</span>
            <strong id="visitCounter">—</strong>
          </div>
        </div>
      </div>
    </div>

    <!-- Franja inferior -->
    <div class="footer-bottom py-3">
      <div class="container d-flex flex-column justify-content-center align-items-center gap-2">
        <span class="small opacity-75">© <span id="year"></span> TecNM Campus Pachuca — Todos los derechos reservados.</span>
      </div>
    </div>
  </footer>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <script>
    // Año actual
    document.getElementById('year').textContent = new Date().getFullYear();

    // Contador de visitas local
    try {
      const key = 'itp_footer_visits';
      const current = parseInt(localStorage.getItem(key) || '0', 10) + 1;
      localStorage.setItem(key, current);
      document.getElementById('visitCounter').textContent = current.toLocaleString('es-MX');
    } catch (e) {
      document.getElementById('visitCounter').textContent = '—';
    }
  </script>
</body>
</html>