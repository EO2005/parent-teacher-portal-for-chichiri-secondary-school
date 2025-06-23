<?php
session_start();

// Inline database connection
$connect = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');

// Check for database connection errors
if ($connect->connect_error) {
    die("Failed to connect to the database: " . $connect->connect_error);
}

// Retrieve user data from the messages_teachers table based on session's 'parent_id'
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
        <a href="Messages.php"><</a>
        <p>
        <?php
        if (isset($_GET["toUser"])) {
            $userName = mysqli_query($connect, "Select * from teachers where teacher_id = '".$_GET["toUser"]."'")
                or die("Error " . mysqli_error($connect));
            $uName = mysqli_fetch_assoc($userName);
            echo '<input type="text" value='.$_GET["toUser"].' id="toUser" hidden /></input>';
            echo $uName['first_name'];
        } else {
            $userName = mysqli_query($connect, "Select * from teachers")
                or die("Error " . mysqli_error($connect));
            $uName = mysqli_fetch_assoc($userName);
            $_SESSION["toUser"] = $uName["teacher_id"];
            echo '<input type="text" value='.$_SESSION["toUser"].' id="toUser" hidden /></input>';
            echo $uName['first_name'];
        }
        ?>
    </header>
    <div class="mobilebody">
        <div class="Message" id="messages">
            <div class="Message-Box" id="message">
                <?php
                if (isset($_GET['toUser'])) {
                    $toUser = $_GET['toUser'];
                    $chats = mysqli_query($connect, "SELECT * FROM message_teacher WHERE (sender_id = '".$_SESSION['parent_id']."' AND receiver_id = '".$toUser."') OR (sender_id = '".$toUser."' AND receiver_id = '".$_SESSION['parent_id']."') ORDER BY time_sent ASC")
                        or die("Error: " . mysqli_error($connect));
                } else {
                    // Use $_SESSION['toUser'] here, and also set it when selecting the default user
                    $toUser = $_SESSION['toUser'];
                    $chats = mysqli_query($connect, "SELECT * FROM message_teacher WHERE (sender_id = '".$_SESSION['parent_id']."' AND receiver_id = '".$toUser."') OR (sender_id = '".$toUser."' AND receiver_id = '".$_SESSION['parent_id']."') ORDER BY time_sent ASC")
                        or die("Error: " . mysqli_error($connect));
                    $toUser = 'Select a User';
                }

                while ($chat = mysqli_fetch_assoc($chats)) {
                    if ($chat['receiver_id'] == $_SESSION['parent_id']) {
                        echo '
                            <div class="sender">    
                                <p class="Reciver">'.$chat['message_text'].'</p>
                            </div>
                        ';
                    } else {
                        echo '
                            <div class="reciver">
                                <p class="Sender">'.$chat['message_text'].'</p>
                            </div>
                        ';
                    }
                }
                ?>
            </div>
            <div class="Message-Send">
                <textarea name="" id="message-text"></textarea>
                <input type="submit" value=">" id="send">
            </div>
        </div>
    </div>
    <nav class="nav">
        <a href="../Calendar/calendarView.php"><img src="../../../../Assets/Images/Naviagtion/Calendar.png" alt="">Calendar</a>
        <a href="Messages.php"><img src="../../../../Assets/Images/Naviagtion/Message.png" alt="">Messaging</a>
        <a href="../Dashboard.php"><img src="../../../../Assets/Images/Naviagtion/Home.png" alt="">Home</a>
        <button onclick="Swal.fire('Parent \n Message', 'Type Words in the messagebox below then click the send button next to it, its a green button')"><img src="../../../../Assets/Images/info.png" alt=""></button>
    </nav>
</body>
<script type="text/javascript">
    function scrollToBottom() {
                var messageBox = document.getElementById("message");
                messageBox.scrollTop = messageBox.scrollHeight;
                }
                scrollToBottom();
        $(document).ready(function () {
            $("#send").on("click", function () {
                var fromUser = <?php echo json_encode($_SESSION['parent_id']); ?>;
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
                            
                            fetchMessages();
                            scrollToBottom();
                    },
                });
            });

            function fetchMessages() {
                var fromUser = <?php echo json_encode($_SESSION['parent_id']); ?>;
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
                        $("#message").html(data); // Update the message container
                        scrollToBottom();
                        
                    }
                });
            }

            fetchMessages();
            
            setInterval(fetchMessages, 700);
        });
</script>
</html>
