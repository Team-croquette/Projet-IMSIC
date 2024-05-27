<?php

$basePath = explode('site',dirname(__FILE__))[0];
define('BASE_PATH', $basePath);
define('SITE_PATH', $basePath . '/site/');

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

    protected function renderTemplate(): void
    {
        $siteRoot = explode('www/',SITE_PATH,2)[1];
        $templatesRoot = SITE_PATH.'/templates/';
        if ($siteRoot[0] !== '/') {
            $siteRoot = '/' . $siteRoot;
        }
        if ($this->name == null || $this->template == null) {
            require SITE_PATH . '/templates/index/index.php';
        } else {
            require SITE_PATH . '/templates/' . $this->name . '/' . $this->template;
        }
    }
}