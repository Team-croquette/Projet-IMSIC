<header>
<link rel="stylesheet" href="<?= $siteRoot ?>/assets/style/popupCaptchaStyle.css">
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script src="<?= $siteRoot ?>/assets/script/scriptCaptcha.js"></script>
    <nav>
        <ul>
            <li><a href="home">Accueil</a></li>
            <li><a href="admin">Admin</a></li>
            <li><a href="quest" <?= $resultSecuIp; ?> >Questionnaire</a></li>
        </ul>
    </nav>
</header>