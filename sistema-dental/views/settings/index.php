<?php require __DIR__ . '/../templates/header.php'; ?>

<div class="container mt-4">
  <!-- Volver a donde tú quieras (por ejemplo al odontograma o al dashboard) -->
  <a href="?controller=dashboard&action=index" class="btn btn-outline-secondary mb-3">
    <i class="bi bi-arrow-left me-1"></i> Volver
  </a>

  <h5 class="mb-3"><?= count($entries) ?> Acción(es) en Odontograma</h5>

  <!-- Buscador + refrescar + agregar -->
  <form class="d-flex mb-3 align-items-center" method="get">
    <input type="hidden" name="controller" value="setting">
    <input type="hidden" name="action" value="index">
    <input
      name="search"
      class="form-control me-2"
      type="search"
      placeholder="Buscar Acción..."
      value="<?= htmlspecialchars($_GET['search'] ?? '') ?>"
    >
    <button class="btn btn-outline-success me-2" type="submit">
      <i class="bi bi-search"></i>
    </button>
    <a href="?controller=setting&action=index" class="btn btn-outline-secondary me-auto">
      <i class="bi bi-arrow-clockwise"></i>
    </a>
    <a href="?controller=setting&action=create" class="btn btn-primary">
      <i class="bi bi-plus-lg me-1"></i> Agregar
    </a>
  </form>

  <!-- Tabla -->
  <div
    class="table-responsive"
    style="border:1px dashed #0d6efd; padding:0.5rem; border-radius:0.25rem;"
  >
    <table class="table table-hover align-middle mb-0">
      <thead class="table-primary">
        <tr>
          <th>#</th>
          <th>Acción</th>
          <th>Color</th>
          <th>Vista previa</th>
          <th>Opciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($entries as $i => $row): ?>
          <tr>
            <td><?= $i + 1 ?></td>
            <td><?= htmlspecialchars($row['action_name']) ?></td>
            <td>
              <code><?= htmlspecialchars($row['color']) ?></code>
            </td>
            <td>
              <span
                class="badge"
                style="background: <?= htmlspecialchars($row['color']) ?>; color: #fff;"
              >
                <?= htmlspecialchars($row['action_name']) ?>
              </span>
            </td>
            <td>
              <a
                href="?controller=setting&action=edit&id=<?= $row['id'] ?>"
                class="btn btn-sm btn-outline-primary"
              >
                <i class="bi bi-pencil"></i> Editar
              </a>
              <a
                href="?controller=setting&action=delete&id=<?= $row['id'] ?>"
                class="btn btn-sm btn-outline-danger"
                onclick="return confirm('¿Eliminar esta acción?')"
              >
                <i class="bi bi-trash"></i> Eliminar
              </a>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require __DIR__ . '/../templates/footer.php'; ?>
