<?php
$host = "localhost";
$username = "admin";
$password = "1234@Work";
$database = "greenstayhubdb";
$port = "3306";

$conn = new mysqli($host, $username, $password, $database, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
