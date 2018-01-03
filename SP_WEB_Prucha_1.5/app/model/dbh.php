<!-- připojení k databázi -->

<?php

// Připojovací údaje
$dbServername = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "web_filmari";

//Připojení
$conn = mysqli_connect($dbServername, $dbUsername, $dbPassword, $dbName);

// Kontrola připojení
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}