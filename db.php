<?php
$host = 'localhost';
$db = 'sae23';
$user = 'tnunes';
$pass = 'motdepasse';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // Enable exceptions for errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Set the default fetch mode to associative array
    PDO::ATTR_EMULATE_PREPARES => false, // Disable emulation of prepared statements
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options); // Create a new PDO instance
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode()); // Throw exception if connection fails
}
?>
