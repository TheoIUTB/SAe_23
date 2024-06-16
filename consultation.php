<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consultation</title>
    <link rel="stylesheet" href="styles/styles.css">
    <meta name="description" content="Page de consultation">
    <meta name="keywords" content="consultation">

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        h1 {
            color: #333;
        }
        table {
            width: 80%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: white;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
<header>
    <nav>
        <ul>
            <li><div class="item"><a href="index.php">Accueil</a></div></li>
            <li><div class="item"><a href="pres_sae.php">Gestion de Projet</a></div></li>
            <li><div class="item"><a href="consultation.php">Consultation</a></div></li>
            <li><div class="item"><a href="batiment1.php">R&T</a></div></li>
            <li><div class="item"><a href="batiment2.php">GIM</a></div></li>
            <?php if (isset($_SESSION['role'])): ?>
                <?php if ($_SESSION['role'] == 'administrator'): ?>
                    <li><div class="item"><a href="index2.php">Ajt/Suppr</a></div></li>
                <?php endif; ?>
                <li><div class="item"><a href="deconnexion.php">Déconnexion</a></div></li>
            <?php else: ?>
                <li><div class="item"><a href="connexion.php">Connexion</a></div></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
<h1>Consultation</h1>
<h1>Dernière mesures</h1>
<table>
    <thead>
        <tr>
            <th>Salle</th>
            <th>Date & Heure</th>
            <th>CO2 (ppm)</th>
            <th>Temperature (°C)</th>
            <th>Humidity (%)</th>
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

            // Fetch all rooms
            $roomStmt = $conn->prepare("SELECT Salle_ID, nom FROM Salle");
            $roomStmt->execute();
            $rooms = $roomStmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($rooms as $room) {
                $roomId = $room['Salle_ID'];
                $roomName = $room['nom'];

                // Fetch the latest CO2 measurement for the room
                $stmt = $conn->prepare("SELECT mesure.date, mesure.horaire, mesure.mesure AS CO2
                                        FROM mesure 
                                        JOIN Capteur ON mesure.capteur_ID = Capteur.capteur_ID
                                        WHERE Capteur.Salle_ID = :roomId AND Capteur.type = 'co2'
                                        ORDER BY mesure.date DESC, mesure.horaire DESC LIMIT 1");
                $stmt->bindParam(':roomId', $roomId);
                $stmt->execute();
                $co2Measurement = $stmt->fetch(PDO::FETCH_ASSOC);

                // Fetch the latest Temperature measurement for the room
                $stmt = $conn->prepare("SELECT mesure.date, mesure.horaire, mesure.mesure AS Temperature
                                        FROM mesure 
                                        JOIN Capteur ON mesure.capteur_ID = Capteur.capteur_ID
                                        WHERE Capteur.Salle_ID = :roomId AND Capteur.type = 'temperature'
                                        ORDER BY mesure.date DESC, mesure.horaire DESC LIMIT 1");
                $stmt->bindParam(':roomId', $roomId);
                $stmt->execute();
                $tempMeasurement = $stmt->fetch(PDO::FETCH_ASSOC);

                // Fetch the latest Humidity measurement for the room
                $stmt = $conn->prepare("SELECT mesure.date, mesure.horaire, mesure.mesure AS Humidite
                                        FROM mesure 
                                        JOIN Capteur ON mesure.capteur_ID = Capteur.capteur_ID
                                        WHERE Capteur.Salle_ID = :roomId AND Capteur.type = 'humidity'
                                        ORDER BY mesure.date DESC, mesure.horaire DESC LIMIT 1");
                $stmt->bindParam(':roomId', $roomId);
                $stmt->execute();
                $humidityMeasurement = $stmt->fetch(PDO::FETCH_ASSOC);

                // Determine the latest timestamp among the measurements
                $timestamp = max(
                    $co2Measurement['date'] . ' ' . $co2Measurement['horaire'],
                    $tempMeasurement['date'] . ' ' . $tempMeasurement['horaire'],
                    $humidityMeasurement['date'] . ' ' . $humidityMeasurement['horaire']
                );

                echo "<tr>";
                echo "<td>{$roomName}</td>";
                echo "<td>{$timestamp}</td>";
                echo "<td>{$co2Measurement['CO2']}</td>";
                echo "<td>{$tempMeasurement['Temperature']}</td>";
                echo "<td>{$humidityMeasurement['Humidite']}</td>";
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

