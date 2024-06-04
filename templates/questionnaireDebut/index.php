<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Début du questionnaire</title>
    <link rel="stylesheet" href="<?= $siteRoot; ?>/assets/css/style.css">
    <link rel="icon" type="image/x-icon" href="../assets/img/icon_question_mark.ico">
</head>
<body>
<?php require_once $templatesRoot . 'header.php'; ?>

<div class="content home">
    <!-- Sub Header -->
    <div class="sub-header">
        <div class="left-part">
            <span class="title">Avant de répondre au <br>questionnaire</span>
            <p>Merci de prendre connaissances des conditions générales d'utilisation ci-dessous.<br>
                Les résultats sont anonymes et ne éseront pas utilisés à des fins commerciales.
            </p>

            <div id="home-buttons">
                <a id="home-imsic" class="button" href="../CGU.pdf">Lire les conditions</a>
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
        <div id="form">
            <?= $form; ?>
        </div>
        </div>
    </div>
</div>
<div id="void">
</div>
<?php require_once $templatesRoot . 'footer.php'; ?>

</body>
</html>