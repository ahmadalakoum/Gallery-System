<?php

// connection file
$host = "localhost";
$username = "root";
$pass = "password";
$db_name = "gallery";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;", $username, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed " . $e->getMessage();
}
