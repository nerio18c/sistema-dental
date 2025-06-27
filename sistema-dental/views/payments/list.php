<?php require __DIR__ . '/../templates/header.php'; ?>

<div class="container mt-4">
  <!-- Botón Volver al inicio -->
  <a
    href="?controller=dashboard&action=index"
    class="btn btn-outline-primary btn-sm mb-3"
  >
    <img
      src="assets/img/arrow-left.png"
      alt="Volver"
      width="16"
      class="me-1 align-text-bottom"
    >
    Volver al inicio
  </a>

  <!-- Título y búsqueda -->
  <h5 class="mt-3"><?= count($entries) ?> CITA(S) EN TOTAL</h5>
  <form class="d-flex my-3 align-items-center" method="get">
    <input type="hidden" name="controller" value="payment">
    <input type="hidden" name="action"     value="index">
    <input
      name="search"
      class="form-control me-2"
      type="search"
      placeholder="Buscar Citas..."
      value="<?= htmlspecialchars($search) ?>"
    >
    <button class="btn btn-outline-success" type="submit">
      <i class="bi bi-search"></i>
    </button>
    <a
      href="?controller=payment&action=index"
      class="btn btn-outline-secondary ms-2"
      title="Actualizar"
    >
      <i class="bi bi-arrow-clockwise"></i>
    </a>
  </form>

  <!-- Tabla con estilo dash‐border -->
  <div
    class="table-responsive"
    style="border:1px dashed #0d6efd; padding:0.5rem; border-radius:0.25rem;"
  >
    <table class="table table-hover align-middle mb-0">
      <thead class="table-primary">
        <tr>
          <th>#</th>
          <th>Paciente</th>
          <th>Tratamiento</th>
          <th>Enfermedad</th>
          <th>Fecha</th>
          <th>Hora</th>
          <th>Pago</th>
          <th>Costo</th>
          <th>Pagado</th>
          <th>Saldo</th>
          <th>Opciones</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($entries as $i => $row):
        // convierte strings a float
        $paid    = (float)$row['paid_amount'];
        $cost    = (float)$row['cost'];
        $balance = $cost - $paid;

        // Estado de Pago
        if ($paid >= $cost) {
          $payLabel = 'Aplicado';
          $payIcon  = 'bi-check-circle';
          $payCls   = 'text-success';
        } elseif ($paid > 0) {
          $payLabel = 'Parcial';
          $payIcon  = 'bi-arrow-down-up';
          $payCls   = 'text-warning';
        } else {
          $payLabel = 'Pendiente';
          $payIcon  = 'bi-clock';
          $payCls   = 'text-danger';
        }

        // Clases para Pagado y Saldo
        $paidCls    = $paid    > 0 ? 'text-success' : 'text-danger';
        $balanceCls = $balance == 0 ? 'text-success' : 'text-danger';
      ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td>
            <?= htmlspecialchars($row['document_number']) ?> –
            <?= htmlspecialchars($row['patient_name']) ?>
          </td>
          <td><?= htmlspecialchars($row['treatment_name']) ?></td>
          <td><?= htmlspecialchars($row['illness']) ?></td>
          <td><?= date('d/m/Y', strtotime($row['date'])) ?></td>
          <td><?= date('H:i',   strtotime($row['time'])) ?></td>
          <td>
            <span class="<?= $payCls ?>">
              <i class="bi <?= $payIcon ?> me-1"></i>
              <?= $payLabel ?>
            </span>
          </td>
          <td>$ <?= number_format($cost,   2) ?></td>
          <td>
            <span class="<?= $paidCls ?>">
              $ <?= number_format($paid,   2) ?>
            </span>
          </td>
          <td>
            <span class="<?= $balanceCls ?>">
              $ <?= number_format($balance,2) ?>
            </span>
          </td>
          <td>
            <a
              href="?controller=payment&action=view&id=<?= $row['id'] ?>"
              class="btn btn-sm btn-outline-primary"
            >
              <i class="bi bi-eye"></i> Ver
            </a>
          </td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require __DIR__ . '/../templates/footer.php'; ?>
