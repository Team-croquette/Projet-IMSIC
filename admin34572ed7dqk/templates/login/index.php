<!DOCTYPE html>
<html>

</html>

<body>
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
        <div>
            <div>
                <?= $form; ?>
            </div>
            <div>
                <img src="<?= $adminRoot; ?>/assets/img/white-star.png"/>
                <h1>Accès Espace Administrateur</h1>
                <img src="<?= $adminRoot; ?>/assets/img/black-star.png"/>
            </div>
        </div>
    </div>

</body>