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

// Check if the 'get_rooms' parameter is set
if(isset($_GET['get_rooms'])) {
    // Query to fetch room data
    $result = $conn->query("SELECT `room` FROM `mesure` WHERE 1");
    $rooms = array();
    if ($result->num_rows > 0) {
      // Fetch each row and add it to the rooms array
      while($row = $result->fetch_assoc()) {
          $rooms[] = $row;
      }
    }
    echo json_encode($rooms); // Encode the rooms array to JSON and output it
}

// Check if the 'search_metrics' parameter is set
if(isset($_GET['search_metrics'])){
  $timestamp = $_GET['timestamp'];
  $room = $_GET['room'];
  // Query to fetch the data
  $query = "SELECT * FROM `mesure` WHERE (DATE_FORMAT(`timestamp`, '%Y-%m-%d %H:%i') = '$timestamp') AND (`room` = '$room')";
  $result = $conn->query($query);
  
  $metrics = array();
  if ($result->num_rows > 0) {
    // Fetch each row and add it to the metrics array
    while($row = $result->fetch_assoc()) {
      $metrics[] = $row;
    }
  }
  
  $conn->close(); // Close the connection
  echo json_encode($metrics); // Encode the metrics array to JSON and output it
}

// Unused and commented code for future reference or testing
// $date = $_GET['date']; // e.g., '2024-06-11'
// $time = $_GET['time']; // e.g., '12:54'

// // Combine date and time
// // $timestamp = $date . ' ' . $time;

// $res =
// try {
//     if($_GET['coucou']) {
//         echo "coucou";
//     }
// } catch (Exception $e) {
//     echo 'Caught exception: ',  $e->getMessage(), "\n";
// }

?>