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

    $new_meeting = [
        'student_name' => $student_name,
        'university_name' => $university_name,
        'meeting_title' => $meeting_title,
        'meeting_date' => $meeting_date,
        'meeting_time' => $meeting_time,
        'status' => 'Scheduled',
    ];

    $meetings[] = $new_meeting;

    file_put_contents('meetings.json', json_encode($meetings, JSON_PRETTY_PRINT));
    echo "<div class='alert alert-success text-center'>Meeting scheduled successfully!</div>";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FullCalendar CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.css">

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary-color: #973D4D;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #fbecee, #ffffff);
            color: #343a40;
        }

        .navbar {
            background-color: var(--primary-color);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.05);
        }

        .card-header {
            background: var(--primary-color);
            color: #fff;
            font-weight: 600;
            border-radius: 15px 15px 0 0;
            text-align: center;
        }

        .form-control {
            border-radius: 10px;
        }

        .btnn {
            background-color: #823341;
            border: none;
            padding: 12px;
            font-weight: bold;
            width: 100%;
            border-radius: 8px;
            font-size: 15px;
            color: white;
            transition: all 0.4s ease-in-out;
        }

        .btnn:hover {
            background-color: #b54c5f;
            color: white;
        }

        #calendar {
            border-radius: 10px;
            background: #fff;
            padding: 20px;
            box-shadow: 0px 5px 20px rgba(0, 0, 0, 0.05);
        }

        .fc-toolbar-title {
            font-size: 1.5rem;
            font-weight: 600;
        }

        .fc-button-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        a{
            display: block;
            margin-top: 20px;
            text-decoration: none;
            font-weight: bold;
            color: black;
            padding: 12px;
            border-radius: 8px;
            transition:all 0.4s ease-in-out;
        }
        
        .back-btn {
            background-color: white;
            color: var(--primary-color);
            border: 2px solid var(--primary-color);
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background-color: var(--primary-color);
            color: white;
            transform: scale(1.05);
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
        }

    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="#"><i class="fas fa-calendar-check"></i> Student-Meeting App</a>
        <div class="ms-auto">
            <a href="result.php" class="btn btn-outline-light rounded-pill px-4 fw-bold shadow-sm back-btn">
                <i class="fas fa-arrow-left me-2"></i>Back to Results
            </a>
        </div>
    </div>
</nav>


<!-- Main Content -->
<div class="container mt-5">
    <h2 class="text-center mb-5"><i class="fa-solid fa-calendar-days"></i> Schedule a Meeting</h2>

    <div class="row justify-content-center">
        <!-- Schedule Form -->
        <div class="col-md-5 mb-4">
            <div class="card">
                <div class="card-header">Schedule a New Meeting</div>
                <div class="card-body">
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">Your Name</label>
                            <input type="text" class="form-control" name="student_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">University Name</label>
                            <input type="text" class="form-control" name="university_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Meeting Title</label>
                            <input type="text" class="form-control" name="meeting_title" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Date</label>
                            <input type="date" class="form-control" name="meeting_date" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Time</label>
                            <input type="time" class="form-control" name="meeting_time" required>
                        </div>
                        <button type="submit" class="btn btnn">Create</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Calendar -->
        <div class="col-md-7">
            <div class="card">
                <div class="card-header">Your Meeting Calendar</div>
                <div class="card-body">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="meetingModal" tabindex="-1" aria-labelledby="meetingModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title" id="meetingModalLabel">Meeting Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><strong>Title:</strong> <span id="modalTitle"></span></p>
        <p><strong>Date:</strong> <span id="modalDate"></span></p>
        <p><strong>University & Student:</strong> <span id="modalDescription"></span></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" id="deleteMeetingBtn" class="btn btn-danger">Done</button>
      </div>
    </div>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.11.3/main.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarEl = document.getElementById('calendar');
        var meetingsData = <?php echo json_encode($meetings); ?>;

        var events = meetingsData.map(function (meeting) {
            return {
                title: meeting.meeting_title,
                start: meeting.meeting_date + 'T' + meeting.meeting_time,
                description: meeting.university_name + ' - ' + meeting.student_name
            };
        });

        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: events,
            eventClick: function (info) {
                document.getElementById('modalTitle').innerText = info.event.title;
                document.getElementById('modalDate').innerText = info.event.start.toLocaleString();
                document.getElementById('modalDescription').innerText = info.event.extendedProps.description;

                const eventKey = info.event.start.toISOString() + '_' + info.event.title;

                document.getElementById('deleteMeetingBtn').onclick = function () {
                    fetch('delete_meeting.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ key: eventKey })
                    })
                    .then(res => res.text())
                    .then(response => {
                        if (response === 'success') {
                            info.event.remove();
                            bootstrap.Modal.getInstance(document.getElementById('meetingModal')).hide();
                        }
                    });
                };

                new bootstrap.Modal(document.getElementById('meetingModal')).show();
            }
        });

        calendar.render();
    });
</script>

</body>
</html>
