<?php
    require('../../../../Classes/GenerateReport.php');

    $generate_student_progress = new GenerateReport();

    $student_id = $_POST['student_id'];

    $generate_student_progress->generateStudentProgress($student_id);
?>