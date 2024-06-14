<?php
session_start();
$servername = "localhost";
		$username = "tnunes";
		$password = "motdepasse";
		$dbname = "sae23";

		// Create a connection to SQL database
		$conn = new mysqli($servername, $username, $password, $dbname);

		if ($conn->connect_error) {
			die("Connexion echouee: " . $conn->connect_error);
		}
		
 ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Ajout/Supp</title>
    <meta name="author" content="MD" />
    <link rel="stylesheet" href="styles/style.css" />
    <meta name="description" content="Ajout/Supp salles/bats" />
    <meta name="keywords" content="ajout/supp" />
    <meta http-equiv="refresh" content="30" />
</head>
<body>
    <header>
        <nav>
            <ul>
                <li><div class="item"><a href="index.php">Accueil</a></div></li>
            	<li><div class="item"><a href="pres_sae.html">Gestion de projet</a></div></li>
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
<body>
	<div class="container">
		<h2>Ajouter un Bâtiment </h2>
		<form action="./batiment.php" method="POST">
		
			<input type="hidden" name="action" value="add_batiment">
			
			<label for="bat_id">Nom:</label>
			<input type="text" id="bat_id" name="bat_id" required>

			<select name="gest_id" id="gest_id">

				<option value="">--Please choose an option--</option>
					<?php

				$req = "SELECT * FROM `Gestionnaire` WHERE 1;";
				$res = $conn->query($req);


				$gestionnaires = [];
				if ($res != false && $res->num_rows > 0) {
				while ($row = $res->fetch_assoc()) {
					$gestionnaires[] = $row;
				}
				}



				foreach ($gestionnaires as $gestionnaire) {
				echo "<option value=\"" . htmlspecialchars($gestionnaire['id_gestionnaire']) . "\">" . htmlspecialchars($gestionnaire['login']) . "</option>";
				}
				?>
			</select>




			<button type="submit">Ajouter</button>
		</form>
	</div>









	<div class="container">
		<h2>Supprimer un Bâtiment </h2>
		<form action="./batiment.php" method="POST">
		
			<input type="hidden" name="action" value="delete_batiment">
			
			<select name="bat_id" id="bat_id">

				<option value="">--Please choose an option--</option>
					<?php

				$req = "SELECT * FROM `batiment` WHERE 1;";
				$res = $conn->query($req);


				$batiments = [];
				if ($res != false && $res->num_rows > 0) {
				while ($row = $res->fetch_assoc()) {
					$batiments[] = $row;
				}
				}



				foreach ($batiments as $batiment) {
				echo "<option value=\"" . htmlspecialchars($batiment['id_batiment']) . "\">" . htmlspecialchars($batiment['nom']) . "</option>";
				}
				?>
			</select>
			
			<button type="submit">Supprimer</button>
		</form>
	</div>
	






	<div class="container">
		<h2>Ajouter une Salle </h2>
		<form action="./salle.php" method="POST">
		
			<input type="hidden" name="action" value="add_salle">
			
			<label for="bat_id">Batiment:</label>
			<select name="bat_id" id="bat_id">
			<option value="">--Please choose an option--</option>
					
					
					
					<?php
			
			$req = "SELECT * FROM `batiment` WHERE 1;";
			$res = $conn->query($req);
			
			
			$batiments = [];
			if ($res != false && $res->num_rows > 0) {
				while ($row = $res->fetch_assoc()) {
					$batiments[] = $row;
				}
			}

			
			
			foreach ($batiments as $batiment) {
			echo "<option value=\"" . htmlspecialchars($batiment['id_batiment']) . "\">" . htmlspecialchars($batiment['nom']) . "</option>";
			}
			?>



			</select>
			
			<label for="name">Nom:</label>*
			<input type="text" id="name" name="name" required>
			
			<label for="type">Type:</label>
			<input type="text" id="type" name="type" required>
			
			<label for="capacite">Capacité:</label>
			<input type="text" id="capacity" name="capacity" required>
			
			<button type="submit">Ajouter</button>
		</form>
	</div>








	<div class="container">
		<h2>Supprimer une Salle </h2>
		<form action="./salle.php" method="POST">
		
			<input type="hidden" name="action" value="delete_salle">
			
			<label for="id">ID:</label>
			<!-- <input type="number" id="id" name="id" required> !-->
			<select name="id" id="id">

			<option value="">--Please choose an option--</option>

					<?php
			
			$req = "SELECT * FROM `salle` WHERE 1;";
			$res = $conn->query($req);
			
			
			$salles = [];
			if ($res != false && $res->num_rows > 0) {
				while ($row = $res->fetch_assoc()) {
					$salles[] = $row;
				}
			}
			

			
			foreach ($salles as $salle) {
			echo "<option value=\"" . htmlspecialchars($salle['id_salle']) . "\">" . htmlspecialchars($salle['nom']) . "</option>";
			}
			?>
			</select>
			<button type="submit">Supprimer</button>
		</form>
	</div>
</body>
</html>


<?php 
$conn->close();
		

?>
