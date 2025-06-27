<?php require __DIR__ . '/../templates/header.php'; ?>

<?php
  $isEdit = isset($entry);
  $action = $isEdit ? 'edit&id=' . $entry['id'] : 'create';
?>

<div class="container mt-4">
  <a href="?controller=setting&action=index" class="btn btn-outline-secondary mb-3">
    <i class="bi bi-arrow-left me-1"></i> Volver
  </a>

  <h5 class="mb-4"><?= $isEdit ? 'Editar' : 'Agregar' ?> Acción</h5>

  <form method="post" action="?controller=setting&action=<?= $action ?>">
    <div class="mb-3">
      <label for="action_name" class="form-label">Acción</label>
      <input
        type="text"
        id="action_name"
        name="action_name"
        class="form-control"
        required
        value="<?= $isEdit ? htmlspecialchars($entry['action_name']) : '' ?>"
      >
    </div>

    <div class="mb-3">
      <label for="color" class="form-label">Color</label>
      <input
        type="color"
        id="color"
        name="color"
        class="form-control form-control-color"
        required
        value="<?= $isEdit ? htmlspecialchars($entry['color']) : '#000000' ?>"
      >
    </div>

    <button type="submit" class="btn btn-success">
      <i class="bi bi-check2 me-1"></i> Guardar
    </button>
  </form>
</div>

<?php require __DIR__ . '/../templates/footer.php'; ?>
