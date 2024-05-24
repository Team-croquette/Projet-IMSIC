<header>
    <div id="left-part">
        <img class="left-star" src="<?= $adminRoot; ?>/assets/img/ask-question.png"/>
        <a>IMSIC Questionnaire</a>
    </div>

    <div id="right-part">
        <?php
        if (key_exists('token', $_SESSION)) {
            ?>
            <a href="<?= $adminRoot ?>/disconnect" id="disconnect">Déconnexion</a>
            <?php
        }
        ?>
        <a id="question"><img class="left-star" src="<?= $adminRoot; ?>/assets/img/Help.png"/>Question</a>
    </div>
</header>