<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./assets/css/index.css">
    <title>Votre titre</title>
</head>
<body>

<!-- Header -->
<?php require $header; ?>

<!-- Body -->
<div id="content">
    <?php echo $question; ?>
    <?php echo $reponses; ?>
</div>

<!-- Footer -->
<?php require $footer; ?>

</body>
</html>
