<?php
$servername = "localhost";
// $servername = "localhost:8889";
$username = "root";
// $password = "root"; // No password
$password = ""; // No password
$dbname = "db_sae24";

// Create a new MySQLi connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$room = $_GET['room'];
$sql = "SELECT temperature, humidity, co2, timestamp, room FROM mesure WHERE room='$room'";
$result = $conn->query($sql); 

$metrics = array();
if ($result->num_rows > 0) {
  // Fetch each row and add it to the metrics array
  while($row = $result->fetch_assoc()) {
    $metrics[] = $row;
  }
}

$conn->close(); // Close the connection
echo json_encode($metrics); // Encode the metrics array to JSON and output it
?>