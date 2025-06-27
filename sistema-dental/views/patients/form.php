<?php
// views/patients/form.php

$isEdit = isset($patient);
$title  = $isEdit ? 'Editar Paciente' : 'Registro de Pacientes';
$action = $isEdit
    ? "?controller=patient&action=update&id={$patient['id']}"
    : "?controller=patient&action=store";

// Opciones de tipo de documento
$docTypes = [
  'DNI'       => 'DNI',
  'Pasaporte' => 'Pasaporte',
  'CE'        => 'Carnet Ext.',
];

// Opciones para historia clínica (Sí/No)
$yesNo = [
  0 => 'No',
  1 => 'Sí',
];
?>
<div class="container mt-4">
  <div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
      <h5 class="mb-0">
        <i class="bi bi-person-plus-fill text-success me-2"></i>
        <?= $title ?>
      </h5>
      <a href="?controller=patient&action=index" class="btn-close"></a>
    </div>
    <div class="card-body">
      <form method="post" action="<?= $action ?>">
        <div class="row g-4">
          <!-- Columna Izquierda -->
          <div class="col-lg-6">
            <div class="row g-3">
              <div class="col-6">
                <label class="form-label">Tipo documento</label>
                <select name="document_type" class="form-select" required>
                  <option value="">-- Seleccione --</option>
                  <?php foreach($docTypes as $val => $lbl): ?>
                    <option value="<?= $val ?>"
                      <?= (isset($patient['document_type']) && $patient['document_type']==$val) ? 'selected' : '' ?>>
                      <?= $lbl ?>
                    </option>
                  <?php endforeach; ?>
                </select>
              </div>

              <div class="col-6">
                <label class="form-label">N° documento</label>
                <input
                  type="text"
                  name="document_number"
                  class="form-control"
                  placeholder="N° de documento"
                  required
                  value="<?= $patient['document_number'] ?? '' ?>"
                >
              </div>

              <div class="col-12">
                <label class="form-label">Nombres y Apellidos</label>
                <input
                  type="text"
                  name="name"
                  class="form-control"
                  placeholder="Nombres y Apellidos"
                  required
                  value="<?= $patient['name'] ?? '' ?>"
                >
              </div>

              <div class="col-12">
                <label class="form-label">Fecha de Nacimiento</label>
                <input
                  type="date"
                  name="dob"
                  class="form-control"
                  required
                  value="<?= $patient['dob'] ?? '' ?>"
                >
              </div>

              <div class="col-12">
                <label class="form-label">Dirección</label>
                <input
                  type="text"
                  name="address"
                  class="form-control"
                  placeholder="Dirección"
                  required
                  value="<?= htmlspecialchars($patient['address'] ?? '') ?>"
                >
              </div>

              <div class="col-12">
                <label class="form-label">Email</label>
                <input
                  type="email"
                  name="email"
                  class="form-control"
                  placeholder="correo electrónico"
                  value="<?= $patient['email'] ?? '' ?>"
                >
              </div>

              <div class="col-12">
                <label class="form-label">Teléfono</label>
                <input
                  type="text"
                  name="phone"
                  class="form-control"
                  placeholder="Teléfono"
                  value="<?= $patient['phone'] ?? '' ?>"
                >
              </div>
            </div>
          </div>

          <!-- Columna Derecha: Historia Clínica -->
          <div class="col-lg-6">
            <div class="p-3 mb-3 text-center rounded-3" style="background: rgba(0,123,255,0.1);">
              <strong>Historia Clínica</strong>
            </div>
            <div class="row g-3">
              <?php foreach([
                'under_treatment' => 'Bajo tratamiento médico',
                'bleeding'        => 'Propenso a la Hemorragia',
                'allergic'        => 'Alérgico a algún medicamento',
                'hypertensive'    => 'Hipertenso',
                'diabetic'        => 'Diabético',
                'pregnant'        => 'Embarazada',
              ] as $field => $label): ?>
                <div class="col-7 d-flex align-items-center">
                  <?= $label ?>
                </div>
                <div class="col-5">
                  <select name="<?= $field ?>" class="form-select">
                    <?php foreach($yesNo as $val => $lbl): ?>
                      <option value="<?= $val ?>"
                        <?= (isset($patient[$field]) && $patient[$field]==$val) ? 'selected' : '' ?>>
                        <?= $lbl ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              <?php endforeach; ?>

              <div class="col-12">
                <label class="form-label">Motivo de la consulta</label>
                <textarea
                  name="motive"
                  class="form-control"
                  rows="2"
                  placeholder="Motivo de la consulta"
                ><?= $patient['motive'] ?? '' ?></textarea>
              </div>

              <div class="col-12">
                <label class="form-label">Diagnóstico</label>
                <textarea
                  name="diagnosis"
                  class="form-control"
                  rows="2"
                  placeholder="Diagnóstico"
                ><?= $patient['diagnosis'] ?? '' ?></textarea>
              </div>

              <div class="col-12">
                <label class="form-label">Observaciones</label>
                <textarea
                  name="observations"
                  class="form-control"
                  rows="2"
                  placeholder="Observaciones"
                ><?= $patient['observations'] ?? '' ?></textarea>
              </div>

              <div class="col-12">
                <label class="form-label">Referido por</label>
                <input
                  type="text"
                  name="referred_by"
                  class="form-control"
                  placeholder="Referido por"
                  value="<?= $patient['referred_by'] ?? '' ?>"
                >
              </div>
            </div>
          </div>
        </div>

        <div class="d-flex justify-content-end mt-4">
          <button type="submit" class="btn btn-success me-2">
            <i class="bi bi-check-circle-fill"></i> Guardar
          </button>
          <a href="?controller=patient&action=index" class="btn btn-dark">
            <i class="bi bi-x-circle-fill"></i> Cancelar
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
