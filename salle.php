<?php
// File: capteur.php

// Database configuration
$servername = "localhost";
$username = "tnunes";
$password = "motdepasse";
$dbname = "sae23";

// Connect to the MySQL database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check which action was requested
$action = $_POST['action'];

if ($action == "add_capteur") {
    // Retrieve form data
    $type = $_POST['type'];
    $unite = $_POST['unite'];
    $salle_id = $_POST['salle_id'];

    // Prepare and execute the insertion query
    $sql = "INSERT INTO Capteur (type, unite, Salle_ID) VALUES ('$type', '$unite', $salle_id)";
    if ($conn->query($sql) === TRUE) {
        echo "New capteur added successfully";
    } else {
        echo "Error: " . $conn->error;
    }

} elseif ($action == "delete_capteur") {
    // Retrieve the ID from the form
    $capteur_id = $_POST['capteur_id'];

    // Prepare and execute the deletion query
    $sql = "DELETE FROM Capteur WHERE capteur_ID=$capteur_id";
    if ($conn->query($sql) === TRUE) {
        echo "Capteur deleted successfully";
    } else {
        echo "Error: " . $conn->error;
    }
}

header('Location: index2.php'); // Redirect to the index2.php page
// Close the connection
$conn->close();
?>

