<?php
// views/users/form.php
$isEdit = isset($user);
$title  = $isEdit ? 'Editar Usuario' : 'Registro de Nuevo Usuario';
$action = $isEdit
    ? "?controller=user&action=update&id={$user['id']}"
    : "?controller=user&action=store";

// Opciones de rol
$roles = [
  'admin'     => 'Administrador',
  'dentist'   => 'Dentista',
  'assistant' => 'Asistente',
];

// Opciones de documento
$docTypes = [
  'DNI'       => 'DNI',
  'Pasaporte' => 'Pasaporte',
  'CE'        => 'Carnet Ext.',
];

?>
<div class="container mt-4">
  <div class="card shadow-sm">
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
      <h5 class="mb-0">
        <i class="bi bi-person-plus-fill text-success me-2"></i>
        <?= $title ?>
      </h5>
      <a href="?controller=user&action=index" class="btn-close"></a>
    </div>
    <div class="card-body">
      <form method="post" action="<?= $action ?>">
        <div class="row g-3">
          <!-- Nombres completos -->
          <div class="col-12">
            <label class="form-label">Nombres y Apellidos</label>
            <input
              type="text"
              name="username"
              class="form-control"
              placeholder="Nombres y Apellidos"
              required
              value="<?= $user['username'] ?? '' ?>"
            >
          </div>

          <!-- Tipo Usuario -->
          <div class="col-md-6">
            <label class="form-label">Tipo Usuario</label>
            <select name="role" class="form-select" required>
              <option value="">Seleccione...</option>
              <?php foreach($roles as $val=>$label): ?>
              <option value="<?= $val ?>"
                <?= isset($user['role']) && $user['role']==$val ? 'selected' : '' ?>>
                <?= $label ?>
              </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Tipo Documento -->
          <div class="col-md-6">
            <label class="form-label">Tipo Documento</label>
            <select name="document_type" class="form-select" required>
              <option value="">-- Seleccione --</option>
              <?php foreach($docTypes as $val=>$label): ?>
              <option value="<?= $val ?>"
                <?= isset($user['document_type']) && $user['document_type']==$val ? 'selected' : '' ?>>
                <?= $label ?>
              </option>
              <?php endforeach; ?>
            </select>
          </div>

          <!-- Nº Documento -->
          <div class="col-md-6">
            <label class="form-label">N° Documento</label>
            <input
              type="text"
              name="document_number"
              class="form-control"
              placeholder="N° de documento"
              required
              value="<?= $user['document_number'] ?? '' ?>"
            >
          </div>

          <!-- Teléfono -->
          <div class="col-md-6">
            <label class="form-label">Teléfono</label>
            <input
              type="text"
              name="phone"
              class="form-control"
              placeholder="Teléfono"
              required
              value="<?= $user['phone'] ?? '' ?>"
            >
          </div>

          <!-- Email -->
          <div class="col-12">
            <label class="form-label">Email</label>
            <input
              type="email"
              name="email"
              class="form-control"
              placeholder="correo electrónico"
              required
              value="<?= $user['email'] ?? '' ?>"
            >
          </div>
        </div>

        <!-- Sección Contraseña -->
        <hr class="my-4">
        <h6 class="text-center text-uppercase text-secondary">Contraseña de Usuario</h6>

        <div class="row g-3 mt-2">
          <div class="col-md-6">
            <label class="form-label">Contraseña</label>
            <input
              type="password"
              name="password"
              class="form-control"
              placeholder="Contraseña"
              <?= $isEdit ? '' : 'required' ?>
            >
          </div>
          <div class="col-md-6">
            <label class="form-label">Confirmar Contraseña</label>
            <input
              type="password"
              name="confirm_password"
              class="form-control"
              placeholder="Contraseña"
              <?= $isEdit ? '' : 'required' ?>
            >
          </div>
        </div>

        <!-- Botones -->
        <div class="d-flex justify-content-end mt-4">
          <button type="submit" class="btn btn-success me-2">
            <i class="bi bi-check-circle-fill"></i> Guardar
          </button>
          <a href="?controller=user&action=index" class="btn btn-dark">
            <i class="bi bi-x-circle-fill"></i> Cancelar
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
