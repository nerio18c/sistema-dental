<?php
// views/history/list.php

// $records viene de HistoryController::index()
$count  = count($records);
$search = htmlspecialchars($_GET['search'] ?? '', ENT_QUOTES);
?>
<div class="container-fluid mt-4">

  <!-- Volver / Buscar / Refrescar -->
  <div class="d-flex align-items-center mb-3">
    <a href="index.php?controller=dashboard&action=index" class="btn btn-light me-2">
      <i class="bi bi-arrow-left"></i> Volver
    </a>

    <form class="d-flex flex-grow-1" method="get" action="index.php">
      <input type="hidden" name="controller" value="history">
      <input type="hidden" name="action"     value="index">

      <input
        type="text"
        name="search"
        class="form-control me-2"
        placeholder="Buscar Citas..."
        value="<?= $search ?>"
      >
      <button class="btn btn-success me-2" type="submit">
        <i class="bi bi-search"></i>
      </button>
      <a href="index.php?controller=history&action=index" class="btn btn-primary">
        <i class="bi bi-arrow-clockwise"></i>
      </a>
    </form>
  </div>

  <!-- Conteo total -->
  <div class="text-center mb-3">
    <small class="text-muted">
      <?= $count ?> HISTORIAL<?= $count!==1?'ES':'' ?> DE CITAS EN TOTAL
    </small>
  </div>

  <!-- Tabla de historial -->
  <div class="table-responsive"
       style="border:1px dashed var(--bs-primary); padding:1rem; border-radius:5px;">
    <table class="table table-striped table-hover align-middle mb-0">
      <thead class="table-primary">
        <tr>
          <th>#</th>
          <th>Tratamiento</th>
          <th>Médico</th>
          <th>Paciente</th>
          <th>Fecha</th>
          <th>Hora</th>
          <th>Enfermedad</th>
          <th>Estado</th>
          <th>Pago</th>
          <th class="text-end">Costo</th>
          <th class="text-end">Pagado</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($records as $i => $r):
        // Color para estado de cita
        $statusClass = match($r['status']) {
          'atendida'  => 'text-success',
          'cancelada' => 'text-danger',
          default     => 'text-warning',
        };

        // Derivar estado de pago según montos
        if ($r['paid'] >= $r['cost']) {
          $payText  = 'Aplicado';
          $payIcon  = 'bi-check-circle';
          $payClass = 'text-success';
        } elseif ($r['paid'] > 0) {
          $payText  = 'Falta completar';
          $payIcon  = 'bi-exclamation-triangle';
          $payClass = 'text-warning';
        } else {
          $payText  = 'Pendiente';
          $payIcon  = 'bi-x-circle';
          $payClass = 'text-danger';
        }

        // Color para monto pagado
        $paidClass = $r['paid'] == 0
                   ? 'text-danger'
                   : ($r['paid'] < $r['cost'] ? 'text-warning' : 'text-success');
      ?>
        <tr>
          <td><?= $i+1 ?></td>
          <td><?= htmlspecialchars($r['treatment_name']) ?></td>
          <td><?= htmlspecialchars($r['doctor_name']) ?></td>
          <td><?= htmlspecialchars($r['patient_name']) ?></td>
          <td><?= htmlspecialchars($r['date']) ?></td>
          <td><?= htmlspecialchars($r['time']) ?></td>
          <td><?= htmlspecialchars($r['illness']) ?></td>

          <td class="<?= $statusClass ?>">
            <?= ucfirst(htmlspecialchars($r['status'])) ?>
          </td>

          <td class="<?= $payClass ?>">
            <i class="bi <?= $payIcon ?> me-1"></i>
            <?= $payText ?>
          </td>

          <td class="text-end">$ <?= number_format($r['cost'], 2) ?></td>
          <td class="text-end <?= $paidClass ?>">
            $ <?= number_format($r['paid'], 2) ?>
          </td>
        </tr>
        
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
