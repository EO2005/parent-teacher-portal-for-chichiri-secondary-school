<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "parent_teacher_portal_chichiri";

    $connection = new mysqli($servername, $username, $password, $database);

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        if (!isset($_GET["student_id"])) {
            header('location: manageclass.php');
            exit;
        }
    
        $student_id = $_GET['student_id'];
        $sql = "SELECT * FROM students WHERE student_id = '$student_id'";
        $result = $connection->query($sql);
    
        // Check if the query was successful and if any rows were fetched
        if (!$result || $result->num_rows == 0) {
            header('location: manageSubject.php');
            exit;
        }
    
        // Fetch the student's information
        $row = $result->fetch_assoc();
        $student_id = $row['student_id'];
        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $address = $row['address'];
    }
    else {
        $student_id = $_POST['student_id'];
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $address = $_POST['address'];
        
        // Validate input and perform the update
        if (empty($student_id) || empty($first_name) || empty($last_name) || empty($address)) {
            $errorMessage = "All the fields are required";
        } else {
            // Use prepared statement to prevent SQL injection
            $stmt = $connection->prepare("UPDATE students SET first_name=?, last_name=?, address=? WHERE student_id=?");
            if (!$stmt) {
                $errorMessage = "Prepare failed: " . $connection->error;
            } else {
                $stmt->bind_param("sssi", $first_name, $last_name, $address, $student_id);

                if ($stmt->execute()) {
                    $successMessage = "Student Updated Successfully";
                } else {
                    $errorMessage = "Update failed: " . $stmt->error;
                }
                $stmt->close();
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Edit Students</title>
    <link rel="stylesheet" href="../../../Styles/Style.css">
    <script src="../../../Libraries/Javascript/sweetalert2.all.min.js"></script>
</head>
<body class="Dashboard">
        <header>
            <img src="../../../../../Assets/Images/chichiri.png" alt="">
            <h1>Admin | Manage Students</h1>
        </header>
        <nav>
            <a href="../../Dashboard.php"><img src="../../../../../Assets/Images/Naviagtion/Home.png" alt="">Dashboard</a>
            <a href="../Manage.php"><img src="../../../../../Assets/Images/Naviagtion/Manage.png" alt="">Manage</a>
            <a href="../"><img src="../../../../../Assets/Images/Naviagtion/Calendar.png" alt="">Calendar</a>
            <a href="../../../Login.html">Logout</a>
        </nav>
        <main class="form">
            <form action="" method="post">
                <h1>Edit Students</h1>
                <br>
                <input type="text" name="student_id" value="<?php echo $student_id;?>" placeholder="Student ID" required>
                <br>
                <input type="text" name="first_name" value="<?php echo $first_name;?>" placeholder="First Name" required>
                <br>
                <input type="text" name="last_name" value="<?php echo $last_name;?>" placeholder="Last Name" required>
                <br>
                <input type="text" name="address" value="<?php echo $address;?>" placeholder="Address" required>
                <br>
                <input type="submit" value="Edit Student">
                <a href="viewStudents.php">Back</a>
            </form>
        </main>
    </div>
</body>
</html>
