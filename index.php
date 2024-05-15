<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Votre titre</title>
</head>
<body>

<!-- Header -->
<?php include 'header.php'; ?>

<!-- Body -->
<div id="content"></div>

<!-- Footer -->
<?php include 'footer.php'; ?>

<!-- Script JavaScript pour charger le contenu dynamiquement -->
<script>
    // Fonction pour charger le contenu en fonction de l'URL
    function loadContent() {
        const url = window.location.pathname;
        const filename = url.substring(url.lastIndexOf('/') + 1);
        console.log(filename);
        const contentDiv = document.getElementById('content');

        // Charger le contenu correspondant
        if (filename === 'admin') {
            contentDiv.innerHTML = '<?php include './pages/admin/admin.php'; ?>';

        } else if (filename === 'home') {
            contentDiv.innerHTML = '<?php include './pages/home/home.php'; ?>';

        } else if (filename === 'secuIp') {
            contentDiv.innerHTML = '<?php include './site/controllers/SecuIpController.php'; ?>';

        } else {
            contentDiv.innerHTML = '<?php include './pages/notFound/notFound.php'; ?>';
        }
    }

    loadContent();
</script>
</body>
</html>
