<?php

$basePath = explode('classes',dirname(__FILE__))[0];
define('BASE_PATH', $basePath);
define('SITE_PATH', $basePath);

if (!file_exists(BASE_PATH . '/.env')) {
    throw new Exception("Le fichier .env n'existe pas.");
}

$file = file(BASE_PATH.'/.env');
foreach ($file as $line) {
    if (strpos(trim($line), '#') === 0) {
        continue;
    }

    list($key, $value) = explode(':', $line, 2);
    $key = trim($key);
    $value = trim($value);

    if (!array_key_exists($key, $_ENV)) {
        putenv(sprintf('%s=%s', $key, $value));
        $_ENV[$key] = $value;
    }
}

class ControllerCore{
    protected string $name;
    protected string $template;


    public static function getInstanceByName($name) : ControllerCore {
        $className =  ucfirst($name) .'Controller';
        require_once SITE_PATH . '/controllers/' . $className .'.php';
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
        $siteRoot = $_ENV["PROJECT_ROOT"];
        $templatesRoot = SITE_PATH.'/templates/';
        if ($siteRoot[0] !== '/') {
            $siteRoot = '/' . $siteRoot;
        }
        foreach($variables as $varName => $varValue){
            $$varName = $varValue;
        }

        if ($this->name == null || $this->template == null) {
            require $templatesRoot . '/index/index.php';
        } else {
            require $templatesRoot . $this->name . '/' . $this->template;
        }
    }
}