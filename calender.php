<?php
include_once(__DIR__ . '/classes/Task.php');
include_once(__DIR__ . '/classes/User.php');

session_start();
if (!isset($_SESSION['user'])) {
    header('location: index.php');
} else {
    $users = User::getAllData();
    foreach ($users as $user) :
        if ($user['email'] == $_SESSION['user']->getEmail()) {
            $username = $user['username'];
            $email = $user['email'];
            $name = $user['name'];
            if ($user['type'] == 'Manager') {
                $manager = true;
            } else if ($user['type'] == 'Admin') {
                header('location: home.php');
            } else {
                header('location: calendarUser.php');
            }
        }
    endforeach;
}
$tasks = Task::getAllUserTasksWithTaskNameAndUserInfo();

// Format the events with start and end times
$events = array_map(function ($task) {
    // Combine date and time to create ISO 8601 datetime format
    $start = $task['date'] . 'T' . $task['start_time'] . ':00';
    $end = $task['date'] . 'T' . $task['end_time'] . ':00';

    // Create the event title with task type and user info
    $title = $task['task_type'];
    if (isset($task['user_name'])) {
        // If user name exists, include it in the title
        $userName = htmlspecialchars($task['user_name']); // Escape user name
        $title .= ' ' . ucfirst($userName);
    }

    // Create the event object with task name and user info
    return [
        'id' => $task['id'],
        'title' => $title,
        'start' => $start,
        'end' => $end
    ];
}, $tasks);

?>

<!DOCTYPE html>
<html lang='en'>

<head>
    <meta charset='utf-8' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js'></script>
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/main.min.css' rel='stylesheet' />
    <link href='css/calender.css' rel='stylesheet' />
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                customButtons: {
                    assignTaskButton: {
                        text: 'Assign Task',
                        click: function() {
                            window.location.href = 'task.php';
                        }
                    }
                },
                initialView: 'dayGridMonth',
                events: <?php echo json_encode($events); ?>,
                headerToolbar: {
                    start: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
                    center: 'title',
                    end: 'assignTaskButton,prevYear,prev,next,nextYear'
                },
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    omitZeroMinute: false,
                    meridiem: true
                },
                views: {
                    listWeek: {
                        eventContent: function(arg) {
                            let deleteBtn = document.createElement('button');
                            deleteBtn.innerText = 'Delete';
                            deleteBtn.classList.add('btn', 'btn-danger', 'btn-sm', 'ml-2');
                            deleteBtn.addEventListener('click', function() {
                                if (confirm('Are you sure you want to delete this event?')) {
                                    let taskId = arg.event.id;
                                    $.ajax({
                                        url: 'delete_task.php',
                                        method: 'POST',
                                        data: {
                                            taskId: taskId
                                        },
                                        success: function(response) {
                                            arg.event.remove(); // Verwijder het event uit de kalender
                                        },
                                        error: function(xhr, status, error) {
                                            console.error(xhr.responseText);
                                            alert('Er is een fout opgetreden bij het verwijderen van de taak.');
                                        }
                                    });
                                }
                            });

                            let title = document.createElement('div');
                            title.innerHTML = arg.event.title;

                            let arrayOfDomNodes = [title, deleteBtn];

                            return {
                                domNodes: arrayOfDomNodes
                            };
                        }
                    }
                }
            });
            calendar.render();
        });
    </script>
</head>

<body>
    <?php include_once 'bootstrap.php'; ?>

    <div id="wrapper">
        <ul class="navbar-nav bg-dark sidebar sidebar-dark accordion" id="accordionSidebar">
            <div class="container justify-content-center" id="sidebar-logo">
                <a class="navbar-brand py-3 m-0 justify-content-center" href="#">
                    <img src="images/Little-Sun-Logo.png" alt="" id="big-logo" height="35">
                    <img src="images/Little-Sun-Logo-small.png" id="small-logo" alt="" height="50">
                </a>
            </div>

            <hr class="sidebar-divider my-0">

            <li class="nav-item active">
                <a class="nav-link" href="home.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <hr class="sidebar-divider">

            <div class="sidebar-heading">
                Calendar
            </div>

            <li class="nav-item">
                <?php if ($manager == true) { ?>
                    <a class="nav-link collapsed" href="timeOffManager.php">
                        <i class='far fa-clock'></i>
                        <span>Time Off</span>
                    </a>
                <?php } else { ?>
                    <a class="nav-link collapsed" href="timeOffUser.php">
                        <i class='far fa-clock'></i>
                        <span>Time Off</span>
                    </a>
                <?php } ?>
            </li>

            <li class="nav-item">
                <a class="nav-link collapsed" href="calender.php">
                    <i class='far fa-calendar-alt'></i>
                    <span>Calendar</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <?php if ($manager == true) : ?>
                <div class="sidebar-heading">
                    Manager Tools
                </div>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="hub.php">
                        <i class="fa-brands fa-hubspot"></i>
                        <span>Location Hub</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="task.php">
                        <i class="fas fa-tasks"></i>
                        <span>Assign Task</span>
                    </a>
                </li>
                <li class="nav-item">
                <a class="nav-link collapsed" href="report.php">
                    <i class="fas fa-chart-bar"></i>
                    <span>Generate reports</span>
                </a>
            </li>
            <?php endif; ?>
        </ul>

        <div id="content-wrapper" class="d-flex flex-column">
            <div id="content">
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img-profile rounded-circle mx-2" src="images/<?php echo $user['profile_picture']; ?>">
                                <div class="container flex-column  align-items-start">
                                    <span class="small">
                                        <?php
                                        if ($admin == true) {
                                            echo '<span class="mr-1 d-none d-lg-inline text-gray-600 medium">🛡️ Admin</span>';
                                        } else if ($manager == true) {
                                            echo '<span class="mr-1 d-none d-lg-inline text-gray-600 medium">💼 Manager</span>';
                                        } else {
                                            echo '<span class="mr-1 d-none d-lg-inline text-gray-600 medium">👤 User</span>';
                                        }
                                        ?>
                                    </span>
                                    <span class="mr-2 d-none d-lg-inline text-dark ">
                                        <?php
                                        echo ucfirst($username);
                                        ?>
                                    </span>
                                </div>
                                <i class="fa-solid fa-angle-down"></i>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="logout.php">Logout</a>
                            </div>
                        </li>
                    </ul>
                </nav>
                <div id='calendar' class="container">
                </div>
            </div>
        </div>
    </div>
</body>
<script src="js/script.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>