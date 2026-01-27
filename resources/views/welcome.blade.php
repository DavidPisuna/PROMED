<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PintuMed - Gestión Médica Digital</title>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">

  <style>
    :root {
      --primary: #0d6efd; /* El azul original solicitado */
      --secondary: #0a3d62;
      --accent: #00a8ff;
      --light: #f0f7ff;
      --dark: #1e272e;
    }

    * { font-family: 'Poppins', sans-serif; scroll-behavior: smooth; }

    /* --- NAVBAR --- */
    .navbar { 
      padding: 1rem 0; 
      background: #fff; 
      box-shadow: 0 2px 15px rgba(13, 110, 253, 0.1);
    }
    .navbar-brand { font-weight: 700; font-size: 1.7rem; color: var(--secondary); }
    .navbar-brand span { color: var(--primary); }

    .btn-ingresar {
      background: var(--primary);
      color: white;
      border-radius: 50px;
      padding: 10px 28px;
      font-weight: 600;
      text-decoration: none;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(13, 110, 253, 0.3);
      border: none;
    }

    .btn-ingresar:hover {
      background: var(--secondary);
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(13, 110, 253, 0.4);
    }

    /* --- HERO --- */
    .hero-section {
      padding: 150px 0 100px;
      background: linear-gradient(180deg, #fff 0%, var(--light) 100%);
    }
    .hero-title { font-size: 3.5rem; font-weight: 800; color: var(--secondary); line-height: 1.2; }
    .hero-title span { color: var(--primary); }
    
    .hero-img {
      border-radius: 30px;
      box-shadow: 20px 20px 60px rgba(0,0,0,0.1);
      border: 10px solid #fff;
    }

    /* --- FEATURES CARDS --- */
    .card-portal {
      border: none;
      border-radius: 25px;
      padding: 40px 30px;
      background: #fff;
      box-shadow: 0 10px 40px rgba(10, 61, 98, 0.05);
      transition: 0.4s;
      height: 100%;
    }

    .card-portal:hover {
      transform: translateY(-12px);
      box-shadow: 0 15px 45px rgba(13, 110, 253, 0.15);
    }

    .icon-box {
      width: 70px;
      height: 70px;
      background: var(--light);
      color: var(--primary);
      border-radius: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 2rem;
      margin-bottom: 25px;
      transition: 0.3s;
    }

    .card-portal:hover .icon-box {
      background: var(--primary);
      color: #fff;
    }

    /* --- INFO SECTION --- */
    .info-section { padding: 100px 0; }
    .badge-blue {
      background: var(--light);
      color: var(--primary);
      padding: 8px 20px;
      border-radius: 50px;
      font-weight: 600;
      display: inline-block;
      margin-bottom: 20px;
    }

    /* --- FOOTER --- */
    footer { background: var(--secondary); color: #fff; padding: 60px 0 30px; }
    .footer-link { color: rgba(255,255,255,0.7); text-decoration: none; transition: 0.3s; }
    .footer-link:hover { color: var(--accent); }

  </style>
</head>
<body>

  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container">
      <a class="navbar-brand" href="#"><i class="fas fa-file-medical me-2"></i><span>Pintu</span>Med</a>
      
      <div class="ms-auto">
        <a href="{{ route('login') }}" class="btn-ingresar">
          <i class="fas fa-sign-in-alt me-2"></i>INGRESAR
        </a>
      </div>
    </div>
  </nav>

  <header class="hero-section">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6">
          <div class="badge-blue">Gestión de Pacientes Centralizada</div>
          <h1 class="hero-title">Tu salud en <span>datos seguros.</span></h1>
          <p class="lead text-muted my-4">Acceda a su historial clínico digital, gestione sus citas médicas y consulte sus resultados de laboratorio desde cualquier lugar.</p>
          <div class="d-flex gap-3">
            <a href="#" class="btn btn-primary btn-lg rounded-pill px-5 fw-bold">Ver Mi Expediente</a>
            <a href="#servicios" class="btn btn-outline-primary btn-lg rounded-pill px-4">Más Servicios</a>
          </div>
        </div>
        <div class="col-lg-6 mt-5 mt-lg-0 text-center">
          <img src="https://images.unsplash.com/photo-1576091160550-2173dba999ef?auto=format&fit=crop&w=800&q=80" alt="Gestión Médica" class="hero-img img-fluid">
        </div>
      </div>
    </div>
  </header>

  <section id="servicios" class="info-section">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="fw-bold text-secondary">Nuestro Sistema de Atención</h2>
        <p class="text-muted">Herramientas digitales diseñadas para el cuidado integral del paciente.</p>
      </div>

      <div class="row g-4">
        <div class="col-md-4">
          <div class="card-portal text-center">
            <div class="icon-box mx-auto"><i class="fas fa-folder-open"></i></div>
            <h5 class="fw-bold text-secondary">Expediente Digital</h5>
            <p class="text-muted">Historial completo de consultas, diagnósticos y tratamientos previos siempre a su alcance.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card-portal text-center">
            <div class="icon-box mx-auto"><i class="fas fa-notes-medical"></i></div>
            <h5 class="fw-bold text-secondary">Resultados Online</h5>
            <p class="text-muted">Reciba y descargue sus resultados de laboratorio y estudios de imagen de forma inmediata.</p>
          </div>
        </div>
        <div class="col-md-4">
          <div class="card-portal text-center">
            <div class="icon-box mx-auto"><i class="fas fa-clock"></i></div>
            <h5 class="fw-bold text-secondary">Gestión de Citas</h5>
            <p class="text-muted">Programe sus visitas médicas y reciba recordatorios automáticos para nunca perder un control.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="py-5" style="background-color: var(--light);">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-lg-6 mb-4 mb-lg-0">
          <img src="https://images.unsplash.com/photo-1551076805-e1869033e561?auto=format&fit=crop&w=800&q=80" class="img-fluid rounded-4 shadow" alt="Doctor Digital">
        </div>
        <div class="col-lg-6 ps-lg-5">
          <h2 class="fw-bold text-secondary">Privacidad Garantizada</h2>
          <p class="text-muted">Sus datos médicos están protegidos bajo los más altos estándares de seguridad informática y confidencialidad.</p>
          <div class="mt-4">
            <div class="d-flex mb-3">
              <i class="fas fa-check-circle text-primary me-3 fa-lg"></i>
              <p class="mb-0">Acceso cifrado exclusivo para el paciente.</p>
            </div>
            <div class="d-flex mb-3">
              <i class="fas fa-check-circle text-primary me-3 fa-lg"></i>
              <p class="mb-0">Cumplimiento con normativas de protección de datos.</p>
            </div>
            <div class="d-flex">
              <i class="fas fa-check-circle text-primary me-3 fa-lg"></i>
              <p class="mb-0">Actualización en tiempo real de su información clínica.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="py-5 text-center text-white" style="background: linear-gradient(135deg, var(--primary), var(--secondary));">
    <div class="container py-5">
      <h2 class="fw-bold mb-4">¿Ya es paciente de PintuMed?</h2>
      <p class="lead mb-5 opacity-75">Ingrese a su portal personal para revisar sus datos médicos.</p>
      <a href="#" class="btn btn-light btn-lg rounded-pill px-5 py-3 fw-bold text-primary shadow-lg">
        <i class="fas fa-lock me-2"></i>INGRESAR AL SISTEMA
      </a>
    </div>
  </section>

  <footer>
    <div class="container">
      <div class="row g-4">
        <div class="col-md-6">
          <h3 class="fw-bold mb-3">PintuMed<span>.</span></h3>
          <p class="footer-link">Comprometidos con la tecnología al servicio de su salud y la integridad de sus datos.</p>
        </div>
        <div class="col-md-3">
          <h6 class="fw-bold mb-3">Enlaces</h6>
          <ul class="list-unstyled">
            <li><a href="#" class="footer-link">Inicio</a></li>
            <li><a href="#" class="footer-link">Portal Paciente</a></li>
            <li><a href="#" class="footer-link">Política de Privacidad</a></li>
          </ul>
        </div>
        <div class="col-md-3 text-md-end">
          <h6 class="fw-bold mb-3">Contacto</h6>
          <p class="small mb-1"><i class="fas fa-phone me-2"></i> +1 800-PINTUMED</p>
          <p class="small"><i class="fas fa-envelope me-2"></i> soporte@pintumed.com</p>
        </div>
      </div>
      <hr class="mt-5 opacity-25">
      <p class="text-center small mb-0 opacity-50">&copy; 2026 PintuMed - Todos los derechos reservados.</p>
    </div>
  </footer>

</body>
</html>