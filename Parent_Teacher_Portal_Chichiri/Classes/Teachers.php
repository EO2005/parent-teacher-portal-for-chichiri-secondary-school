<?php
    class Teachers{
        function takingGrades($class_id, $student_id, $subject, $test_type, $score, $comment){
            $conn = new mysqli("localhost", "root", "", "parent_teacher_portal_chichiri");
            $takeGrade = "insert into grades(student_id, subject_id, grade_value, type_of_assessment, comments, class_id) values('$student_id', '$subject', $score, '$test_type', '$comment', '$class_id')";
            $query = mysqli_query($conn, $takeGrade);
            if($query == true){
                echo "<script>alert('Grade Added Successfully');</script>";
            }
            else{
                echo "<script>alert('Failed To Add Grade');</script>";
                echo $conn->connect_error;
            }
            $conn->close();
        }

        function takingAttendance($student_id, $status, $class){
        $conn = new mysqli("localhost", "root", "", "parent_teacher_portal_chichiri");
        
        // Get the current date in the format 'd-m-y'
        $date = date("d-m-y");
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        // Check if attendance already exists for the given student and date
        $checkAttendance = "SELECT * FROM attendance WHERE student_id = '$student_id' AND datetaken = '$date'";
        $result = mysqli_query($conn, $checkAttendance);
        
        if(mysqli_num_rows($result) > 0) {
            echo "<script>alert('Attendance already recorded for today');</script>";
        } else {
            $takeAttendance = "INSERT INTO attendance VALUES('$student_id', '$date', '$status', '$class')";
            $query = mysqli_query($conn, $takeAttendance);
            
            if($query == true){
                echo "<script>alert('Attendance Added Successfully');</script>";
            } else {
                echo "<script>alert('Failed To Add Attendance Of Student');</script>";
                echo $conn->connect_error;
            }
        }
}
    }
?>