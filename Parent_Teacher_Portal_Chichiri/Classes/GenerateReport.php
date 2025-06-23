<?php
require('C:\wamp64\www\Parent_Teacher_Portal_Chichiri\Libraries\Php\FPDF\fpdf.php'); // Use the absolute path

    /*
    
    
        The Class Generate Report is going to generate a response
    
    
    */
   
    class GenerateReport {
        public function generateStudentProgress($student_id) {
            ob_start();
            $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
            $pdf = new FPDF();
            $pdf->AddPage('L');
            $pdf->SetFont('Arial', 'B', 16); // Set font and size
            $pdf->Image('C:\wamp64\www\Parent_Teacher_Portal_Chichiri\Assets\Images/chichiri-small09.jpg');
            // Call functions using $this to access them within the class
            $pdf->Cell(0, 10, "Chichiri Secondary School", 0, 1, 'C');
            $pdf->Cell(0, 10, "Location: 52XV+M38, Blantyre", 0, 1, 'C');
            $pdf->Cell(0, 10, $this->getName($student_id) . ' Progress Report', 0, 1, 'C');
            $pdf->Ln(10);
            $pdf->SetFont('Arial', '', 12);
            $pdf->SetX(10);
            $pdf->Cell(60, 10, "Name: " . $this->getName($student_id), 0, 0, 'L');
            $pdf->Cell(60, 10, 'Gender: ' . $this->getGender($student_id), 0, 0, 'L');
            $pdf->SetX(140);
            $pdf->Cell(0, 10, 'Overall Attendance: ' . $this->getAverageAttendance($student_id), 0, 1, 'R');
            $pdf->Cell(0, 10, 'Overall Grade: ' . $this->getAverageGrade($student_id), 0, 1, 'R');
            $pdf->Ln(30);
            $sqlGrades = "SELECT subjects.subject_name, (SUM(grades.grade_value) / COUNT(grades.subject_id)) AS total_grades FROM students JOIN grades ON students.student_id = grades.student_id JOIN subjects ON grades.subject_id = subjects.subject_id WHERE students.student_id='$student_id' GROUP BY students.student_id, subjects.subject_name";
            $result = $conn->query($sqlGrades);
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(140, 10, 'Subject Name', 1, 0, 'C');
            $pdf->Cell(140, 10, 'Grades', 1, 0, 'C');
            $pdf->Ln(10);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $pdf->SetFont('Arial', '', 11);
                    $pdf->Cell(140, 10, $row['subject_name'], 1, 0, 'C');
                    $pdf->Cell(140, 10, $this->checkGrade($row['total_grades']), 1, 0, 'C');
                    $pdf->Ln();
                }
            }
            $conn->close();
            ob_end_clean();
            $pdf->Output();
        }
    
        
    /*
        This class is for generating the student progress reports for the students
    */
    function getAverageAttendance($student_id){
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
    
    /*
        This calculates the average grade of the student
    */
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
    
    /*

        This function is for getting the gender of the student

    */
    function getGender($student_id){
        $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
        $sqlGender = "select * from students where student_id='$student_id'";
        $queryGender = mysqli_query($conn, $sqlGender);

        if($queryGender->num_rows > 0){
            $row = $queryGender->fetch_assoc();
            $gender = $row['gender'];
        }
        else{
            echo "Failed To Retrive";
        }
        return $gender;
    }
    /*

        This function is for getting the name of the student

    */
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