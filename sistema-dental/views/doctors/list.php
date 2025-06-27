<?php
// views/doctors/list.php

$doctors         = $doctors         ?? [];
$specialties     = $specialties     ?? [];
$count           = count($doctors);
$doctorParam     = $doctor          ?? null;
$showDoctorModal = (bool)($showDoctorModal ?? false);

if (is_string($doctorParam)) {
    $doctor = json_decode(urldecode($doctorParam), true);
} else {
    $doctor = null;
}
?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid mt-4">

  <div class="d-flex align-items-center mb-3">
    <a href="?controller=dashboard&action=index" class="btn btn-light me-3">
      <img src="assets/img/arrow-left.png" width="16" class="me-1" alt="Volver">Volver
    </a>
    <button id="btnNewDoctor" class="btn btn-primary me-3">
      <img src="assets/img/doctor-plus.png" width="20" class="me-2 align-text-bottom" alt="Nuevo Médico">Nuevo Médico
    </button>
    <div class="input-group ms-auto" style="max-width:360px;">
      <input type="text" id="searchDoctor" class="form-control" placeholder="Buscar médico…">
      <button class="btn btn-success" id="btnSearchDoctor">
        <img src="assets/img/search.png" width="16" alt="Buscar">
      </button>
      <button class="btn btn-primary" id="btnRefreshDoctor">
        <img src="assets/img/refresh.png" width="16" alt="Recargar">
      </button>
    </div>
  </div>

  <div class="text-center mb-3">
    <span class="text-muted small">
      <?= $count ?> MÉDICO<?= $count !== 1 ? 'S' : '' ?> EN TOTAL
    </span>
  </div>

  <div class="table-responsive" style="border:1px dashed #6c757d; border-radius:5px; padding:1rem;">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-primary">
        <tr>
          <th style="width:60px;">#</th>
          <th>Nombres y Apellidos</th>
          <th>DNI</th>
          <th>Especialidad</th>
          <th>Dirección</th>
          <th>Email</th>
          <th>Teléfono</th>
          <th class="text-center" style="width:200px;">Opciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($doctors as $i => $d): ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td>
            <img src="<?= htmlspecialchars($d['avatar'] ?? 'assets/img/doctor.png') ?>"
                 width="32" class="me-1 rounded-circle align-middle" alt="Avatar">
            <?= htmlspecialchars($d['name']) ?>
          </td>
          <td><?= htmlspecialchars($d['dni'] ?? '') ?></td>
          <td class="text-uppercase"><?= htmlspecialchars($d['specialty_name'] ?? '') ?></td>
          <td><?= htmlspecialchars($d['address'] ?? '') ?></td>
          <td><?= htmlspecialchars($d['email'] ?? '') ?></td>
          <td><?= htmlspecialchars($d['phone'] ?? '') ?></td>
          <td class="text-center">
            <div class="btn-group">
              <button
                class="btn btn-sm btn-outline-primary btnEdit"
                data-doctor='<?= json_encode($d) ?>'
              >
                <img src="assets/img/pencil.png" width="16" class="me-1" alt="Editar">Editar
              </button>
              <a
                href="?controller=doctor&action=delete&id=<?= $d['id'] ?>"
                class="btn btn-sm btn-outline-danger"
                onclick="return confirm('¿Eliminar este médico?')"
              >
                <img src="assets/img/trash.png" width="16" class="me-1" alt="Eliminar">Eliminar
              </a>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>

        <?php if ($count === 0): ?>
        <tr>
          <td colspan="8" class="text-center text-muted py-4">
            No se encontraron médicos.
          </td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<?php include __DIR__ . '/form.php'; ?>

<script>
  function fillDoctorForm(d) {
    const parts = d.name.split(' ');
    document.querySelector('input[name="first_name"]').value = parts.shift() || '';
    document.querySelector('input[name="last_name"]').value  = parts.join(' ') || '';
    document.querySelector('input[name="dni"]').value         = d.dni || '';
    document.querySelector('select[name="specialty_id"]').value = d.specialty_id || '';
    document.querySelector('input[name="address"]').value     = d.address || '';
    document.querySelector('input[name="email"]').value       = d.email || '';
    document.querySelector('input[name="phone"]').value       = d.phone || '';
  }

  document.getElementById('btnNewDoctor').addEventListener('click', () => {
    const form = document.getElementById('doctorForm');
    form.reset();
    form.action = '?controller=doctor&action=store';
    document.getElementById('doctorModalTitle').innerText = 'Registro de Nuevo Médico';
    new bootstrap.Modal(document.getElementById('doctorModal')).show();
  });

  document.querySelectorAll('.btnEdit').forEach(btn => {
    btn.addEventListener('click', () => {
      const doctor = JSON.parse(btn.dataset.doctor);
      fillDoctorForm(doctor);
      const form = document.getElementById('doctorForm');
      form.action = '?controller=doctor&action=update&id=' + doctor.id;
      document.getElementById('doctorModalTitle').innerText = 'Editar Médico';
      new bootstrap.Modal(document.getElementById('doctorModal')).show();
    });
  });

  document.getElementById('btnSearchDoctor').addEventListener('click', () => {
    const term = document.getElementById('searchDoctor').value.toLowerCase();
    document.querySelectorAll('tbody tr').forEach(tr => {
      tr.style.display = tr.textContent.toLowerCase().includes(term) ? '' : 'none';
    });
  });
  document.getElementById('searchDoctor').addEventListener('keydown', e => {
    if (e.key === 'Enter') {
      e.preventDefault();
      document.getElementById('btnSearchDoctor').click();
    }
  });

  document.getElementById('btnRefreshDoctor').addEventListener('click', () => {
    window.location.reload();
  });

  <?php if (isset($_GET['error'])): ?>
    Swal.fire({ icon:'error', title:'¡Oops!', text:<?= json_encode(urldecode($_GET['error']))?> });
  <?php endif; ?>
  <?php if (isset($_GET['success'])): ?>
    Swal.fire({
      icon:'success',
      title:'¡Hecho!',
      text:<?= json_encode(urldecode($_GET['success']))?>,
      timer:2000,
      showConfirmButton:false
    });
  <?php endif; ?>
</script>
