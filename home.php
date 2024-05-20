<?php
include_once(__DIR__ . '/classes/User.php');
include_once(__DIR__ . '/classes/Location.php');
include_once(__DIR__ . '/classes/ClockTime.php');
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
            if ($user['profile_picture'] == null) {
                $user['profile_picture'] = 'default.jpg';
            } else {
                $profile = $user['profile_picture'];
            }
            if ($user['type'] == 'Admin') {
                $admin = true;
            }
            if ($user['type'] == 'Manager') {
                $manager = true;
            }
        }
    endforeach;
    $clockedOut = true;
    $clockedIn = false;
    if (isset($_POST['clock_in'])) {
        try {
            $clockTime = new ClockTime();
            $clockTime->clockIn($id);
            $clockedIn = true;
            $clockedOut = false;
        } catch (Throwable $ex) {
            $error = $ex->getMessage();
        }
    }
    if (isset($_POST['clock_out'])) {
        try {
            $clockTime = new ClockTime();
            $clockTime->clockOut($id);
            $clockedOut = true;
        } catch (Throwable $ex) {
            $error = $ex->getMessage();
        }
    }
    if (!empty($_POST)) {
        try {
            if (isset($_POST['password']) && isset($_POST['rpassword'])) {
                if ($_POST['password'] !== $_POST['rpassword']) {
                    throw new Exception("The passwords do not match.");
                } else {
                    $user = new User();
                    $options = [
                        'cost' => 12,
                    ];
                    $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT, $options);
                    $user->setName($_POST['name']);
                    $user->setUsername($_POST['username']);
                    $user->setEmail($_POST['email']);
                    $user->setPassword($hashedPassword);
                    $user->setLocation_id($_POST['hub_location']);
                    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
                        $uploadDir = __DIR__ . '/images/';
                        $uploadFile = $uploadDir . basename($_FILES['photo']['name']);

                        // Unieke identifier aan de bestandsnaam om conflicten te voorkomen
                        $uniqueFileName = uniqid() . '_' . basename($_FILES['photo']['name']);
                        $uploadFile = $uploadDir . $uniqueFileName;

                        if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
                            // Unieke bestandsnaam opgeslagen in de database
                            $user->setPhoto($uniqueFileName);
                        } else {
                            throw new Exception("Failed to move uploaded file.");
                        }
                    }
                    $user->saveManager();
                }
            }
        } catch (Throwable $ex) {
            $error = $ex->getMessage();
        }
    }
    if (!empty($_POST)) {
        try {
            if (isset($_POST['passwordUser']) && isset($_POST['rpasswordUser'])) {
                if ($_POST['passwordUser'] !== $_POST['rpasswordUser']) {
                    throw new Exception("The passwords do not match.");
                } else {
                    $user = new User();
                    $options = [
                        'cost' => 12,
                    ];
                    $hashedPassword = password_hash($_POST['passwordUser'], PASSWORD_DEFAULT, $options);
                    $user->setName($_POST['nameUser']);
                    $user->setUsername($_POST['userName']);
                    $user->setEmail($_POST['emailUser']);
                    $user->setPassword($hashedPassword);
                    $user->setLocation_id($location_name['id']);
                    if (isset($_FILES['photoUser']) && $_FILES['photoUser']['error'] === UPLOAD_ERR_OK) {
                        $uploadDir = __DIR__ . '/images/';
                        $uploadFile = $uploadDir . basename($_FILES['photoUser']['name']);

                        // Unieke identifier aan de bestandsnaam om conflicten te voorkomen
                        $uniqueFileName = uniqid() . '_' . basename($_FILES['photoUser']['name']);
                        $uploadFile = $uploadDir . $uniqueFileName;

                        if (move_uploaded_file($_FILES['photoUser']['tmp_name'], $uploadFile)) {
                            // Unieke bestandsnaam opgeslagen in de database
                            $user->setPhoto($uniqueFileName);
                        } else {
                            throw new Exception("Failed to move uploaded file.");
                        }
                    }
                    $user->save();
                }
            }
        } catch (Throwable $ex) {
            $error = $ex->getMessage();
        }
    }
    if (!empty($_POST)) {
        try {
            $location = new Location();
            if (isset($_POST['location'])) {
                $location->setHub_location($_POST['location']);
                if (isset($_POST['add'])) {
                    $location->addLocation();
                } elseif (isset($_POST['remove'])) {
                    $location->removeLocation();
                }
            }
        } catch (Throwable $ex) {
            $error = $ex->getMessage();
        }
    }
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


        <!-- Heading -->
        <?php if ($admin == false) { ?>
            <hr class="sidebar-divider">
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
        <?php } ?>

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



        <!-- Divider -->
        <?php if ($admin == true) { ?>
            <div class="sidebar-heading">
                Admin Tools
            </div>
            <li class="nav-item">
                <a class="nav-link collapsed" href="taskTypes.php">
                    <i class='far fa-clock'></i>
                    <span>Task types</span>
                </a>
            </li>
        <?php }  ?>

        <?php if ($admin == false && $manager == false) { ?>
            <div class="sidebar-heading">
                User Tools
            </div>
            <li class="nav-item">
                <a class="nav-link collapsed" href="userTask.php">
                    <i class="fas fa-tasks"></i>
                    <span>My Task</span>
                </a>
            </li>
        <?php }  ?>

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
                            <img class="img-profile rounded-circle mx-2" src="images/<?php echo $profile; ?>">
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
                <?php
                if ($manager == true || $admin == true) :
                ?>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-dark">Add a hub manager</h6>
                        </div>
                        <div class="card-body">
                            <form action="" class="mx-1 mx-md-4" method="post" enctype="multipart/form-data">

                                <div class="d-flex flex-row align-items-center mb-4">
                                    <div data-mdb-input-init class="form-outline flex-fill mb-0">
                                        <label class="form-label" for="form3Example1c">Name</label>
                                        <input type="text" id="form3Example1c" name="name" class="form-control" />
                                    </div>
                                </div>

                                <div class="d-flex flex-row align-items-center mb-4">
                                    <div data-mdb-input-init class="form-outline flex-fill mb-0">
                                        <label class="form-label" for="form3Example1c">Username</label>
                                        <input type="text" id="form3Example1c" name="username" class="form-control" />
                                    </div>
                                </div>

                                <div class="d-flex flex-row align-items-center mb-4">
                                    <div data-mdb-input-init class="form-outline flex-fill mb-0">
                                        <label class="form-label" for="form3Example3c">Email</label>
                                        <input type="email" id="form3Example3c" name="email" class="form-control" />
                                    </div>
                                </div>
                                <?php
                                // if (isset($error)) {
                                //     echo "<div class='alert alert-danger' role='alert'>$error</div>";
                                // }
                                ?>
                                <div class="d-flex flex-row align-items-center mb-4">
                                    <div data-mdb-input-init class="form-outline flex-fill mb-0">
                                        <label class="form-label" for="form3Example4c">Password</label>
                                        <input type="password" id="form3Example4c" name="password" class="form-control" />
                                    </div>
                                </div>

                                <div class="d-flex flex-row align-items-center mb-4 ">
                                    <div data-mdb-input-init class="form-outline flex-fill mb-0">
                                        <label class="form-label" for="form3Example4cd">Repeat Password</label>
                                        <input type="password" id="form3Example4cd" name="rpassword" class="form-control" />
                                    </div>
                                </div>

                                <div class="d-flex flex-row align-items-center mb-4 ">
                                    <div data-mdb-input-init class="form-outline flex-fill mb-0">
                                        <label class="form-label" for="form3Example4cd">Hub Location nr</label>
                                        <input type="password" id="form3Example4cd" name="hub_location" class="form-control" />
                                    </div>
                                </div>

                                <div class="d-flex flex-row align-items-center mb-4">
                                    <div class="form-outline flex-fill mb-0">
                                        <label class="form-label" for="formFile">Upload Profile Picture</label>
                                        <input class="form-control" type="file" id="formFile" name="photo">
                                    </div>
                                </div>

                                <div class="d-flex justify-content-start">
                                    <input type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary px-5" style="font-weight: bold;" value="Add">
                                </div>
                            </form>
                        </div>

                    </div>
                <?php endif; ?>
                <div class="row mx-1 justify-content-between">
                    <?php
                    if ($admin == true) :
                    ?>
                        <div class="col-xl-4 col-lg-5 mr-4" style="padding: 0;">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3">
                                    <h6 class="m-0 font-weight-bold text-dark">Add a hub location</h6>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="row justify-content-center">
                                        <div class="col-md-8">
                                            <form action="" class="mx-1 mx-md-4" method="post">

                                                <div class="d-flex flex-row align-items-center mb-4">
                                                    <div data-mdb-input-init class="form-outline flex-fill mb-0">
                                                        <label class="form-label" for="form3Example1c">Location Name</label>
                                                        <input type="text" id="form3Example1c" name="location" class="form-control" />
                                                    </div>
                                                </div>

                                                <div class="d-flex justify-content-center mb-2">
                                                    <input type="submit" name="add" data-mdb-button-init data-mdb-ripple-i nit class="btn btn-primary btn-block btn-lg text-body" style="font-weight: bold;" value="Add">
                                                </div>
                                                <div class="d-flex justify-content-center mb-2">
                                                    <input type="submit" name="remove" data-mdb-button-init data-mdb-ripple-init class="btn btn-danger btn-block btn-lg text-white" style="font-weight: bold;" value="Remove">
                                                </div>

                                            </form>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="col-xl col-lg" style="padding: 0;">
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-dark">Hub Locations</h6>
                            </div>
                            <div class="card-body">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th scope="col">Location Name</th>
                                            <th scope="col">Hub ID</th>
                                        </tr>
                                    </thead>
                                    <?php
                                    $locations = Location::getAllLocations();
                                    foreach ($locations as $location) :
                                    ?>

                                        <tbody>
                                            <tr>
                                                <td><?php echo $location['location_name'] ?></td>
                                                <td><?php echo $location['id'] ?></td>
                                            </tr>
                                        </tbody>
                                    <?php endforeach; ?>
                                </table>
                            </div>
                        </div>
                        <?php
                        if ($manager == false && $admin == false) {
                        ?>
                            <div class="col-lg-6 mb-4 px-0">
                                <div class="card shadow mb-4">
                                    <div class="card-header py-3">
                                        <h6 class="m-0 font-weight-bold text-primary">Clock In/Out</h6>
                                    </div>
                                    <div class="card-body">
                                        <form method="post">
                                            <?php if ($clockedOut) : ?>
                                                <button type="submit" name="clock_in" class="btn btn-primary btn-block">
                                                    <i class="fas fa-3x fa-clock mb-2"></i><br>Clock In
                                                </button>
                                            <?php endif; ?>
                                            <?php if ($clockedIn) : ?>
                                                <button type="submit" name="clock_out" class="btn btn-danger btn-block">
                                                    <i class="fas fa-3x fa-coffee mb-2"></i><br>Clock Out
                                                </button>
                                            <?php endif; ?>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="popup" id="clockPopup">
                            <i class="fas fa-check-circle"></i>
                            <div id="clockPopupText"></div>
                        </div>
                        <div class="col-lg-6 mb-4">

                        </div>

                    </div>
                </div>

                <!-- End of Main Content -->



            </div>
            <!-- End of Content Wrapper -->

        </div>
        <!-- End of Page Wrapper -->
    </div>
</div>

<!-- End of Page Wrapper -->

<!-- <script src="js/showPopup.js"></script> -->
<script src="js/script.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</head>