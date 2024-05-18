<?php
include_once(__DIR__ . '/classes/Task.php');
include_once(__DIR__ . '/classes/User.php');
include_once(__DIR__ . '/classes/Sick.php');

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
                header('location: calender.php');
            } else if ($user['type'] == 'Admin') {
                header('location: home.php');
            }
            $tasks = Task::getTaskByUserId($user['id']); // Set $tasks variable
            $sickDays = Sick::getOneData($user['id']); // Set $sickDays variable
        }
    endforeach;
}


$allEvents = [];

// Add task events to the array
foreach ($tasks as $task) {
    $start = $task['date'] . 'T' . $task['start_time'] . ':00';
    $end = $task['date'] . 'T' . $task['end_time'] . ':00';
    $allEvents[] = [
        'id' => $task['id'],
        'title' => $task['task_type'],
        'start' => $start,
        'end' => $end
    ];
}

// Add sick day events to the array
if ($sickDays) {
    foreach ($sickDays as $sickDay) {
        // Format start and end dates
        $startDate = date('Y-m-d', strtotime($sickDay['start_date']));
        $endDate = date('Y-m-d', strtotime($sickDay['end_date']) + 86400);
        $allEvents[] = [
            'id' => $sickDay['id'],
            'title' => 'Sick Day',
            'start' => $startDate,
            'end' => $endDate,
            'display' => 'background',
            'color' => 'red'
        ];
    }
}

// Encode all events as JSON
$eventsJson = json_encode($allEvents);



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
                events: <?php echo $eventsJson; ?>,


                headerToolbar: {
                    start: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek',
                    center: 'title',
                    end: 'prevYear,prev,next,nextYear'
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
                            deleteBtn.innerText = 'Call Sick';
                            deleteBtn.classList.add('btn', 'btn-danger', 'btn-sm', 'ml-2');
                            deleteBtn.addEventListener('click', function() {
                                window.location.href = 'timeOffUser.php';
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
            <?php endif; ?>

            <?php if ($admin == false && $manager == false) { ?>
                <li class="nav-item">
                    <div class="sidebar-heading">
                        User Tools
                    </div>
                    <a class="nav-link collapsed" href="userTask.php">
                        <i class="fas fa-tasks"></i>
                        <span>My Task</span>
                    </a>
                </li>
            <?php }  ?>
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
                                <a class="dropdown-item" href="#">TEST</a>
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