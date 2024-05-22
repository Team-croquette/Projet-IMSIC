<?php


class IndexController extends ControllerCore
{
    protected string $name;

    public function __construct()
    {
        $this->template = 'index.php';
    }

    public function run(): bool
    {
        $this->renderTemplate($this->getTemplateVariables());
        return true;
    }

    private function getTemplateVariables():array
    {
        $header = SITE_PATH . '/templates/header.php';
        $footer = SITE_PATH . '/templates/footer.php';
        $resultSecuIp = 'class="disabled"';
        return [
            'header' => $header,
            'footer' => $footer,
            'resultSecuIp' => $resultSecuIp,
        ];
    }
}