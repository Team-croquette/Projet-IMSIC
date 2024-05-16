<!DOCTYPE html>
<html>

</html>
<body>
    <ul class="alert-error">
        <?php
        foreach ($errors as $message) {
            ?>
        <li>
            <?= $message ?>
        </li>
            <?php
        }
        ?>
    </ul>
<?= $form ?>
</body>