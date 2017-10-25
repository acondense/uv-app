<?php
    require('./connection.php');
    header('Content-Type: application/json');

    if (!isset($_SESSION['id']))
        session_start();

    $json = json_decode(file_get_contents('php://input'), true);
                            
    $firstname = $json['firstname'];
    $lastname = $json['lastname'];
    $email = $json['email'];
    $password = $json['password'];
    $phone = $json['phone'];
    
    $query = "
    INSERT INTO `user` (firstname, lastname, email, password, phone)
    VALUES ('$firstname', '$lastname', '$email', '$password', '$phone')";

    if (mysqli_query($con, $query)) {
        $ret['status'] = 'OK';
        $_SESSION['id'] = mysqli_insert_id($con);

    } else {
        $ret['status'] = 'ERROR';
    }
    echo json_encode($ret);
?>