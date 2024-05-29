<?php 

class QuestionAdminController extends AdminControllerCore{
    private array $errors = [];

    public function __construct()
    {
        $this->template = 'index.php';
    }

    public function run(): bool
    {
        if(!key_exists('token', $_SESSION) || $_SESSION['token'] != (new LoginAdminController())->getToken($_SESSION['login'])){

            header('Location: ../');
            die;
        }

        if(key_exists('action', $_GET)){
            $this->executeAction($_GET);
        }
        if ($this->errors != []) {
            $_SESSION['errors'] = json_encode($this->errors);
        }
        header('Location: ../');
        return true;
    }

    private function executeAction($params){       

        switch ($params['action']) {
            case 'remove':
            (new QuestionModel())->removeQuestion($params['id']);
            break;
            case 'add':
            if ($_GET['question'] == '') {
                $this->errors[] = 'La question ne peut pas être vide.';
                break;
            }
            (new QuestionModel())->addQuestion($params['questionType'],$params['libelle'],$params['images'],$params['slider'],$params['reponses']);
            break;
        }
    }
}