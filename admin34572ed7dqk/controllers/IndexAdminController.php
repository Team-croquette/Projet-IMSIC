<?php 

class IndexAdminController extends AdminControllerCore{
    protected string $name;

    public function __construct()
    {
        $this->template = 'index.php';
    }

    public function run(): bool
    {
        if (!key_exists('token',$_SESSION)){
            header('Location: ./login/');
            die;
        }
        if( $_SESSION['token'] != (new LoginAdminController())->getToken($_SESSION['login'])) {
            header('Location: ./login/');
            die;
        }
        $this->renderTemplate($this->getTemplateVariables());
        return true;
    } 

    private function getTemplateVariables():array{
        
        $owner = (new UserModel())->isOwner($_SESSION['login']);
        $vars = [
            'title' => 'Espace administrateur',
            'owner' => $owner,
        ];

        if ($owner) {
            $vars['adminUsers'] =  (new UserModel())->getAllUser();
            $vars['addUserForm'] =  $this->getForm();
        }
        return $vars ;
    }

    private function getForm():string
    {
        $formBuilder = new FormBuilder();
        $formBuilder
            ->setAction('./user/index.php')
            ->setMethod('GET')
            ->setClass('form')
            ->add('login','Identifiant', InputTypeEnum::TEXT,true)
            ->add('password','Mot de passe', InputTypeEnum::PASSWORD,true,'', ['pattern' => '^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$'])
            ->add('confirm_password','Confirmation mot de passe', InputTypeEnum::PASSWORD,true,'', ['pattern' => '^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$'])
            ->add('action','', InputTypeEnum::HIDDEN,true,'add')
            ->add('submit','', InputTypeEnum::SUBMIT,true,'Créer');

        return $formBuilder->renderForm();
    }
}
