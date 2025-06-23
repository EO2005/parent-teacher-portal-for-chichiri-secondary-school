<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Manage Classes</title>
    <link rel="stylesheet" href="../../../Styles/Style.css">
    <script src="../../../Libraries/Javascript/sweetalert2.all.min.js"></script>
</head>
<body class="Dashboard">
    <header>
        <img src="../../../../../Assets/Images/chichiri.png" alt="">
        <h1>Admin | Manage Classes</h1>
    </header>
    <nav>
        <a href="../../Dashboard.php"><img src="../../../../../Assets/Images/Naviagtion/Home.png" alt="">Dashboard</a>
        <a href="../Manage.php"><img src="../../../../../Assets/Images/Naviagtion/Manage.png" alt="">Manage</a>
        <a href="../../Calendar/calendar.html"><img src="../../../../../Assets/Images/Naviagtion/Calendar.png" alt="">Calendar</a>
        <a href="../../../Login.html">Logout</a>
    </nav>
    <main class="main">
        <div class="center-container">
        <h1>Classes</h1>
        <br>
        <a href="addClass.html" class="btn-success">Add Class</a>
        <a href="../Manage.php" class="btn-success">Back</a>
        <br>
                    
        <table class="content-table">
            <thead>
                <tr>
                    <th>Class Name</th>
                    <th>Intake Date</th>
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

                    $sql = 'select * from classes';
                    $result = $conn->query($sql);

                    if(!$result){
                        die("Invalid Query: " . $conn->error);
                    }
                    while($row = $result->fetch_assoc()){
                        echo "
                            <tr>
                            <td>$row[class_name]</td>
                            <td>$row[date_enrolled]</td>
                            <td>
                                <a href='deleteclass.php?class_id=$row[class_id]' class='btn-danger'>Delete</a>
                            </td>
                            </tr>
                        ";
                    }
                ?>
            </tbody>
        </table>
    </div>
    </main>
</body>
</html>