<?php
    include '../../../../../Classes/Admin.php';
    $delete = new Admin();

    if (isset($_GET["subject_id"])) {
        $subject_id = $_GET["subject_id"];
        $location = 'viewSubject.php';
        $delete->deleteSubjects($subject_id, $location);
    }
?>
