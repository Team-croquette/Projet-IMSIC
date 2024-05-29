<header>

    <!-- code captcha -->
    <link rel="stylesheet" href="<?= $siteRoot ?>/assets/style/popupCaptchaStyle.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script type="text/javascript">
        const siteRoot = '<?= $siteRoot;?>';
    </script>
    <script src="<?= $siteRoot ?>/assets/script/scriptCaptcha.js"></script>
    <?php include 'templates/popupCaptcha/index.php' ?>

    <nav>
        <ul>
            <li><a href="home">Accueil</a></li>
            <li><a href="admin">Admin</a></li>
            <li><a id="openPopupBtn" <?= $resultSecuIp; ?> >Questionnaire</a></li>
        </ul>
    </nav>
</header>