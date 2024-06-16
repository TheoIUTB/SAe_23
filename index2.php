<?php
session_start();
$servername = "localhost";
$username = "tnunes";
$password = "motdepasse";
$dbname = "sae23";

// Create a connection to SQL database
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connexion échouée: " . $conn->connect_error);
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
        <h2>Ajouter un Bâtiment</h2>
        <form action="batiment.php" method="POST">
            <input type="hidden" name="action" value="add_building">
            
            <label for="nom">Nom:</label>
            <input type="text" id="nom" name="nom" required>

            <label for="gest_ID">Gestionnaire:</label>
            <select name="gest_ID" id="gest_ID" required>
                <option value="">--Please choose an option--</option>
                <?php
                $req = "SELECT * FROM `Gestionnaire`";
                $res = $conn->query($req);
                if ($res != false && $res->num_rows > 0) {
                    while ($row = $res->fetch_assoc()) {
                        echo "<option value=\"" . htmlspecialchars($row['id_gestionnaire']) . "\">" . htmlspecialchars($row['login']) . "</option>";
                    }
                }
                ?>
            </select>
            <button type="submit">Ajouter</button>
        </form>
    </div>

    <div class="container">
        <h2>Supprimer un Bâtiment</h2>
        <form action="batiment.php" method="POST">
            <input type="hidden" name="action" value="delete_building">
            
            <label for="nom">Nom:</label>
            <select name="nom" id="nom" required>
                <option value="">--Please choose an option--</option>
                <?php
                $req = "SELECT * FROM `Batiment`";
                $res = $conn->query($req);
                if ($res != false && $res->num_rows > 0) {
                    while ($row = $res->fetch_assoc()) {
                        echo "<option value=\"" . htmlspecialchars($row['nom']) . "\">" . htmlspecialchars($row['nom']) . "</option>";
                    }
                }
                ?>
            </select>
            <button type="submit">Supprimer</button>
        </form>
    </div>

    <div class="container">
        <h2>Ajouter un Capteur</h2>
        <form action="salle.php" method="POST">
            <input type="hidden" name="action" value="add_capteur">
            
            <label for="salle_id">Salle:</label>
            <select name="salle_id" id="salle_id" required>
                <option value="">--Please choose an option--</option>
                <?php
                $req = "SELECT * FROM `Salle`";
                $res = $conn->query($req);
                if ($res != false && $res->num_rows > 0) {
                    while ($row = $res->fetch_assoc()) {
                        echo "<option value=\"" . htmlspecialchars($row['Salle_ID']) . "\">" . htmlspecialchars($row['nom']) . "</option>";
                    }
                }
                ?>
            </select>
            
            <label for="type">Type:</label>
            <input type="text" id="type" name="type" required>
            
            <label for="unite">Unité:</label>
            <input type="text" id="unite" name="unite" required>
            
            <button type="submit">Ajouter</button>
        </form>
    </div>

    <div class="container">
        <h2>Supprimer un Capteur</h2>
        <form action="salle.php" method="POST">
            <input type="hidden" name="action" value="delete_capteur">
            
            <label for="capteur_id">Capteur:</label>
            <select name="capteur_id" id="capteur_id" required>
                <option value="">--Please choose an option--</option>
                <?php
                $req = "SELECT * FROM `Capteur`";
                $res = $conn->query($req);
                if ($res != false && $res->num_rows > 0) {
                    while ($row = $res->fetch_assoc()) {
                        echo "<option value=\"" . htmlspecialchars($row['capteur_ID']) . "\">" . htmlspecialchars($row['type']) . " (" . htmlspecialchars($row['unite']) . ")</option>";
                    }
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

