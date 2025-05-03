<?php
session_start();

// Initialize meetings data from meetings.json
$meetings_data = file_get_contents('meetings.json');
$meetings = json_decode($meetings_data, true);
if (!$meetings) {
    $meetings = [];
}

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_name = $_POST['student_name'];
    $university_name = $_POST['university_name'];
    $meeting_title = $_POST['meeting_title'];
    $meeting_date = $_POST['meeting_date'];
    $meeting_time = $_POST['meeting_time'];
    
    // Add new meeting to the meetings array
    $new_meeting = [
        'student_name' => $student_name,
        'university_name' => $university_name,
        'meeting_title' => $meeting_title,
        'meeting_date' => $meeting_date,
        'meeting_time' => $meeting_time,
        'status' => 'Scheduled',
    ];
    
    // Add new meeting to existing meetings
    $meetings[] = $new_meeting;
    
    // Save updated meetings data back to the file
    file_put_contents('meetings.json', json_encode($meetings, JSON_PRETTY_PRINT));

    echo "Meeting scheduled successfully!";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student-Meeting App</title>

    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- FullCalendar CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">
    
    <!-- FontAwesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Custom Styling -->
    <style>
        body {
            background-color: #f8f9fa;
        }
        .navbar {
            margin-bottom: 20px;
        }
        .card {
            border-radius: 10px;
            margin-bottom: 30px;
        }
        .card-header {
            background-color: #0d6efd;
            color: white;
            text-align: center;
        }
        .form-control {
            border-radius: 8px;
        }
        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
        }
        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }
        #calendar {
            border-radius: 10px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-teal-800 shadow-lg">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Student-Meeting App</a>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mt-5">

        <h2 class="text-center display-4 mb-4"><i class="fa-solid fa-calendar-days"></i> Schedule a Meeting</h2>

        <div class="row">

            <!-- Schedule Form -->
            <div class="col-lg-4">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4 class="mb-0">Schedule a New Meeting</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label for="student_name" class="form-label">Your Name</label>
                                <input type="text" class="form-control" name="student_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="university_name" class="form-label">University Name</label>
                                <input type="text" class="form-control" name="university_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="meeting_title" class="form-label">Meeting Title</label>
                                <input type="text" class="form-control" name="meeting_title" required>
                            </div>
                            <div class="mb-3">
                                <label for="meeting_date" class="form-label">Date</label>
                                <input type="date" class="form-control" name="meeting_date" required>
                            </div>
                            <div class="mb-3">
                                <label for="meeting_time" class="form-label">Time</label>
                                <input type="time" class="form-control" name="meeting_time" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Create</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Calendar Display -->
            <div class="col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h4 class="mb-0">Your Meeting Calendar</h4>
                    </div>
                    <div class="card-body">
                        <div id="calendar"></div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- Scripts -->
    <!-- FullCalendar JS -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>

    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.0/js/bootstrap.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            
            // Convert PHP meetings data to JavaScript-friendly format
            var meetingsData = <?php echo json_encode($meetings); ?>;
            var events = meetingsData.map(function(meeting) {
                return {
                    title: meeting.meeting_title,
                    start: meeting.meeting_date + 'T' + meeting.meeting_time,
                    description: meeting.university_name + ' - ' + meeting.student_name
                };
            });

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: events, // Pass events to the calendar
                eventClick: function(info) {
                    alert("Meeting: " + info.event.title + "\nDate: " + info.event.start.toLocaleString());
                }
            });
            calendar.render();
        });
    </script>
</body>
</html>
