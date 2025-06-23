<?php
    $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
    if($conn->connect_error){
        echo "Error: " . $conn->connect_error;
    }

    $whereSql = '';
    if(!empty($_GET['start']) && !empty($_GET['end'])){
        $whereSql .= " where start between '". $_GET['start'] ."' AND '" .$_GET['end']."'";
    }
    $sql = "select * from events $whereSql";
    $result = $conn->query($sql);

    $eventsArr = array();
    if($result->num_rows > 0){
        while($row = $result->fetch_assoc()){
            array_push($eventsArr, $row);
        }
    }
    echo json_encode($eventsArr);
?>