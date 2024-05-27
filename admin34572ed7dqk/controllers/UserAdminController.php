<?php 

class UserAdminController extends AdminControllerCore{
    private array $errors = [];

    public function __construct()
    {
        $this->template = 'index.php';
    }

    public function run(): bool
    {
        if(!key_exists('token', $_SESSION) || !((new UserModel())->isOwner($_SESSION['login']))){

            header('Location: ../');
            die;
        }

        if(key_exists('action', $_GET)){
            $this->executeAction($_GET);
        }
        if ($this->errors != []) {
            header('Params: '.json_encode($this->errors));
            header('Method: POST');
        }
        header('Location: ../');
        return true;
    }

    private function executeAction($params){       

        switch ($params['action']) {
            case 'remove':
                (new UserModel())->removeUser($_GET['id']);
                break;
            case 'add':
                if ($_GET['password'] != $_GET['confirm_password']) {
                    $this->errors[] = 'Les mots de passe ne correspondent pas.';
                }
                (new UserModel())->addUser($_GET['login'],$_GET['password']);
                break;

        }
    }
}