<?php
session_start();

// Inline database connection
$connect = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');

// Check for database connection errors
if ($connect->connect_error) {
    die("Failed to connect to the database: " . $connect->connect_error);
}

// Retrieve user data from the messages_teachers table based on session's 'userId'
$sql = "SELECT * FROM message_teacher WHERE sender_id = {$_SESSION['parent_id']} OR receiver_id = {$_SESSION['parent_id']}";
$result = $connect->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent | Messages</title>
    <link rel="stylesheet" href="../../Styles/StyleMobile.css">
    <script src="../../../../Libraries/Javascript/node_modules/jquery/dist/jquery.js"></script>
    <script src="../../../../Libraries/Javascript/sweetalert2.all.min.js"></script>
</head>
<body class="Mobileview">
    <header>
        <a href="../Dashboard.php"><</a>
        <h3>Messages</h3>
    </header>
    <div class="mobilebody">
        <div class="userlist">
            <h1>Teachers Chat</h1>
            <hr>
            <!--This section is for the contact list so that the parents can talk to the teachers-->
            <?php
            $msgs = mysqli_query($connect, "SELECT * FROM teachers") or die("Failed To Connect " . mysqli_error($connect));
            while($msg = mysqli_fetch_assoc($msgs)){
            echo '<div class="contact-list">';
            echo   '<a href="MessageChat.php?toUser='. $msg['teacher_id'] .'"><img src="../../../../Assets/Images/man.png" alt="User">'. $msg['first_name'] . ' ' . $msg['last_name'] .'</a>';
            echo '</div>';
            }
            ?>
        </div>
    </div>
    <nav class="nav">
        <a href="../Calendar/calendarView.php"><img src="../../../../Assets/Images/Naviagtion/Calendar.png" alt="">Calendar</a>
        <a href="Messages.php"><img src="../../../../Assets/Images/Naviagtion/Message.png" alt="">Messaging</a>
        <a href="../Dashboard.php"><img src="../../../../Assets/Images/Naviagtion/Home.png" alt="">Home</a>
        <button onclick="Swal.fire('Parent \n Message', 'Select A Chat')"><img src="../../../../Assets/Images/info.png" alt=""></button>
    </nav>
</body>
</html>