<?php
//foutmeldingen zichtbaar maken
ini_set('display_errors', 1);
error_reporting(E_ALL);
//inlog gegevens voor de database
$servername = "127.0.0.1";
$username = "modellen-bureau";
$password = "ITS-ALEX-CONSANI";
$database = "modellen-bureau";


$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //echo "Connected successfully";
} catch (PDOException $e) {

    echo "Connection failed: " . $e->getMessage();
}
