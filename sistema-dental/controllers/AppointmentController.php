<?php
// controllers/AppointmentController.php

require_once __DIR__ . '/../models/Appointment.php';
require_once __DIR__ . '/../models/Treatment.php';
require_once __DIR__ . '/../models/Doctor.php';
require_once __DIR__ . '/../models/Patient.php';

class AppointmentController
{
    private PDO $pdo;
    private Appointment $model;

    public function __construct(PDO $pdo)
    {
        // Activa excepciones para ver errores SQL
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->pdo   = $pdo;
        $this->model = new Appointment($pdo);
    }

    public function index(): void
    {
        $error   = $_GET['error']   ?? '';
        $success = $_GET['success'] ?? '';
        $search  = trim($_GET['search'] ?? '');

        $appointments = $this->model->getAllWithDetails($search);
        $treatments   = (new Treatment($this->pdo))->all();
        $doctors      = (new Doctor($this->pdo))->all();
        $patients     = (new Patient($this->pdo))->all();

        require __DIR__ . '/../views/templates/header.php';
        require __DIR__ . '/../views/appointments/list.php';
        require __DIR__ . '/../views/appointments/form.php';
        require __DIR__ . '/../views/templates/footer.php';
    }

    public function store(): void
    {
        $data = [
            'treatment_id' => $_POST['treatment_id'] ?? '',
            'doctor_id'    => $_POST['doctor_id']    ?? '',
            'patient_id'   => $_POST['patient_id']   ?? '',
            'date'         => $_POST['date']         ?? '',
            'time'         => $_POST['time']         ?? '',
            'illness'      => $_POST['illness']      ?? '',
            'status'       => $_POST['status']       ?? '',
            'cost'         => $_POST['cost']         ?? '',
            'paid'         => $_POST['paid']         ?? 0,
        ];

        // Validación
        foreach (['treatment_id','doctor_id','patient_id','date','time','status','cost'] as $f) {
            if ($data[$f] === '' || $data[$f] === null) {
                header('Location: index.php?controller=appointment&action=index&error='
                    . urlencode('Complete todos los campos obligatorios'));
                exit;
            }
        }

        try {
            $this->model->create($data);
            header('Location: index.php?controller=appointment&action=index&success='
                . urlencode('Cita registrada correctamente'));
            exit;
        } catch (PDOException $e) {
            header('Location: index.php?controller=appointment&action=index&error='
                . urlencode('Error al guardar cita: '.$e->getMessage()));
            exit;
        }
    }

    public function update(): void
    {
        $id = $_POST['id'] ?? '';
        if (!$id) {
            header('Location: index.php?controller=appointment&action=index&error='
                . urlencode('ID de cita inválido'));
            exit;
        }

        $data = [
            'treatment_id' => $_POST['treatment_id'] ?? '',
            'doctor_id'    => $_POST['doctor_id']    ?? '',
            'patient_id'   => $_POST['patient_id']   ?? '',
            'date'         => $_POST['date']         ?? '',
            'time'         => $_POST['time']         ?? '',
            'illness'      => $_POST['illness']      ?? '',
            'status'       => $_POST['status']       ?? '',
            'cost'         => $_POST['cost']         ?? '',
            'paid'         => $_POST['paid']         ?? 0,
        ];

        foreach (['treatment_id','doctor_id','patient_id','date','time','status','cost'] as $f) {
            if ($data[$f] === '' || $data[$f] === null) {
                header('Location: index.php?controller=appointment&action=index&error='
                    . urlencode('Complete todos los campos obligatorios'));
                exit;
            }
        }

        try {
            $this->model->update($id, $data);
            header('Location: index.php?controller=appointment&action=index&success='
                . urlencode('Cita actualizada correctamente'));
            exit;
        } catch (PDOException $e) {
            header('Location: index.php?controller=appointment&action=index&error='
                . urlencode('Error al actualizar cita: '.$e->getMessage()));
            exit;
        }
    }

    public function delete(): void
    {
        $id = $_GET['id'] ?? '';
        if (!$id) {
            header('Location: index.php?controller=appointment&action=index&error='
                . urlencode('ID inválido'));
            exit;
        }

        try {
            $this->model->delete($id);
            header('Location: index.php?controller=appointment&action=index&success='
                . urlencode('Cita eliminada'));
            exit;
        } catch (PDOException $e) {
            header('Location: index.php?controller=appointment&action=index&error='
                . urlencode('No se pudo eliminar cita: '.$e->getMessage()));
            exit;
        }
    }

    public function findByDni(): void
    {
        header('Content-Type: application/json');
        $dni = $_GET['dni'] ?? '';
        if (!$dni) {
            echo json_encode([]);
            return;
        }
        $patients = (new Patient($this->pdo))->findByDni($dni);
        echo json_encode($patients);
    }
}
