<?php
    $student_id = $_GET['student_id'];
    echo $student_id;
    include('../../../../Classes/Students.php');
    $school = new Students();
    $student_name = $school->getName($student_id);
    $student_grade = $school->getAverageGrade($student_id);
    $student_attendacne = $school->getAverageAttendcane($student_id);

    $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
    $sqlGrades = "SELECT subjects.subject_name, (SUM(grades.grade_value) / COUNT(grades.subject_id)) AS total_grades FROM students JOIN grades ON students.student_id = grades.student_id JOIN subjects ON grades.subject_id = subjects.subject_id WHERE students.student_id='$student_id' GROUP BY students.student_id, subjects.subject_name";
    $result = $conn->query($sqlGrades);
    function checkGrade($Grade){
        if($Grade >= 90){
            $Grade = 'A+';
        }
        else if($Grade >= 80){
            $Grade = 'A';
        }
        else if($Grade >= 70){
            $Grade = 'B';
        }
        else if($Grade >=60){
            $Grade = 'C';
        }
        else if($Grade >=50){
            $Grade = 'D';
        }
        else if($Grade >=0){
            $Grade = 'F';
        }
        else{
            $Grade = 'No Result';
        }
        return $Grade;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent | Student Progress</title>
    <link rel="stylesheet" href="../../Styles/StyleMobile.css">
    <script src="../../../../Libraries/Javascript/sweetalert2.all.min.js"></script>
</head>
<body class="Mobileview">
    <header>
        <a href=""></a>
        <h3>Student Progress For <?php echo $student_name?></</h3>
    </header>
        <div class="mobilebody">
            <h1>Student Name: <?php echo $student_name?></h1>
            <br>
            <br>
            <p>Overall Grade: <?php echo $student_grade?></p>
            <br>
            <p>Overall Attendance: <?php echo $student_attendacne?></p>
            <br>
            <div class="content-table">
            <table>
                <thead>
                    <tr>
                        <th>Subject</th>
                        <th>Grade</th>
                    </tr>
                </thead>
                <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "
                        <tr>
                            <td>$row[subject_name]</td>
                            <td>".checkgrade($row['total_grades'])."</td>
                        </tr>
                    ";
                }
            }
            ?>
            </tbody>
            </table>
            <br>   
        </div>
        </div>
    <nav class="nav">
        <a href="../Calendar/calendarView.php"><img src="../../../../Assets/Images/Naviagtion/Calendar.png" alt="">Calendar</a>
        <a href="../Messaging/Messages.php"><img src="../../../../Assets/Images/Naviagtion/Message.png" alt="">Messaging</a>
        <a href="../Dashboard.php"><img src="../../../../Assets/Images/Naviagtion/Home.png" alt="">Home</a>
        <button onclick="Swal.fire('Parent \n View Students', 'This screen will show you your childs current progress and their attendance')"><img src="../../../../Assets/Images/info.png" alt=""></button>
    </nav>
</body>
</html>