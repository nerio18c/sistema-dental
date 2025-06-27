<?php require __DIR__ . '/../templates/header.php'; ?>

<div class="container mt-4">
  <!-- Volver al dashboard principal -->
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
    Volver
  </a>

  <h5 class="mb-3">
    <i class="bi bi-bar-chart me-1"></i>
    Resumen General de citas
  </h5>

  <div
    class="table-responsive"
    style="border:1px dashed #0d6efd; padding:1rem; border-radius:0.25rem;"
  >
    <canvas id="summaryChart"></canvas>
  </div>
</div>

<!-- Chart.js desde CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  const labels = <?= json_encode($labels) ?>;
  const data   = <?= json_encode($counts) ?>;

  new Chart(
    document.getElementById('summaryChart'),
    {
      type: 'bar',
      data: {
        labels: labels,
        datasets: [{
          label: 'Citas',
          data: data
        }]
      },
      options: {
        scales: { y: { beginAtZero: true } },
        plugins: { legend: { display: false } }
      }
    }
  );
</script>

<?php require __DIR__ . '/../templates/footer.php'; ?>
