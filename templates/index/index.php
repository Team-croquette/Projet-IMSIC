<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IMSIC Questionnaire - Accueil</title>
    <link rel="stylesheet" href="<?= $siteRoot; ?>assets/css/style.css">
    <link rel="stylesheet" href="<?= $siteRoot; ?>assets/css/index.css">
    <link rel="icon" type="image/x-icon" href="./assets/img/icon_question_mark.ico">
</head>
<body>
<?php require_once $templatesRoot . 'header.php'; ?>

<div class="content home">
    <!-- Sub Header -->
    <div class="sub-header">
        <div class="left-part">
            <span class="title">Répondez à un<br>questionnaire</span>
            <p>Pour nous aider à évaluer et comparer les perceptions de la valeur de l'information entre les
                journalistes/professionnels de l'information et le grand public</p>

            <div id="home-buttons">
                <a id="start" class="button" href="https://www.imsic.fr/">
                    <img class="left-star" src="<?= $siteRoot; ?>assets/img/RocketLaunch.png"/>C’est parti</a>
                <a id="home-imsic" class="button" href="https://www.imsic.fr/">L’IMSIC c’est quoi ?</a>
            </div>
        </div>
        <div class="right-part">
            <div class="top">
                <div class="top-left">
                    <img src="<?= $siteRoot; ?>assets/img/white-star.png" class="left-star" alt="white-star">
                    <img src="<?= $siteRoot; ?>assets/img/black-star.png" class="right-star" alt="black-star"></div>
                <div class="top-right">

                </div>
            </div>

            <div class="bot">
            </div>
        </div>
    </div>
    <!-- End Sub Header -->

    <!-- Home content -->
    <div class="home-content">
        <div class="home-content__left">
            <div class="top-left">
                <img src="<?= $siteRoot; ?>assets/img/blue-star.png" class="left-star" alt="white-star">
            </div>
            <div class="bot-left">
                <div class="bot"></div>
            </div>
        </div>
        <div class="home-content__right">
            <span class="title">Un questionnaire éthique</span>
            <p>Géré par l’IMSIC, un organisme [Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod
                tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation
                ullamco laboris nisi ut aliquip ex ea commodo consequat.]</p>
            <div class="list">
                <div><img src="<?= $siteRoot; ?>assets/img/GDPR.png" class="icon" alt="icon">Anonyme</div>
                <div><img src="<?= $siteRoot; ?>assets/img/Smiling.png" class="icon" alt="icon">Ludique</div>
            </div>
            <div class="list">
                <div><img src="<?= $siteRoot; ?>assets/img/Scales.png" class="icon" alt="icon">Etique</div>
                <div><img src="<?= $siteRoot; ?>assets/img/Statistics.png" class="icon" alt="icon">Enrichissant</div>
            </div>
        </div>
    </div>

    </div>
    <?php require_once $templatesRoot . 'footer.php'; ?>

</body>
</html>