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
$stmt->bind_param("ssss", $fromUser, $toUser, $toUser,$fromUser);
$stmt->execute();
$result = $stmt->get_result();

while ($chat = $result->fetch_assoc()) {
    if ($chat["sender_id"] == $_SESSION["userId"]) {
        $output .= "
            <div style='text-align:right;'>
                <p style='background-color:lightblue; word-wrap: break-word; display:inline-block; padding:5px; border-radius:10px; max-width:70%'>
                    " . $chat["message_text"] . "
                    <p style='font-size:10px'>
                        ". $chat["time_sent"] ."
                    </p>
                </p>
            </div>
        ";
    } else {
        $output .= "
            <div style='text-align:left;'>
                <p style='background-color:orange; word-wrap: break-word; display:inline-block; padding:5px; border-radius:10px; max-width:70%'>
                    " . $chat["message_text"] . "
                    <p style='font-size:10px'>
                        ". $chat["time_sent"] ."
                    </p>
                </p>
            </div>
        ";
    }
}

echo $output;
?>