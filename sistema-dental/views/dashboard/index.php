<?php // views/dashboard/index.php ?>

<div class="container mt-4">
  <div class="alert alert-light">
    <strong>Hola <?= htmlspecialchars($_SESSION['user']['username']) ?></strong>, bienvenido(a) al sistema.
  </div>

  <div class="row gy-4">
    <?php
      $modules = [
        ['Usuarios',        'user&action=index',        'users.png'],
        ['Pacientes',       'patient&action=index',     'patients.png'],
        ['Especialidades',  'specialty&action=index',   'specialties.png'],
        ['Médicos',         'doctor&action=index',      'doctors.png'],
        ['Tratamientos',    'treatment&action=index',   'treatments.png'],
        ['Citas',           'appointment&action=index', 'appointments.png'],
        ['Odontograma',     'odontogram&action=index',  'odontogram.png'],
        ['Historial Citas', 'history&action=index',     'history.png'],
        ['Calendario',      'calendar&action=index',    'calendar.png'],
        ['Pagos',           'payment&action=index',     'payments.png'],
        ['Reportes',        'report&action=index',      'reports.png'],
        // <- Aquí cambiamos dashboard por summary
        ['Resumen',         'summary&action=index',     'dashboard.png'],
      ];

      foreach ($modules as [$label, $route, $icon]) : ?>
      <div class="col-6 col-md-4 col-lg-3">
        <a href="?controller=<?= $route ?>"
           class="card text-center h-100 text-decoration-none">
          <div class="card-body d-flex flex-column align-items-center justify-content-center py-4">
            <img 
              src="assets/img/<?= $icon ?>" 
              alt="<?= $label ?>" 
              style="width:64px;height:64px;" 
            >
            <h6 class="card-title mt-2"><?= $label ?></h6>
          </div>
        </a>
      </div>
    <?php endforeach; ?>
  </div>
</div>
