<?php
// views/appointments/list.php

$count  = count($appointments);
$search = htmlspecialchars($_GET['search'] ?? '', ENT_QUOTES);
?>
<div class="container-fluid mt-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <a href="index.php?controller=dashboard&action=index" class="btn btn-light me-2">
        <i class="bi bi-arrow-left"></i> Volver
      </a>
      <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#appointmentModal">
        <i class="bi bi-plus-circle"></i> Nueva Cita
      </button>
    </div>

    <form class="d-flex" method="get" action="index.php">
      <input type="hidden" name="controller" value="appointment">
      <input type="hidden" name="action"     value="index">
      <input
        class="form-control me-2"
        type="text"
        name="search"
        placeholder="Buscar Citas..."
        value="<?= $search ?>"
      >
      <button class="btn btn-success" type="submit">
        <i class="bi bi-search"></i>
      </button>
    </form>

    <a href="index.php?controller=appointment&action=index" class="btn btn-primary">
      <i class="bi bi-arrow-clockwise"></i>
    </a>
  </div>

  <div class="text-center mb-3">
    <small class="text-muted">
      <?= $count ?> CITA<?= $count !== 1 ? 'S' : '' ?> EN TOTAL
    </small>
  </div>

  <div class="table-responsive" style="border:1px dashed var(--bs-primary); border-radius:5px; padding:1rem;">
    <table class="table table-striped table-hover align-middle mb-0">
      <thead class="table-primary">
        <tr>
          <th>#</th>
          <th>Tratamiento</th>
          <th>Médico</th>
          <th>Paciente</th>
          <th>Fecha</th>
          <th>Enfermedad</th>
          <th>Estado</th>
          <th>Hora</th>
          <th class="text-end">Costo</th>
          <th class="text-end">Pagado</th>
          <th>Opciones</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($appointments as $i => $app):
          // color para pagado
          $paidClass = $app['paid'] == 0
                     ? 'text-danger'
                     : ($app['paid'] < $app['cost'] ? 'text-warning' : 'text-success');
          // color para estado
          switch ($app['status']) {
            case 'atendida':
              $statusClass = 'text-success';
              break;
            case 'cancelada':
              $statusClass = 'text-danger';
              break;
            default: // pendiente u otros
              $statusClass = 'text-warning';
          }
        ?>
        <tr>
          <td><?= $i + 1 ?></td>
          <td><?= htmlspecialchars($app['treatment_name']) ?></td>
          <td><?= htmlspecialchars($app['doctor_name']) ?></td>
          <td><?= htmlspecialchars($app['patient_name']) ?></td>
          <td><?= htmlspecialchars($app['date']) ?></td>
          <td><?= htmlspecialchars($app['illness']) ?></td>
          <td class="<?= $statusClass ?>">
            <?= ucfirst(htmlspecialchars($app['status'])) ?>
          </td>
          <td><?= htmlspecialchars($app['time']) ?></td>
          <td class="text-end">$ <?= number_format($app['cost'],2) ?></td>
          <td class="text-end <?= $paidClass ?>">
            $ <?= number_format($app['paid'],2) ?>
          </td>
          <td>
            <button
              class="btn btn-sm btn-outline-secondary me-1"
              data-bs-toggle="modal"
              data-bs-target="#appointmentModal"
              data-id="<?= $app['id'] ?>"
              data-treatment-id="<?= $app['treatment_id'] ?>"
              data-doctor-id="<?= $app['doctor_id'] ?>"
              data-patient-id="<?= $app['patient_id'] ?>"
              data-patient-name="<?= htmlspecialchars($app['patient_name'],ENT_QUOTES) ?>"
              data-date="<?= $app['date'] ?>"
              data-time="<?= $app['time'] ?>"
              data-illness="<?= htmlspecialchars($app['illness'],ENT_QUOTES) ?>"
              data-status="<?= $app['status'] ?>"
              data-cost="<?= $app['cost'] ?>"
              data-paid="<?= $app['paid'] ?>"
            >
              <i class="bi bi-pencil"></i> Editar
            </button>
            <a
              href="index.php?controller=appointment&action=delete&id=<?= $app['id'] ?>"
              class="btn btn-sm btn-outline-danger"
              onclick="return confirm('¿Eliminar cita?')"
            >
              <i class="bi bi-trash"></i>
            </a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>
