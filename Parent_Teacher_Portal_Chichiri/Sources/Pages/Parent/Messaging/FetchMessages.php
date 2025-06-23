<?php
session_start();
// Inline database connection
$connect = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');

// Check for database connection errors
if ($connect->connect_error) {
    die("Failed to connect to the database: " . $connect->connect_error);
}
$fromUser = $_POST["fromUser"];
$toUser = $_POST["toUser"];
$output = '';

$sql = "SELECT * FROM message_teacher WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?) ORDER BY time_sent asc, date_sent asc";
$stmt = $connect->prepare($sql);
$stmt->bind_param("ssss", $fromUser, $toUser, $toUser, $fromUser);
$stmt->execute();
$result = $stmt->get_result();

while ($chat = $result->fetch_assoc()) {
    if ($chat["receiver_id"] == $_SESSION["parent_id"]) {
        $output .= '
        <div class="sender">
            <p class="Reciver">'.$chat['message_text'].'</p>
        </div>
        ';
    } else {
        $output .= '
        <div class="reciver">
            <p class="Sender">'.$chat['message_text'].'</p>
        </div>
        ';
    }
}

echo $output;
?>