<?php
$conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');

$sqlPresent = "SELECT COUNT(status) as count FROM attendance WHERE status = 'present' AND student_id = 'P00298012'";
$queryPresent = mysqli_query($conn, $sqlPresent);

if ($queryPresent) {
    $rowPresent = $queryPresent->fetch_assoc();
    $countPresent = $rowPresent["count"];

    // Display the count for 'present' statuses
    echo "The count of 'present' statuses for student P00298012 is: " . $countPresent;
} else {
    echo "Query failed.";
}

$sqlTotal = "SELECT COUNT(DISTINCT datetaken) as date_count FROM attendance WHERE student_id = 'P00298012'";
$queryTotal = mysqli_query($conn, $sqlTotal);

if ($queryTotal) {
    $rowTotal = $queryTotal->fetch_assoc();
    $countTotal = $rowTotal["date_count"];

    // Display the total count of distinct dates
    echo "The total count of distinct dates for student P00298012 is: " . $countTotal;
} else {
    echo "Query failed.";
}
$averagegrade = ($countPresent/$countTotal) * 100;
echo "<br>" . number_format($averagegrade) . "%";

$sqlGrades = "SELECT SUM(grade_value) AS grades FROM grades WHERE student_id = 'P00298012'";
$queryGrades = mysqli_query($conn, $sqlGrades);

if ($queryGrades) {
    $rowTotal = $queryGrades->fetch_assoc();
    $countTotal = $rowTotal["grades"];
    echo $countTotal;
} else {
    echo "No result";
}

$sqlAverageGrade = "SELECT COUNT(grade_value) AS grades FROM grades WHERE student_id = 'P00298012'";
$queryTotalGrade = mysqli_query($conn, $sqlAverageGrade);

if ($queryTotalGrade) {
    $rowAverage = $queryTotalGrade->fetch_assoc();
    $countGrades = $rowAverage["grades"];
    echo "<br>". $countGrades;
} else {
    echo "No result";
}
$TotalMark = $countGrades * 100;
echo "<br> '$TotalMark'";
$averageGrade = ($countTotal/ $TotalMark) * 100;
echo "<br>Your mark is " . number_format($averageGrade) . "%";
$conn->close();
?>