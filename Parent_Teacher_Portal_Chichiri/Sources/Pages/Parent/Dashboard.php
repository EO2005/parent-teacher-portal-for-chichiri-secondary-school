<?php
session_start();

if (!isset($_SESSION["parent_id"])) {
    header("Location: login.php");
    exit();
}

// Establish a database connection (replace with your database credentials)
$mysqli = new mysqli("localhost", "root", "", "parent_teacher_portal_chichiri");

if ($mysqli->connect_error) {
    die("Database connection failed: " . $mysqli->connect_error);
}

// Retrieve the user's name from the database based on their user ID
$dbUserId = $_SESSION["parent_id"];
$query = "SELECT first_name FROM parents WHERE parent_id = ?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param("s", $dbUserId); // "i" represents an integer

if ($stmt->execute()) {
    $stmt->bind_result($userName);
    $stmt->fetch();
} else {
    die("Query failed: " . $stmt->error);
}

// Close the database connection
$stmt->close();
$mysqli->close();
?>
<?php
// Establish a database connection (replace with your database credentials)
$mysqli = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');

if ($mysqli->connect_error) {
    die("Connection failed: " . $mysqli->connect_error);
}

$query = "SELECT DISTINCT
students.student_id,
students.first_name,
students.last_name,
classes.class_name
FROM
students
LEFT JOIN
student_classes ON student_classes.student_id = students.student_id
LEFT JOIN
classes ON classes.class_id = student_classes.class_id
LEFT JOIN
student_parents ON student_parents.student_id = students.student_id
LEFT JOIN
parents ON parents.parent_id = student_parents.parent_id
WHERE
parents.parent_id = ?";


$stmt = $mysqli->prepare($query);

if (!$stmt) {
    die("Query preparation failed: " . $mysqli->error);
}

// Bind the parameter to the placeholder
$stmt->bind_param("s", $_SESSION["parent_id"]);  // "s" for string, adjust if it's a different data type

// Execute the statement
if ($stmt->execute()) {
    $result = $stmt->get_result();

    if (!$result) {
        die("Query execution failed: " . $mysqli->error);
    }
} else {
    die("Query execution failed: " . $stmt->error);
}

?>
<?php
    include('../../../Classes/Notification.php');
    $reciveNotification = new Notfication();
    
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent | Dashboard</title>
    <link rel="stylesheet" href="../Styles/StyleMobile.css">
    <script src="../../../Libraries/Javascript/sweetalert2.all.min.js"></script>
</head>
<body class="Mobileview">
    <header>
        <h3>Home</h3>
    </header>
    <div class="mobilebody">
        <h1>Welcome <?php echo $userName?></h1>
        <br>
        <br>
        <h1>Your Children</h1>
        <br>
        <?php while ($row = $result->fetch_assoc()) { ?>
        <div class="card">
            <img src="../../../Assets/Images/man.png" alt="Image Depending On Gender">
            <h2><?php echo $row['first_name'] . " " .$row['last_name'] ; ?></h2>
            <p><?php echo $row['class_name']; ?></p>
            <a href="Students/Student.php?student_id=<?php echo $row['student_id']; ?>">View Child</a>
        </div>
        <?php } ?>
        <div class="list-notification">
            <h1>Your Notificaitons</h1>
            <?php
                $reciveNotification->RecieveNotification($_SESSION['parent_id']);
            ?>
        </div>
       
    </div>
    <nav class="nav">
        <a href="Calendar/calendarView.php"><img src="../../../Assets/Images/Naviagtion/Calendar.png" alt="">Calendar</a>
        <a href="Messaging/Messages.php"><img src="../../../Assets/Images/Naviagtion/Message.png" alt="">Messaging</a>
        <a href="#"><img src="../../../Assets/Images/Naviagtion/Home.png" alt="">Home</a>
        <button onclick="Swal.fire('Hello <?php echo $userName?>', 'This is parent dashboard, you can view your childs current progress, your Notificaitons and navigate though the navbar')"><img src="../../../Assets/Images/info.png" alt=""></button>
    </nav>
</body>
</html>
<?php $mysqli->close();?>