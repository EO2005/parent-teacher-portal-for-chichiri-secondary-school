<?php
    class Attendance{
        
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
                    echo "No attendance data available.";
                    return 0;
                }
            } else {
                echo "Query failed.";
                return 0; // Return 0 in case of a query failure.
            }
            $averageAttendance = ($countPresent / $countTotal) * 100;
            $conn->close();
            return number_format($averageAttendance, 0) . "%";
        }
    }
?>