<?php
include_once(__DIR__ . '/classes/User.php');
include_once(__DIR__ . '/classes/Location.php');
include_once(__DIR__ . '/classes/Task.php');
include_once(__DIR__ . '/classes/TimeOff.php');
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
            $location_name = Location::getLocationById($user['location_id']);
            if ($user['type'] == 'Manager') {
                $manager = true;
            } else {
                header('location: timeOffUser.php');
            }
        }
    endforeach;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hub</title>

</head>

<body>
    <?php include_once 'bootstrap.php'; ?>


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
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-dark">Time Off Requests</h6>
                        </div>
                        <div class="card-body">
                            <form action="" method="get">
                                <?php
                                $timeOffs = TimeOff::getAllTimeOffRequestsAllUsers();
                                foreach ($timeOffs as $timeOff) :
                                    $name = User::getUserById($timeOff['userId']);
                                    $name = $name['name'];
                                ?>
                                    <div class="d-block d-md-none mb-3">
                                        <div class="p-3 border rounded bg-light">
                                            <p><strong>Name: </strong><?php echo ucfirst($name) ?></p>
                                            <p><strong>Start Date: </strong><?php echo $timeOff['start_time']; ?></p>
                                            <p><strong>End Date: </strong><?php echo $timeOff['end_time']; ?></p>
                                            <p><strong>Reason: </strong><?php echo ucfirst($timeOff['reason']); ?></p>
                                            <p><strong>Day Type: </strong><?php echo $timeOff['day_type']; ?></p>
                                            <p><strong>Status: </strong>
                                                <?php
                                                if ($timeOff['status'] == 0) {
                                                    echo '<span style="color: orange; background-color: #fff3e0; border: 1px solid orange; padding: 5px; border-radius: 3px;">Pending</span>';
                                                } elseif ($timeOff['status'] == 'Accepted') {
                                                    echo '<span style="color: green; background-color: #e0f7fa; border: 1px solid green; padding: 5px; border-radius: 3px;">Accepted</span>';
                                                } elseif ($timeOff['status'] == 'Declined') {
                                                    echo '<span style="color: red; background-color: #ffebee; border: 1px solid red; padding: 5px; border-radius: 3px;">Declined</span>';
                                                } else {
                                                    echo $timeOff['status'];
                                                }
                                                ?>
                                            </p>
                                            <div class="d-flex justify-content-between">
                                                <a href="acceptTimeOff.php?id=<?php echo $timeOff['id']; ?>" class="btn btn-success btn-sm">Approve</a>
                                                <a href="rejectTimeOff.php?id=<?php echo $timeOff['id']; ?>" class="btn btn-danger btn-sm">Reject</a>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>

                                <div class="table-responsive d-none d-md-block">
                                    <table class="table table-striped">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th scope="col">Name</th>
                                                <th scope="col">Start Date</th>
                                                <th scope="col">End Date</th>
                                                <th scope="col">Reason</th>
                                                <th scope="col">Day Type</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($timeOffs as $timeOff) :
                                                $name = User::getUserById($timeOff['userId']);
                                                $name = $name['name'];
                                            ?>
                                                <tr>
                                                    <td class="align-middle"><?php echo ucfirst($name) ?></td>
                                                    <td class="align-middle"><?php echo $timeOff['start_time']; ?></td>
                                                    <td class="align-middle"><?php echo $timeOff['end_time']; ?></td>
                                                    <td class="align-middle"><?php echo ucfirst($timeOff['reason']); ?></td>
                                                    <td class="align-middle"><?php echo $timeOff['day_type']; ?></td>
                                                    <td><?php
                                                        if ($timeOff['status'] == 0) {
                                                            echo '<span style="color: orange; background-color: #fff3e0; border: 1px solid orange; padding: 5px; border-radius: 3px;">Pending</span>';
                                                        } elseif ($timeOff['status'] == 'Accepted') {
                                                            echo '<span style="color: green; background-color: #e0f7fa; border: 1px solid green; padding: 5px; border-radius: 3px;">Accepted</span>';
                                                        } elseif ($timeOff['status'] == 'Declined') {
                                                            echo '<span style="color: red; background-color: #ffebee; border: 1px solid red; padding: 5px; border-radius: 3px;">Declined</span>';
                                                        } else {
                                                            echo $timeOff['status'];
                                                        }
                                                        ?></td>

                                                    <td class="align-middle">
                                                        <a href="acceptTimeOff.php?id=<?php echo $timeOff['id']; ?>" class="btn btn-success btn-sm">Approve</a>
                                                        <a href="rejectTimeOff.php?id=<?php echo $timeOff['id']; ?>" class="btn btn-danger btn-sm">Reject</a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>




                <!-- End of Main Content -->



            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->
    </div>
</body>

<script src="js/script.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</html>