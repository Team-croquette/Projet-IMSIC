<?php

require_once SITE_PATH . '/controllers/SecuIpController.php';

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
        $secuIp = new SecuIpController();
        $result = $secuIp->run();
        $info = $secuIp->getInfo();
        if ($result){
            $resultSecuIp = 'class="disabled"';
        } else {
            $resultSecuIp = 'class="enabled"';
        }

        $header = SITE_PATH . '/templates/header.php';
        $footer = SITE_PATH . '/templates/footer.php';
        return [
            'header' => $header,
            'footer' => $footer,
            'resultSecuIp' => $resultSecuIp,
            'info' => $info,
        ];
    }
}