<?php 

class IndexAdminController extends AdminControllerCore{
    protected string $name;

    public function __construct()
    {
        $this->template = 'index.php';
    }

    public function run(): bool
    {
        $this->renderTemplate();
        return true;
    }
}
