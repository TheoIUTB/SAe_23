<?php
session_start();
require 'db.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['login'];
    $password = $_POST['password'];

    // Check for administrators
    $stmt = $pdo->prepare('SELECT * FROM Administration WHERE login = ?');
    $stmt->execute([$username]);
    $user = $stmt->fetch();
    $role = 'administrateur';
    $id_column = 'id_admin';

    if (!$user) {
        // Check for managers
        $stmt = $pdo->prepare('SELECT * FROM Gestionnaire WHERE login = ?');
        $stmt->execute([$username]);
        $user = $stmt->fetch();
        if ($user) {
            $id_column = 'id_gestionnaire';
            if ($user[$id_column] == 1) {
                $role = 'gestionnaire1';
            } elseif ($user[$id_column] == 2) {
                $role = 'gestionnaire2';
            } else {
                $role = 'gestionnaire';
            }
        }
    }

    // Verify password and set session variables
    if ($user && $password === $user['mot_de_passe']) {
        $_SESSION['user_id'] = $user[$id_column];
        $_SESSION['role'] = $role;
        header('Location: index.php'); // Redirect to the homepage if login is successful
        exit;
    } else {
        $error = 'Nom d\'utilisateur ou mot de passe incorrect'; // Error message for incorrect login
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="stylesheet" href="styles/styles.css">
    <meta name="description" content="Page de connexion">
    <meta name="keywords" content="connexion">
</head>
<body>
<header>
    <nav>
        <ul>
            <li><div class="item"><a href="index.php">Accueil</a></div></li>
            <li><div class="item"><a href="plan_fr.php">Plan</a></div></li>
            <li><div class="item"><a href="consultation.php">Consultation</a></div></li>
            <li><div class="item"><a href="connexion.php">Connexion</a></div></li>
        </ul>
    </nav>
</header>
<div class="login-wrapper">
    <div class="login-container">
        <form class="login-form" action="connexion.php" method="POST">
            <h2>Connexion</h2>
            <?php if (isset($error)): ?>
                <p style="color:red;"><?php echo $error; ?></p> <!-- Display error message if login fails -->
            <?php endif; ?>
            <label for="login">Nom d'utilisateur</label>
            <input type="text" id="login" name="login" required>
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>
            <button type="submit">Se connecter</button>
        </form>
    </div>
</div>
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

