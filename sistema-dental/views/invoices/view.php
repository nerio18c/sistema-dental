<!-- views/invoices/view.php -->
<div class="container mt-4">
  <h2>Factura #<?= $invoice['id'] ?></h2>
  <p><strong>Paciente:</strong> <?= htmlspecialchars($patient['name']) ?></p>
  <p><strong>Fecha:</strong> <?= $invoice['date'] ?></p>
  <p><strong>Total:</strong> S/. <?= number_format($invoice['total'],2) ?></p>
  <button onclick="window.print()" class="btn btn-outline-primary">Imprimir</button>
  <a href="?controller=invoice&action=index" class="btn btn-secondary">Volver</a>
</div>
