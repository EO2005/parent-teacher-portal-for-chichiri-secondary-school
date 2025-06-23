<?php
    include '../../../../../Classes/Admin.php';
    $delete = new Admin();

    if (isset($_GET["student_id"])) {
        $student_id = $_GET["student_id"];
        $location = 'viewStudents.php';
        $delete->deleteStudents($student_id, $location);
    }
?>