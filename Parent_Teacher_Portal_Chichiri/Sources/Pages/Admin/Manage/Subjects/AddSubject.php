<?php
    include('../../../../../Classes/Admin.php');
    $admin = new Admin();

    $subject_name = $_POST['subject_name'];
    $location = 'viewSubject.php';
    
    $admin->addSubject($subject_name, $location);
?>