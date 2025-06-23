<?php
    include('../../../../../Classes/Admin.php');
    $addteacher = new Admin();

    $teacher_id = $_POST['teacher_id'];
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $gender = $_POST['gender'];
    $location = "viewTeachers.php";
    $addteacher->addTeachers($teacher_id, $password, $first_name, $last_name, $gender, $location);
?>