<?php
    include("../../../../Classes/Notification.php");
    date_default_timezone_set('Africa/Blantyre');
    $date = date("y.m.d");
    $time = date("H:i:s");
     $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
     if($conn->connect_error){
         echo "Error: " . $conn->connect_error;
     }
     
     $jsonStr = file_get_contents("php://input");
     $jsonObj = json_decode($jsonStr);

     if ($jsonObj->request_type == "addEvent") {
        $start = $jsonObj->start;
        $end = $jsonObj->end;
    
        $event_data = $jsonObj->event_data;
        $event_title = !empty($event_data[0]) ? $event_data[0] : '';
        $event_description = !empty($event_data[1]) ? $event_data[1] : ''; // Use [1] to access the description
    
        if (!empty($event_title)) {
            $sql = "insert into events(title, description, start, end) values (?,?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssss', $event_title, $event_description, $start, $end);
            $insert = $stmt->execute();
    
            if ($insert) {
                $output = [
                    'status' => 1
                ];
                echo json_encode($output);
            } else {
                echo json_encode(['error' => 'Event Add request Failed']);
            }
        }elseif ($jsonObj->request_type == 'deleteEvent') {
            $id = $jsonObj->event_id;

            $sql = "Delete from events where id=$id";
            $delete = $conn->query($sql);

            if($delete){
                $output = [
                    'status' => 1
                ];
                echo json_encode($output);
            }else{
                echo json_encode(['error' => 'Event Delete Request Failed']);
            }
        }
    }
    
?>