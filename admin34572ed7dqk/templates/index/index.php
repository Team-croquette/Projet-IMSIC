<!DOCTYPE html>
<html lang="FR">
<body>
    <?php require_once $templatesRoot .'header.php'; ?>

    <?php if ($owner) {?>
        <div class="gestion">
            <div class="gestion__top">
                <div class="gestion__top--title">
                    <h2>Gestion des administrateurs</h2>
                    <h3>Vous pouvez ajouter ou supprimer des administrateurs.</h3>
                </div>
                <button onclick="">Ajouter un admin</button>
            </div>
            <div class="gestion__content">
                <ul>
                    <?php foreach($adminUsers as $user){?>
                    <li>
                        <span><?= $user['identifiant'] ?></span>
                        <span><?= $user['date'] ?></span>
                        <?php if($user['identifiant'] != $_SESSION['login']){?>
                            <a href="<?= $adminRoot ?>/user/?action=remove&id=<?= $user['identifiant']?>">Supprimer</a>
                        <?php }?>
                    </li>
                    <?php } ?>
                </ul>
            </div>
        </div>

    <?php } ?>
</body>
</html>
