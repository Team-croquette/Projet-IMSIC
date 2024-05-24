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
        header('Location: ../');
        return true;
    }

    private function executeAction($params){

        switch ($params['action']) {
            case 'remove':
                (new UserModel())->removeUser($_GET['id']);
                break;
            
            default:
                # code...
                break;
        }
    }
}