<?php require __DIR__ . '/../templates/header.php'; ?>

<div class="container mt-4">

  <!-- Volver a la lista de pagos -->
  <a
    href="?controller=payment&action=index"
    class="btn btn-outline-primary mb-3"
  >
    <img
      src="assets/img/arrow-left.png"
      alt="Volver"
      width="16"
      class="me-1 align-text-bottom"
    >
    Volver
  </a>

  <?php
    // Cálculo de montos
    $paid    = (float)$appointment['paid'];
    $cost    = (float)$appointment['cost'];
    $balance = $cost - $paid;
  ?>

  <!-- Botón Cobrar si queda saldo -->
  <?php if ($balance > 0): ?>
    <button
      type="button"
      class="btn btn-primary mb-4"
      data-bs-toggle="modal"
      data-bs-target="#paymentModal"
    >
      <i class="bi bi-cash-stack me-1"></i>
      Cobrar
    </button>
  <?php endif; ?>

  <h5 class="mb-3">Detalle de Pago</h5>

  <div class="row">
    <!-- Datos de la cita -->
    <div class="col-md-6">
      <ul class="list-group mb-4">
        <li class="list-group-item">
          <strong>Paciente:</strong>
          <?= htmlspecialchars($appointment['document_number']) ?> –
          <?= htmlspecialchars($appointment['patient_name']) ?>
        </li>
        <li class="list-group-item">
          <strong>Tratamiento:</strong>
          <?= htmlspecialchars($appointment['treatment_name']) ?>
        </li>
        <li class="list-group-item">
          <strong>Enfermedad:</strong>
          <?= htmlspecialchars($appointment['illness']) ?>
        </li>
        <li class="list-group-item">
          <strong>Médico:</strong>
          <?= htmlspecialchars($appointment['doctor_name']) ?>
        </li>
      </ul>
    </div>

    <!-- Totales y estado de pago -->
    <div class="col-md-6">
      <?php
        if      ($paid >= $cost) { $statusText = 'Aplicado';  $statusCls = 'text-success';  $statusIcon = 'bi-check-circle'; }
        elseif  ($paid == 0.0)   { $statusText = 'Pendiente'; $statusCls = 'text-danger';   $statusIcon = 'bi-clock';        }
        else                     { $statusText = 'Parcial';   $statusCls = 'text-warning';  $statusIcon = 'bi-arrow-down-up'; }
      ?>
      <ul class="list-group mb-4">
        <li class="list-group-item">
          <strong>Pago:</strong>
          <span class="<?= $statusCls ?>">
            <i class="bi <?= $statusIcon ?> me-1"></i>
            <?= $statusText ?>
          </span>
        </li>
        <li class="list-group-item">
          <strong>Costo:</strong>
          $ <?= number_format($cost, 2) ?>
        </li>
        <li class="list-group-item">
          <strong>Pagado:</strong>
          <span class="<?= $paid > 0 ? 'text-success' : 'text-danger' ?>">
            $ <?= number_format($paid, 2) ?>
          </span>
        </li>
        <li class="list-group-item">
          <strong>Saldo:</strong>
          <span class="<?= $balance === 0 ? 'text-success' : 'text-danger' ?>">
            $ <?= number_format($balance, 2) ?>
          </span>
        </li>
      </ul>
    </div>
  </div>

  <!-- Movimientos de pago -->
  <h6 class="mb-2">Movimientos de Pago</h6>
  <div class="table-responsive" style="border:1px dashed #0d6efd; padding:0.5rem; border-radius:0.25rem;">
    <table class="table table-hover mb-0">
      <thead class="table-primary">
        <tr>
          <th>#</th>
          <th>Fecha</th>
          <th>Hora</th>
          <th>Monto</th>
          <th>Recibió</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($paymentsList)): ?>
          <?php foreach ($paymentsList as $j => $mov): ?>
          <tr>
            <td><?= $j + 1 ?></td>
            <td><?= date('d/m/Y', strtotime($mov['created_at'])) ?></td>
            <td><?= date('H:i:s', strtotime($mov['created_at'])) ?></td>
            <td>$ <?= number_format($mov['amount'], 2) ?></td>
            <td><?= htmlspecialchars($mov['received_by']) ?></td>
          </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="5" class="text-center text-muted">
              No hay pagos registrados.
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- Modal de Cobrar -->
<div
  class="modal fade"
  id="paymentModal"
  tabindex="-1"
  aria-labelledby="paymentModalLabel"
  aria-hidden="true"
>
  <div class="modal-dialog">
    <form
      action="?controller=payment&action=store"
      method="post"
      class="modal-content"
    >
      <div class="modal-header">
        <h5 class="modal-title" id="paymentModalLabel">
          <i class="bi bi-cash-stack me-1"></i>
          Registro de Pagos
        </h5>
        <button
          type="button"
          class="btn-close"
          data-bs-dismiss="modal"
          aria-label="Cerrar"
        ></button>
      </div>
      <div class="modal-body">
        <input
          type="hidden"
          name="appointment_id"
          value="<?= $appointment['id'] ?>"
        >
        <div class="mb-3">
          <label for="amount" class="form-label">S/. Monto</label>
          <input
            type="number"
            step="0.01"
            min="0"
            max="<?= $balance ?>"
            id="amount"
            name="amount"
            class="form-control"
            required
          >
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">
          <i class="bi bi-check2 me-1"></i> Guardar
        </button>
        <button
          type="button"
          class="btn btn-secondary"
          data-bs-dismiss="modal"
        >
          <i class="bi bi-x me-1"></i> Cancelar
        </button>
      </div>
    </form>
  </div>
</div>

<?php require __DIR__ . '/../templates/footer.php'; ?>
