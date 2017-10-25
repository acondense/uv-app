<?php
    require('../connection.php');
    $json = json_decode(file_get_contents('php://input'), true);
                                
    if (!isset($_SESSION['id']))
        session_start();

    $user_id = $_SESSION['id'];
    $ride_id = $json['ride_id'];
    $qty = $json['qty'];
    
    $query = "
    INSERT INTO `reservation` (user_id, ride_id, qty)
    VALUES ('$user_id', '$ride_id', '$qty')";

    mysqli_query($con, $query);
?>