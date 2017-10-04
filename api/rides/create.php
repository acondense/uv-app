<?php
    require('../connection.php');
    $json = json_decode(file_get_contents('php://input'), true);
                            
    $start_id = $json['start_id'];
    $end_id   = $json['end_id'];
    $time     = $json['time'];
    $date     = $json['date'];
    $seats    = $json['seats'];
    $info     = $json['info'];
    
    $query = "
    INSERT INTO `ride` (start_id, end_id, time, date, seats, info)
    VALUES ('$start_id', '$end_id', '$time', '$date', '$seats', '$info')";

    mysqli_query($con, $query);
?>