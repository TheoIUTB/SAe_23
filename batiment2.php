<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bâtiment GIM</title>
    <meta name="author" content="MD" />
    <link rel="stylesheet" href="styles/styles.css">
    <meta name="description" content="Données GIM" />
    <meta name="keywords" content="data GIM" />
    <meta http-equiv="refresh" content="30" /> <!-- Refresh the page every 30 seconds -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/moment@2.29.1"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@1.0.0"></script>
    <style>
        .chart-container {
            display: flex;
            flex-wrap: wrap; /* Allow charts to wrap to the next line */
        }
        .chart-item {
            flex: 1 1 30%; /* Flex item to take 30% of the width */
            padding: 10px;
        }

        table {
            width: 80%; /* Set the table width to 80% */
            border-collapse: collapse;
            margin: 20px 0;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Add shadow to the table */
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2; /* Light gray background for table headers */
        }
    </style>
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
<h1 class="gim">Bâtiment GIM</h1>
<table>
    <thead>
        <tr>
            <th>Salle</th>
            <th>Température Minimum (°C)</th>
            <th>Température Maximum (°C)</th>
            <th>Température Moyenne (°C)</th>
            <th>Humidité Minimum (%)</th>
            <th>Humidité Maximum (%)</th>
            <th>Humidité Moyenne (%)</th>
            <th>CO2 Minimum (ppm)</th>
            <th>CO2 Maximum (ppm)</th>
            <th>CO2 Moyenne (ppm)</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $servername = "localhost";
        $username = "tnunes";
        $password = "motdepasse";
        $dbname = "sae23";

        try {
            $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Changer les noms des salles ici
            $rooms = ['B111', 'B002'];

            foreach ($rooms as $room) {
                $stmt = $conn->prepare("
                    SELECT 
                        MIN(CASE WHEN Capteur.type = 'temperature' THEN mesure.mesure END) AS temp_min,
                        MAX(CASE WHEN Capteur.type = 'temperature' THEN mesure.mesure END) AS temp_max,
                        AVG(CASE WHEN Capteur.type = 'temperature' THEN mesure.mesure END) AS temp_avg,
                        MIN(CASE WHEN Capteur.type = 'humidity' THEN mesure.mesure END) AS hum_min,
                        MAX(CASE WHEN Capteur.type = 'humidity' THEN mesure.mesure END) AS hum_max,
                        AVG(CASE WHEN Capteur.type = 'humidity' THEN mesure.mesure END) AS hum_avg,
                        MIN(CASE WHEN Capteur.type = 'co2' THEN mesure.mesure END) AS co2_min,
                        MAX(CASE WHEN Capteur.type = 'co2' THEN mesure.mesure END) AS co2_max,
                        AVG(CASE WHEN Capteur.type = 'co2' THEN mesure.mesure END) AS co2_avg
                    FROM mesure
                    JOIN Capteur ON mesure.capteur_ID = Capteur.capteur_ID
                    JOIN Salle ON Capteur.Salle_ID = Salle.Salle_ID
                    WHERE Salle.nom = :room
                ");
                $stmt->bindParam(':room', $room);
                $stmt->execute();
                $result = $stmt->fetch(PDO::FETCH_ASSOC);

                echo "<tr>";
                echo "<td>{$room}</td>";
                echo "<td>" . round($result['temp_min'], 2) . "</td>";
                echo "<td>" . round($result['temp_max'], 2) . "</td>";
                echo "<td>" . round($result['temp_avg'], 2) . "</td>";
                echo "<td>" . round($result['hum_min'], 2) . "</td>";
                echo "<td>" . round($result['hum_max'], 2) . "</td>";
                echo "<td>" . round($result['hum_avg'], 2) . "</td>";
                echo "<td>" . round($result['co2_min'], 2) . "</td>";
                echo "<td>" . round($result['co2_max'], 2) . "</td>";
                echo "<td>" . round($result['co2_avg'], 2) . "</td>";
                echo "</tr>";
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
        $conn = null; // Close the database connection
        ?>
    </tbody>
</table>

<footer>
    <p>
        <a href="METTRE LIEN" style="float: left;"><img src="images/vcss-blue.png" alt="css" /></a>
        <a href="METTRE LIEN" style="float: left;"><img src="images/html.png" alt="html" style="height: 30px; width: 90px;" /></a>
        <a href="https://www.iut-blagnac.fr/fr/" style="text-decoration: none; color: aqua;">IUT Blagnac</a> | <a href="https://dupratmatteo.com" style="text-decoration: none; color: aqua;">LAVIALLE</a> | <a style="text-decoration: none; color: aqua;">NUNES DIAS</a> | <a style="text-decoration: none; color: aqua;">REYNAUD</a> | <a style="text-decoration: none; color: aqua;">LOPEZ</a>
    </p>
</footer>
</body>
</html>

