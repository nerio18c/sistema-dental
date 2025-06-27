<?php
// controllers/OdontogramController.php
class OdontogramController extends BaseController
{
    public function index()
    {
        // Cargar estados previos desde DB si lo deseas
        $this->render('odontogram/index');
    }
}
