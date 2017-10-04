<?php
    header('Content-Type: application/json');

    require('../connection.php');

    $query = "SELECT * FROM `location` order by `name`";
    $result = mysqli_query($con, $query);
    $locations = array();
    while ($row = mysqli_fetch_array($result)) {
        $location['id'] = $row['id'];
        $location['name'] = $row['name'];
        $location['address'] = $row['address'];
        $location['image'] = $row['image'];
        array_push($locations, $location);
    }

    $return = new stdClass();
    $return->locations = $locations;
    echo json_encode($return);
?>