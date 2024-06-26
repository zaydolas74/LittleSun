<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once(__DIR__ . '/classes/User.php');
include_once(__DIR__ . '/classes/Location.php');

session_start();
if (!isset($_SESSION['user'])) {
    header('location: index.php');
    exit();
} else {
    $users = User::getAllData();
    $admin = false;
    $manager = false;
    foreach ($users as $user) {
        if ($user['email'] == $_SESSION['user']->getEmail()) {
            $username = $user['username'];
            $email = $user['email'];
            $name = $user['name'];
            $location_name = Location::getLocationById($user['location_id']);
            if ($user['profile_picture'] == null) {
                $user['profile_picture'] = 'default.jpg';
            } else {
                $profile = $user['profile_picture'];
            }
            if ($user['type'] == 'Manager') {
                $manager = true;
            } else {
                header('location: home.php');
                exit();
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
    <title>Generate a report</title>
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
                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img-profile rounded-circle mx-2" src="images/<?php echo $profile ?>">
                                <div class="container flex-column  align-items-start">
                                    <span class="small">
                                        <?php
                                        if ($admin == true) {
                                            echo '<span class="mr-1  d-lg-inline text-gray-600 medium">🛡️ Admin</span>';
                                        } else if ($manager == true) {
                                            echo '<span class="mr-1  d-lg-inline text-gray-600 medium">💼 Manager</span>';
                                        } else {
                                            echo '<span class="mr-1  d-lg-inline text-gray-600 medium">👤 User</span>';
                                        }
                                        ?>
                                    </span>
                                    <span class="mr-2  d-lg-inline text-dark ">
                                        <?php
                                        echo ucfirst($username)
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
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-dark">Generate A Report</h6>
                        </div>
                        <div class="card-body">
                            <h1 class="h3 mb-4 text-gray-800 text-center">Sick hours - <?php echo date('F'); ?></h1>
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th scope="col">Name</th>
                                            <th scope="col">Email</th>
                                            <th scope="col">Sick Hours</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $users = User::getAllData();
                                    $totalSickHours = 0;
                                    foreach ($users as $userData) :
                                        if ($userData['type'] == 'User') :
                                            $user_id = $userData['id'];
                                            $user = new User();
                                            $sickHours = $user->getSickHoursForMonth($user_id, date('Y'), date('m'));
                                            $totalSickHours += $sickHours;
                                    ?>

                                            <tr>
                                                <td><?php echo $userData['name']; ?></td>
                                                <td><?php echo $userData['email']; ?></td>
                                                <td><?php echo $sickHours ?></td>
                                            </tr>
                                    <?php endif;
                                    endforeach; ?>
                                    <tfoot>
                                        <tr>
                                            <td colspan="2"><strong>Total</strong></td>
                                            <td><strong><?php echo $totalSickHours; ?></strong></td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- End of Content Wrapper -->

            </div>
            <!-- End of Page Wrapper -->
        </div>

</body>


<script src="js/script.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>