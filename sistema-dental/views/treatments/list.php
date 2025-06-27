<?php
// views/treatments/list.php
$treatments = $treatments ?? [];
$count      = count($treatments);
?>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container-fluid mt-4">

  <!-- Barra de acciones -->
  <div class="d-flex align-items-center mb-3">
    <a href="?controller=dashboard&action=index" class="btn btn-light me-3">
      <img src="assets/img/arrow-left.png" alt="Volver" width="16" class="me-1">
      Volver
    </a>

    <button id="btnNewTreatment" class="btn btn-primary me-3">
      <img src="assets/img/plus.png" alt="Nuevo Tratamiento" width="20" class="me-2 align-text-bottom">
      Nuevo Tratamiento
    </button>

    <div class="input-group ms-auto" style="max-width:360px;">
      <input
        type="text"
        id="searchTreatment"
        class="form-control"
        placeholder="Buscar Tratamientos..."
      >
      <button class="btn btn-success" id="btnSearchTreatment">
        <img src="assets/img/search.png" alt="Buscar" width="16">
      </button>
      <button class="btn btn-primary" id="btnRefreshTreatment">
        <img src="assets/img/refresh.png" alt="Recargar" width="16">
      </button>
    </div>
  </div>

  <!-- Conteo total -->
  <div class="text-center mb-3">
    <span class="text-muted small">
      <?= $count ?> TRATAMIENTO<?= $count !== 1 ? 'S' : '' ?> EN TOTAL
    </span>
  </div>

  <!-- Tabla -->
  <div class="table-responsive"
       style="border:1px dashed #6c757d; border-radius:5px; padding:1rem;">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-primary">
        <tr>
          <th style="width:60px;">#</th>
          <th>Tratamientos</th>
          <th class="text-center" style="width:120px;">Precio</th>
          <th class="text-center" style="width:200px;">Opciones</th>
          <th class="text-center" style="width:80px;">
            <label for="checkAllTreatments" class="form-label mb-0">Todo</label><br>
            <input type="checkbox" id="checkAllTreatments">
          </th>
        </tr>
      </thead>
      <tbody>
        <?php if ($count === 0): ?>
          <tr>
            <td colspan="5" class="text-center text-muted py-4">
              No hay tratamientos registrados.
            </td>
          </tr>
        <?php else: ?>
          <?php foreach ($treatments as $i => $tr): ?>
            <tr>
              <td><?= $i + 1 ?></td>
              <td><?= htmlspecialchars($tr['name']) ?></td>
              <td class="text-center"><?= number_format($tr['price'], 2) ?></td>
              <td class="text-center">
                <div class="btn-group" role="group">
                  <button
                    type="button"
                    class="btn btn-sm btn-outline-primary btnEdit"
                    data-tr='<?= json_encode($tr, JSON_HEX_APOS) ?>'
                  >
                    <img src="assets/img/pencil.png" alt="Editar" width="16" class="me-1">
                    Editar
                  </button>
                  <a
                    href="?controller=treatment&action=delete&id=<?= $tr['id'] ?>"
                    class="btn btn-sm btn-outline-danger"
                    onclick="return confirm('¿Eliminar este tratamiento?')"
                  >
                    <img src="assets/img/trash.png" alt="Eliminar" width="16" class="me-1">
                    Eliminar
                  </a>
                </div>
              </td>
              <td class="text-center">
                <input
                  type="checkbox"
                  name="ids[]"
                  value="<?= $tr['id'] ?>"
                  class="form-check-input select-treatment"
                >
              </td>
            </tr>
          <?php endforeach; ?>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal/Form -->
<?php include __DIR__ . '/form.php'; ?>

<script>
  // Rellena el modal para editar
  function fillForm(tr) {
    document.querySelector('#treatmentForm [name="name"]').value  = tr.name;
    document.querySelector('#treatmentForm [name="price"]').value = tr.price;
  }

  // Nuevo Tratamiento
  document.getElementById('btnNewTreatment').addEventListener('click', () => {
    const f = document.getElementById('treatmentForm');
    f.reset();
    f.action = '?controller=treatment&action=store';
    document.getElementById('treatmentModalTitle').innerText = 'Nuevo Tratamiento';
    new bootstrap.Modal(document.getElementById('treatmentModal')).show();
  });

  // Editar Tratamiento
  document.querySelectorAll('.btnEdit').forEach(btn => {
    btn.addEventListener('click', () => {
      const tr = JSON.parse(btn.getAttribute('data-tr'));
      fillForm(tr);
      const f = document.getElementById('treatmentForm');
      f.action = '?controller=treatment&action=update&id=' + tr.id;
      document.getElementById('treatmentModalTitle').innerText = 'Editar Tratamiento';
      new bootstrap.Modal(document.getElementById('treatmentModal')).show();
    });
  });

  // Buscar
  document.getElementById('btnSearchTreatment').addEventListener('click', () => {
    const term = document.getElementById('searchTreatment').value.toLowerCase();
    document.querySelectorAll('tbody tr').forEach(row => {
      row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
    });
  });
  document.getElementById('searchTreatment').addEventListener('keydown', e => {
    if (e.key === 'Enter') {
      e.preventDefault();
      document.getElementById('btnSearchTreatment').click();
    }
  });

  // Recargar
  document.getElementById('btnRefreshTreatment').addEventListener('click', () => {
    window.location.reload();
  });

  // Borrar múltiple
  const checkAll = document.getElementById('checkAllTreatments');
  const checks   = document.querySelectorAll('.select-treatment');
  checkAll.addEventListener('change', () => {
    checks.forEach(cb => cb.checked = checkAll.checked);
  });

  // SweetAlert2
  <?php if (isset($_GET['error'])): ?>
    Swal.fire({ icon: 'error', title: '¡Oops!', text: <?= json_encode(urldecode($_GET['error'])) ?> });
  <?php endif; ?>
  <?php if (isset($_GET['success'])): ?>
    Swal.fire({
      icon: 'success',
      title: '¡Hecho!',
      text: <?= json_encode(urldecode($_GET['success'])) ?>,
      timer: 1500,
      showConfirmButton: false
    });
  <?php endif; ?>
</script>
