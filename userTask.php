<?php
include_once(__DIR__ . '/classes/User.php');
include_once(__DIR__ . '/classes/Task.php');
include_once("bootstrap.php");

session_start();
if (!isset($_SESSION['user'])) {
    header('Location: index.php');
    exit;
} else {
    $admin = false;
    $manager = false;
    $users = User::getAllData();
    foreach ($users as $user) {
        if ($user['email'] == $_SESSION['user']->getEmail()) {
            $username = $user['username'];
            $email = $user['email'];
            $name = $user['name'];
            $id = $user['id'];
            $tasks = Task::getAllUserTasksById($id);
            if ($user['type'] == 'Admin') {
                $admin = true;
            }
            if ($user['type'] == 'Manager') {
                $manager = true;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Tasks</title>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/popup.css">
</head>

<body>
    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="navbar-nav bg-dark sidebar sidebar-dark accordion" id="accordionSidebar">
            <!-- Sidebar - Brand -->
            <div class="container justify-content-center" id="sidebar-logo">
                <a class="navbar-brand py-3 m-0 justify-content-center" href="#">
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
            <hr class="sidebar-divider">
            <!-- Heading -->
            <div class="sidebar-heading">
                Calendar
            </div>
            <!-- Nav Item - Time Off -->
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
            <!-- Nav Item - Calendar -->
            <li class="nav-item">
                <a class="nav-link collapsed" href="#">
                    <i class='far fa-calendar-alt'></i>
                    <span>Calendar</span>
                </a>
            </li>
            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Manager Tools -->
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
                        <span>Assign Task</span>
                    </a>
                </li>
            <?php endif; ?>
            <!-- Admin Tools -->
            <?php if ($admin == true) : ?>
                <li class="nav-item">
                    <a class="nav-link collapsed" href="taskTypes.php">
                        <i class='far fa-clock'></i>
                        <span>Task Types</span>
                    </a>
                </li>
            <?php endif; ?>

            <li class="nav-item">
                <?php if ($admin == false && $manager == false) { ?>
                    <a class="nav-link collapsed" href="userTask.php">
                        <i class="fas fa-tasks"></i>
                        <span>My Task</span>
                    </a>
                <?php }  ?>
            </li>
        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img-profile rounded-circle mx-2" src="images/<?php echo $user['profile_picture']; ?>">
                                <div class="container flex-column align-items-start">
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
                                        <?php echo ucfirst($username) ?>
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
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-dark">Welcome, <?php echo $username ?></h6>
                        </div>
                        <div class="card-body">
                            <h2>Your Tasks</h2>
                            <?php foreach ($tasks as $task) :
                                $taskDetails = Task::getTaskById($task['taskId']);
                                $taskName = $taskDetails['name'];
                                $taskType = $taskDetails['type'];
                                $taskDate = $task['date'];
                                $taskStartTime = $task['start_time'];
                                $taskEndTime = $task['end_time'];
                            ?>
                                <div class="task">
                                    <h3><?php echo $taskName ?></h3>
                                    <p>Type: <?php echo $taskType ?></p>
                                    <p>Date: <?php echo $taskDate ?></p>
                                    <p>Start Time: <?php echo $taskStartTime ?></p>
                                    <p>End Time: <?php echo $taskEndTime ?></p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>
                <!-- End of Main Content -->
            </div>
            <!-- End of Content Wrapper -->
        </div>
    </div>
    <!-- End of Page Wrapper -->

    <!-- Bootstrap core JavaScript-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
</body>
<script src="js/script.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>