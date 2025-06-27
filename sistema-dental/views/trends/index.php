<!-- views/trends/index.php -->
<div class="container mt-4">
  <h2>Tendencias de Ingresos</h2>
  <canvas id="chartIncome"></canvas>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('chartIncome');
new Chart(ctx, {
  type: 'line',
  data: {
    labels: <?= json_encode(array_column($income,'mes')) ?>,
    datasets: [{ label: 'Ingresos', data: <?= json_encode(array_column($income,'total')) ?> }]
  }
});
</script>
