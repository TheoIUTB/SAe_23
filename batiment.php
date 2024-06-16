<?php
// File: batiment.php

// Maria DB configuration
$servername = "localhost";
$username = "tnunes";
$password = "motdepasse";
$dbname = "sae23";

// Create a connection to the Maria DB (SQL database)
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check which action is requested
$action = $_POST['action'];

if ($action == "add_building") {
    // Get the data from the form
    $building_name = $_POST['nom'];
    $manager_id = $_POST['gest_ID'];

    // Prepare and execute the insertion query
    $stmt = $conn->prepare("INSERT INTO Batiment (nom, gest_ID) VALUES (?, ?)");
    $stmt->bind_param("si", $building_name, $manager_id);

    if ($stmt->execute() === TRUE) {
        echo "New entry added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();

} elseif ($action == "delete_building") {
    // Get the name from the form
    $building_name = $_POST['nom'];

    // Prepare and execute the deletion query
    $stmt = $conn->prepare("DELETE FROM Batiment WHERE nom = ?");
    $stmt->bind_param("s", $building_name);

    if ($stmt->execute() === TRUE) {
        $_SESSION['message'] = "Entrée supprimée avec succès";
    } else {
        $_SESSION['message'] = "Erreur lors de la suppression de l'entrée: " . $stmt->error;
    }

    $stmt->close();
}

// Redirect to the main page
header('Location: index2.php');

// Close the connection
$conn->close();
?>

