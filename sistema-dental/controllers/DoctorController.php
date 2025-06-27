<?php
// controllers/DoctorController.php

class DoctorController extends BaseController
{
    private Doctor $model;
    private Specialty $specialtyModel;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->checkRole(['admin']);
        $this->model         = new Doctor($pdo);
        $this->specialtyModel = new Specialty($pdo);
    }

    public function index(): void
    {
        $doctors         = $this->model->all();
        $specialties     = $this->specialtyModel->all();
        $doctorParam     = $_REQUEST['doctor']     ?? null;
        $showDoctorModal = (bool)($_REQUEST['showModal'] ?? false);

        if (is_string($doctorParam)) {
            $doctor = json_decode(urldecode($doctorParam), true);
        } else {
            $doctor = null;
        }

        $this->render('doctors/list', compact(
            'doctors',
            'specialties',
            'doctor',
            'showDoctorModal'
        ));
    }

    public function create(): void
    {
        header('Location: ?controller=doctor&action=index&showModal=1');
        exit;
    }

    public function store(): void
    {
        $data = [
            'name'         => trim(($_POST['first_name'] ?? '') . ' ' . ($_POST['last_name'] ?? '')),
            'dni'          => trim($_POST['dni'] ?? ''),
            'specialty_id' => (int) ($_POST['specialty_id'] ?? 0),
            'address'      => trim($_POST['address'] ?? ''),
            'email'        => trim($_POST['email'] ?? ''),
            'phone'        => trim($_POST['phone'] ?? ''),
        ];

        $this->model->create($data);
        $this->redirect(
            '?controller=doctor&action=index&success='
            . urlencode('Médico creado correctamente.')
        );
    }

    public function edit(): void
    {
        $id     = (int)($_GET['id'] ?? 0);
        $doctor = $this->model->find($id);
        $ser    = urlencode(json_encode($doctor));

        header("Location: ?controller=doctor&action=index&showModal=1&doctor={$ser}");
        exit;
    }

    public function update(): void
    {
        $id = (int)($_GET['id'] ?? 0);

        $data = [
            'name'         => trim(($_POST['first_name'] ?? '') . ' ' . ($_POST['last_name'] ?? '')),
            'dni'          => trim($_POST['dni'] ?? ''),
            'specialty_id' => (int) ($_POST['specialty_id'] ?? 0),
            'address'      => trim($_POST['address'] ?? ''),
            'email'        => trim($_POST['email'] ?? ''),
            'phone'        => trim($_POST['phone'] ?? ''),
        ];

        $this->model->update($id, $data);
        $this->redirect(
            '?controller=doctor&action=index&success='
            . urlencode('Médico actualizado correctamente.')
        );
    }

    public function delete(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $this->model->delete($id);
        $this->redirect(
            '?controller=doctor&action=index&success='
            . urlencode('Médico eliminado correctamente.')
        );
    }
}
