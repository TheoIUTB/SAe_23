<?php  // File: building.php 

// Maria DB configuration
$servername = "localhost";
$username = "tnunes";
$password = "motdepasse";
$dbname = "sae23";

// Create a connection to the Maria DB (SQL database)
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
	
// Check which action is requested
$action = $_POST['action'];

if ($action == "add_building") {
    // Get the data from the form
    $building_name = $_POST['building_name'];
    $manager_id = $_POST['manager_id'];
    // Prepare and execute the insertion query
    $sql = "INSERT INTO building (name, manager_id) VALUES ('$building_name', '$manager_id')";
    if ($conn->query($sql) === TRUE) {
        echo "New entry added successfully";
    } else {
        echo "Erreur: ";
    }

} elseif ($action == "delete_building") {
    // Get the ID from the form
    $id = $_POST['building_id'];
    // Prepare and execute the deletion query
    $sql = "DELETE FROM `building` WHERE id_building='$id'";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['message'] = "Entrée supprimée avec succès";
    } else {
        $_SESSION['message'] = "Erreur lors de la suppression de l'entrée";
    }
}

header('Location: index2.php');
// Close the connection
mysqli_close($conn);
?>
