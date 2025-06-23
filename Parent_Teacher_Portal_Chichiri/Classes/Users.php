<?php
    class Users{
        /*
          Logging In
        */
        function Login($staffID, $password, $location){
          $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
          if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
          }
          $sql = "SELECT * FROM teachers WHERE teacher_id = ? AND password = ?";
          $stmt = $conn->prepare($sql);
          if (!$stmt) {
            die("Error preparing statement: " . $conn->error);
          }
          $stmt->bind_param("ss", $staffID, $password);
          $stmt->execute();
          $result = $stmt->get_result();
          if($staffID == "Admin" && $password == "1234"){
            header("Location:" . $location);
          }
          else if ($result->num_rows === 1){
            session_start();
            $_SESSION['userId'] = $staffID;
            header("Location:" . $location);
            exit();
          }
          else if($result->num_rows === 0){
            echo '<script>alert("No Teachers found."); window.history.back();</script>';
          }
          else{
            echo "Invalid Login Credentials";
          }
          $stmt->close();
          $conn->close();
        }


        function ParentLogin($parentID, $password, $location){
          $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
          if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
          }
          $sql = "SELECT * FROM parents WHERE parent_id = ? AND password = ?";
          $stmt = $conn->prepare($sql);
          if (!$stmt) {
            die("Error preparing statement: " . $conn->error);
          }
          $stmt->bind_param("ss", $parentID, $password);
          $stmt->execute();
          $result = $stmt->get_result();
          if ($result->num_rows === 1){
            session_start();
            $_SESSION['parent_id'] = $parentID;
            header("Location:" . $location);
            exit();
          }
          else if($result->num_rows === 0){
            echo '<script>alert("No students found in the class."); window.history.back();</script>';
          }
          else{
            echo "Invalid Login Credentials";
          }
          $stmt->close();
          $conn->close();
        }
    }
?>