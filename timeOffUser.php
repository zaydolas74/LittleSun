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
            $user_id = $user['id'];
            $location_name = Location::getLocationById($user['location_id']);
            if ($user['type'] == 'Manager') {
                header('location: timeOffManager.php');
            }

            // Time off request
            if (!empty($_POST)) {
                try {
                    $timeOff = new TimeOff();
                    $timeOff->setUserId($user['id']);
                    $timeOff->setStartDate($_POST['start']);
                    $timeOff->setEndDate($_POST['end']);
                    $timeOff->setReason($_POST['reason']);
                    $timeOff->setDay_Type($_POST['day']);
                    $timeOff->save();
                } catch (\Throwable $th) {
                    echo $th->getMessage();
                }
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
                Calander
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
                <a class="nav-link collapsed" href="#">
                    <i class='far fa-calendar-alt'></i>
                    <span>Calander</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->


            <!-- Nav Item - Pages Collapse Menu -->
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
                                <a class="dropdown-item" href="#">TEST</a>
                                <a class="dropdown-item" href="#">TEST</a>
                                <a class="dropdown-item" href="logout.php">Logout</a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid px-5">
                    <div class="">
                        <div class="row flex-wrap justify-content-around">
                        <div class="card shadow col-md-6 mb-4" >
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-dark">Request Time Off</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body" >
                                    <div class="row justify-content-center">
                                        <div class="col-md-11">
                                            <form action="#" method="post">
                                                <div class="form-group">
                                                    <label for="Day"><strong>Day</strong> </label>
                                                    <div class="row justify-content-around mb-3">
                                                        <div class="ml-2 ">
                                                            <input type="radio" name="day" value="Half" id="Half">
                                                            <label for="Half">Half a Day</label>
                                                        </div>
                                                        <div>
                                                            <input type="radio" name="day" value="Full" id="Full">
                                                            <label for="Full">Full Day</label>
                                                        </div>
                                                        <div>
                                                            <input type="radio" name="day" value="More" id="More">
                                                            <label for="More">More Then a Day</label>
                                                        </div>
                                                    </div>
                                                    <div class="row my-2">
                                                        <div class="col">
                                                            <div>
                                                                <label for="start"><strong>Start Date</strong></label>
                                                            </div>
                                                            <div>
                                                                <input type="date" name="start" id="start">
                                                            </div>
                                                        </div>
                                                        <div class="col">
                                                            <div>
                                                                <label for="end"><strong>End Date</strong></label>
                                                            </div>
                                                            <div>
                                                                <input type="date" name="end" id="end">
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="my-4">
                                                        <div>
                                                            <label for="reason"><strong>Reason</strong></label>
                                                        </div>
                                                        <div>
                                                            <select name="reason" id="reason" class="custom-select">
                                                                <option value="vacation">Vacation</option>
                                                                <option value="birthdays">Birthdays</option>
                                                                <option value="maternity">maternity</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex justify-content-center">
                                                        <input type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block btn-lg text-body" style="font-weight: bold;" value="Request">
                                                    </div>
                                                </div>
                                            </form>

                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div class="col-md-4 mb-4">
                            <div class="card shadow call-sick-card">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-dark">Call Sick</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <form>
                                        <div class="form-group">
                                            <label for="sick-date"><strong>Date</strong></label>
                                            <input type="date" class="form-control" id="sick-date" name="sick-date">
                                        </div>
                                        <div class="form-group">
                                            <label for="sick-reason"><strong>Reason</strong></label>
                                            <textarea class="form-control" id="sick-reason" name="sick-reason" rows="3"></textarea>
                                        </div>
                                        <div class="d-flex justify-content-center">
                                                        <input type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block btn-lg text-body" style="font-weight: bold;" value="Request">
                                                    </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                            <div class="card shadow mb-3" style="width: 100%;">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row  align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-dark">Time Off Requests</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        <div class="row justify-content-center">
                                            <div class="col-md-11" style="width: 60vw;">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Start Date</th>
                                                            <th scope="col">End Date</th>
                                                            <th scope="col">Reason</th>
                                                            <th scope="col">Status</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $timeOffs = TimeOff::getAllTimeOffRequests($user_id);
                                                        foreach ($timeOffs as $timeOff) :
                                                        ?>
                                                            <tr>
                                                                <td><?php echo $timeOff['start_time']; ?></td>
                                                                <td><?php echo $timeOff['end_time']; ?></td>
                                                                <td><?php echo $timeOff['reason']; ?></td>
                                                                <td><?php
                                                                    if ($timeOff['status'] == 0) {
                                                                        echo 'Pending';
                                                                    } else {
                                                                        echo 'Approved';
                                                                    }
                                                                    ?></td>
                                                            </tr>
                                                        <?php

                                                        endforeach;
                                                        ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
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

</html>