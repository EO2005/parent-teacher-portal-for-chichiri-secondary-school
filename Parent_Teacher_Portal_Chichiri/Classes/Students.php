<?php
    class Students{
        function getName($student_id){
            $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
            $sqlName = "select * from students where student_id = '$student_id'";
            $queryName = mysqli_query($conn, $sqlName);
    
            if($queryName->num_rows > 0){
                $row = $queryName->fetch_assoc();
                $first_name = $row['first_name'];
                $last_name = $row['last_name'];
            }
            else{
                echo 'No result';
            }
            return $first_name . " " . $last_name;
        }
        function getAverageAttendcane($student_id){
            $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
        
            $sqlPresent = "SELECT COUNT(status) as count FROM attendance WHERE status = 'present' AND student_id = '$student_id'";
            $queryPresent = mysqli_query($conn, $sqlPresent);
        
            if ($queryPresent) {
                $rowPresent = $queryPresent->fetch_assoc();
                $countPresent = $rowPresent["count"];
            } else {
                echo "Query failed.";
                return 0; // Return 0 in case of a query failure.
            }
            
            $sqlTotal = "SELECT COUNT(DISTINCT datetaken) as date_count FROM attendance WHERE student_id = '$student_id'";
            $queryTotal = mysqli_query($conn, $sqlTotal);
        
            if ($queryTotal) {
                $rowTotal = $queryTotal->fetch_assoc();
                $countTotal = $rowTotal["date_count"];
                if ($countTotal == 0) {
                    return "No attendance data available";
                    
                }
            } else {
                return "Query failed.";
                  // Return 0 in case of a query failure.
            }
            $conn->close();
            if ($countTotal == 0) {
                // Handle the case where countTotal is zero to avoid division by zero
                return "No attendance data available.";
            }
        
            $averageAttendance = ($countPresent / $countTotal) * 100;
            
            return number_format($averageAttendance, 0) . "%";
        }
        function getAverageGrade($student_id) {
            $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
            
            // Check for a valid database connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
    
            $sqlGrades = "SELECT SUM(grade_value) AS grades FROM grades WHERE student_id = ?";
            $stmtGrades = $conn->prepare($sqlGrades);
            $stmtGrades->bind_param("s", $student_id);
            $stmtGrades->execute();
            $resultGrades = $stmtGrades->get_result();
        
            if ($resultGrades->num_rows > 0) {
                $rowTotal = $resultGrades->fetch_assoc();
                $countTotal = $rowTotal["grades"];
            } else {
                return "No result";
            }
        
            $sqlAverageGrade = "SELECT COUNT(grade_value) AS grades FROM grades WHERE student_id = ?";
            $stmtAverageGrade = $conn->prepare($sqlAverageGrade);
            $stmtAverageGrade->bind_param("s", $student_id);
            $stmtAverageGrade->execute();
            $resultAverageGrade = $stmtAverageGrade->get_result();
        
            if ($resultAverageGrade->num_rows > 0) {
                $rowAverage = $resultAverageGrade->fetch_assoc();
                $countGrades = $rowAverage["grades"];
            } else {
                return "No result";
            }
        
            $conn->close();
        
            // Avoid division by zero
            if ($countGrades == 0) {
                return "No grades available";
            }
        
            $totalMark = $countGrades / 100;
            $averageGrade = ($countTotal / $totalMark) * 100;
        
            // Return the result
            
            return $this->checkGrade(number_format($averageGrade, 0));
        }
        function checkGrade($Grade){
            if($Grade >= 90){
                $Grade = 'A+';
            }
            else if($Grade >= 80){
                $Grade = 'A';
            }
            else if($Grade >= 70){
                $Grade = 'B';
            }
            else if($Grade >=60){
                $Grade = 'C';
            }
            else if($Grade >=50){
                $Grade = 'D';
            }
            else if($Grade >=0){
                $Grade = 'F';
            }
            else{
                $Grade = 'No Result';
            }
            return $Grade;
        }
        
    }
?>