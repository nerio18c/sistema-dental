<?php
// views/specialty/form.php

// Detecta si estamos editando o creando
$isEdit   = isset($specialty);
$title    = $isEdit ? 'Editar Especialidad' : 'Registro de Nueva Especialidad';
$action   = $isEdit
    ? "?controller=specialty&action=update&id={$specialty['id']}"
    : "?controller=specialty&action=store";
?>
<div class="container mt-4">
  <div class="card shadow-sm">
    <!-- Header -->
    <div class="card-header bg-white d-flex justify-content-between align-items-center">
      <h5 class="mb-0">
        <i class="bi bi-briefcase-fill text-success me-2"></i>
        <?= $title ?>
      </h5>
      <a href="?controller=specialty&action=index" class="btn-close"></a>
    </div>

    <!-- Body -->
    <div class="card-body">
      <form method="post" action="<?= $action ?>">
        <div class="mb-3">
          <label class="form-label">Descripción</label>
          <input
            type="text"
            name="name"
            class="form-control text-uppercase"
            placeholder="DESCRIPCION"
            required
            value="<?= htmlspecialchars($specialty['name'] ?? '') ?>"
          >
        </div>

        <div class="d-flex justify-content-end mt-4">
          <button type="submit" class="btn btn-success me-2">
            <i class="bi bi-check-circle-fill"></i> Guardar
          </button>
          <a href="?controller=specialty&action=index" class="btn btn-dark">
            <i class="bi bi-x-circle-fill"></i> Cancelar
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
