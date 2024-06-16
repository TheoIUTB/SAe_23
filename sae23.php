#!/opt/lampp/bin/php
<?php

// Connect to the database
$id_bd = mysqli_connect("localhost", "tnunes", "motdepasse", "sae23");

// Check the database connection
if (!$id_bd) {
    die("Connection failed: " . mysqli_connect_error());
}

// Infinite loop
while (true) {
    // Execute the shell script and decode the JSON
    $jsonData = shell_exec('mosquitto_sub -h mqtt.iut-blagnac.fr -t AM107/by-room/+/data -C 1');
    $decodedData = json_decode($jsonData, true);

    // Extract specific data from the JSON object
    $measurements = $decodedData[0];
    $deviceInfo = $decodedData[1];

    // Retrieve the room and building
    $roomName = $deviceInfo['room'];

    // Determine the building and other attributes based on the room name
    if (strpos($roomName, 'E') === 0) {
        $buildingId = 1; // RT
        $roomType = 'TypeE'; // Set appropriate type for E rooms
        $roomCapacity = 30; // Set a default capacity for E rooms
    } elseif (strpos($roomName, 'B') === 0) {
        $buildingId = 2; // GIM
        $roomType = 'TypeB'; // Set appropriate type for B rooms
        $roomCapacity = 40; // Set a default capacity for B rooms
    } else {
        $buildingId = 0; // Default or unknown building
        $roomType = 'Unknown';
        $roomCapacity = 0;
    }

    // Search for the room in the Room table
    $checkRoomQuery = "SELECT Salle_ID FROM Salle WHERE nom = '$roomName' AND batiment_ID = '$buildingId'";
    $roomResult = mysqli_query($id_bd, $checkRoomQuery);

    // If the room does not exist, create it
    if (mysqli_num_rows($roomResult) == 0) {
        $insertRoomQuery = "INSERT INTO Salle (nom, type, capacite, batiment_ID) VALUES ('$roomName', '$roomType', '$roomCapacity', '$buildingId')";
        if (!mysqli_query($id_bd, $insertRoomQuery)) {
            echo "Error creating room $roomName in building $buildingId: " . mysqli_error($id_bd);
            continue;
        } else {
            echo "Successfully created room $roomName in building $buildingId.\n";
        }
        // Re-execute the query to get the new room ID
        $roomResult = mysqli_query($id_bd, $checkRoomQuery);
    }

    $roomRow = mysqli_fetch_assoc($roomResult);
    $roomId = $roomRow['Salle_ID'];

    // Loop through the types of sensors and retrieve the values
    foreach ($measurements as $sensorType => $sensorValue) {
        // Ignore unwanted sensors
        if (in_array($sensorType, ['activity', 'infrared', 'tvoc', 'infrared_and_visible'])) {
            continue;
        }

        // Determine the sensor unit
        $unit = '';
        switch ($sensorType) {
            case 'temperature':
                $unit = "°C";
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
        $checkSensorQuery = "SELECT capteur_ID FROM Capteur WHERE type = '$sensorType' AND Salle_ID = '$roomId'";
        $sensorResult = mysqli_query($id_bd, $checkSensorQuery);

        // If the sensor does not exist, insert it into the database
        if (mysqli_num_rows($sensorResult) == 0) {
            $insertSensorQuery = "INSERT INTO Capteur (type, unite, Salle_ID) VALUES ('$sensorType', '$unit', '$roomId')";
            if (!mysqli_query($id_bd, $insertSensorQuery)) {
                echo "Error inserting sensor $sensorName: " . mysqli_error($id_bd);
            } else {
                echo "Successfully inserted sensor $sensorName.\n";
            }
            // Re-execute the query to get the new sensor ID
            $sensorResult = mysqli_query($id_bd, $checkSensorQuery);
        }

        $sensorRow = mysqli_fetch_assoc($sensorResult);
        $sensorId = $sensorRow['capteur_ID'];

        // Insert the measurement into the database
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i:s');
        $insertMeasurementQuery = "INSERT INTO mesure (date, horaire, mesure, capteur_ID) VALUES ('$currentDate', '$currentTime', '$sensorValue', '$sensorId')";

        if (!mysqli_query($id_bd, $insertMeasurementQuery)) {
            echo "Error inserting measurement for sensor $sensorName: " . mysqli_error($id_bd);
        } else {
            echo "Successfully inserted measurement for sensor $sensorName.\n";
        }
    }
}
?>

