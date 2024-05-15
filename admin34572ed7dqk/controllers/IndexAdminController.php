<?php 

class IndexAdminController extends AdminControllerCore{
    protected string $name;

    public function run(): bool
    {
        var_dump('Yolo');
        die;
        return true;
    }
}