<?php
// views/patients/list.php
$patients = $patients ?? [];
$count    = count($patients);
?>
<div class="container-fluid mt-4">

  <!-- Barra de acciones -->
  <div class="d-flex align-items-center mb-3">

    <!-- Botón Volver -->
    <a href="?controller=dashboard&action=index" class="btn btn-light me-3">
      <img src="assets/img/arrow-left.png" alt="Volver" width="16" class="me-1">
      Volver
    </a>

    <!-- Botón Nuevo Paciente -->
    <a href="?controller=patient&action=create" class="btn btn-primary me-3">
      <img src="assets/img/person-plus.png" alt="Nuevo" width="16" class="me-1">
      Nuevo paciente
    </a>

    <!-- Buscador y Recarga al lado derecho -->
    <div class="input-group ms-auto" style="max-width:320px;">
      <!-- Campo de búsqueda -->
      <input
        type="text"
        id="searchPatient"
        class="form-control"
        placeholder="Buscar paciente..."
      >
      <!-- Botón Buscar -->
      <button class="btn btn-success" id="btnSearch">
        <img src="assets/img/search.png" alt="Buscar" width="16">
      </button>
      <!-- Botón Recargar -->
      <button class="btn btn-primary" onclick="window.location.reload()">
        <img src="assets/img/refresh.png" alt="Refrescar" width="16">
      </button>
    </div>

  </div>

  <!-- Conteo total -->
  <div class="text-center mb-3">
    <span class="text-muted small">
      <?= $count ?> PACIENTE<?= $count !== 1 ? 'S' : '' ?> EN TOTAL
    </span>
  </div>

  <!-- Tabla responsiva con borde punteado -->
  <div class="table-responsive"
       style="border:1px dashed #6c757d; border-radius:5px; padding:1rem;">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-primary">
        <tr>
          <th>Foto</th>
          <th>Documento</th>
          <th>Paciente</th>
          <th>Email</th>
          <th>Teléfono</th>
          <th class="text-center">Opciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($patients as $p): ?>
        <tr>
          <td><img src="assets/img/person-circle.png" alt="Foto" width="24"></td>
          <td><?= htmlspecialchars(($p['document_type'] ?? '') . ' - ' . ($p['document_number'] ?? '')) ?></td>
          <td><?= htmlspecialchars($p['name']) ?></td>
          <td><?= htmlspecialchars($p['email']) ?></td>
          <td><?= htmlspecialchars($p['phone']) ?></td>
          <td class="text-center">
            <a href="?controller=patient&action=edit&id=<?= $p['id'] ?>"
               class="btn btn-sm btn-outline-primary me-1">
              <img src="assets/img/pencil.png" alt="Editar" width="16" class="me-1">
              Editar
            </a>
            <a href="?controller=patient&action=delete&id=<?= $p['id'] ?>"
               class="btn btn-sm btn-outline-danger"
               onclick="return confirm('¿Eliminar paciente?')">
              <img src="assets/img/trash.png" alt="Eliminar" width="16" class="me-1">
              Eliminar
            </a>
          </td>
        </tr>
        <?php endforeach; ?>

        <?php if ($count === 0): ?>
        <tr>
          <td colspan="6" class="text-center text-muted py-4">
            No se encontraron pacientes.
          </td>
        </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
  // Filtrado en tiempo real al escribir
  document.getElementById('searchPatient').addEventListener('input', () => {
    const term = document.getElementById('searchPatient').value.toLowerCase();
    document.querySelectorAll('table tbody tr').forEach(row => {
      row.style.display = row.textContent.toLowerCase().includes(term) ? '' : 'none';
    });
  });
</script>
