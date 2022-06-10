<?php
session_start();
if(isset($_SESSION["username"])){
    $username = $_SESSION["username"];
}
include("nav.php");
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Calendar</title>
        <link rel="stylesheet" href="fullcalendar.css"/>
        <link rel="stylesheet" href="../bootstrap.css"/>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.4.0/fullcalendar.min.js"></script>
        <script>
            $(document).ready(function(){
                var calendar = $('#calendar').fullCalendar({
                    editable: true,
                    header:{
                        left: 'prev, next today',
                        center: 'title',
                        right: 'month, agendaWeek, agendaDay'
                    },
                    events: 'load.php',
                    selectable: true,
                    selectHelper: true,
                    select: function(start, end, allDay){
                        var title = prompt("Enter event title");
                        if(title){
                            var start = $.fullCalendar.formatDate(start, "Y-MM-DD HH:mm:ss");
                            var end = $.fullCalendar.formatDate(end, "Y-MM-DD HH:mm:ss");
                            $.ajax({
                                url: "insert.php",
                                type: "POST",
                                data: {
                                    title: title,
                                    start: start,
                                    end: end
                                },
                                success: function(){
                                    calendar.fullCalendar('refetchEvents');
                                    alert("Added successfully.");
                                }
                            })
                        }
                    },
                    editable: true,

                    eventResize: function(event){
                        var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                        var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                        var title = event.title;
                        var id = event.id;
                        $.ajax({
                            url: "update.php",
                            type: "POST",
                            data: {
                                title: title,
                                start: start,
                                end: end,
                                id: id
                            },
                            success: function(){
                                calendar.fullCalendar('refetchEvents');
                                alert("Event updated.");
                            }
                        })
                    },

                    eventDrop: function(event){
                        var start = $.fullCalendar.formatDate(event.start, "Y-MM-DD HH:mm:ss");
                        var end = $.fullCalendar.formatDate(event.end, "Y-MM-DD HH:mm:ss");
                        var title = event.title;
                        var id = event.id;
                        $.ajax({
                            url: "update.php",
                            type: "POST",
                            data: {
                                title: title,
                                start: start,
                                end: end,
                                id: id
                            },
                            success: function(){
                                calendar.fullCalendar('refetchEvents');
                                alert("Event updated");
                            }
                        })
                    },

                    eventClick: function(event){
                        if(confirm("Are you sure you want to remove event?")){
                            var id = event.id;
                            $.ajax({
                                url: "delete.php",
                                type: "POST",
                                data: {
                                    id: id
                                },
                                success: function(){
                                    calendar.fullCalendar('refetchEvents');
                                    alert("Event removed.")
                                }
                            })
                        }
                    }
                });
            });
        </script>
    </head>
    <body>
        <br>
        <div class="container">
            <a href="../home.php">< Back</a>
            <div id="calendar"></div>
        </div>
    </body>
</html>