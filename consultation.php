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
            <li><div class="item"><a href="plan_fr.html">Plan</a></div></li>
            <li><div class="item"><a href="consultation.php">Consultation</a></div></li>
            <li><div class="item"><a href="CDC.php">Cahier des charges</a></div></li>
            <!-- Start the session and check if the user is logged in -->
            <?php session_start(); if (isset($_SESSION['role'])): ?>
                <!-- Display links based on user roles -->
                <?php if ($_SESSION['role'] == 'Administrateur' || $_SESSION['role'] == 'gestionnaire1'): ?>
                    <li><div class="item"><a href="batiment1.php">R&T</a></div></li>
                <?php endif; ?>
                <?php if ($_SESSION['role'] == 'Administrateur' || $_SESSION['role'] == 'gestionnaire2'): ?>
                    <li><div class="item"><a href="batiment2.php">GIM</a></div></li>
                <?php endif; ?>
                <?php if ($_SESSION['role'] == 'Administrateur'): ?>
                    <li><div class="item"><a href="index2.php">AJout/Supp</a></div></li>
                <?php endif; ?>
                <li><div class="item"><a href="deconnexion.php">Déconnexion</a></div></li>
            <?php else: ?>
                <li><div class="item"><a href="connexion.php">Connexion</a></div></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>
<h1>Consultation</h1>
<h1>Dernières mesures</h1>
    <table>
        <thead>
            <tr>
                <th>Salle</th>
                <th>Timestamp</th>
                <th>CO2 (ppm)</th>
                <th>Température (°C)</th>
                <th>Humidité (%)</th>
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

                $rooms = ['E001', 'E007', 'B111', 'B112'];

                // Fetch measurements for each room
                foreach ($rooms as $room) {
                    $stmt = $conn->prepare("SELECT timestamp, co2, temperature, humidity FROM mesure WHERE room = :room ORDER BY timestamp DESC LIMIT 2");
                    $stmt->bindParam(':room', $room);
                    $stmt->execute();
                    $measurements = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Display measurements in the table
                    foreach ($measurements as $measurement) {
                        echo "<tr>";
                        echo "<td>{$room}</td>";
                        echo "<td>{$measurement['timestamp']}</td>";
                        echo "<td>{$measurement['co2']}</td>";
                        echo "<td>{$measurement['temperature']}</td>";
                        echo "<td>{$measurement['humidity']}</td>";
                        echo "</tr>";
                    }
                }

            } catch(PDOException $e) {
                echo "Error: " . $e->getMessage();
            }
            $conn = null; // Close the database connection
            ?>
        </tbody>
    </table>
<footer>
    <p>
        <!-- W3C validation links for CSS and HTML -->
        <a href="METTRE LIEN" style="float: left;"><img src="images/vcss-blue.png" alt="css" /></a>
        <a href="METTRE LIEN" style="float: left;"><img src="images/html.png" alt="html" style="height: 30px; width: 90px;" /></a>
        <a href="https://www.iut-blagnac.fr/fr/" style="text-decoration: none; color: aqua;">IUT Blagnac</a> | <a href="https://dupratmatteo.com" style="text-decoration: none; color: aqua;">LAVIALLE</a> | <a style="text-decoration: none; color: aqua;">NUNES DIAS</a> | <a style="text-decoration: none; color: aqua;">REYNAUD</a> | <a style="text-decoration: none; color: aqua;">LOPEZ</a>
    </p>
</footer>
</body>
</html>
