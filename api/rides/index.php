<?php
    header('Content-Type: application/json');

    require('../connection.php');

    if (isset($_GET['id'])) {
        get_ride($_GET['id'], $con);
    } else {
        get_rides($con);
    }

    function get_rides($con) {

         // Pagination on front-end starts at 1, but on backend pagination starts at 0
         // - 1 on page URL parmater is used to match the pagination on front-end
        if (isset($_GET['page'])) {
            $page = $_GET['page'] - 1;
        } else {
            $page = 0;
        }
        $page = $page * 8;

        $query = "
        SELECT ride.id as id, date, time, seats, info,
            s.id as start_id, s.name as start_name, s.address as start_address, s.image as start_image,
            e.id as end_id, e.name as end_name, e.address as end_address, e.image as end_image
        FROM ride
            INNER JOIN location as s
                ON s.id = ride.start_id
            INNER JOIN location as e
                ON e.id = ride.end_id
        WHERE ride.date >= CURDATE()
        ORDER BY ride.date
        LIMIT $page, 8";
        $rides = array();
        $result = mysqli_query($con, $query);
        while ($row = mysqli_fetch_array($result)) {
            $ride['id'] = $row['id'];
            $ride['date'] = $row['date'];
            $ride['time'] = $row['time'];
            $ride['seats'] = $row['seats'];
            $ride['info'] = $row['seats'];
            $ride['start_id'] = $row['start_id'];
            $ride['start_name'] = $row['start_name'];
            $ride['start_address'] = $row['start_address'];
            $ride['start_image'] = $row['start_image'];
            $ride['end_id'] = $row['end_id'];
            $ride['end_name'] = $row['end_name'];
            $ride['end_address'] = $row['end_address'];
            $ride['end_image'] = $row['end_image'];
            array_push($rides, $ride);
        }
        $return = new stdClass();
        $return->rides = $rides;
        echo json_encode($return);
    }

    function get_ride($id, $con) {
        $query = "
        SELECT ride.id as id, date, time, seats, info,
            s.id as start_id, s.name as start_name, s.address as start_address, s.image as start_image,
            e.id as end_id, e.name as end_name, e.address as end_address, e.image as end_image
        FROM ride
            INNER JOIN location as s
                ON s.id = ride.start_id
            INNER JOIN location as e
                ON e.id = ride.end_id
        WHERE ride.id = $id";
        $result = mysqli_query($con, $query);
        $row = mysqli_fetch_array($result);
        $ride['id'] = $row['id'];
        $ride['start_id'] = $row['start_id'];
        $ride['start_name'] = $row['start_name'];
        $ride['start_address'] = $row['start_address'];
        $ride['start_image'] = $row['start_image'];
        $ride['end_id'] = $row['end_id'];
        $ride['end_name'] = $row['end_name'];
        $ride['end_address'] = $row['end_address'];
        $ride['end_image'] = $row['end_image'];
        $return = new stdClass();
        $return->ride = $ride;
        echo json_encode($return);
    }
?>