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
        $secuIpCont = new SecuIpController();
        $secuIpMod = new SecuIpModel();
        if (! $secuIpMod->isIpDesac($secuIpCont->getIp())) {
            $result = $secuIpCont->run();
            $info = '<script type="text/javascript">window.alert("'. $secuIpCont->getInfo() .'");</script>';

            if ($result) {
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
        } else {
            $header = SITE_PATH . '/templates/header.php';
            $footer = SITE_PATH . '/templates/footer.php';
            $resultSecuIp = 'class="enabled"';
            $info = '';
            return [
                'header' => $header,
                'footer' => $footer,
                'resultSecuIp' => $resultSecuIp,
                'info' => $info,
            ];
        }
    }
}