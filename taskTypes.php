<?php
include_once(__DIR__ . '/classes/User.php');
include_once(__DIR__ . '/classes/Location.php');
include_once(__DIR__ . '/classes/Task.php');
include_once("bootstrap.php");

session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
} else {
    $admin = false;
    $manager = false;
    $users = User::getAllData();
    foreach ($users as $user) :
        if ($user['email'] == $_SESSION['user']->getEmail()) {
            $username = $user['username'];
            $email = $user['email'];
            $name = $user['name'];
            $id = $user['id'];
            $location_name = Location::getLocationById($user['location_id']);
            if ($user['type'] == 'Admin') {
                $admin = true;
            } else {
                header('Location: home.php');
            }
        }
    endforeach;

    $task = Task::getAllTasks();
}

?>

<!-- Page Wrapper -->
<div id="wrapper">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/popup.css">
    <!-- Sidebar -->
    <ul class="navbar-nav bg-dark sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Sidebar - Brand -->
        <div class="container justify-content-center" id="sidebar-logo">
            <a class="navbar-brand py-3 m-0 justify-content-center" href="home.php">
                <img src="images/Little-Sun-Logo.png" alt="" id="big-logo" height="35">
                <img src="images/Little-Sun-Logo-small.png" id="small-logo" alt="" height="50">
            </a>
        </div>

        <!-- Divider -->
        <hr class="sidebar-divider my-0">


        <!-- Nav Item - Dashboard -->
        <li class="nav-item active">
            <a class="nav-link" href="home.php">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <?php if ($admin == false) { ?>
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Calender
            </div>

            <!-- Nav Item - Pages Collapse Menu -->
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

            <!-- Nav Item - Utilities Collapse Menu -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="calender.php">
                    <i class='far fa-calendar-alt'></i>
                    <span>Calendar</span>
                </a>
            </li>
        <?php } ?>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <div class="sidebar-heading">
            Admin Tools
        </div>
        <li class="nav-item">
            <?php if ($admin == true) { ?>
                <a class="nav-link collapsed" href="taskTypes.php">
                    <i class='far fa-clock'></i>
                    <span>Task types</span>
                </a>
            <?php }  ?>
        </li>

        <!-- Heading -->
        <?php if ($manager == true) : ?>
            <div class="sidebar-heading">
                Manager Tools
            </div>
            <li class="nav-item">
                <a class="nav-link collapsed" href="hub.php">
                    <i class="fa-brands fa-hubspot"></i>
                    <span>Manager Hub</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link collapsed" href="task.php">
                    <i class="fas fa-tasks"></i>
                    <span>Asign Task</span>
                </a>
            </li>
        <?php endif; ?>

        <!-- Nav Item - Charts
        <li class="nav-item">
            <a class="nav-link" href="charts.html">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>TEST</span></a>
        </li>

        Nav Item - Tables 
        <li class="nav-item">
            <a class="nav-link" href="tables.html">
                <i class="fas fa-fw fa-table"></i>
                <span>TEST</span></a>
        </li>
        -->




    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">


                <!-- Topbar Search 
                <form class=" d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                    <div class="input-group">
                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary" type="button">
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </form>
                -->
                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Nav Item - User Information -->
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
                                    echo ucfirst($username)
                                    ?>
                                </span>
                            </div>
                            <i class="fa-solid fa-angle-down"></i>

                        </a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                            <!-- <a class="dropdown-item" href="#">TEST</a> -->
                            <a class="dropdown-item" href="logout.php">Logout</a>
                        </div>
                    </li>

                </ul>

            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class='container fluid'>
                <div class='container'>
                    <div class='row'>
                        <div class='col-12'>
                            <h1 class='text-center'>Task Types</h1>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-12'>
                            <table class='table table-striped'>
                                <thead>
                                    <tr>
                                        <th scope='col'>#</th>
                                        <th scope='col'>Task Type</th>
                                        <th scope='col'>Edit</th>
                                        <th scope='col'>Save</th>
                                        <th scope='col'>Delete</th>
                                    </tr>
                                </thead>
                                <tbody id="taskTableBody">
                                    <?php
                                    foreach ($task as $task) {
                                        echo "<tr>";
                                        echo "<th scope='row'>" . $task['id'] . "</th>";
                                        echo "<td class='task-type' data-id='" . $task['id'] . "'>" . $task['type'] . "</td>";
                                        echo "<td><button class='btn btn-edit' data-id='" . $task['id'] . "'><i class='fas fa-edit'></i></button></td>";
                                        echo "<td><button class='btn btn-save' data-id='" . $task['id'] . "' style='display:none;'><i class='fas fa-save'></i></button></td>";
                                        echo "<td><a href='deleteTask.php?id=" . $task['id'] . "'><i class='fas fa-trash-alt'></i></a></td>";
                                        echo "</tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class='row'>
                        <div class='col-12'>
                            <button id="addTaskButton" class='btn btn-primary'>Add Task</button>
                        </div>
                    </div>
                </div>

            </div>

            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->
    </div>
</div>

<!-- End of Page Wrapper -->

<!-- <script src="js/showPopup.js"></script> -->
<script>
    document.addEventListener('DOMContentLoaded', (event) => {
        document.querySelectorAll('.btn-edit').forEach(button => {
            button.addEventListener('click', function() {
                var taskId = this.getAttribute('data-id');
                var taskTypeElement = document.querySelector(`.task-type[data-id='${taskId}']`);
                var taskType = taskTypeElement.textContent.trim();

                taskTypeElement.innerHTML = `<input type='text' value='${taskType}' class='edit-input form-control' />`;

                this.style.display = 'none';
                document.querySelector(`.btn-save[data-id='${taskId}']`).style.display = 'inline-block';
            });
        });

        document.querySelectorAll('.btn-save').forEach(button => {
            button.addEventListener('click', function() {
                var taskId = this.getAttribute('data-id');
                var newType = document.querySelector(`.task-type[data-id='${taskId}'] input`).value;

                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'editTask.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        document.querySelector(`.task-type[data-id='${taskId}']`).innerHTML = newType;
                        document.querySelector(`.btn-edit[data-id='${taskId}']`).style.display = 'inline-block';
                        document.querySelector(`.btn-save[data-id='${taskId}']`).style.display = 'none';
                    } else if (xhr.readyState === 4) {
                        alert('Error saving task');
                    }
                };
                xhr.send('id=' + taskId + '&type=' + encodeURIComponent(newType));
            });
        });

    });

    document.addEventListener('DOMContentLoaded', (event) => {
        // Functie om de "Add Task" knop te verbergen
        function hideAddTaskButton() {
            document.getElementById('addTaskButton').style.display = 'none';
        }

        // Functie om de "Add Task" knop weer te tonen
        function showAddTaskButton() {
            document.getElementById('addTaskButton').style.display = 'inline-block';
        }

        // Event listener voor klikken op "Add Task" knop
        document.getElementById('addTaskButton').addEventListener('click', function() {
            hideAddTaskButton(); // Verberg de knop wanneer erop wordt geklikt

            // Maak een nieuwe rij aan voor het toevoegen van een taak
            var newRow = document.createElement('tr');
            newRow.innerHTML = `
            <td></td>
            <td><input type='text' class='form-control' id='newTaskInput'></td>
            <td></td>
            <td class='btn btn-save-new'><button class='btn btn-save-new'><i class='fas fa-save btn-save-new'></i></button></td>
            <td></td>
        `;
            document.getElementById('taskTableBody').appendChild(newRow);
        });

        // Event listener voor klikken op "Save" knop van nieuwe taak
        document.getElementById('taskTableBody').addEventListener('click', function(event) {
            if (event.target.classList.contains('btn-save-new')) {
                // Voer AJAX-verzoek uit om nieuwe taak toe te voegen
                var newTaskInput = document.getElementById('newTaskInput').value;
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'addTask.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        // Verwijder de nieuwe rij uit de tabel na succesvolle toevoeging
                        event.target.closest('tr').remove();
                        showAddTaskButton(); // Toon de "Add Task" knop weer
                        location.reload(); // Vernieuw de pagina om de toegevoegde taak weer te geven
                    } else if (xhr.readyState === 4) {
                        alert('Er is een fout opgetreden bij het toevoegen van de taak.');
                    }
                };
                xhr.send('task=' + encodeURIComponent(newTaskInput));
            }
        });

        // Event listener voor klikken op de pagina om toevoeging van taak te annuleren
        document.addEventListener('click', function(event) {
            if (!event.target.closest('#taskTableBody') && event.target.id !== 'addTaskButton') {
                // Controleer of er buiten de tabel en de "Add Task" knop is geklikt
                showAddTaskButton(); // Toon de "Add Task" knop weer
                // Verwijder de nieuwe rij als deze nog niet is toegevoegd aan de tabel
                if (document.getElementById('newTaskInput')) {
                    document.getElementById('newTaskInput').closest('tr').remove();
                }
            }
        });
    });
</script>



<script src="js/script.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</head>