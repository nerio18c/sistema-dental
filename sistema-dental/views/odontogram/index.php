<!-- views/odontogram/index.php -->
<div class="container mt-4">
  <h2>Odontograma</h2>
  <p>Haz clic en cada diente para cambiar su estado.</p>
  <div id="odontograma">
    <!-- Ejemplo con 32 botones -->
    <?php for($i=1;$i<=32;$i++): ?>
      <button class="tooth" data-id="<?= $i ?>"><?= $i ?></button>
    <?php endfor; ?>
  </div>
  <script src="assets/js/script.js"></script>
</div>
