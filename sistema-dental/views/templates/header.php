<!DOCTYPE html>
<html lang="es">
<head>
  <link
  href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
  rel="stylesheet"
>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
<link href="assets/css/style.css" rel="stylesheet">
  <meta charset="UTF-8">
  <title>Sistema Dental</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Google Font Poppins -->
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap"
    rel="stylesheet"
  >
  <!-- Bootstrap 5 CSS -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
  <!-- Bootstrap Icons -->
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css"
    rel="stylesheet"
  >
  <!-- Tu CSS -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<?php
  // session_start() debe ir en tu BaseController
  $role     = $_SESSION['user']['role']     ?? '';
  $username = htmlspecialchars($_SESSION['user']['username'] ?? 'Usuario');
?>
<nav
  class="navbar navbar-expand-lg navbar-dark"
  style="
    background: linear-gradient(90deg, #1e3c72, #2a5298);
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
    position: sticky;
    top: 0;
    z-index: 1000;
  "
>
  <div class="container-fluid">
    <a class="navbar-brand fw-semibold" href="?controller=dashboard&action=index">
      <img src="assets/img/logo.png" alt="Logo" width="32" class="me-2">
      DentalApp
    </a>
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#mainNav"
      aria-controls="mainNav"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <!-- Inicio -->
        <li class="nav-item">
          <a class="nav-link" href="?controller=dashboard&action=index">
            <i class="bi bi-house-fill me-1"></i>Inicio
          </a>
        </li>

        <!-- Mantenimiento -->
        <li class="nav-item dropdown">
          <a
            class="nav-link dropdown-toggle"
            href="#"
            id="maintDropdown"
            role="button"
            data-bs-toggle="dropdown"
            aria-expanded="false"
          >
            <i class="bi bi-tools me-1"></i>Mantenimiento
          </a>
          <ul class="dropdown-menu" aria-labelledby="maintDropdown">
            <li>
              <a class="dropdown-item" href="?controller=user&action=index">
                <i class="bi bi-people-fill me-1"></i>Usuarios
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="?controller=specialty&action=index">
                <i class="bi bi-globe me-1"></i>Especialidades
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="?controller=doctor&action=index">
                <i class="bi bi-person-badge-fill me-1"></i>Médicos
              </a>
            </li>
            <li>
              <a class="dropdown-item" href="?controller=treatment&action=index">
                <i class="bi bi-bandaid-fill me-1"></i>Tratamientos
              </a>
            </li>
          </ul>
        </li>

        <!-- Citas -->
        <li class="nav-item">
          <a class="nav-link" href="?controller=appointment&action=index">
            <i class="bi bi-calendar-check me-1"></i>Citas
          </a>
        </li>

        <!-- Historial Citas -->
        <li class="nav-item">
          <a class="nav-link" href="?controller=history&action=index">
            <i class="bi bi-clock-history me-1"></i>Historial Citas
          </a>
        </li>

        <!-- Calendario -->
        <li class="nav-item">
          <a class="nav-link" href="?controller=calendar&action=index">
            <i class="bi bi-calendar-event me-1"></i>Calendario
          </a>
        </li>
      </ul>

      <?php if ($username): ?>
      <ul class="navbar-nav ms-auto">
        <!-- Dropdown del usuario -->
        <li class="nav-item dropdown">
          <a
            class="nav-link dropdown-toggle"
            href="#"
            id="userDropdown"
            role="button"
            data-bs-toggle="dropdown"
            aria-expanded="false"
          >
            <i class="bi bi-person-circle me-1"></i><?= $username ?>
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
            <li>
              <a class="dropdown-item" href="?controller=setting&action=index">
                <i class="bi bi-gear-fill me-1"></i>Configuración
              </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
              <a class="dropdown-item" href="?controller=auth&action=logout">
                <i class="bi bi-box-arrow-right me-1"></i>Cerrar Sesión
              </a>
            </li>
          </ul>
        </li>
      </ul>
      <?php endif; ?>
    </div>
  </div>
</nav>
