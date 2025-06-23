<?php
include('../../../../Classes/Notification.php'); // Corrected typo in the class name
$conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
$notification = new Notfication(); // Corrected typo in the variable name

// Get the current date and time
date_default_timezone_set('Africa/Blantyre');
$date = date("y.m.d");
$time = date("H:i:s");

// Assuming $_POST['student_id'] and $_POST['status'] are arrays
if (isset($_POST['student_id']) && is_array($_POST['student_id']) &&
    isset($_POST['status']) && is_array($_POST['status'])) {

    $student_ids = $_POST['student_id'];
    $statuses = $_POST['status'];
    $class_id = $_POST['class_id'];

    // Check if attendance has already been taken for this class and date
    $sql_check = "SELECT COUNT(*) as count FROM attendance WHERE class_id = '$class_id' AND DateTaken = '$date'";
    $result_check = $conn->query($sql_check);
    $row_check = $result_check->fetch_assoc();
    $attendance_taken = $row_check['count'] > 0;

    if ($attendance_taken) {
        // Attendance has already been taken, display an alert for each student
        echo '<script>alert("Attendance for this class on ' . $date . ' has already been taken.");window.history.back();</script>';
    } else {
        // Loop through the arrays and perform validation first
        for ($i = 0; $i < count($student_ids); $i++) {
            $student_id = $student_ids[$i];
            $status = $statuses[$i];

            // Fetch the parent IDs associated with this student
            $sql_parent_ids = "SELECT parent_id FROM student_parents WHERE student_id = '$student_id'";
            $result_parent_ids = $conn->query($sql_parent_ids);
            
            while ($row_parent_id = $result_parent_ids->fetch_assoc()) {
                $parent_id = $row_parent_id['parent_id'];

                // Insert attendance record for this student
                $sql = "INSERT INTO attendance (student_id, DateTaken, status, class_id) VALUES ('$student_id', '$date', '$status', '$class_id')";
                $result = $conn->query($sql);

                if (!$result) {
                    echo '<script>alert("Error: ' . $conn->error . '");window.history.back();</script>';
                } else {
                    // Call the function to send notifications based on attendance status
                    $notification->SendNotificationAttendance($parent_id, "Attendance Marked", "attendance status is '$status'", $date, $time, $status);
                }
            }
        }
        echo '<script>alert("Attendance recorded successfully."); window.history.back();</script>';
    }
    
    // Close the database connection
    $conn->close();
}
?>
