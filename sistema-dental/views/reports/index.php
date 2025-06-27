<?php require __DIR__ . '/../templates/header.php'; ?>

<div class="container mt-4">
  <div class="card">
    <div class="card-header">
      Opciones de Reporte
    </div>
    <div class="card-body">
      <div class="row gx-3 gy-3">
        <!-- Inicio -->
        <div class="col-md-4">
          <a href="?controller=dashboard&action=index"
             class="d-block p-4 border rounded text-center text-decoration-none">
            <img src="assets/img/arrow-left.png"
                 alt="Inicio"
                 style="width:48px;">
            <div class="mt-2 fw-semibold">Inicio</div>
          </a>
        </div>
        <!-- Pacientes -->
        <div class="col-md-4">
          <a href="?controller=report&action=patients"
             class="d-block p-4 border rounded text-center text-decoration-none">
            <img src="assets/img/patients.png"
                 alt="Pacientes"
                 style="width:48px;">
            <div class="mt-2 fw-semibold">Pacientes</div>
          </a>
        </div>
        <!-- Médicos -->
        <div class="col-md-4">
          <a href="?controller=report&action=doctors"
             class="d-block p-4 border rounded text-center text-decoration-none">
            <img src="assets/img/doctor-plus.png"
                 alt="Médicos"
                 style="width:48px;">
            <div class="mt-2 fw-semibold">Médicos</div>
          </a>
        </div>
      </div>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../templates/footer.php'; ?>
