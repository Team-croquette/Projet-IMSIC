<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Accès Espace Administrateur</title>
    <link rel="stylesheet" href="<?= $adminRoot; ?>/assets/css/style.css">

</head>
<body>
    <?php require_once '../../'.$templatesRoot .'header.php'; ?>

    <div class="content">
        <ul class="alert-error">
            <?php
            foreach ($errors as $message) {
            ?>
            <li>
                <?= $message; ?>
            </li>
            <?php
        }
        ?>
    </ul>
    <div id="adminConnect">
        <div id="form">
            <?= $form; ?>
        </div>
        <div id="text">
            <img class="left-star" src="<?= $adminRoot; ?>/assets/img/white-star.png"/>
            <h1>Accès Espace<br/>Administrateur</h1>
            <img class="right-star" src="<?= $adminRoot; ?>/assets/img/black-star.png"/>
        </div>
    </div>
</div>

</body>
</html>