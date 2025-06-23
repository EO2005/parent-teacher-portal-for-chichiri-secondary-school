<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Parent | Calendar View</title>
    <script src='../../../../Libraries/Javascript/fullcalendar-6.1.9/dist/index.global.min.js'></script>
    <script src="../../../../Libraries/Javascript/sweetalert2.all.min.js"></script>
    <link rel="stylesheet" href="../../Styles/StyleMobile.css">
    <script>
document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 500,
            events: 'fetchEvents.php',
            eventDisplay: 'block',

            eventClick: function(info){
            info.jsEvent.preventDefault();
            info.el.style.borderColor = "green";

            Swal.fire({
                title: info.event.title,
                icon: 'info',
                html: '<p>'+ info.event.extendedProps.description +'</p>'
            });
            }
        });
            calendar.render();
        });
    </script>
</head>
<body class="Mobileview">
  <header>
    <h3>Calendar Events</h3>
  </header>
    <div class="mobilebody">
        <div id='calendar'>
        
        </div>
    </div>
    <br>
    <nav class="nav">
        <a href="#"><img src="../../../../Assets/Images/Naviagtion/Calendar.png" alt="">Calendar</a>
        <a href="../Messaging/Messages.php"><img src="../../../../Assets/Images/Naviagtion/Message.png" alt="">Messaging</a>
        <a href="../Dashboard.php"><img src="../../../../Assets/Images/Naviagtion/Home.png" alt="">Home</a>
        <button onclick="Swal.fire('Parent \n Calendar', 'This is the calendar view, click on a date that has an event and you will be able to see it in full detail')"><img src="../../../../Assets/Images/info.png" alt=""></button>
    </nav>
</body>
</html>