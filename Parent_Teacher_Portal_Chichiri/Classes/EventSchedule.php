<?php
    class EventSchedule{
        function addevent($event_name, $event_date, $event_time, $event_location, $event_desciption){
            $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
            $sql = "insert into events(event_name, event_date, event_time, event_location, event_description) values('$event_name', '$event_date', '$event_time', '$event_location', '$event_desciption')";
            $queryEventAdding = mysqli_query($conn, $sql);
            if($queryEventAdding == true){
                echo "<script>alert('Event Added For The Event $event_name On The $event_date')</script>";
            }
            else{
                echo "<script>alert('Event Failed To Get Added')</script>";
            }
            $conn->close();
        }
        function editevent($event_name, $event_date, $event_time, $event_location, $event_desciption, $event_id){
            $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
            $sql = 'update events set ';
        }
    }
?>