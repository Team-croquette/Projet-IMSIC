<header>
    <!-- code captcha -->
    <link rel="stylesheet" href="<?= $siteRoot ?>assets/style/popupCaptchaStyle.css">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script type="text/javascript">
        const siteRoot = '<?= $siteRoot;?>';
        const $templatesRoot = '<?= $templatesRoot;?>';
    </script>
    <script src="<?= $siteRoot ?>assets/script/scriptCaptcha.js"></script>
    <?php include SITE_PATH .'/templates/popupCaptcha/index.php' ?>
    
    <a class="button" href="<?= $siteRoot ?>">
        <div id="left-part">
            <img class="left-star" src="<?= $siteRoot; ?>assets/img/ask-question.png"/>
            <span class="left-title">IMSIC Questionnaire</span>
        </div>
    </a>
    <div id="right-part" class="button">
        <a id="openPopupBtn"><img class="left-star" src="<?= $siteRoot; ?>assets/img/Help.png"/>Questionnaire</a>
    </div>
</header>