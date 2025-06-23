<?php
    $class_id = $_POST['class_id'];
    $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
    $sql = "SELECT students.student_id, students.first_name, students.last_name, students.gender, students.date_of_birth FROM students 
        JOIN 
        student_classes ON students.student_id = student_classes.student_id 
        JOIN 
        classes ON student_classes.class_id = classes.class_id 
        WHERE student_classes.class_id = $class_id";
    $result = $conn->query($sql);
    if ($result->num_rows === 0) {
        // No students found, display an alert and go back
        echo '<script>alert("No student data available for the selected class."); window.history.back();</script>';
        exit; // Exit to prevent further execution of the page
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Tracking | List Of Students</title>
    <link rel="stylesheet" href="../../Styles/Style.css">
    <script src="../../../../Libraries/Javascript/sweetalert2.all.min.js"></script>
</head>
<body class="Dashboard">
<header>
      <img src="../../../../Assets/Images/chichiri.png" alt="">
      <h1>Teacher | Attendance</h1>
    </header>
    <nav>
        <button onclick="Swal.fire('User Guide Teacher \n Attendnace Tracking', 'Now you will be presented with a list of students, choose their attedance for the day. \n if the attendance has already been taken, then it will alert them and you back. \n There is the view students where it will take you to the page and see the students overall attenance', 'info')"><img src="../../../../Assets/Images/info.png" alt=""></button>
      <a href="../Dashboard.php"><img src="../../../../Assets/Images/Naviagtion/Home.png" alt="">Dashboard</a>
      <a href="../Calendar/CalendarView.html"><img src="../../../../Assets/Images/Naviagtion/Calendar.png" alt="">Calendar</a>
      <a href="../Attendance/TakingAttendance.php"><img src="../../../../Assets/Images/Naviagtion/Manage.png" alt="">Attendance</a>
      <a href="../Grading/GradeTracking_Classes.php"><img src="../../../../Assets/Images/Naviagtion/Grading.png" alt="">Grading</a>
      <a href="../Generation/GenerationOfStudentProgress.php"><img src="../../../../Assets/Images/Naviagtion/Report.png" alt="">Generation</a>
      <a href="../Messaging/message.php"><img src="../../../../Assets/Images/Naviagtion/Message.png" alt="">Messaging</a>
      <a href="../../Login.html">Logout</a>
    </nav>
    <section class="view_students">
        <main>
        <form action="Process_attendance.php" method="post">
            <h1 style="color:black;">Take Attendnace</h1>
            <table class="content-table">
                <thead>
                <tr>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Date of Birth</th>
                    <th>Attendance</th>
                </tr>
                </thead>
                <?php
                while ($row = $result->fetch_assoc()) {
                    echo '<tbody style="color:black;">';
                    echo '<tr>';
                    echo '<td>' . $row['first_name'] . ' ' . $row['last_name'] . '</td>';
                    echo '<td>' . $row['gender'] . '</td>';
                    echo '<td>' . $row['date_of_birth'] . '</td>';
                    echo '<td>';
                    echo "<select name='status[]'>";
                    echo '<option value="Present">Present</option>';
                    echo '<option value="Absent">Absent</option>';
                    echo '<option value="Sick">Sick</option>';
                    echo '</select>';
                    echo "<input type='text' name='student_id[]' value='" . $row['student_id'] . "' hidden>";
                    echo '</td>';
                    echo '</tr>';
                    echo '</tbody>';
                }
                ?>
            </table>
            <input type="text" name="class_id" value="<?php echo $class_id; ?>" hidden>
            <input type="submit" value="Take Attendance">
            <a href="View_students.php?class_id=<?php echo $class_id?>">View Students</a>
        </form>
        </main>
    </section>
</div>
</body>
</html>
