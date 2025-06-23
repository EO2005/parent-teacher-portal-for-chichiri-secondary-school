<?php
    $servername = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'parent_teacher_portal_chichiri';

    $conn = new mysqli($servername, $username, $password, $database);

    $studentSQL = 'select * from students';
    $resultsStudents = $conn->query($studentSQL);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher | Progress Report</title>
    <link rel="stylesheet" href="../../Styles/Style.css">
    <script src="../../../../Libraries/Javascript/sweetalert2.all.min.js"></script>
</head>
<body>
<header>
      <img src="../../../../Assets/Images/chichiri.png" alt="">
      <h1>Teacher | Progress Generation</h1>
    </header>
    <nav>
        <button onclick="Swal.fire('User Guide Teacher \n PDF Generation','This is the PDF Student Progress Generation Page, this will enable you to select a student and then submit it to generate a pdf', 'info')"><img src="../../../../Assets/Images/info.png" alt=""></button>
    <a href="../Dashboard.php"><img src="../../../../Assets/Images/Naviagtion/Home.png" alt="">Dashboard</a>
      <a href="../Calendar/CalendarView.html"><img src="../../../../Assets/Images/Naviagtion/Calendar.png" alt="">Calendar</a>
      <a href="../Attendance/TakingAttendance.php"><img src="../../../../Assets/Images/Naviagtion/Manage.png" alt="">Attendance</a>
      <a href="../Grading/GradeTracking_Classes.php"><img src="../../../../Assets/Images/Naviagtion/Grading.png" alt="">Grading</a>
      <a href="../Generation/GenerationOfStudentProgress.php"><img src="../../../../Assets/Images/Naviagtion/Report.png" alt="">Generation</a>
      <a href="../Messaging/message.php"><img src="../../../../Assets/Images/Naviagtion/Message.png" alt="">Messaging</a>
      <a href="../../Login.html">Logout</a>
    </nav>
 <section>
    <form action="Generate_Student_Progress.php" method="Post" style="text-align: center
    ;">
        <h1>Generate Student Progress Report</h1>
    <select name="student_id">
                <?php
                    while($students = $resultsStudents->fetch_assoc()){
                        echo "<option value='". $students['student_id'] ."'>". $students['first_name']  . " ". $students['last_name']. "</option>";
                    }
                ?>
            </select>
            <br>
            <input type="submit" value="Generate Report">
    </form>
    </section>
</body>
</html>