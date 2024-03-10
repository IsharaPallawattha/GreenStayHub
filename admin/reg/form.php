<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$phone = $_POST['phoneno'];
$email = $_POST['email'];
$password = $_POST['password'];
$gender = $_POST['gender'];
$usertype = $_POST['usertype'];

// Hash the password
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Database connection
$servername = "localhost";
$username = "root";
$password = ""; 
$dbname = "users"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
    die('Connection Failed : '.$conn->connect_error);
} else {
    $stmt = $conn->prepare("INSERT INTO users (firstname, lastname, phone, email, password, gender, usertype) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssissss", $firstname, $lastname, $phone, $email, $hashed_password, $gender, $usertype);
    $stmt->execute();
    echo "Registration Successful...";
    $stmt->close();
    $conn->close();
}
?>
