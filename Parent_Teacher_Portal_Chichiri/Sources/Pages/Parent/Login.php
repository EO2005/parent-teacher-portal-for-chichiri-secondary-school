<?php
    session_start();
    include("../../../Classes/Users.php");
    $parentLogin = new Users();
    $parent_id = $_POST['parent_id'];
    $password = $_POST['password'];
    $location = "Dashboard.php";
    $parentLogin->ParentLogin($parent_id, $password, $location);
    $_SESSION['parent_id'] = $parent_id;
?>