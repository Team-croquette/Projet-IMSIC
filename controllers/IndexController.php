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
        if (isset($_SESSION['VerifIp'])) {
            if(!$_SESSION['VerifIp']){
                $info = '<script type="text/javascript">window.alert("'. $_SESSION['info'] .'");</script>';
    
                $header = SITE_PATH . '/templates/header.php';
                $footer = SITE_PATH . '/templates/footer.php';
                return [
                    'header' => $header,
                    'footer' => $footer,
                    'info' => $info,
                ];
            }else {
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