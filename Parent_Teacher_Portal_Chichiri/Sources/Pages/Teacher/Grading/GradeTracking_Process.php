<?php
    $student_id = $_POST['student_id'];
    $subject_id = $_POST['subject'];
    $test_type = $_POST['assignment_type'];
    $comment = $_POST['comment'];
    $grade = $_POST['grade'];

    $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
    $sql = "
    insert into grades(student_id, subject_id, grade_value, type_of_assessment, comments) 
    values('$student_id', $subject_id, $grade, '$test_type', '$comment')";
    $result = $conn->query($sql);
    if($result == true){
        echo '<script>alert("Students Grades Added Successfully");</script>';
        echo '<script>window.location.href = "GradeTracking_Classes.php";</script>';
    }
    else{
        echo $conn->error;
    }
?>

