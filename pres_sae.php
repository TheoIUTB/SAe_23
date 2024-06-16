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

<section class="text">
	<h1> Gestion de projet </h1>
</section>
<section class="text">
	<h2>  Synthèse personnelle: </h2>
		<ul>
			<li><strong>Théo:</strong>Pour ma part, je me suis occupé de faire la configuration des dockers, avec l’installation et la configuration de node-red, d’influxdb, et de grafana. La configuration de node-red a été plutôt simple, puis un problème est survenu sur la vm, ce qui nous a rendu dans l’impossibilité de se reconnecter à grafana.</li>
			<br>
			<li><strong>Mathis:</strong> Lors de cette SAé j'ai réalisé le schéma le de la base de données sur le site draw.io, j'ai aussi aidé Guillaume sur le gantt. J'ai réalisé une partie du site (partie script html) J'ai aussi réalisé les compte rendus de séance.</li>
			<br>
			<li><strong>Guillaume:</strong>Je me suis occupé du livrable 1, dans lesquelles j’ai effectué le gantt prévisionnelle, et j'ai réalisé les codes php et html ainsi qu'une partie de la base de données sur PhpMyAdmin. Enfin, j'ai réalisé le code de récuperation de données du broker mqtt et les envoyées vers la base de données.</li>
			<br>
		    <li><strong>Esteban:</strong> Esteban a abandonné l'année ce qui fait qu'il n'a réalisé que le Gantt.</li>
		</ul> 
	
</section>
<section class="text">
	<h3> Problèmes rencontrés: </h3>
	<ul>
			<li><strong>Théo:</strong> mettre du texte </li>
			<br>
			<li><strong>Mathis:</strong> Durant cette Saé, j'ai rencontré un seul problème, qui était de réaliser la base de données car elle était compliquée à réaliser. </li>
			<br>
			<li><strong>Guillaume:</strong> Cette SAÉ etait je trouve une des plus difficiles de l'années, et j'ai eu de nombreux problèmes comme par exemple la réalisation du code php, ou encore la connexion entre la base de donnée et le site. </li>
<br>
			<li><strong>Esteban:</strong> Esteban a abandonné l'année ce qui fait qu'il n'a réalisé que le Gantt. </li>
			
		</ul> 
		
</section>
<section class="text">
	<h3>  Degré de satisfaction: </h3>

<strong>Site web dynamique:</strong>
<br>
La solution de créer un site Web dynamique permettant de pouvoir visualiser des données d'un broker mqtt etait l'une des principales taches à réaliser. Sur ce site, plusieurs pages sont protégées par des formulaires de connexions. Ainsi, seuls les utilisateurs connus par la base de données peuvent se connecter aux différentes pages d'administrations (comme par exemple la page d'ajout et de suppression des batiments.
<br>
<br>
<strong>Solution Docker:</strong>
<br>  
Un enjeu de cette SAÉ etait aussi de completer et utiliser nos connaissances sur les Docker, une solution simple et intelligente. Nous avons pu utiliser cette solution dans de nombreuses parties de cette SAÉ comme durant la création du Grafana ou encore le Node-Red et la base de données Influx-DB.
<br>
<br>
</section>
<section class="text">
	<h2>Répartition des tâches:</h2>
	<br>
	<strong> Schéma Gantt</strong>
	</br>
	<br>
        <img src="images/Gantte.PNG" class="Gantt">
	<br>
	<br>
</section>
<section class="text">
	<h3>Dockers:</h3>
	Voici les captures d'écran de la chaîne de docker établie.
	<br>
	Nodered => InfluxDB => Grafana
	<br>
	4 capteurs sélectionnés: humidité, température, co2 et luminosité.
	<br>
	<br>
	<strong>Docker n°1:Nodered</strong>
	<br>
	<br> 
	<u>Flow Nodered</u>
	<br> 
	<br> 
	<img src="images/nr_conf_1.png" alt="CE" /> 
	<img src="images/nr_conf_2.png" alt="CE" /> 
	<br> 
	<br>
	Grâce au flow Nodered nous pouvons avoir une bonne vue d'ensemble de ce qui se passe au niveau de la chaîne de dockers et l'acquisition des données mqtt.  C'est lors de cette étape que nous choississons l'architecture de notre solution docker. Ici nous avons choisi de prendre les données du mqtt.iut-blagnac.fr puis faire la sélection des salles. Ensuite, les switchs vont permettre de choisir quels capteurs nous voulons sélectionner dans les salles. Puis nous avons les noeuds influxDB ainsi que le dashboard nodered qui se rajoute à la fin. C'est grâce à ce noeud influxDB que nous pouvons utiliser Grafana.
	<br> 
	<br> 
	<u>DashBoard Nodered</u>
	<br> 
	<br>
	<img src="images/nr_fin_1.png" alt="CE" />
	<img src="images/nr_fin_2.png" alt="CE" />
	<br>
	<br>
	Le DashBoard Nodered permet de faire un premier point lors de l'installation de la solution, afin d'avoir une bonne visualisation de l'acquisition et de la répartition des données mqtt.
	<br>
	<br>
	<br>
	<strong>Docker n°2: InfluxDB</strong>
	<br>
	<br>
	<u>Base de données influx</u>
	<br>
	<br>
	<img src="images/influxdb.png" alt="CE" /> 
	<br>
	<br>
	Le docker influxDB nous a permis d'établir une base de données docker facilement exploitable et simple de gestion.
	<br>
	<br>
	<br>
	<strong>Docker n°2: Grafana</strong>
	<br>
	<br>
	<u>Dashboard</u>
	<br>
	<br>
	<img class="CE" src="./images/screen.jpg" alt="CE" /> 
	<br>
	<br>
	Voici les graphiques des différents capteurs. Cela représente l'évolution de leurs relevés dans le temps.
	<br>
	<br>
</section>
<section class="text">
	<h3>Site web dynamique:</h3>
	<br>
	<strong>Base de données: Schéma BD avec les clés étrangères</strong>
	<br>
	<br>
<img class="CE" src="images/bd.jpg" alt="CE" />
	<br>
	<br>
</section>
<section class="text">
	<h3>  GitHub:</h3>
	<a href="https://github.com/TheoIUTB/SAe_23" > GitHub de la SAE23</a>
	<br>
	<br>
</section>

<!--Start of footer -->
<footer>
	<p>
        <a href="METTRE LIEN" style="float: left;"><img src="images/vcss-blue.png" alt="css" /></a>
        <a href="METTRE LIEN" style="float: left;"><img src="images/html.png" alt="html" style="height: 30px; width: 90px;" /></a>
<a href="https://www.iut-blagnac.fr/fr/" style="text-decoration: none; color: aqua;">IUT Blagnac</a> | <a href="https://dupratmatteo.com" style="text-decoration: none; color: aqua;">LAVIALLE</a> | <a style="text-decoration: none; color: aqua;">NUNES DIAS</a> | <a style="text-decoration: none; color: aqua;">REYNAUD</a> | <a style="text-decoration: none; color: aqua;">LOPEZ</a>
    </p>
    		</ul>  
  		</footer>
</body>
</html>
