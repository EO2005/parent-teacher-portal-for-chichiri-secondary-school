<?php
session_start();
$conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');

// Check if class_id is set in the POST request
if (isset($_POST['class_id'])) {
    $class_id = $_POST['class_id'];

    // Prepare the SQL statement with a parameter placeholder
    $sql = "SELECT students.*, student_classes.class_id
            FROM students
            INNER JOIN student_classes ON students.student_id = student_classes.student_id
            INNER JOIN classes ON student_classes.class_id = classes.class_id
            WHERE classes.class_id = ?";

    // Create a prepared statement
    $stmt = $conn->prepare($sql);

    // Bind the class_id parameter
    $stmt->bind_param("s", $class_id);

    // Execute the statement
    $stmt->execute();

    // Get the result
    $result = $stmt->get_result();
    // Close the statement
    $stmt->close();
}

// Close the database connection
$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher | Grade Tracking</title>
    <link rel="stylesheet" href="../../Styles/Style.css">
    <script src="../../../../Libraries/Javascript/sweetalert2.all.min.js"></script>
</head>
<body>
<header>
      <img src="../../../../Assets/Images/chichiri.png" alt="">
      <h1>Teacher | Grade Tracking</h1>
    </header>
    <nav>
        <button onclick="Swal.fire('User Guide Teacher \n Grading', 'This is the grading student Page, select the students that will be graded, so select a student', 'info')"><img src="../../../../Assets/Images/info.png" alt=""></button>
      <a href="../Dashboard.php"><img src="../../../../Assets/Images/Naviagtion/Home.png" alt="">Dashboard</a>
      <a href="../Calendar/CalendarView.html"><img src="../../../../Assets/Images/Naviagtion/Calendar.png" alt="">Calendar</a>
      <a href="../Attendance/TakingAttendance.php"><img src="../../../../Assets/Images/Naviagtion/Manage.png" alt="">Attendance</a>
      <a href="GradeTracking_Classes.php"><img src="../../../../Assets/Images/Naviagtion/Grading.png" alt="">Grading</a>
      <a href="../Generation/GenerationOfStudentProgress.php"><img src="../../../../Assets/Images/Naviagtion/Report.png" alt="">Generation</a>
      <a href="../Messaging/message.php"><img src="../../../../Assets/Images/Naviagtion/Message.png" alt="">Messaging</a>
      <a href="../../Login.html">Logout</a>
    </nav>
    <section>
    <div class="form">
<form action="GradeTracking_TakeGrades.php" method="post">
    <h1>Select Students</h1>
    <br>
    <select name="student_id">
        <?php
        // Reset the result set pointer to the beginning
        $result->data_seek(0);

        while($row = $result->fetch_assoc()){
            $student_id = $row['student_id'];
            echo "<option value='$student_id'> First Name: " . $row['first_name'] . ' Last name: ' . $row['last_name'] . "</option>";
        }
        ?>
    </select>
        <br>
        <input type="submit" value="Grade Them">
    </form>
    </div>
    </section>
</body>
</html>
