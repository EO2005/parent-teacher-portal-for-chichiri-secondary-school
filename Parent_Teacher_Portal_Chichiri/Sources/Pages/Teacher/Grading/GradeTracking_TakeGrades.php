<?php
    session_start();
    $student_id = $_POST['student_id'];

    $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
    
    // Check for a database connection error
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $sql = "select students.* 
    from 
    students inner join student_classes on students.student_id = student_classes.student_id 
    inner join 
    classes on student_classes.class_id = classes.class_id 
    where 
    students.student_id = '$student_id'";

    $studentResult = $conn->query($sql);

    // Check if the query execution was successful
    if ($studentResult === false) {
        die("Query failed: " . $conn->error);
    }

    if ($studentResult->num_rows > 0) {
        $student = $studentResult->fetch_assoc();

        $subjectSQL = "select * from subjects";
        $subjectResult = $conn->query($subjectSQL);

        // Check if the query execution was successful
        if ($subjectResult === false) {
            die("Query failed: " . $conn->error);
        }

        $conn->close();
    } else {
        echo '<script>alert("No Student Data, Please Select The Correct Student.");</script>';
        echo '<script>window.history.back();</script>';
        unset($_POST['student_id']);
        header("Location:GradeTracking_Classes.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers | Grade Tracking</title>
    <link rel="stylesheet" href="../../Styles/Style.css">
    <script src="../../../../Libraries/Javascript/sweetalert2.all.min.js"></script>
</head>
<body>
    <header>
      <img src="../../../../Assets/Images/chichiri.png" alt="">
      <h1>Teacher | Grade Tracking</h1>
    </header>
    <nav>
    <button onclick="Swal.fire('User Guide Teacher \n Grading', 'This is the grading student grading Page, Enter their details and enter grade', 'info')"><img src="../../../../Assets/Images/info.png" alt=""></button>
      <a href="../Dashboard.php"><img src="../../../../Assets/Images/Naviagtion/Home.png" alt="">Dashboard</a>
      <a href="../Calendar/CalendarView.html"><img src="../../../../Assets/Images/Naviagtion/Calendar.png" alt="">Calendar</a>
      <a href="../Attendance/TakingAttendance.php"><img src="../../../../Assets/Images/Naviagtion/Manage.png" alt="">Attendance</a>
      <a href="../Grading/GradeTracking_Classes.php"><img src="../../../../Assets/Images/Naviagtion/Grading.png" alt="">Grading</a>
      <a href="../Generation/GenerationOfStudentProgress.php"><img src="../../../../Assets/Images/Naviagtion/Report.png" alt="">Generation</a>
      <a href="../Messaging/message.php"><img src="../../../../Assets/Images/Naviagtion/Message.png" alt="">Messaging</a>
      <a href="">Logout</a>
    </nav>
    <div class="form">
    <form action="GradeTracking_Process.php" method="post" class="grading">
    <h1>Marking Grades for <?php echo $student['first_name'] . " " . $student['last_name']?></h1>
    <br>
    <h2>Enter Their Grades</h2>
        <input type="hidden" name="student_id" value="<?php echo $student['student_id']?>">
        <br>
        <label for="subject">Select Subject: </label>
        <select name="subject">
            <?php
                while($row = $subjectResult->fetch_assoc()){
                    echo "<option value=".$row['subject_id'].">".$row['subject_name']."</option>";
                }
            ?>
        </select>
        <br>
        <br>
        <label for="assignement">Test Type:</label>
        <select name="assignment_type" id="">
            <option value="Weekly-Test">Weekly Test</option>
            <option value="Assignment">Assignment</option>
            <option value="Homework">Homework</option>
        </select>
        <br>
        <br>
        <input type="text" name="comment" placeholder="Comment">
        <br>
        <br>
        <label for="Grade">Enter Grade: </label>
        <input type="number" name="grade" id="gradeInput">
        <p>Calculated Grade: <span id="gradeDisplay"></span></p>
        <br>
        <br>
        <input type="submit" value="Enter Grades">
    </form>
    </div>
    <script src="../../../../Script/Grading.js"></script>
</body>
</html>