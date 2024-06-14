<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr" class="graphs">
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

</head>
<body class="graphs">
<header>
    <nav>
        <ul>
            <li><div class="item"><a href="index.php">Accueil</a></div></li>
            <li><div class="item"><a href="pres_sae.php">Gestion de projet</a></div></li>
	    	<li><div class="item"><a href="consultation.php">Consultation</a></div></li>
	    	<li><div class="item"><a href="CDC.php">Cahier des charges</a></div></li>
			<li><div class="item"><a href="batiment1.php">R&T</a></div></li>
            <li><div class="item"><a href="batiment2.php">GIM</a></div></li>
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
</header>
<h1 class="gim">Bâtiment GIM</h1>
<!-- Main content section -->
<body>
     <h1>Metrics</h1>
    <div id="metrics"></div>

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
            <!-- Row for room B111 -->
            <tr>
                <td>B111</td>
                <td id="temp_min_B111"></td>
                <td id="temp_max_B111"></td>
                <td id="temp_moy_B111"></td>
                <td id="hum_min_B111"></td>
                <td id="hum_max_B111"></td>
                <td id="hum_moy_B111"></td>
                <td id="co2_min_B111"></td>
                <td id="co2_max_B111"></td>
                <td id="co2_moy_B111"></td>
            </tr>
            <!-- Row for room B112 -->
            <tr>
                <td>B112</td>
                <td id="temp_min_B112"></td>
                <td id="temp_max_B112"></td>
                <td id="temp_moy_B112"></td>
                <td id="hum_min_B112"></td>
                <td id="hum_max_B112"></td>
                <td id="hum_moy_B112"></td>
                <td id="co2_min_B112"></td>
                <td id="co2_max_B112"></td>
                <td id="co2_moy_B112"></td>
            </tr>
        </tbody>
    </table>

    <h2>Salle B111</h2>
    <div class="chart-container">
        <div class="chart-item">
            <canvas id="temp_B111" width="50vh" height="50vh"></canvas> 
        </div>
        <div class="chart-item">
            <canvas id="hum_B111" width="50vh" height="50vh"></canvas> 
        </div>
        <div class="chart-item">
            <canvas id="co2_B111" width="50vh" height="50vh"></canvas>
        </div>
    </div>

    <h2>Salle B112</h2>
    <div class="chart-container">
        <div class="chart-item">
            <canvas id="temp_B112" width="50vh" height="50vh"></canvas>
        </div>
        <div class="chart-item">
            <canvas id="hum_B112" width="50vh" height="50vh"></canvas>
        </div>
        <div class="chart-item">
            <canvas id="co2_B112" width="50vh" height="50vh"></canvas>
        </div>
    </div>
    <!-- </section> -->
    <footer>
        <p>
        <!-- W3C validation links for CSS and HTML -->
        <a href="METTRE LIEN" style="float: left;"><img src="images/vcss-blue.png" alt="css" /></a>
        <a href="METTRE LIEN" style="float: left;"><img src="images/html.png" alt="html" style="height: 30px; width: 90px;" /></a>
        <a href="https://www.iut-blagnac.fr/fr/" style="text-decoration: none; color: aqua;">IUT Blagnac</a> | <a href="https://dupratmatteo.com" style="text-decoration: none; color: aqua;">LAVIALLE</a> | <a style="text-decoration: none; color: aqua;">NUNES DIAS</a> | <a style="text-decoration: none; color: aqua;">REYNAUD</a> | <a style="text-decoration: none; color: aqua;">LOPEZ</a>
        </p>
        </footer>
    <script src="charts.js"></script>
    <script src="search.js"></script>
</body>
</html>
