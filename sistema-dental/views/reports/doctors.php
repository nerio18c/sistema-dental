<?php require __DIR__ . '/../templates/header.php'; ?>

<div class="container mt-4">
  <a href="?controller=report&action=index"
     class="btn btn-outline-primary mb-3">
    <img src="assets/img/arrow-left.png" width="16" class="me-1 align-text-bottom" alt="">
    Volver
  </a>

  <h5>Reporte de Médicos</h5>
  <p class="text-end text-muted"><?= date('d/m/Y h:i:s a') ?></p>

  <div class="table-responsive" style="border:1px solid #ccc; padding:1rem; border-radius:0.5rem;">
    <table class="table mb-0">
      <thead class="table-light">
        <tr>
          <th>Doc. Identidad</th>
          <th>Nombres</th>
          <th>Especialidad</th>
          <th>Correo</th>
          <th>Teléfono</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach($doctors as $row): ?>
        <tr>
          <td><?= htmlspecialchars($row['doc_id']) ?></td>
          <td><?= htmlspecialchars($row['name']) ?></td>
          <td><?= htmlspecialchars($row['specialty']) ?></td>
          <td><?= htmlspecialchars($row['email']) ?></td>
          <td><?= htmlspecialchars($row['phone']) ?></td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require __DIR__ . '/../templates/footer.php'; ?>
