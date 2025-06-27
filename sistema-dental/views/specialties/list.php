<?php
// views/specialties/list.php
$specialties = $specialties ?? [];
$count       = count($specialties);
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

    <a href="?controller=specialty&action=create" class="btn btn-primary me-3">
      <img
        src="assets/img/briefcase-plus.png"
        alt="Nueva Especialidad"
        width="20"
        class="me-2 align-text-bottom"
      >
      Nueva Especialidad
    </a>

    <div class="input-group ms-auto" style="max-width:360px;">
      <input
        type="text"
        id="searchSpecialty"
        class="form-control"
        placeholder="Buscar especialidad..."
      >
      <button class="btn btn-success" id="btnSearchSpecialty">
        <img src="assets/img/search.png" alt="Buscar" width="16">
      </button>
      <button class="btn btn-primary" id="btnRefreshSpecialty">
        <img src="assets/img/refresh.png" alt="Recargar" width="16">
      </button>
    </div>
  </div>

  <!-- Conteo total -->
  <div class="text-center mb-3">
    <span class="text-muted small">
      <?= $count ?> ESPECIALIDAD<?= $count !== 1 ? 'ES' : '' ?> EN TOTAL
    </span>
  </div>

  <!-- Form para borrado múltiple -->
  <form id="batchDeleteForm" method="post" action="?controller=specialty&action=deleteMultiple">
    <div class="table-responsive"
         style="border:1px dashed #6c757d; border-radius:5px; padding:1rem;">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-primary">
          <tr>
            <th style="width:60px;">#</th>
            <th>Descripción</th>
            <th class="text-center" style="width:200px;">Opciones</th>
            <th class="text-center" style="width:80px;">
              <label for="checkAllSpecialties" class="form-label mb-0">Todo</label><br>
              <input type="checkbox" id="checkAllSpecialties">
              <button
                type="submit"
                id="btnDeleteSelected"
                class="btn btn-sm btn-danger mt-1"
                style="display:none;"
              >
                <img src="assets/img/trash.png" alt="Borrar" width="16" class="me-1">Borrar
              </button>
            </th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($specialties as $i => $s): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td class="text-uppercase"><?= htmlspecialchars($s['name']) ?></td>
            <td class="text-center">
              <div class="btn-group">
                <a
                  href="?controller=specialty&action=edit&id=<?= $s['id'] ?>"
                  class="btn btn-sm btn-outline-primary"
                >
                  <img src="assets/img/pencil.png" alt="Editar" width="16" class="me-1">
                  Editar
                </a>
                <a
                  href="?controller=specialty&action=delete&id=<?= $s['id'] ?>"
                  class="btn btn-sm btn-outline-danger"
                  onclick="return confirm('¿Eliminar esta especialidad?')"
                >
                  <img src="assets/img/trash.png" alt="Eliminar" width="16" class="me-1">
                  Eliminar
                </a>
              </div>
            </td>
            <td class="text-center">
              <input type="checkbox" name="ids[]" value="<?= $s['id'] ?>" class="select-specialty">
            </td>
          </tr>
          <?php endforeach; ?>

          <?php if ($count === 0): ?>
          <tr>
            <td colspan="4" class="text-center text-muted py-4">
              No se encontraron especialidades.
            </td>
          </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </form>
</div>

<script>
  // Filtrar listado
  document.getElementById('btnSearchSpecialty').addEventListener('click', () => {
    const term = document.getElementById('searchSpecialty').value.toLowerCase();
    document.querySelectorAll('tbody tr').forEach(row => {
      row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
    });
  });
  document.getElementById('searchSpecialty').addEventListener('keydown', e => {
    if (e.key === 'Enter') {
      e.preventDefault();
      document.getElementById('btnSearchSpecialty').click();
    }
  });

  // Recargar
  document.getElementById('btnRefreshSpecialty').addEventListener('click', () => {
    window.location.reload();
  });

  // Checkboxes y botón Borrar múltiple
  const checkAll = document.getElementById('checkAllSpecialties');
  const selects = document.querySelectorAll('.select-specialty');
  const btnDeleteSelected = document.getElementById('btnDeleteSelected');

  function updateDeleteButton() {
    const anyChecked = Array.from(selects).some(cb => cb.checked);
    btnDeleteSelected.style.display = anyChecked ? 'inline-block' : 'none';
  }

  checkAll.addEventListener('change', function() {
    selects.forEach(cb => cb.checked = this.checked);
    updateDeleteButton();
  });

  selects.forEach(cb => cb.addEventListener('change', () => {
    if (!cb.checked) checkAll.checked = false;
    else if (Array.from(selects).every(c => c.checked)) checkAll.checked = true;
    updateDeleteButton();
  }));

  // SweetAlert2 para mensajes
  <?php if (isset($_GET['error'])): ?>
  Swal.fire({
    icon: 'error',
    title: '¡Oops!',
    text: <?= json_encode(urldecode($_GET['error'])) ?>,
  });
  <?php endif; ?>

  <?php if (isset($_GET['success'])): ?>
  Swal.fire({
    icon: 'success',
    title: '¡Hecho!',
    text: <?= json_encode(urldecode($_GET['success'])) ?>,
    timer: 2000,
    showConfirmButton: false
  });
  <?php endif; ?>
</script>
