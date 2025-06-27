<?php
// controllers/TreatmentController.php

class TreatmentController extends BaseController
{
    public function index()
    {
        global $pdo;                      // ↪️ Traemos la conexión PDO global
        $model      = new Treatment($pdo);
        $treatments = $model->all();
        $this->render('treatments/list', compact('treatments'));
    }

    public function store()
    {
        global $pdo;
        $model = new Treatment($pdo);
        $data  = [
            'name'  => trim($_POST['name']  ?? ''),
            'price' => trim($_POST['price'] ?? ''),
        ];

        if ($model->create($data)) {
            header('Location: ?controller=treatment&action=index&success=' . urlencode('Tratamiento creado'));
        } else {
            header('Location: ?controller=treatment&action=index&error='   . urlencode('Error al crear tratamiento'));
        }
    }

    public function update()
    {
        global $pdo;
        $id    = (int)($_GET['id'] ?? 0);
        $model = new Treatment($pdo);
        $data  = [
            'name'  => trim($_POST['name']  ?? ''),
            'price' => trim($_POST['price'] ?? ''),
        ];

        if ($model->update($id, $data)) {
            header('Location: ?controller=treatment&action=index&success=' . urlencode('Tratamiento actualizado'));
        } else {
            header('Location: ?controller=treatment&action=index&error='   . urlencode('Error al actualizar tratamiento'));
        }
    }

    public function delete()
    {
        global $pdo;
        $id    = (int)($_GET['id'] ?? 0);
        $model = new Treatment($pdo);

        if ($model->delete($id)) {
            header('Location: ?controller=treatment&action=index&success=' . urlencode('Tratamiento eliminado'));
        } else {
            header('Location: ?controller=treatment&action=index&error='   . urlencode('Error al eliminar tratamiento'));
        }
    }
}
