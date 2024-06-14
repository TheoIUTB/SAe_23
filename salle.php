<?php
// File: salle.php

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

if ($action == "add_salle") {
    // Retrieve form data
    $name = $_POST['name'];
    $type = $_POST['type'];
    $capacity = $_POST['capacity'];
    $bat_id = $_POST['bat_id'];

    // Prepare and execute the insertion query
    $sql = "INSERT INTO salle (nom, type, capacite, batiment_id) VALUES ('$name', '$type', $capacity, $bat_id)";
    if ($conn->query($sql) === TRUE) {
        echo "New entry added successfully";
    } else {
        echo "Error: ";
    }

} elseif ($action == "delete_salle") {
    // Retrieve the ID from the form
    $id = $_POST['id'];

    // Prepare and execute the deletion query
    $sql = "DELETE FROM salle WHERE id_salle=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Entry deleted successfully";
    } else {
        echo "Error: ";
    }
}

header('Location: index2.php'); // Redirect to the index2.php page
// Close the connection
mysqli_close($conn);
?>
