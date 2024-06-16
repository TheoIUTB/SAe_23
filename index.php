<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Accueil</title>
    <meta name="author" content="MD" />
    <meta name="description" content="Accueil site" />
    <meta name="keywords" content="Accueil" />
    <link rel="stylesheet" href="styles/styles.css">
</head>
<body>
<header>
    <nav>
        <ul>
            <li><div class="item"><a href="index.php">Accueil</a></div></li>
            <li><div class="item"><a href="pres_sae.php">Gestion de projet</a></div></li>
	    	<li><div class="item"><a href="consultation.php">Consultation</a></div></li>
			<li><div class="item"><a href="batiment1.php">R&T</a></div></li>
            <li><div class="item"><a href="batiment2.php">GIM</a></div></li>
            <?php if (isset($_SESSION['role'])): ?>
		<?php if ($_SESSION['role'] == 'administrateur'): ?>
                    <li><div class="item"><a href="index2.php">AJout/Supp</a></div></li>
                <?php endif; ?>
                <li><div class="item"><a href="deconnexion.php">Déconnexion</a></div></li>
            <?php else: ?>
                <li><div class="item"><a href="connexion.php">Connexion</a></div></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
<section class="display">
    <div class="choix2">
        <h1>Ressources de cette SAÉ</h1>
        <a href="CDC.php" class="a"><h3>Cahier des charges</h3></a>
        <a href="pres_sae.php" class="a"><h3>Gestion de projet</h3></a>
    </div>
    <div class="choix2">
        <h1>Choisir entre les bâtiments :</h1><br>
        <a href="batiment1.php" class="a"><h3>Réseaux et Télécommunications</h3></a>
        <a href="batiment2.php" class="a"><h3>Génie Mécanique et Industriel</h3></a>
    </div>
</section>
<footer>
    <p>
        <a href="METTRE LIEN" style="float: left;"><img src="images/vcss-blue.png" alt="css" /></a>
        <a href="METTRE LIEN" style="float: left;"><img src="images/html.png" alt="html" style="height: 30px; width: 90px;" /></a>
        <a href="https://www.iut-blagnac.fr/fr/" style="text-decoration: none; color: aqua;">IUT Blagnac</a> | <a href="https://dupratmatteo.com" style="text-decoration: none; color: aqua;">LAVIALLE</a> | <a style="text-decoration: none; color: aqua;">NUNES DIAS</a> | <a style="text-decoration: none; color: aqua;">REYNAUD</a> | <a style="text-decoration: none; color: aqua;">LOPEZ</a>
    </p>
</footer>
</body>
</html>
