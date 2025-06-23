<?php
    function getParentsOptions() {
        // Create a database connection
        $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
        
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $selectStudents = "SELECT parent_id, first_name, last_name FROM parents";
        $result = mysqli_query($conn, $selectStudents);
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['parent_id'] . "'>" . $row['first_name'] . ' ' . $row['last_name'] . "</option>";
            }
        } else {
            echo "<option value='-1'>No Parents found</option>";
        }

        $conn->close();
    }
    function getClassesOption() {
        // Create a database connection
        $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
        
        // Check if the connection was successful
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        
        // SQL SELECT statement to retrieve student information
        $selectStudents = "SELECT class_id, class_name FROM classes";
        $result = mysqli_query($conn, $selectStudents);
        
        if ($result) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<option value='" . $row['class_id'] . "'>" . $row['class_name'] . "</option>";
            }
        } else {
            echo "<option value='-1'>No Parents found</option>";
        }

        $conn->close();
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Add Student</title>
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
    <div class="form">
        <h1>Add Student</h1>
        <br>
        <form action="AddStudents.php" method="post">
            <label for="StudentID">Student ID</label>
            <input type="text" name="student_id" id="" placeholder="Student ID" required>
            <br>
            <label for="First_name">First Name</label>
            <input type="text" name="first_name" id="" placeholder="First Name" required>
            <br>
            <label for="Last_name">Last name</label>
            <input type="text" name="last_name" id="" placeholder="Last Name" required>
            <br>
            <label for="DOB">Date Of Birth</label>
            <input type="date" name="date_of_birth" id="" placeholder="Date of Birth" required>
            <br>
            <label for="gender">Gender</label>
            <select name="gender" id="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
            <br>
            <label for="Address">Address</label>
            <input type="text" name="address" id="" placeholder="Address" required>
            <br>
            <label for="Parent">Parent</label>
            <select name="parent_id">
            <?php
             getParentsOptions();
            ?>
            </select>
            <br>
            <div>
            <label for="Class">Class</label>
            <select name="class_id">
            <?php
             getClassesOption();
            ?>
            </select>
            <br>
            <br>
            <a href="viewStudents.php" class="btn-success">Back</a>
            <br>
            <br>
            <input type="submit" value="Add Student">
        </form>
    </div>
</body>
</html>
