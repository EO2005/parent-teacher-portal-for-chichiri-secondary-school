<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Manage Students</title>
    <link rel="stylesheet" href="../../../Styles/Style.css">
    <script src="../../../../Libraries/Javascript/sweetalert2.all.min.js"></script>
</head>
<body class="Dashboard">
    <header>
        <img src="../../../../../Assets/Images/chichiri.png" alt="">
        <h1>Admin | Manage Students</h1>
    </header>
    <nav>
        
        <a href="../../Dashboard.php"><img src="../../../../../Assets/Images/Naviagtion/Home.png" alt="">Dashboard</a>
        <a href="../Manage.php"><img src="../../../../../Assets/Images/Naviagtion/Manage.png" alt="">Manage</a>
        <a href="../../Calendar/calendar.html"><img src="../../../../../Assets/Images/Naviagtion/Calendar.png" alt="">Calendar</a>
        <a href="../../../Login.html">Logout</a>
    </nav>
        <main class="main">
        <div class="center-container">
            <h1>Students</h1>
            <br>
            <a href="addStudent.php" class="btn-success">Add Student</a>
            <a href="../Manage.php" class="btn-success">Back</a>
            <br>
            <table class="content-table">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Date of Birth</th>
                        <th>Gender</th>
                        <th>Address</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php
                    $servername = 'localhost';
                    $username = 'root';
                    $password = '';
                    $database = 'parent_teacher_portal_chichiri';
                
                    $conn = new mysqli($servername, $username, $password, $database);
                
                    if($conn->connect_error){
                        echo 'Error: ' . mysqli_connect_error();
                    }

                    $sql = 'select * from students';
                    $result = $conn->query($sql);

                    if(!$result){
                        die("Invalid Query: " . $conn->error);
                    }
                    while($row = $result->fetch_assoc()){
                        echo "
                            <tr>
                                <td>$row[student_id]</td>
                                <td>$row[first_name]</td>
                                <td>$row[last_name]</td>
                                <td>$row[date_of_birth]</td>
                                <td>$row[gender]</td>
                                <td>$row[address]</td>
                                <td>
                                    <a href='editStudents.php?student_id=$row[student_id]' class='btn-success'>Edit</a>
                                    <a href='deleteStudents.php?student_id=$row[student_id]' class='btn-danger'>Delete</a>
                                </td>
                            </tr>
                        ";
                    }
                ?>
                </tbody>
            </table>
        </div>
    </main>
    </div>
    </body>
</html>
