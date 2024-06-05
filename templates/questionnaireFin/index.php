<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Fin du questionnaire</title>
    <link rel="stylesheet" href="<?= $siteRoot; ?>/assets/css/style.css">
    <link rel="icon" type="image/x-icon" href="../assets/img/icon_question_mark.ico">
</head>
<body>
<?php require_once $templatesRoot . 'header.php'; ?>

<div class="content home">
    <!-- Sub Header -->
    <div class="sub-header">
        <div class="left-part">
            <span class="title">Merci d'avoir répondu au <br>questionnaire</span>
            <p>Pour nous aider à évaluer et comparer les perceptions de la valeur de l'information entre les
                journalistes/professionnels de l'information et le grand public</p>

            <div id="home-buttons">
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

</div>
<div id="void">
</div>
<?php require_once $templatesRoot . 'footer.php'; ?>

</body>
</html>