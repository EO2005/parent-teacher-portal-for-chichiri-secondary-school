<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Dashboard</title>
    <link rel="stylesheet" href="../Styles/Style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="../../../Libraries/Javascript/sweetalert2.all.min.js"></script>
</head>
<body class="Dashboard">
    <header>
        <img src="../../../Assets/Images/chichiri.png" alt="">
        <h1>Admin | Dashboard</h1>
    </header>
        <nav>
        <button onclick="Swal.fire('User Guide Admin Dashboard', 'Welcome to the home page \n here on the navigation bar you can click on any link and it will take you to the pages \n this is the dashboard, you will see all anayltics', 'info')"><img src="../../../Assets/Images/info.png" alt=""></button>
        <a href="#"><img src="../../../Assets/Images/Naviagtion/Home.png" alt="">Dashboard</a>
        <a href="Manage/Manage.php"><img src="../../../Assets/Images/Naviagtion/Manage.png" alt="">Manage</a>
        <a href="Calendar/calendar.html"><img src="../../../Assets/Images/Naviagtion/Calendar.png" alt="">Calendar</a>
        <a href="../Login.html">Logout</a>
        </nav>
    <section class="section-dash">
        <div class="card-container">
            <div class="cards">
                <p>Classes</p>
                <img src="../../../Assets/Images/Class.png" alt="">
                <p>
                <?php
                    $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
                    $sqlClasses = "select count(*) as countclasses from classes";
                    $result = $conn->query($sqlClasses);
                    if($result->num_rows > 0){
                        $row = $result->fetch_assoc();
                        $count = $row['countclasses'];
                        echo $count;
                    }
                    else{
                        echo "No Classes Found";
                    }
                    $conn->close();
                ?>
                </p>
            </div>
            <div class="cards">
                <p>Students</p>
                <img src="../../../Assets/Images/Children.png" alt="">
                <p>
                <?php
                    $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
                    $sqlStudents = "select count(*) as countStudents from Students";
                    $result = $conn->query($sqlStudents);
                    if($result->num_rows > 0){
                        $row = $result->fetch_assoc();
                        $count = $row['countStudents'];
                        echo $count;
                    }
                    else{
                        echo "No Students Found";
                    }
                    $conn->close();
                ?>
                </p>
            </div>
            <div class="cards">
                <p>Teachers</p>
                <img src="../../../Assets/Images/Teacher.png" alt="">
                <p>
                <?php
                    $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
                    $sqlTeachers = "select count(*) as countTeachers from Teachers";
                    $result = $conn->query($sqlTeachers);
                    if($result->num_rows > 0){
                        $row = $result->fetch_assoc();
                        $count = $row['countTeachers'];
                        echo $count;
                    }
                    else{
                        echo "No Teachers Found";
                    }
                    $conn->close();
                ?>
                </p>
            </div>
            <div class="cards">
                <p>Parents</p>
                <img src="../../../Assets/Images/Person.png" alt="">
                <p>
                    <?php
                    $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
                    $sqlParents = "select count(*) as countParents from Parents";
                    $result = $conn->query($sqlParents);
                    if($result->num_rows > 0){
                        $row = $result->fetch_assoc();
                        $count = $row['countParents'];
                        echo $count;
                    }
                    else{
                        echo "No Parents Found";
                    }
                    $conn->close();
                ?>
                </p>
            </div>
        </div>
        <div style="width: 550px">
  <canvas id="myChart"></canvas>
</div>
    </section>
    </div>
</body>
<script>
   const ctx = document.getElementById('myChart');
   
   const labels = ['Classes', 'Students', 'Teachers', 'Parents' ];
new Chart(ctx, {
  type: 'bar',
  data: {
    labels: ['Classes', 'Students', 'Teachers', 'Parents' ],
    datasets: [{
      label: 'Data Set',
      data: [  <?php
                    $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
                    $sqlClasses = "select count(*) as countclasses from classes";
                    $result = $conn->query($sqlClasses);
                    if($result->num_rows > 0){
                        $row = $result->fetch_assoc();
                        $count = $row['countclasses'];
                        echo $count;
                    }
                    else{
                        echo "No Classes Found";
                    }
                    $conn->close();
                ?>, <?php
                    $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
                    $sqlStudents = "select count(*) as countStudents from Students";
                    $result = $conn->query($sqlStudents);
                    if($result->num_rows > 0){
                        $row = $result->fetch_assoc();
                        $count = $row['countStudents'];
                        echo $count;
                    }
                    else{
                        echo "No Students Found";
                    }
                    $conn->close();
                ?>, <?php
                    $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
                    $sqlTeachers = "select count(*) as countTeachers from Teachers";
                    $result = $conn->query($sqlTeachers);
                    if($result->num_rows > 0){
                        $row = $result->fetch_assoc();
                        $count = $row['countTeachers'];
                        echo $count;
                    }
                    else{
                        echo "No Teachers Found";
                    }
                    $conn->close();
                ?>, <?php
                    $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
                    $sqlParents = "select count(*) as countParents from Parents";
                    $result = $conn->query($sqlParents);
                    if($result->num_rows > 0){
                        $row = $result->fetch_assoc();
                        $count = $row['countParents'];
                        echo $count;
                    }
                    else{
                        echo "No Parents Found";
                    }
                    $conn->close();
                ?>],
      borderWidth: 1
    }]
  },
  options: {
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});
</script>
</html>