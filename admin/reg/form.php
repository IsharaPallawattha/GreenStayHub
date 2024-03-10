<?php
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $password = $_POST['password'];
   
    // Database connection
    $conn = new mysqli('localhost','root','','greenstayhub');
    if($conn->connect_error){
        die('Connection Failed : '.$conn->connect_error);
    }else{
        $stmt = $conn->prepare("insert into registration(firstname, lastname, phone, email, password) values(?, ?, ?, ?, ?)");
        $stmt->bind_param("ssiss", $firstname, $lastname, $phone, $email, $password);
        $stmt->execute();
        echo "Registration Successful...";
        $stmt->close();
        $conn->close();
    }

?>