<?php
// controllers/PatientController.php

class PatientController extends BaseController
{
    private Patient $model;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->checkRole(['admin']);  // ajusta roles si es necesario
        $this->model = new Patient($pdo);
    }

    /**
     * Lista todos los pacientes.
     */
    public function index(): void
    {
        $patients = $this->model->all();
        $this->render('patients/list', compact('patients'));
    }

    /**
     * Muestra el formulario de creación.
     */
    public function create(): void
    {
        $this->render('patients/form');
    }

    /**
     * Procesa el POST de creación.
     */
    public function store(): void
    {
        if ($this->model->create($_POST)) {
            header('Location: index.php?controller=patient&action=index&success=' . urlencode('Paciente creado'));
        } else {
            header('Location: index.php?controller=patient&action=index&error=' . urlencode('Error al crear paciente'));
        }
    }

    /**
     * Muestra el formulario de edición.
     */
    public function edit(): void
    {
        $id = intval($_GET['id'] ?? 0);
        $patient = $this->model->find($id);
        $this->render('patients/form', compact('patient'));
    }

    /**
     * Procesa el POST de actualización.
     */
    public function update(): void
    {
        $id = intval($_GET['id'] ?? 0);
        if ($this->model->update($id, $_POST)) {
            header('Location: index.php?controller=patient&action=index&success=' . urlencode('Paciente actualizado'));
        } else {
            header('Location: index.php?controller=patient&action=index&error=' . urlencode('Error al actualizar paciente'));
        }
    }

    /**
     * Elimina un paciente.
     */
    public function delete(): void
    {
        $id = intval($_GET['id'] ?? 0);
        if ($this->model->delete($id)) {
            header('Location: index.php?controller=patient&action=index&success=' . urlencode('Paciente eliminado'));
        } else {
            header('Location: index.php?controller=patient&action=index&error=' . urlencode('Error al eliminar paciente'));
        }
    }

    /**
     * Acción AJAX para buscar paciente por DNI y devolver JSON.
     * URL: ?controller=patient&action=findByDni&dni=...
     */
    public function findByDni(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        $dni = $_GET['dni'] ?? '';
        if (!$dni) {
            echo json_encode([]);
            return;
        }
        $patients = $this->model->findByDni($dni);
        echo json_encode($patients);
    }
}
