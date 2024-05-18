<?php 

class LoginAdminController extends AdminControllerCore{
    private array $errors = [];

    public function __construct()
    {
        $this->template = 'index.php';
    }

    public function run(): bool
    {
        if(key_exists('token', $_SESSION)){
            header('Location: ../index.php');
            die;
        }
        if(key_exists('submit', $_POST)){
            $this->proccessForm();
        }
        $this->renderTemplate($this->getTemplateVariables());
        return true;
    }

    private function getTemplateVariables():array
    {
        $form = $this->getForm();
        return [
            'adminRoot' => str_replace(ROOT_PATH,'',ADMIN_PATH),
            'form' => $form,
            'errors' => $this->errors,
        ];
    }

    private function getForm():string
    {
        $formBuilder = new FormBuilder();
        $formBuilder
            ->add('login','Identifiant', InputTypeEnum::TEXT,true)
            ->add('password','Mot de passe', InputTypeEnum::PASSWORD,true)
            ->add('submit','', InputTypeEnum::SUBMIT,true,'Se connecter');

        return $formBuilder->renderForm();
    }

    private function proccessForm(){

        try {
            /* changer ce if par quelque chose qui regarde dans la bd */
            if (!(isset($_POST['login'])) || !(isset($_POST['password']) && password_verify($_POST['password'],'$2y$10$qC/qndTH5RspkCY/HYAsrOC4REl7YYNuz6u/2fjBmkiivIFaxc/e2')) ) {
                throw new Exception("L'identifiant ou le mot de passe est incorrect. Veuillez réessayer.", 1);
            }

            $_SESSION['token'] = $this->getToken($_POST['login']);
            $_SESSION['login'] = $_POST['login'];

            header('Location: ../index.php');
            die;
        } catch (\Throwable $th) {
            $this->errors[] = $th->getMessage();
        }
    }

    public function getToken(string $userLogin):string
    {
        return md5(base64_encode($userLogin.'_dclskc09_'.date('d-m-Y')));
    }
}