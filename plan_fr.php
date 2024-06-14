<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plan</title>
    <meta name="author" content="MD" />
    <link rel="stylesheet" href="styles/styles.css">
    <meta name="description" content="Plan du site" />
    <meta name="keywords" content="plan" />
</head>
<body>
<header>
    <nav>
        <ul>
            <li><div class="item"><a href="index.php">Accueil</a></div></li>
            <li><div class="item"><a href="plan_fr.php">Plan</a></div></li>
	    <li><div class="item"><a href="consultation.php">Consultation</a></div></li>
	    <li><div class="item"><a href="CDC.php">Cahier des charges</a></div></li>
            <?php if (isset($_SESSION['role'])): ?>
                <?php if ($_SESSION['role'] == 'administrateur' || $_SESSION['role'] == 'gestionnaire1'): ?>
                    <li><div class="item"><a href="batiment1.php">R&T</a></div></li>
                <?php endif; ?>
                <?php if ($_SESSION['role'] == 'administrateur' || $_SESSION['role'] == 'gestionnaire2'): ?>
                    <li><div class="item"><a href="batiment2.php">GIM</a></div></li>
                <?php endif; ?>
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
    <div class="divplan">
        <h2>Cliquez sur le bâtiment de votre choix (R&amp;T ou GIM) :</h2>
        <img src="images/plan.jpg" usemap="#image-map" class="plan">

        <map name="image-map">
            <area target="" alt="Bâtiment R&amp;T" title="Bâtiment R&amp;T" href="batiment1.php" coords="70,359,443,219,492,254,472,383,170,512,99,488" shape="poly">
            <area target="" alt="Bâtiment GIM" title="Bâtiment GIM" href="batiment2.php" coords="779,349,884,274,922,207,920,127,1086,132,1117,219,1058,411,940,516,817,453" shape="poly">
        </map>
    </div>
</body>
</html>