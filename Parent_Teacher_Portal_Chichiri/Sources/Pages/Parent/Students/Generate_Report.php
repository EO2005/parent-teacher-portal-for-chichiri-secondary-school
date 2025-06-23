<?php
require('../../../../Classes/GenerateReport.php');

// Retrieve the student_id from POST data
$student_id = $_GET['student_id'];

// Create an instance of GenerateReport
$generate_student_progress = new GenerateReport();

// Output the PDF to the browser
header('Content-Type: application/pdf');
header('Content-Disposition: inline; filename="student_report.pdf"');
echo $generate_student_progress->generateStudentProgress($student_id);
?>