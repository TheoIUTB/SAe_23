#!/opt/lampp/bin/php

<?php

//DATABASE connection 
$id_bd = mysqli_connect("localhost", "tnunes", "motdepasse", "sae23");

//Check the connection to the database
if (!$databaseConnection) {
	die("Échec de la connexion : " . mysqli_connect_error());

// Infinite loop
while (true) {
    // Run the shell script and decode the JSON
    $jsonData = shell_exec('mosquitto_sub -h mqtt.iut-blagnac.fr -t AM107/by-room/+/data -C 1');
    $decodedData = json_decode($jsonData, true);

    //extract specific data from JSON object
    $measurements = $decodedData[0];
    $deviceInfo = $decodedData[1];

    // recover the room and the building
    $roomName = $deviceInfo['room'];
    $buildingId = $deviceInfo['Building'];

    //look in the data table for all the sensor types and retrieves the value
    foreach ($measurements as $sensorType => $sensorValue) {
        // Ignore unwanted sensors
        if (in_array($sensorType, ['activity', 'infrared', 'tvoc', 'infrared_and_visible'])) {
            continue;
        }

        //Determine the sensor unit
        $unit = '';
        switch ($sensorType) {
            case 'temperature':
                $unit = "\u{2103}C";
                break;
            case 'humidity':
                $unit = '%';
                break;
            case 'co2':
                $unit = 'ppm';
                break;
            case 'illumination':
                $unit = 'lux';
                break;
            case 'pressure':
                $unit = 'hPa';
                break;
            default:
                $unit = '';
        }

        // Construct the sensor name using the room name followed by the sensor type
        $sensorName = $roomName . '_' . $sensorType;
        // Check if the sensor already exists in the database
        $checkSensorQuery = "SELECT * FROM Capteur WHERE name = '$sensorName'";
        $sensorResult = mysqli_query($id_bd, $checkSensorQuery); // Utilisation de $id_bd

        // If the sensor does not exist, insert it into the database
        if (mysqli_num_rows($sensorResult) == 0) {
            $insertSensorQuery = "INSERT INTO capteur (name, type, unite, Salle_ID) VALUES ('$sensorName', '$sensorType', '$unit', '$roomName')";
            if (!mysqli_query($id_bd, $insertSensorQuery)) { // Utilisation de $id_bd de mysql.php
                echo "Erreur lors de l'insertion du capteur $sensorName : " . mysqli_error($id_bd); // Utilisation de $id_bd
            } else {
                echo "Insertion du capteur $sensorName réussie.\n";
            }
        }

        // Insert date and time into database
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i:s');
        $insertMeasurementQuery = "INSERT INTO mesure (mesure_ID, date, horaire, capteur_ID) VALUES ('$sensorValue', '$currentDate', '$currentTime', '$sensorName')";

        if (!mysqli_query($id_bd, $insertMeasurementQuery)) { // Utilisation de $id_bd de mysql.php
            echo "Erreur lors de l'insertion de la mesure pour le capteur $sensorName : " . mysqli_error($id_bd); // Utilisation de $id_bd
        } else {
            echo "Insertion de la mesure pour le capteur $sensorName réussie.\n";
        }
    }
}
?>
