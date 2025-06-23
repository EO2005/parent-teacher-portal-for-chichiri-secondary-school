<?php
session_start();
include("../../../../Classes/Notification.php");
$sendnotifi = new Notfication();
// Inline database connection
$connect = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');

// Check for database connection errors
if ($connect->connect_error) {
    die("Failed to connect to the database: " . $connect->connect_error);
}
date_default_timezone_set('Africa/Blantyre');
$fromUser = $_POST["fromUser"];
$toUser = $_POST["toUser"];
$message = $_POST["Message"];
$time = date("H:i:s");
$date = date("y.m.d");
$output = '';

$sql = "INSERT INTO message_teacher (sender_id, receiver_id, message_text, time_sent) VALUES (?, ?, ?, ?)";
$stmt = $connect->prepare($sql);
$stmt->bind_param("ssss", $fromUser, $toUser, $message, $time);

if ($stmt->execute()) {
    $output .= "Message inserted successfully";
    $sendnotifi->SendNotification($toUser, "New Message", $message, $date, $time);
} else {
    $output .= "Error: " . $stmt->error;
}

echo $output;
?>

