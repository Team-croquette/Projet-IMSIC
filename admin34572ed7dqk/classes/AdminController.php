<?php 

$basePath = explode('admin34572ed7dqk',dirname(__FILE__))[0];
$basePath = str_replace('\\','/',$basePath);
define('ROOT_PATH',$basePath);
define('ADMIN_PATH',$basePath.'/admin34572ed7dqk/');

class AdminControllerCore{
    protected string $name;
    protected string $template;

    public static function getInstanceByName($name) : AdminControllerCore {
        $className =  ucfirst($name) .'AdminController';
        require_once ADMIN_PATH.'/controllers/' . $className .'.php';
        $controller = new $className();
        $controller->setName($name);
        return $controller;
    }
    
    public function run(): bool
    {
        return true;
    }

    public function setName($name): void
    {
        $this->name = $name;
    }

    protected function renderTemplate($variables = []): void
    {
        foreach($variables as $varName => $varValue){
            $$varName = $varValue;
        }
        require ADMIN_PATH.'/templates/' . $this->name . '/' . $this->template;
    }
}