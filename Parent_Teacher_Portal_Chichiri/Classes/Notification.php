<?php
    class Notfication{
        function SendNotification($receiver_id, $title, $message, $date, $time) {
            $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
        
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
        
            $stmt = $conn->prepare('INSERT INTO notification (reciver_id, title, description, created_date, created_time) VALUES (?, ?, ?, ?, ?)');
        
            if (!$stmt) {
                die("Error in prepare: " . $conn->error);
            }
        
            $stmt->bind_param('sssss', $receiver_id, $title, $message, $date, $time);
        
            if (!$stmt->execute()) {
                die("Error in execute: " . $stmt->error);
            } else {
                $conn->close();
                return true;
            }
        }
        function SendNotificationAttendance($receiver_id, $title, $message, $date, $time, $attendanceStatus) {
            $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
        
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            if($attendanceStatus == "Absent"){
                $stmt = $conn->prepare('INSERT INTO notification (reciver_id, title, description, created_date, created_time) VALUES (?, ?, ?, ?, ?)');
                if (!$stmt) {
                    die("Error in prepare: " . $conn->error);
                }
                $stmt->bind_param('sssss', $receiver_id, $title, $message, $date, $time);
         
                if (!$stmt->execute()) {
                    die("Error in execute: " . $stmt->error);
                } else {
                    $conn->close();
                    return true;
                }
            } 
        }
        
        function RecieveNotification($user_id) {
            $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
        
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
        
            $stmt = $conn->prepare('SELECT * FROM notification WHERE reciver_id = ? order by created_time desc');
            if (!$stmt) {
                die("Error in prepare: " . $conn->error);
            }
            
            $stmt->bind_param('s', $user_id);
            if (!$stmt->execute()) {
                die("Error in execute: " . $stmt->error);
            }
        
            $result = $stmt->get_result();
        
            while ($row = $result->fetch_assoc()) {

                echo '<div class="notifications">';
                echo '<div class="header">';
                echo '<h3>' . $row['title'] . '</h3>';
                echo '<p>'. $row['description'] .'</p>';
                echo '</div>';
                echo '<div class="content">';
                echo '<p>' . $row['created_date'] . '</p>';
                echo '<p>' . $row['created_time'] . '</p>';
                echo '</div>';
                echo '</div>';
            }
        
            $conn->close();
        }
        function SendNotificationToAllUsers($title, $message, $date, $time) {
            $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
        
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
        
            // Send notifications to teachers
            $teacherStmt = $conn->prepare('INSERT INTO notification (receiver_id, title, description, created_date, created_time) SELECT teacher_id, ?, ?, ?, ? FROM teachers');
            if (!$teacherStmt) {
                die("Error in prepare: " . $conn->error);
            }
        
            $teacherStmt->bind_param('ssss', $title, $message, $date, $time);
        
            if (!$teacherStmt->execute()) {
                die("Error in execute: " . $teacherStmt->error);
            }
        
            // Send notifications to parents
            $parentStmt = $conn->prepare('INSERT INTO notification (receiver_id, title, description, created_date, created_time) SELECT parent_id, ?, ?, ?, ? FROM parents');
            if (!$parentStmt) {
                die("Error in prepare: " . $conn->error);
            }
        
            $parentStmt->bind_param('ssss', $title, $message, $date, $time);
        
            if (!$parentStmt->execute()) {
                die("Error in execute: " . $parentStmt->error);
            }
        
            $conn->close();
            return true;
        }
        
        
        function countNotifications(){

        }
        
    }
?>