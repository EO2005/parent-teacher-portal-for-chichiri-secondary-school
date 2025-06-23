<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Manage Subjects</title>
    <link rel="stylesheet" href="../../../Styles/Style.css">
    <script src="../../../Libraries/Javascript/sweetalert2.all.min.js"></script>
</head>
<body class="Dashboard">
    <header>
        <img src="../../../../../Assets/Images/chichiri.png" alt="">
        <h1>Admin | Manage Subjects</h1>
    </header>
    <nav>
        <a href="../../Dashboard.php"><img src="../../../../../Assets/Images/Naviagtion/Home.png" alt="">Dashboard</a>
        <a href="../Manage.php"><img src="../../../../../Assets/Images/Naviagtion/Manage.png" alt="">Manage</a>
        <a href="../"><img src="../../../../../Assets/Images/Naviagtion/Calendar.png" alt="">Calendar</a>
        <a href="../../../Login.html">Logout</a>
    </nav>
        <main class="main">
            <div class="center-container">
                <h1>Subjects</h1>
                <br>
                <a href="addSubject.html" class="btn-success">Add Subject</a>
                <a href="../Manage.php" class="btn-success">Back</a>
                <br>
                <table class="content-table">
                    <thead>
                        <tr>
                            <th>Subject Name</th>
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

                        $sql = 'select * from subjects';
                        $result = $conn->query($sql);

                        if(!$result){
                            die("Invalid Query: " . $conn->error);
                        }
                        while($row = $result->fetch_assoc()){
                            echo "
                                <tr>
                                    <td>$row[subject_name]</td>
                                    <td>
                                        <a href='deleteSubject.php?subject_id=$row[subject_id]' class='btn-danger'>Delete</a>
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
