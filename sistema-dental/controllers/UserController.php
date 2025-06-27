<?php
// controllers/UserController.php
class UserController extends BaseController
{
    private $model;

    public function __construct(PDO $pdo)
    {
        parent::__construct($pdo);
        $this->model = new User($pdo);
    }

    public function index()
    {
        $users = $this->model->all();
        $this->render('users/list', ['users' => $users]);
    }

    public function create()
    {
        $this->render('users/form');
    }

    public function store()
    {
        $this->model->create($_POST);
        $this->redirect('?controller=user&action=index');
    }

    public function edit()
    {
        $user = $this->model->find($_GET['id']);
        $this->render('users/form', ['user' => $user]);
    }

    public function update()
    {
        $this->model->update($_GET['id'], $_POST);
        $this->redirect('?controller=user&action=index');
    }

    public function delete()
    {
        $this->model->delete($_GET['id']);
        $this->redirect('?controller=user&action=index');
    }
}
