<?php
    include('../../../../../Classes/Admin.php');
    $addstudent = new Admin();

    $student_id = $_POST['student_id'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $address = $_POST['address'];
    $date_of_birth = $_POST['date_of_birth'];
    $gender = $_POST['gender'];
    $parent_id = $_POST['parent_id'];
    $class_id = $_POST['class_id'];
    $location = 'viewStudents.php';
    
    $addstudent->addStudents($student_id,$first_name,$last_name,$date_of_birth,$gender,$address,$parent_id,$class_id,$location);
    
?>