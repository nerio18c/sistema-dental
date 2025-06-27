<!-- views/invoices/list.php -->
<div class="container mt-4">
  <h2>Facturas <a href="?controller=invoice&action=create" class="btn btn-primary btn-sm">Nueva</a></h2>
  <table class="table">
    <thead><tr><th>#</th><th>Paciente</th><th>Fecha</th><th>Total</th><th>Acciones</th></tr></thead>
    <tbody>
    <?php foreach($invoices as $i):
      $p = $patients[array_search($i['patient_id'], array_column($patients,'id'))];
    ?>
      <tr>
        <td><?= $i['id'] ?></td>
        <td><?= htmlspecialchars($p['name']) ?></td>
        <td><?= $i['date'] ?></td>
        <td>S/. <?= number_format($i['total'],2) ?></td>
        <td>
          <a href="?controller=invoice&action=view&id=<?= $i['id'] ?>" class="btn btn-sm btn-info">Ver</a>
        </td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>
