<?php
    header('Content-Type: application/json');

    require('../connection.php');

    if (isset($_GET['ride_id'])) {
        get_reservation($con, $_GET['ride_id']);
    }

    function get_user_reservation($con, $ride_id) {
        if (!isset($_SESSION['id']))
            session_start();
        $user_id = $_SESSION['id'];
        $query = "SELECT * FROM `reservation` WHERE `ride_id`=$ride_id AND `user_id`=$user_id LIMIT 1";
        $result = mysqli_query($con, $query);
        $reservation = mysqli_fetch_array($result);
        $return = new stdClass();
        $return->reservation = $reservation;
        echo json_encode($return);
    }

    function get_other_reservation($con, $ride_id) {
        if (!isset($_SESSION['id']))
            session_start();
        $user_id = $_SESSION['id'];
        $query = "SELECT * FROM `reservation` WHERE `ride_id`=$ride_id AND `user_id`!=$user_id";
        $result = mysqli_query($con, $query);
        $reservations = mysqli_fetch_array($result);
        $return = new stdClass();
        $return->reservation = $reservation;
        echo json_encode($return);
    }

    
    // $result = mysqli_query($con, $query);
    // $locations = array();
    // while ($row = mysqli_fetch_array($result)) {
    //     $location['id'] = $row['id'];
    //     $location['name'] = $row['name'];
    //     $location['address'] = $row['address'];
    //     $location['image'] = $row['image'];
    //     array_push($locations, $location);
    // }

    // $return = new stdClass();
    // $return->locations = $locations;
    // echo json_encode($return);
?>