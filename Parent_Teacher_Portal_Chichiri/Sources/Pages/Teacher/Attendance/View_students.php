<?php
    function getAverageAttendcane($student_id){
        $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
    
        $sqlPresent = "SELECT COUNT(status) as count FROM attendance WHERE status = 'present' AND student_id = '$student_id'";
        $queryPresent = mysqli_query($conn, $sqlPresent);
    
        if ($queryPresent) {
            $rowPresent = $queryPresent->fetch_assoc();
            $countPresent = $rowPresent["count"];
        } else {
            echo "Query failed.";
            return 0; // Return 0 in case of a query failure.
        }
        
        $sqlTotal = "SELECT COUNT(DISTINCT datetaken) as date_count FROM attendance WHERE student_id = '$student_id'";
        $queryTotal = mysqli_query($conn, $sqlTotal);
    
        if ($queryTotal) {
            $rowTotal = $queryTotal->fetch_assoc();
            $countTotal = $rowTotal["date_count"];
            if ($countTotal == 0) {
                echo "No attendance data available.";
                return 0;
            }
        } else {
            echo "Query failed.";
            return 0; // Return 0 in case of a query failure.
        }
        $averageAttendance = ($countPresent / $countTotal) * 100;
        $conn->close();
        return number_format($averageAttendance, 0) . "%";
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher | Attendace | View Student</title>
    <link rel="stylesheet" href="../../Styles/Style.css">
    <script src="../../../../Libraries/Javascript/sweetalert2.all.min.js"></script>
</head>
<body class="Dashboard">
    <header>
      <img src="../../../../Assets/Images/chichiri.png" alt="">
      <h1>Teacher | Attendance</h1>
    </header>
    <nav>
      <button onclick="Swal.fire('User Guide Teacher \n Attendnace Tracking', 'This page shows the overall attendance for students in a class. \n select a start date and an end date to generate a report by clicking on filter')"><img src="../../../../Assets/Images/info.png" alt=""></button>
      <a href="../Dashboard.php"><img src="../../../../Assets/Images/Naviagtion/Home.png" alt="">Dashboard</a>
      <a href=""><img src="../../../../Assets/Images/Naviagtion/Calendar.png" alt="">Calendar</a>
      <a href="TakingAttendance.php"><img src="../../../../Assets/Images/Naviagtion/Manage.png" alt="">Attendance</a>
      <a href="../Grading/GradeTracking_Classes.php"><img src="../../../../Assets/Images/Naviagtion/Grading.png" alt="">Grading</a>
      <a href="../Generation/GenerationOfStudentProgress.php"><img src="../../../../Assets/Images/Naviagtion/Report.png" alt="">Generation</a>
      <a href="../Messaging/message.php"><img src="../../../../Assets/Images/Naviagtion/Message.png" alt="">Messaging</a>
      <a href="">Logout</a>
    </nav>
    <section>
        <main>
<table class="content-table">
        <thead>
            <tr>
                <th>Student ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>Date Of Birth</th>
                <th>Attendace</th>
            </tr>
        </thead>
        <tbody Style="color:black;">
           <tr>
          
           <?php
                    $servername = 'localhost';
                    $username = 'root';
                    $password = '';
                    $database = 'parent_teacher_portal_chichiri';
                
                    $conn = new mysqli($servername, $username, $password, $database);
                
                    if($conn->connect_error){
                        echo 'Error: ' . mysqli_connect_error();
                    }

                    $sql = "select students.student_id, students.first_name, students.last_name, students.gender, students.date_of_birth from students 
                    join 
                    student_classes on students.student_id = student_classes.student_id 
                    join 
                    classes on student_classes.class_id = classes.class_id where student_classes.class_id = $_GET[class_id]";
                    $result = $conn->query($sql);

                 
                    if (!$result) {
                        die("Invalid Query: " . $conn->error);
                    }

                    if ($result->num_rows === 0) {
                        // No students found in the class, display an alert
                        echo '<script>alert("No students found in the class."); window.history.back();</script>';
                        echo '<a href="previous_page.php">Go back</a>';
                    } else {
                        // Display the table if students are found
                        while ($row = $result->fetch_assoc()) {
                            echo "
                                <tr>
                                    <td>$row[student_id]</td>
                                    <td>$row[first_name]</td>
                                    <td>$row[last_name]</td>
                                    <td>$row[gender]</td>
                                    <td>$row[date_of_birth]</td>
                                    <td>
                                        " . getAverageAttendcane($row['student_id']) . "
                                    </td>
                                </tr>
                            ";
                        }
                    }
                    ?>
           </tr> 
        </tbody>
    </table>
    <form action="Process_View_Attendance.php?class_id=<?php echo $_GET['class_id']?>" method="post" style="color:black;">
        
        <label for="start_date">Start Date:</label>
        <input type="date" name="start_date" id="start_date">

        <label for="end_date">End Date:</label>
        <input type="date" name="end_date" id="end_date">

        <input type="submit" value="Filter">
    </form>
    </main>
    </section>
</body>
</html>