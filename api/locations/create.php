<?php
    require('../connection.php');
    $json = json_decode(file_get_contents('php://input'), true);
    $name = $json['name'];
    $address = $json['address'];

    $query = "
    INSERT INTO `location` (name, address)
    VALUES ('$name', '$address')";

    mysqli_query($con, $query);
?>