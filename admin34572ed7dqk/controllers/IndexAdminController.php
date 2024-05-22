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

    private function getTemplateVariables():array
    {
        $adminRoot = explode('www/',ADMIN_PATH,2)[1];
        return [
            'adminRoot' => $adminRoot,
        ];
    }
}
