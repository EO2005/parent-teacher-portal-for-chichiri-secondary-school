<?php
session_start();

// Inline database connection
$connect = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');

// Check for database connection errors
if ($connect->connect_error) {
    die("Failed to connect to the database: " . $connect->connect_error);
}

// Retrieve user data from the messages_teachers table based on session's 'userId'
$sql = "SELECT * FROM message_teacher WHERE sender_id = {$_SESSION['userId']} OR receiver_id = {$_SESSION['userId']} ORDER BY time_sent DESC";
$result = $connect->query($sql);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher | Message</title>
    <link rel="stylesheet" href="../../Styles/Style.css">
    <script src="../../../../Libraries/Javascript/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="../../../../Libraries/Javascript/sweetalert2.all.min.js"></script>
</head>
<body class="Dashboard">
    <header>
      <img src="../../../../Assets/Images/chichiri.png" alt="">
      <h1>Teacher | Messaging</h1>
    </header>
    <nav>
    <button onclick="Swal.fire('User Guide Teacher \n Messaging','This is the messaging page, this will allow parents and teacher to communcication, first step is to select a chat, once done so, you can see the chat will be changed to another chat and now you should be able to see a textbox and a button that says send, so write a message and then press send.', 'info')"><img src="../../../../Assets/Images/info.png" alt=""></button>
      <a href="../Dashboard.php"><img src="../../../../Assets/Images/Naviagtion/Home.png" alt="">Dashboard</a>
      <a href="../Calendar/CalendarView.html"><img src="../../../../Assets/Images/Naviagtion/Calendar.png" alt="">Calendar</a>
      <a href="../Attendance/TakingAttendance.php"><img src="../../../../Assets/Images/Naviagtion/Manage.png" alt="">Attendance</a>
      <a href="../Grading/GradeTracking_Classes.php"><img src="../../../../Assets/Images/Naviagtion/Grading.png" alt="">Grading</a>
      <a href="../Generation/GenerationOfStudentProgress.php"><img src="../../../../Assets/Images/Naviagtion/Report.png" alt="">Generation</a>
      <a href="../Messaging/message.php"><img src="../../../../Assets/Images/Naviagtion/Message.png" alt="">Messaging</a>
      <a href="../../Login.html">Logout</a>
    </nav>
    <section>
      <div class="message-box">
        <div class="userlist">
            <h1>Parents</h1>
            <hr>
                <ul>
                    <div>
                <?php
                    $msgs = mysqli_query($connect, "SELECT * FROM parents") or die("Failed To Connect " . mysqli_error($connect));
                    while($msg = mysqli_fetch_assoc($msgs)){
                        echo '<li><a href="?toUser='. $msg['parent_id'] .'">'.$msg['first_name']. ' ' .$msg['last_name'] . '</a></li>';
                    }
                ?>
                </div>
                </ul>
        </div>
        <div class="message-column">
        <div class="user">
            <img src="../../../../Assets/Images/man.png" alt="">
            <p>
            <?php
           if(isset($_GET["toUser"])){
            $userName = mysqli_query($connect,"Select * from parents where parent_id = '".$_GET["toUser"]."'")
            or die("Error " . mysqli_error($connect));
            $uName = mysqli_fetch_assoc($userName);
            echo '<input type="text" value='.$_GET["toUser"].' id="toUser" hidden /></input>';
            echo $uName['first_name'];
        }
        else{
            $userName = mysqli_query($connect,"Select * from parents")
            or die("Error " . mysqli_error($connect));
            $uName = mysqli_fetch_assoc($userName);
            $_SESSION["toUser"] = $uName["parent_id"];
            echo '<input type="text" value='.$_SESSION["toUser"].' id="toUser" hidden /></input>';
            echo $uName['first_name'];
        }
            ?>
            </p>
        </div>
        <div class="messages" id="messages">
    <?php
    if (isset($_GET['toUser'])) {
        $toUser = $_GET['toUser'];
        $chats = mysqli_query($connect, "SELECT * FROM message_teacher WHERE (sender_id = '".$_SESSION['userId']."' AND receiver_id = '".$toUser."') OR (sender_id = '".$toUser."' AND receiver_id = '".$_SESSION['userId']."') ORDER BY date_sent desc, time_sent asc")
            or die("Error: " . mysqli_error($connect));
    } else {
        // Use $_SESSION['toUser'] here, and also set it when selecting the default user
        $toUser = $_SESSION['toUser'];
        $chats = mysqli_query($connect, "SELECT * FROM message_teacher WHERE (sender_id = '".$_SESSION['userId']."' AND receiver_id = '".$toUser."') OR (sender_id = '".$toUser."' AND receiver_id = '".$_SESSION['userId']."') ORDER BY date_sent desc, time_sent asc")
            or die("Error: " . mysqli_error($connect));
        $toUser = 'Select a User';
    }
    while ($chat = mysqli_fetch_assoc($chats)) {
        if ($chat['sender_id'] == $_SESSION['userId']) {
            echo "
                <div style='text-align:right;'>
                    <p style='background-color:lightblue; word-wrap: break-word; display:inline-block; padding:5px; border-radius:10px; max-width:70%'>
                        ".$chat["message_text"]."
                        <p>
                            ".$chat["time_sent"]."
                        </p>
                    </p>
                </div>
            ";
        } else {
            echo "
                <div style='text-align:left;'>
                    <p style='background-color:orange; word-wrap: break-word; display:inline-block; padding:5px; border-radius:10px; max-width:70%'>
                        ".$chat["message_text"]."
                        </p>
                        <p>
                            ".$chat["time_sent"]."
                        </p>
                    </p>
                </div>
            ";
        }
    }
    ?>
</div>

        <div class="sending-Message">
            <textarea name="" id="message-text" cols="30" rows="10"></textarea>
            <button id="send" class="send">Send</button>
        </div>
        </div>
      </div>
    </section>
</body>
<script type="text/javascript">
        $(document).ready(function () {
            $("#send").on("click", function () {
                var fromUser = <?php echo json_encode($_SESSION['userId']); ?>;
                var toUser = $("#toUser").val();
                var message = $("#message-text").val();

                $.ajax({
                    url: "SendMessage.php",
                    method: "POST",
                    data: {
                        fromUser: fromUser,
                        toUser: toUser,
                        Message: message,
                    },
                    dataType: "text",
                    success: function (data) {
                        // Handle the response
                            $("#message-text").val("");
                            // Refresh the message display
                            fetchMessages();
                    },
                    error: function (xhr, status, error) {
                        // Log the error to the console
                        console.error("AJAX Error: " + status + " - " + error);
                        console.log("AJAX Error: " + status + " - " + error); // Log the error message to the console
                    }
                });
            });

            function fetchMessages() {
                var fromUser = <?php echo json_encode($_SESSION['userId']); ?>;
                var toUser = $("#toUser").val();

                $.ajax({
                    url: 'FetchMessages.php',
                    method: "POST",
                    data: {
                        fromUser: fromUser,
                        toUser: toUser,
                    },
                    dataType: "html",
                    success: function (data) {
                        $("#messages").html(data); // Update the message container
                    }
                });
            }

            fetchMessages(); // Fetch messages initially

            setInterval(fetchMessages, 700); // Fetch messages periodically

        });
</script>

</html>
