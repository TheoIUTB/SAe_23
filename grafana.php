<?php
session_start();

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: connexion.php');
    exit;
}

// Check permissions based on the user's role
if ($_SESSION['role'] !== 'administrateur') {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr" class="grafana">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Grafana</title>
    <meta name="author" content="MD" />
    <link rel="stylesheet" href="styles/styles.css" />
    <meta name="description" content="Page de graphiques" />
    <meta name="keywords" content="grafana" />
</head>
<body class="grafana">
    <header>
        <nav>
            <ul>
                <li><div class="item"><a href="index.php">Accueil</a></div></li>
                <li><div class="item"><a href="plan_fr.php">Plan</a></div></li>
                <li><div class="item"><a href="consultation.php">Consultation</a></div></li>
                <li><div class="item"><a href="batiment1.php">R&T</a></div></li>
                <li><div class="item"><a href="batiment2.php">GIM</a></div></li>
                <li><div class="item"><a href="CDC.php">Cahier des charges</a></div></li>
                <?php if ($_SESSION['role'] == 'administrateur'): ?>
                    <li><div class="item"><a href="index2.php">AJout/Supp</a></div></li>
                <?php endif; ?>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <li><div class="item"><a href="deconnexion.php">Déconnexion</a></div></li>
                <?php else: ?>
                    <li><div class="item"><a href="connexion.php">Connexion</a></div></li>
                <?php endif; ?>
            </ul>
        </nav>
    </header>
    <h1 class="gim">Grafana</h1>
    <h2>Mesures Bâtiment E:</h2>
    <!-- Embed Grafana dashboards for building E -->
    <iframe src="http://192.168.52.128:3000/public-dashboards/c155f30c03704b848ab9970b426f6c34" width="100%" height="455" frameborder="0"></iframe>
    <iframe src="http://192.168.52.128:3000/public-dashboards/50b2bb918abc4eedb2e39b75afcaf17c" width="100%" height="455" frameborder="0"></iframe>
    <h2>Mesures Bâtiment B:</h2>
    <!-- Embed Grafana dashboards for building B -->
    <iframe src="http://192.168.52.128:3000/public-dashboards/9968cec25e8949808c30fdd78e7fbabd" width="100%" height="455" frameborder="0"></iframe>
    <iframe src="http://192.168.52.128:3000/public-dashboards/c28f30ac0a94417bb527ecce9d2ba608" width="100%" height="455" frameborder="0"></iframe>
    <footer>
        <p>
            <!-- W3C validation links for CSS and HTML -->
            <a href="http://jigsaw.w3.org/css-validator/validator?lang=en&profile=css3svg&uri=http%3A%2F%2Fduprat.atwebpages.com%2Fsae15%2Fbatiment2.html&usermedium=all&vextwarning=&warning=1" style="float: left;"><img src="images/vcss-blue.png" alt="css" /></a>
            <a href="http://duprat.atwebpages.com/sae15/batiment2.html" style="float: left;"><img src="images/html.png" alt="html" style="height: 30px; width: 90px;" /></a>
            <a href="https://www.iut-blagnac.fr/fr/" style="text-decoration: none; color: aqua;">IUT Blagnac</a> | <a href="https://dupratmatteo.com" style="text-decoration: none; color: aqua;">DUPRAT</a> | <a style="text-decoration: none; color: aqua;">DURAND-NAUZE</a> | <a style="text-decoration: none; color: aqua;">BERNA</a> | <a style="text-decoration: none; color: aqua;">MENTASTI</a>
        </p>
    </footer>
</body>
</html>