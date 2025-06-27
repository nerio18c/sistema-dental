<?php
// views/appointments/form.php
$modalId = 'appointmentModal';
?>
<div class="modal fade" id="<?= $modalId ?>" tabindex="-1" aria-labelledby="<?= $modalId ?>Label" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content">
      <form id="appointmentForm"
            method="post"
            action="index.php?controller=appointment&action=store"
            class="needs-validation"
            novalidate>
        <div class="modal-header bg-light">
          <h5 class="modal-title" id="<?= $modalId ?>Label">
            <i class="bi bi-calendar-plus me-2"></i>Registrar nueva cita
          </h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>

        <div class="modal-body">
          <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
          <?php elseif (!empty($success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
          <?php endif; ?>

          <!-- Hidden para update -->
          <input type="hidden" name="id" id="appointment_id">

          <div class="row g-3">
            <div class="col-md-6">
              <label class="form-label">Tratamiento *</label>
              <select id="treatment_id" name="treatment_id" class="form-select" required>
                <option value="">Seleccione...</option>
                <?php foreach ($treatments as $t): ?>
                  <option value="<?= $t['id'] ?>" data-price="<?= $t['price'] ?>">
                    <?= htmlspecialchars($t['name']) ?> — S/.<?= number_format($t['price'],2) ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <div class="invalid-feedback">Seleccione un tratamiento.</div>
            </div>

            <div class="col-md-6">
              <label class="form-label">Médico *</label>
              <select id="doctor_id" name="doctor_id" class="form-select" required>
                <option value="">Seleccione...</option>
                <?php foreach ($doctors as $d): ?>
                  <option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['name']) ?></option>
                <?php endforeach; ?>
              </select>
              <div class="invalid-feedback">Seleccione un médico.</div>
            </div>

            <div class="col-12">
              <label class="form-label">Paciente *</label>
              <div class="input-group mb-2">
                <input type="text" id="searchDni" class="form-control" placeholder="Buscar por DNI">
                <button type="button" id="btnSearchPatient" class="btn btn-outline-primary">
                  <i class="bi bi-search"></i> Buscar
                </button>
              </div>
              <div id="patientList" class="list-group mb-2"></div>
              <input type="hidden" id="patient_id" name="patient_id" required>
              <div class="invalid-feedback">Seleccione un paciente.</div>
            </div>

            <div class="col-md-6">  
              <label class="form-label">Fecha *</label>
              <input type="date" name="date" class="form-control" required>
              <div class="invalid-feedback">Ingrese la fecha.</div>
            </div>
            <div class="col-md-6">
              <label class="form-label">Hora *</label>
              <input type="time" name="time" class="form-control" required>
              <div class="invalid-feedback">Ingrese la hora.</div>
            </div>

            <div class="col-12">
              <label class="form-label">Enfermedad</label>
              <input type="text" name="illness" class="form-control" placeholder="Descripción">
            </div>

            <div class="col-md-6">
              <label class="form-label">Estado de cita *</label>
              <select name="status" class="form-select" required>
                <option value="">Seleccione...</option>
                <option value="pendiente">Pendiente</option>
                <option value="atendida">Atendida</option>
                <option value="cancelada">Cancelada</option>
              </select>
              <div class="invalid-feedback">Seleccione un estado.</div>
            </div>

            <div class="col-md-3">
              <label class="form-label">Costo *</label>
              <input id="cost" name="cost" type="number" class="form-control" readonly required>
              <div class="invalid-feedback">Costo obligatorio.</div>
            </div>
            <div class="col-md-3">
              <label class="form-label">Pagado</label>
              <input id="paid" name="paid" type="number" class="form-control" value="0" required>
              <div class="invalid-feedback">Indique monto pagado.</div>
            </div>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">
            <i class="bi bi-check2-circle me-1"></i>Guardar
          </button>
          <button type="button" class="btn btn-dark" data-bs-dismiss="modal">
            <i class="bi bi-x-circle me-1"></i>Cancelar
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
(() => {
  const form  = document.getElementById('appointmentForm');
  const modal = document.getElementById('appointmentModal');

  form.addEventListener('submit', e => {
    if (!form.checkValidity()) {
      e.preventDefault(); e.stopPropagation();
    }
    form.classList.add('was-validated');
  });

  document.getElementById('treatment_id').addEventListener('change', function() {
    document.getElementById('cost').value = this.selectedOptions[0]?.dataset.price || '';
  });

  document.getElementById('btnSearchPatient').addEventListener('click', async () => {
    const dni = document.getElementById('searchDni').value.trim();
    if (!dni) return alert('Ingrese un DNI');
    const res = await fetch(`index.php?controller=appointment&action=findByDni&dni=${dni}`);
    const pts = await res.json();
    const list = document.getElementById('patientList');
    list.innerHTML = '';
    if (!pts.length) {
      list.innerHTML = '<div class="alert alert-warning">No se encontró paciente.</div>';
      return;
    }
    pts.forEach(p => {
      const btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'list-group-item list-group-item-action';
      btn.textContent = p.name;
      btn.onclick = () => {
        document.getElementById('searchDni').value  = p.name;
        document.getElementById('patient_id').value = p.id;
        list.innerHTML = '';
      };
      list.append(btn);
    });
  });

  // Prefill para editar
  document.querySelectorAll('button[data-id]').forEach(btn => {
    btn.addEventListener('click', () => {
      const d = btn.dataset;
      form.action = 'index.php?controller=appointment&action=update';
      form.querySelector('#appointment_id').value    = d.id;
      form.querySelector('#treatment_id').value      = d.treatmentId;
      form.querySelector('#doctor_id').value         = d.doctorId;
      document.getElementById('searchDni').value     = d.patientName;
      document.getElementById('patient_id').value    = d.patientId;
      form.querySelector('input[name=date]').value   = d.date;
      form.querySelector('input[name=time]').value   = d.time;
      form.querySelector('input[name=illness]').value= d.illness;
      form.querySelector('select[name=status]').value= d.status;
      form.querySelector('#cost').value              = d.cost;
      form.querySelector('#paid').value              = d.paid;
    });
  });

  modal.addEventListener('show.bs.modal', () => {
    form.reset();
    form.classList.remove('was-validated');
    form.action = 'index.php?controller=appointment&action=store';
    modal.querySelectorAll('.alert').forEach(a => a.remove());
  });
})();
</script>
