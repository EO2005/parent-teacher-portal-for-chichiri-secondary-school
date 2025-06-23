<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin | Manage</title>
    <link rel="stylesheet" href="../../Styles/Style.css">
    <script src="../../../../Libraries/Javascript/sweetalert2.all.min.js"></script>
</head>
<bodyclass="Dashboard">
    <header>
        <img src="../../../../Assets/Images/chichiri.png" alt="">
        <h1>Admin | Manage</h1>
    </header> 
    <nav>
    <button onclick="Swal.fire('User Guide Admin \n Manage', 'Welcome to the home page \n Here on this page, you can manage parents, teachers, classes, subjects and students, click on manage', 'info')"><img src="../../../../Assets/Images/info.png" alt=""></button>
        <a href="../Dashboard.php"><img src="../../../../Assets/Images/Naviagtion/Home.png" alt="">Dashboard</a>
        <a href="#"><img src="../../../../Assets/Images/Naviagtion/Manage.png" alt="">Manage</a>
        <a href="../Calendar/calendar.html"><img src="../../../../Assets/Images/Naviagtion/Calendar.png" alt="">Calendar</a>
        <a href="../../Login.html">Logout</a>
    </nav>
    <section class="manage-section">
        <h1 class="Manage-Heading">Manage</h1>
        <div class="manage-cards-container">
            <div class="manage-cards">
                <h1>Parents</h1>
                <a href="Parents/viewParents.php">Manage Parents</a>
            </div>
            <div class="manage-cards">
                <h1>Students</h1>
                <a href="Students/ViewStudents.php">Manage Students</a>
            </div>
            <div class="manage-cards">
                <h1>Subjects</h1>
                <a href="Subjects/viewSubject.php">Manage Subjects</a>
            </div>
            <div class="manage-cards">
                <h1>Teachers</h1>
                <a href="Teachers/viewTeachers.php">Manage Teachers</a>
            </div>
            <div class="manage-cards">
                <h1>Classes</h1>
                <a href="Classes/viewClasses.php ">Manage Classes</a>
            </div>
        </div>
    </section>
</body>
</html>