<?php
    include("../../../../../Classes/Admin.php");
    $class = new Admin();
    $class_name = $_POST['class_name'];
    $date_intake = $_POST['intake_date'];
    $location = "viewClasses.php";
    $class->addClasses($class_name, $date_intake, $location);
?>