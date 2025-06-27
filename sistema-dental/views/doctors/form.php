<?php
// views/doctors/form.php
// Debe recibir $specialties desde list.php
?>
<div class="modal fade" id="doctorModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form id="doctorForm" method="post">
        <div class="modal-header">
          <h5 class="modal-title" id="doctorModalTitle">Registro de Nuevo Médico</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="container-fluid">
            <div class="row g-3">
              <div class="col-12 col-md-6">
                <label class="form-label">Nombres</label>
                <input type="text" name="first_name" class="form-control" placeholder="Nombres" required>
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label">Apellidos</label>
                <input type="text" name="last_name" class="form-control" placeholder="Apellidos" required>
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label">DNI</label>
                <input type="text" name="dni" class="form-control" placeholder="DNI">
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label">Especialidad</label>
                <select name="specialty_id" class="form-select" required>
                  <option value="">Seleccione...</option>
                  <?php foreach ($specialties as $s): ?>
                    <option value="<?= $s['id'] ?>"><?= htmlspecialchars($s['name']) ?></option>
                  <?php endforeach; ?>
                </select>
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label">Dirección</label>
                <input type="text" name="address" class="form-control" placeholder="Dirección">
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" placeholder="correo electrónico">
              </div>
              <div class="col-12 col-md-6">
                <label class="form-label">Teléfono</label>
                <input type="text" name="phone" class="form-control" placeholder="Teléfono">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Guardar</button>
          <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancelar</button>
        </div>
      </form>
    </div>
  </div>
</div>
