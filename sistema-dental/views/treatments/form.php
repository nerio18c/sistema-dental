<!-- views/treatments/form.php -->

<div class="modal fade" id="treatmentModal" tabindex="-1">
  <div class="modal-dialog">
    <form id="treatmentForm" method="POST" class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="treatmentModalTitle">Nuevo Tratamiento</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <div class="mb-3">
          <label for="name" class="form-label">Tratamiento</label>
          <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="price" class="form-label">Precio</label>
          <input type="number" id="price" name="price" step="0.01" class="form-control" required>
        </div>
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Guardar</button>
        <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancelar</button>
      </div>
    </form>
  </div>
</div>
