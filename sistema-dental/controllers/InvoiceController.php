<?php
// controllers/InvoiceController.php
class InvoiceController extends BaseController
{
    private $model, $patientModel;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->model        = new Invoice($pdo);
        $this->patientModel = new Patient($pdo);
    }

    public function index()
    {
        $invoices = $this->model->all();
        $patients = $this->patientModel->all();
        $this->render('invoices/list',['invoices'=>$invoices,'patients'=>$patients]);
    }

    public function view()
    {
        $inv      = $this->model->find($_GET['id']);
        $patient  = $this->patientModel->find($inv['patient_id']);
        $this->render('invoices/view',['invoice'=>$inv,'patient'=>$patient]);
    }

    public function create()
    {
        // Lógica para generar factura: suma tratamientos, etc.
        // Por simplicidad, formulario manual:
        $patients = $this->patientModel->all();
        $this->render('invoices/form',['patients'=>$patients]);
    }

    public function store()
    {
        $id = $this->model->create($_POST);
        $this->redirect("?controller=invoice&action=view&id={$id}");
    }
}
