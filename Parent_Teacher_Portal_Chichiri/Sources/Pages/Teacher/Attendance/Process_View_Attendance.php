<?php
require('../../../../Libraries/PHP/FPDF/fpdf.php'); // Include the FPDF library

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $startDate = $_POST["start_date"];
    $endDate = $_POST["end_date"];

    // Check if both start and end dates are provided
    if (empty($startDate) || empty($endDate)) {
        echo '<script>alert("Please select both start and end dates.");</script>';
        echo '<script>window.history.back();</script>';
    } else {
        $servername = 'localhost';
        $username = 'root';
        $password = '';
        $database = 'parent_teacher_portal_chichiri';

        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            echo 'Error: ' . mysqli_connect_error();
        }

        // Initialize a PDF object with landscape orientation
        $pdf = new FPDF('L');
        
        // Your SQL query to retrieve attendance data within the date range
        $sql = "SELECT DISTINCT DATE(attendance.datetaken) AS date_taken FROM attendance
                WHERE DATE(attendance.datetaken) BETWEEN '$startDate' AND '$endDate'
                ORDER BY date_taken";

        $result = $conn->query($sql);

        if (!$result) {
            die("Invalid Query: " . $conn->error);
        }

        // Loop through the dates and create pages for each date
        while ($row = $result->fetch_assoc()) {
            $dateTaken = $row['date_taken'];
            
            // Add a new page for each date
            $pdf->AddPage();
            
            // Set font and size for the school name
            $pdf->SetFont('Arial', 'B', 16);
            $pdf->Cell(0, 10, 'Chichiri Secondary School', 0, 1, 'C');
            
            // Title for the entire report
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(280, 10, 'Attendance from ' . $startDate . ' to ' . $endDate, 0, 1, 'C');
            $pdf->Ln(10);

            // Title for the date
            $pdf->SetFont('Arial', 'B', 14);
            $pdf->Cell(280, 10, 'Date: ' . $dateTaken, 0, 1, 'L');
            $pdf->Ln(10); // Add some space below the date title

            // Set font and size for the table
            $pdf->SetFont('Arial', '', 10);

            // Create the table header with a green background
            $pdf->SetFillColor(0, 128, 0); // Green color
            $pdf->SetTextColor(255); // White text color
            
            // Define table header cell sizes and labels
            $headerCellSizes = [40, 40, 40, 40, 40, 80];
            $headerLabels = ['Student ID', 'First Name', 'Last Name', 'Date Of Birth', 'Gender', 'Attendance'];

            // Loop through header labels and add cells with background color
            for ($i = 0; $i < count($headerLabels); $i++) {
                $pdf->Cell($headerCellSizes[$i], 10, $headerLabels[$i], 1, 0, 'C', 1); // Background color
            }
            
            $pdf->Ln(); // Move to the next line

            // Set background color for the data rows (white)
            $pdf->SetFillColor(255, 255, 255); // White color
            $pdf->SetTextColor(0); // Black text color

            // Your SQL query to retrieve attendance data for the current date
            $sql = "SELECT students.student_id, students.first_name, students.last_name, students.gender, students.date_of_birth, attendance.status
                    FROM students
                    JOIN student_classes ON students.student_id = student_classes.student_id
                    JOIN classes ON student_classes.class_id = classes.class_id
                    JOIN attendance ON students.student_id = attendance.student_id
                    WHERE DATE(attendance.datetaken) = '$dateTaken' AND student_classes.class_id = $_GET[class_id]";

            $result2 = $conn->query($sql);

            if (!$result2) {
                die("Invalid Query: " . $conn->error);
            }

            // Add attendance data for the current date
            while ($row2 = $result2->fetch_assoc()) {
                $pdf->Cell(40, 10, $row2['student_id'], 1, 0, 'C'); // Background color
                $pdf->Cell(40, 10, $row2['first_name'], 1, 0, 'C'); // Background color
                $pdf->Cell(40, 10, $row2['last_name'], 1, 0, 'C'); // Background color
                $pdf->Cell(40, 10, $row2['date_of_birth'], 1, 0, 'C'); // Background color
                $pdf->Cell(40, 10, $row2['gender'], 1, 0, 'C'); // Background color
                $pdf->Cell(80, 10, $row2['status'], 1, 1, 'C'); // Background color
            }
        }

        // Output the PDF
        $pdf->Output();
    }
}
?>
