<?php 

class ControllerCore{
    protected string $name;
    protected string $template;


    public static function getInstanceByName($name) : ControllerCore {
        $className =  ucfirst($name) .'Controller';
        require_once '../controllers/' . $className .'.php';
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

    protected function renderTemplate(): void
    {
        require '../templates/' . $this->name . '/' . $this->template;
    }
}