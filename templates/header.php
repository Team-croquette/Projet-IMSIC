<header>
    <!-- code captcha -->
    <link rel="stylesheet" href="<?= $siteRoot ?>assets/style/popupCaptchaStyle.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script type="text/javascript">
        const siteRoot = '<?= $siteRoot;?>';
    </script>
    <script src="<?= $siteRoot ?>assets/script/scriptCaptcha.js"></script>
    <?php include 'templates/popupCaptcha/index.php' ?>

    <div id="left-part">
        <img class="left-star" src="<?= $siteRoot; ?>assets/img/ask-question.png"/>
        <a class="button" href="<?= $siteRoot ?>">IMSIC Questionnaire</a>
    </div>

    <div id="right-part" class="button">
        <a id="openPopupBtn" <?= $resultSecuIp; ?>><img class="left-star" src="<?= $siteRoot; ?>assets/img/Help.png"/>Questionnaire</a>
    </div>
</header>