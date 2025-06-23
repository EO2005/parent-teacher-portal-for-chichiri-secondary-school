<?php
    require('../Classes/Users.php');
    $users = new Users();






    $staffID = $_POST['Staff_ID'];
    $password = $_POST['Password'];
    $locationAdmin = '../Sources/Pages/Admin/Dashboard.php';
    $locationTeacher = '../Sources/Pages/Teacher/Dashboard.php';

    if($staffID == 'Admin' && $password == '1234'){
        $users->Login($staffID,$password,$locationAdmin);
    }
    else{
        $users->Login($staffID,$password,$locationTeacher);
    }
?>