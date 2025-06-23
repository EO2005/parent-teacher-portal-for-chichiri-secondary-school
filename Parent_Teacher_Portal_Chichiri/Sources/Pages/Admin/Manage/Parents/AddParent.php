<?php
    include('../../../../../Classes/Admin.php');
    $addParent = new Admin();

    $parent_id = $_POST['parent_id'];
    $password = $_POST['password'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email_address = $_POST['email_address'];
    $address = $_POST['address'];
    $phone_number = $_POST['phone_number'];
    $location = 'viewParents.php';
    
    $addParent->addParent($parent_id,$first_name,$password,$last_name,$phone_number,$email_address,$address,$location);
?>