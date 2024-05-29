<!DOCTYPE html>
<html lang="FR">

<head>
    <meta charset="UTF-8">
    <title>Accès Espace Administrateur</title>
    <link rel="stylesheet" href="<?= $adminRoot; ?>/assets/css/style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="<?= $adminRoot; ?>/assets/scripts/modal.js"></script>
</head>

<body>
<?php require_once $templatesRoot . 'header.php'; ?>

<?php if ($owner) { ?>
    <!-- Sub Header -->
    <div class="sub-header">
        <div class="left-part">
            <span class="title">Espace<br>Administrateur</span>
            <p>Pour nous aider à évaluer et comparer les perceptions de la valeur de l'information entre les
                journalistes/professionnels de l'information et le grand public</p>
        </div>
        <div class="right-part">
            <div class="top">
                <div class="top-left">
                    <img src="<?= $adminRoot; ?>/assets/img/white-star.png" class="left-star" alt="white-star">
                    <img src="<?= $adminRoot; ?>/assets/img/black-star.png" class="right-star" alt="black-star"></div>
                <div class="top-right">

                </div>
            </div>

            <div class="bot">
                <a id="imsic-link"><img class="left-star" src="<?= $adminRoot; ?>/assets/img/Help.png"/>L’IMSIC c’est quoi ?</a>
            </div>
        </div>
    </div>
    <!-- End Sub Header -->

    <a href="../conditions-generales.php">TEST</a>


    <div class="gestion">
        <div class="gestion__top">
            <div class="gestion__top--title">
                <h2>Gestion des administrateurs</h2>
                <h3>Vous pouvez ajouter ou supprimer des administrateurs.</h3>
            </div>
            <button class="showModal">Ajouter un admin</button>
        </div>
        <div class="gestion__content">
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
            <ul>
                <?php foreach ($adminUsers as $user) { ?>
                    <li>
                        <span><?= $user['identifiant'] ?></span>
                        <span><?= $user['date'] ?></span>
                        <?php if ($user['identifiant'] != $_SESSION['login']) { ?>
                            <a href="<?= $adminRoot ?>/user/?action=remove&id=<?= $user['identifiant'] ?>">Supprimer</a>
                        <?php } ?>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>

<?php } ?>
<div class="modal" data-type="addUser">
    <div class="modal__form">
        <?= $addUserForm ?>
    </div>
    <div class="modal__constraint">
        <p>Le mot de passe doit comporter :</p>
        <ul>
            <li>8 caractères</li>
            <li>1 majuscule</li>
            <li>1 minuscule</li>
            <li>1 caractère spécial</li>
        </ul>
    </div>
</div>
</body>
<?php require_once $templatesRoot . 'footer.php'; ?>
</html>