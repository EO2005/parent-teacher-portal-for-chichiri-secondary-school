<?php
    $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
    $sql = "select * from classes";
    $result = $conn->query($sql);
    $conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher | Select Class</title>
    <link rel="stylesheet" href="../../Styles/Style.css">
    <script src="../../../../Libraries/Javascript/sweetalert2.all.min.js"></script>
</head>
<body class="Dashboard">
<header>
      <img src="../../../../Assets/Images/chichiri.png" alt="">
      <h1>Teacher | Attendance</h1>
    </header>
    <nav>
        <button onclick="Swal.fire('User Guide Teacher \n Attendnace Tracking', 'This is attendance tracking, start by selecting a class', 'info')"><img src="../../../../Assets/Images/info.png"></button>
      <a href="../Dashboard.php"><img src="../../../../Assets/Images/Naviagtion/Home.png" alt="">Dashboard</a>
      <a href="../Calendar/CalendarView.html"><img src="../../../../Assets/Images/Naviagtion/Calendar.png" alt="">Calendar</a>
      <a href="../Attendance/TakingAttendance.php"><img src="../../../../Assets/Images/Naviagtion/Manage.png" alt="">Attendance</a>
      <a href="../Grading/GradeTracking_Classes.php"><img src="../../../../Assets/Images/Naviagtion/Grading.png" alt="">Grading</a>
      <a href="../Generation/GenerationOfStudentProgress.php"><img src="../../../../Assets/Images/Naviagtion/Report.png" alt="">Generation</a>
      <a href="../Messaging/message.php"><img src="../../../../Assets/Images/Naviagtion/Message.png" alt="">Messaging</a>
      <a href="../../Login.html">Logout</a>
    </nav>
    <section>
    <div class="form">
    <form action="Take_attendance.php" method="post">
        <h1>Attendance Tracking | Select Class</h1>
        <br>
    <select name="class_id">
        <?php
        while($row = $result->fetch_assoc()){
            $classId = $row['class_id'];
            echo "<option value='$classId'> Class Name: " . $row['class_name'] . ' Intake Date: ' . $row['date_enrolled'] . "</option>";
        }
        ?>
    </select>
        <br>
        <br>
        <input type="submit" value="Show Students">
    </form>
    </div>
    </section>
</body>
</html>