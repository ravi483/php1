<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "myshop";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

// Check connection
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Get the client ID
$id = $_GET['id'] ?? null;

if ($id) {
    $sql = "DELETE FROM clients WHERE id = $id";
    $connection->query($sql);
}

$connection->close();

// Redirect to the main page after deletion
header("location: /myshop/index.php");
exit;
