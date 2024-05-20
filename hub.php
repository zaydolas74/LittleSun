<?php
include_once(__DIR__ . '/classes/User.php');
include_once(__DIR__ . '/classes/Location.php');
include_once(__DIR__ . '/classes/Task.php');
include_once(__DIR__ . '/classes/Permission.php');
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
            $users = User::getUsersByManagerLocation($user['location_id']);
            $location_name = Location::getLocationById($user['location_id']);
            if ($user['type'] == 'Manager') {
                $manager = true;
            } else {
                header('location: home.php');
            }
        }
    endforeach;
    $allTasks = Task::getAllTasks();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hub</title>
    <style>
        .profile-photo-placeholder {
            width: 100px;
            height: 100px;
            overflow: hidden;
            border-radius: 50%;
        }

        .profile-photo-placeholder img {
            width: 100%;
            height: auto;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>

<body>
    <?php include_once 'bootstrap.php'; ?>


    <!-- Page Wrapper -->
    <div id="wrapper">

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
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Calendar
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

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
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
                <div class="container-fluid">
                    <h1 class="h3 mb-4 text-gray-800"><?php echo $location_name['location_name']; ?> - Hub</h1>
                    <div class="row">
                        <?php foreach ($users as $user) : ?>
                            <?php if ($user['type'] == 'User') : ?>
                                <div class="col-lg-4 col-md-6 mb-4">
                                    <div class="card shadow">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-3">
                                                <img src="images/<?php echo $user['profile_picture']; ?>" class="rounded-circle mr-3" style="width: 60px; height: 60px; object-fit: cover;" alt="foto">
                                                <div>
                                                    <h5 class="card-title mb-1"><?php echo $user['username']; ?></h5>
                                                    <p class="card-text text-muted mb-0"><?php echo $user['name']; ?></p>
                                                    <p class="card-text text-muted"><?php echo $user['email']; ?></p>
                                                </div>
                                            </div>
                                            <hr>
                                            <ul class="list-group mb-3">
                                                <li class="list-group-item list-group-item-action active text-dark "><strong>Tasks</strong></li>
                                                <?php $userTasks = Task::getAllUserTasksById($user['id']); ?>
                                                <?php foreach ($userTasks as $userTask) : ?>
                                                    <?php $task = Task::getTaskById($userTask['taskId']); ?>
                                                    <li class="list-group-item"><?php echo $task['type']; ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                            <h5 class="card-title"><strong>Permission</strong></h5>
                                            <ul class="list-group">
                                                <?php
                                                $userPermissions = Permission::getTaskIdByUserId($user['id']);
                                                $userPermissionIds = array_column($userPermissions, 'taskId');
                                                foreach ($allTasks as $task) : ?>
                                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                                        <?php echo $task['type']; ?>
                                                        <input type="checkbox" class="permission-checkbox" data-user-id="<?php echo $user['id']; ?>" data-task-id="<?php echo $task['id']; ?>" <?php if (in_array($task['id'], $userPermissionIds)) echo 'checked'; ?>>
                                                    </li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                </div>





                <!-- End of Main Content -->



            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->
    </div>

</body>

<script>
    $(document).ready(function() {
        $('.permission-checkbox').change(function() {
            var userId = $(this).data('user-id');
            var taskId = $(this).data('task-id');
            var isChecked = $(this).is(':checked');

            $.ajax({
                url: 'update_permission.php',
                method: 'POST',
                data: {
                    user_id: userId,
                    task_id: taskId,
                    checked: isChecked
                },
                success: function(response) {
                    console.log(response);
                }
            });
        });
    });
</script>
<script src="js/script.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>