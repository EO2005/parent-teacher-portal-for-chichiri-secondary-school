<?php
    session_start();
    include('../../../Classes/Notification.php');
    $notification = new Notfication();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teachers | Dashboard</title>
    <link rel="stylesheet" href="../Styles/Style.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="Dashboard">
    <header>
      <img src="../../../Assets/Images/chichiri.png" alt="">
      <h1>Teacher | Dashboard</h1>
      <script src="../../../Libraries/Javascript/sweetalert2.all.min.js"></script>
    </header>
    <nav>
      <button onclick="Swal.fire('User Guide Teacher Dashboard', 'Welcome to the home page \n here on the navigation bar you can click on any link and it will take you to the pages \n this is the dashboard, you will see all anayltics', 'info')"><img src="../../../Assets/Images/info.png" alt=""></button>
      <a href="Dashboard.php"><img src="../../../Assets/Images/Naviagtion/Home.png" alt="">Dashboard</a>
      <a href="Calendar/CalendarView.html"><img src="../../../Assets/Images/Naviagtion/Calendar.png" alt="">Calendar</a>
      <a href="Attendance/TakingAttendance.php"><img src="../../../Assets/Images/Naviagtion/Manage.png" alt="">Attendance</a>
      <a href="Grading/GradeTracking_Classes.php"><img src="../../../Assets/Images/Naviagtion/Grading.png" alt="">Grading</a>
      <a href="Generation/GenerationOfStudentProgress.php"><img src="../../../Assets/Images/Naviagtion/Report.png" alt="">Generation</a>
      <a href="Messaging/message.php"><img src="../../../Assets/Images/Naviagtion/Message.png" alt="">Messaging</a>
      <a href="../Login.html">Logout</a>
    </nav>
    <section>
      <div class="teacher-dashboard">
        <div style="width: 800px;">
            <canvas id="myChart"></canvas>
        </div>

        <div class="list-notification">
        <h1>Notifications</h1>
          <?php
            $notification->RecieveNotification($_SESSION['userId']);
          ?>
        </div>
      </div>
      </div>
    </section>
    </div>
</body>
<script>
  const ctx = document.getElementById('myChart');

  // Use AJAX or another method to retrieve the average grade from your PHP script
  // and assign it to a JavaScript variable.
  const averageGrade = <?php echo getAverageGrade(); ?>;
  const AverageAttendance = <?php echo getAverageAttendance(); ?>

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Grades', 'Attendance'],
      datasets: [{
        label: '# of Votes',
        data: [averageGrade, AverageAttendance], // Assign the averageGrade variable here
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

<?php
function getAverageGrade() {
  $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
  
  // Check for a valid database connection
  if ($conn->connect_error) {
      die("Connection failed: " . $conn->connect_error);
  }

  $sqlGrades = "SELECT grade_value FROM grades";
  $resultGrades = $conn->query($sqlGrades);

  $totalGrades = 0;
  $countGrades = 0;

  if ($resultGrades->num_rows > 0) {
      while ($row = $resultGrades->fetch_assoc()) {
          $totalGrades += $row["grade_value"];
          $countGrades++;
      }
  } else {
      $conn->close();
      return "No result";
  }

  $conn->close();

  if ($countGrades == 0) {
      return "No grades available";
  }

  $averageGrade = ($totalGrades / ($countGrades * 100)) * 100;

  return number_format($averageGrade, 2);
}




function getAverageAttendance() {
  $conn = new mysqli('localhost', 'root', '', 'parent_teacher_portal_chichiri');
  
  $sqlPresent = "SELECT COUNT(status) as count FROM attendance WHERE status = 'Present'";
  $queryPresent = mysqli_query($conn, $sqlPresent);
  
  if ($queryPresent) {
      $rowPresent = $queryPresent->fetch_assoc();
      $countPresent = $rowPresent["count"];
  } 
  else {
      $conn->close();
      echo "Query failed.";
      return 0; // Return 0 in case of a query failure.
  }
  
  $sqlTotal = "SELECT COUNT(DISTINCT datetaken) as date_count FROM attendance";
  $queryTotal = mysqli_query($conn, $sqlTotal);
  
  if ($queryTotal) {
      $rowTotal = $queryTotal->fetch_assoc();
      $countTotal = $rowTotal["date_count"];
      if ($countTotal == 0) {
          $conn->close();
          echo "No attendance data available.";
          return 0;
          
      }
  } else {
      $conn->close();
      echo "Query failed.";
      return 0; // Return 0 in case of a query failure.
  }
  
  $averageAttendance = ($countPresent / $countTotal) * 100;
  $conn->close();
  return $averageAttendance;
 
}
?>
</html>