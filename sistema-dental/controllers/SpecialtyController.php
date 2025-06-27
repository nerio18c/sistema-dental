<?php
// controllers/SpecialtyController.php

class SpecialtyController extends BaseController
{
    private Specialty $model;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->checkRole(['admin']);
        $this->model = new Specialty($pdo);
    }

    /**
     * Muestra el listado de especialidades
     */
    public function index(): void
    {
        $specialties = $this->model->all();
        $this->render('specialties/list', compact('specialties'));
    }

    /**
     * Formulario para crear una nueva
     */
    public function create(): void
    {
        $this->render('specialties/form');
    }

    /**
     * Guarda la nueva especialidad
     */
    public function store(): void
    {
        $name = strtoupper(trim($_POST['name'] ?? ''));
        $this->model->create(['name' => $name]);
        $this->redirect('?controller=specialty&action=index&success=' . urlencode('Especialidad creada.'));
    }

    /**
     * Formulario para editar
     */
    public function edit(): void
    {
        $id        = (int)($_GET['id'] ?? 0);
        $specialty = $this->model->find($id);
        $this->render('specialties/form', compact('specialty'));
    }

    /**
     * Actualiza la especialidad
     */
    public function update(): void
    {
        $id   = (int)($_GET['id'] ?? 0);
        $name = strtoupper(trim($_POST['name'] ?? ''));
        $this->model->update($id, ['name' => $name]);
        $this->redirect('?controller=specialty&action=index&success=' . urlencode('Especialidad actualizada.'));
    }

    /**
     * Borra una especialidad (si no tiene médicos ligados)
     */
    public function delete(): void
    {
        $id = (int)($_GET['id'] ?? 0);

        // compruebo si hay médicos con esta especialidad
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM doctors WHERE specialty_id = ?");
        $stmt->execute([$id]);
        if ($stmt->fetchColumn() > 0) {
            $this->redirect('?controller=specialty&action=index&error='
                . urlencode('No se puede borrar: hay médicos asignados.'));
            return;
        }

        $this->model->delete($id);
        $this->redirect('?controller=specialty&action=index&success='
            . urlencode('Especialidad eliminada.'));
    }

    /**
     * Borra múltiples especialidades (solo las que no tengan médicos)
     */
    public function deleteMultiple(): void
    {
        $ids     = $_POST['ids'] ?? [];
        $skipped = [];

        foreach ($ids as $rawId) {
            $id = (int)$rawId;
            if ($id <= 0) continue;
            // compruebo médicos ligados
            $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM doctors WHERE specialty_id = ?");
            $stmt->execute([$id]);
            if ($stmt->fetchColumn() > 0) {
                $skipped[] = $id;
            } else {
                $this->model->delete($id);
            }
        }

        if (!empty($skipped)) {
            $msg = 'No se pudieron borrar IDs [' . implode(', ', $skipped) . '] porque tienen médicos.';
            $this->redirect('?controller=specialty&action=index&error=' . urlencode($msg));
        }

        $this->redirect('?controller=specialty&action=index&success='
            . urlencode('Especialidades eliminadas.'));
    }
}
