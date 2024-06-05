<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= $siteRoot ?>assets/css/style.css">
    <link rel="icon" type="image/x-icon" href="../../assets/img/icon_question_mark.ico">
    <title>Votre titre</title>
</head>
<body>

<!-- Header -->
<?php require $header; ?>

<!-- Sub Header -->
<div class="sub-header">
    <div class="left-part">
        <span class="title">Le questionnaire</span>
        <p>Pour nous aider à évaluer et comparer les perceptions de la valeur de l'information entre les
            journalistes/professionnels de l'information et le grand public</p>

        <div id="home-buttons">

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

<!-- Body -->
<div id="content">
    <?php echo $question; ?>
    <?php echo $reponses; ?>
</div>
<div id="void"></div>
<!-- Footer -->
<?php require $footer; ?>

</body>
</html>
