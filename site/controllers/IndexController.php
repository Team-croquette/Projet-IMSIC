<?php

namespace controllers;
use AdminControllerCore;

class IndexController extends AdminControllerCore
{
    protected string $name;

    public function run(): bool
    {
        var_dump('Yolo');
        die;
        return true;
    }
}