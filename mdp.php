<?php
require 'db.php';

// Define an array of managers with their IDs and passwords
$gestionnaires = [
    ['id' => 1, 'password' => 'passrt'],
    ['id' => 2, 'password' => 'passgim']
];

// Loop through each manager and hash their password
foreach ($gestionnaires as $gestionnaire) {
    $hashed_password = password_hash($gestionnaire['password'], PASSWORD_DEFAULT); // Hash the password
    $stmt = $pdo->prepare('UPDATE gestionnaire SET password = ? WHERE id_gestionnaire = ?'); // Prepare the SQL statement
    $stmt->execute([$hashed_password, $gestionnaire['id']]); // Execute the statement with the hashed password and manager ID
}

echo "Les mots de passe ont été hachés et mis à jour."; // Output a success message

// Hash and output the root password for reference
$hpwd = password_hash("passroot", PASSWORD_DEFAULT);
echo $hpwd;
?>