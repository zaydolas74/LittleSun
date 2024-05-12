<?php
include_once(__DIR__ . '/classes/User.php');
include_once(__DIR__ . '/classes/Location.php');
include_once(__DIR__ . '/classes/ClockTime.php');
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
            }
            if ($user['type'] == 'Manager') {
                $manager = true;
            }
        }
    endforeach;
    $clockedOut = true;
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
        } catch (Throwable $ex) {
            $error = $ex->getMessage();
        }
    }
    if (!empty($_POST)) {
        try {
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
        } catch (Throwable $ex) {
            $error = $ex->getMessage();
        }
    }
    if (!empty($_POST)) {
        try {
            $location = new Location();
            $location->setHub_location($_POST['location']);
            if (isset($_POST['add'])) {
                $location->addLocation();
            } elseif (isset($_POST['remove'])) {
                $location->removeLocation();
            }
        } catch (Throwable $ex) {
            $error = $ex->getMessage();
        }
    }
}
?>
<?php include_once 'bootstrap.php'; ?>

<?php
include_once(__DIR__ . '/classes/User.php');
include_once(__DIR__ . '/classes/Location.php');

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
            $location_name = Location::getLocationById($user['location_id']);
            if ($user['type'] == 'Admin') {
                $admin = true;
            }
            if ($user['type'] == 'Manager') {
                $manager = true;
            }
        }
    endforeach;
    if (!empty($_POST)) {
        try {
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
        } catch (Throwable $ex) {
            $error = $ex->getMessage();
        }
    }
    if (!empty($_POST)) {
        try {
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
        } catch (Throwable $ex) {
            $error = $ex->getMessage();
        }
    }
    if (!empty($_POST)) {
        try {
            $location = new Location();
            $location->setHub_location($_POST['location']);
            if (isset($_POST['add'])) {
                $location->addLocation();
                header("Refresh:0");
            } elseif (isset($_POST['remove'])) {
                $location->removeLocation();
                header("Refresh:0");
            }
        } catch (Throwable $ex) {
            $error = $ex->getMessage();
        }
    }
}

?>

<!-- Page Wrapper -->
<div id="wrapper">
<<<<<<< HEAD
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/popup.css">
=======

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
            <a class="nav-link collapsed" href="calender.php">
                <i class='far fa-calendar-alt'></i>
                <span>Calender</span>
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

>>>>>>> 1b71aaafc9125ee132aefef79598b8f4fcfb0e50
    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">


<<<<<<< HEAD


                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                    <li class="nav-item dropdown no-arrow d-sm-none">
                        <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-search fa-fw"></i>
                        </a>
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                            <form class="form-inline mr-auto w-100 navbar-search">
                                <div class="input-group">
                                    <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" type="button">
                                            <i class="fas fa-search fa-sm"></i>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </li>

                    <!-- Nav Item - Alerts -->
                    <li class="nav-item dropdown no-arrow mx-1">
                        <?php if ($manager == true) : ?>
                            <a class="nav-link" href="hub.php">
                                <!-- Counter - Alerts -->
                                <span class="badge badge-danger badge-counter">hub</span>
                            </a>
                        <?php endif; ?>
                        <!-- Dropdown - Alerts -->
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="alertsDropdown">
                            <h6 class="dropdown-header">
                                Alerts Center
                            </h6>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-primary">
                                        <i class="fas fa-file-alt text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 12, 2019</div>
                                    <span class="font-weight-bold">A new monthly report is ready to download!</span>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-success">
                                        <i class="fas fa-donate text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 7, 2019</div>
                                    $290.29 has been deposited into your account!
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="mr-3">
                                    <div class="icon-circle bg-warning">
                                        <i class="fas fa-exclamation-triangle text-white"></i>
                                    </div>
                                </div>
                                <div>
                                    <div class="small text-gray-500">December 2, 2019</div>
                                    Spending Alert: We've noticed unusually high spending for your account.
                                </div>
                            </a>
                            <a class="dropdown-item text-center small text-gray-500" href="#">Show All Alerts</a>
                        </div>
                    </li>

                    <!-- Nav Item - Messages -->
                    <li class="nav-item dropdown no-arrow mx-1">
                        <!-- Dropdown - Messages -->
                        <div class="dropdown-list dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="messagesDropdown">
                            <h6 class="dropdown-header">
                                Message Center
                            </h6>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="img/undraw_profile_1.svg" alt="...">
                                    <div class="status-indicator bg-success"></div>
                                </div>
                                <div class="font-weight-bold">
                                    <div class="text-truncate">Hi there! I am wondering if you can help me with a
                                        problem I've been having.</div>
                                    <div class="small text-gray-500">Emily Fowler · 58m</div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="img/undraw_profile_2.svg" alt="...">
                                    <div class="status-indicator"></div>
                                </div>
                                <div>
                                    <div class="text-truncate">I have the photos that you ordered last month, how
                                        would you like them sent to you?</div>
                                    <div class="small text-gray-500">Jae Chun · 1d</div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="img/undraw_profile_3.svg" alt="...">
                                    <div class="status-indicator bg-warning"></div>
                                </div>
                                <div>
                                    <div class="text-truncate">Last month's report looks great, I am very happy with
                                        the progress so far, keep up the good work!</div>
                                    <div class="small text-gray-500">Morgan Alvarez · 2d</div>
                                </div>
                            </a>
                            <a class="dropdown-item d-flex align-items-center" href="#">
                                <div class="dropdown-list-image mr-3">
                                    <img class="rounded-circle" src="https://source.unsplash.com/Mv9hjnEUHR4/60x60" alt="...">
                                    <div class="status-indicator bg-success"></div>
                                </div>
                                <div>
                                    <div class="text-truncate">Am I a good boy? The reason I ask is because someone
                                        told me that people say this to all dogs, even if they aren't good...</div>
                                    <div class="small text-gray-500">Chicken the Dog · 2w</div>
                                </div>
                            </a>
                            <a class="dropdown-item text-center small text-gray-500" href="#">Read More Messages</a>
                        </div>
                    </li>

                    <a href="logout.php" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm d-sm-flex align-items-center justify-content-between"> Log out</a>
                    <div class="topbar-divider d-none d-sm-block"></div>
                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?php
                            if ($admin == true) {
                                echo '<span class="mr-1 d-none d-lg-inline text-gray-600 small">🛡️</span>';
                            }
                            ?>
                            <?php
                            if ($manager == true) {
                                echo '<span class="mr-1 d-none d-lg-inline text-gray-600 small">💼</span>';
                            }
                            ?>
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $username; ?></span>

                            <!-- todo image profile pic -->
                            <img class="img-profile rounded-circle" src="">
=======
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

>>>>>>> 1b71aaafc9125ee132aefef79598b8f4fcfb0e50
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

<<<<<<< HEAD
                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
                </div>

                <?php
                if ($admin == true) :
                ?>
                    <div class="row">
                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Add a hub manager</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area">
                                        <div class="row justify-content-center">
                                            <div class="col-md-8">
                                                <form action="" class="mx-1 mx-md-4" method="post" enctype="multipart/form-data">

                                                    <div class="d-flex flex-row align-items-center mb-4">
                                                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                                        <div data-mdb-input-init class="form-outline flex-fill mb-0">
                                                            <label class="form-label" for="form3Example1c">Name</label>
                                                            <input type="text" id="form3Example1c" name="name" class="form-control" />
                                                        </div>
                                                    </div>

                                                    <div class="d-flex flex-row align-items-center mb-4">
                                                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                                        <div data-mdb-input-init class="form-outline flex-fill mb-0">
                                                            <label class="form-label" for="form3Example1c">Username</label>
                                                            <input type="text" id="form3Example1c" name="username" class="form-control" />
                                                        </div>
                                                    </div>

                                                    <div class="d-flex flex-row align-items-center mb-4">
                                                        <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
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
                                                        <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                                        <div data-mdb-input-init class="form-outline flex-fill mb-0">
                                                            <label class="form-label" for="form3Example4c">Password</label>
                                                            <input type="password" id="form3Example4c" name="password" class="form-control" />
                                                        </div>
                                                    </div>

                                                    <div class="d-flex flex-row align-items-center mb-4 ">
                                                        <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                                        <div data-mdb-input-init class="form-outline flex-fill mb-0">
                                                            <label class="form-label" for="form3Example4cd">Repeat Password</label>
                                                            <input type="password" id="form3Example4cd" name="rpassword" class="form-control" />
                                                        </div>
                                                    </div>

                                                    <div class="d-flex flex-row align-items-center mb-4 ">
                                                        <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                                        <div data-mdb-input-init class="form-outline flex-fill mb-0">
                                                            <label class="form-label" for="form3Example4cd">Hub Location nr</label>
                                                            <input type="password" id="form3Example4cd" name="hub_location" class="form-control" />
                                                        </div>
                                                    </div>

                                                    <div class="d-flex flex-row align-items-center mb-4">
                                                        <i class="fas fa-upload fa-lg me-3 fa-fw"></i>
                                                        <div class="form-outline flex-fill mb-0">
                                                            <label class="form-label" for="formFile">Upload Profile Picture</label>
                                                            <input class="form-control" type="file" id="formFile" name="photo">
                                                        </div>
                                                    </div>

                                                    <div class="d-flex justify-content-center">
                                                        <input type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block btn-lg text-body" style="font-weight: bold;" value="Add">
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pie Chart -->
                        <div class="col-xl-4 col-lg-5">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Add a hub location</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
=======
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

>>>>>>> 1b71aaafc9125ee132aefef79598b8f4fcfb0e50
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-pie pt-4 pb-2">
                                        <div class="row justify-content-center">
                                            <div class="col-md-8">
                                                <form action="" class="mx-1 mx-md-4" method="post">

                                                    <div class="d-flex flex-row align-items-center mb-4">
                                                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
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
                        </div>
<<<<<<< HEAD
                    </div>
                <?php endif; ?>
                <?php
                if ($manager == true) :
                ?>
                    <div class="row">
                        <!-- Area Chart -->
                        <div class="col-xl-8 col-lg-7">
                            <div class="card shadow mb-4">
                                <!-- Card Header - Dropdown -->
                                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                    <h6 class="m-0 font-weight-bold text-primary">Add User</h6>
                                    <div class="dropdown no-arrow">
                                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                                            <div class="dropdown-header">Dropdown Header:</div>
                                            <a class="dropdown-item" href="#">Action</a>
                                            <a class="dropdown-item" href="#">Another action</a>
                                            <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="#">Something else here</a>
                                        </div>
                                    </div>
                                </div>
                                <!-- Card Body -->
                                <div class="card-body">
                                    <div class="chart-area">
                                        <div class="row justify-content-center">
                                            <div class="col-md-8">
                                                <form action="" class="mx-1 mx-md-4" method="post" enctype="multipart/form-data">

                                                    <div class="d-flex flex-row align-items-center mb-4">
                                                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                                        <div data-mdb-input-init class="form-outline flex-fill mb-0">
                                                            <label class="form-label" for="form3Example1c">Name</label>
                                                            <input type="text" id="form3Example1c" name="nameUser" class="form-control" />
                                                        </div>
                                                    </div>

                                                    <div class="d-flex flex-row align-items-center mb-4">
                                                        <i class="fas fa-user fa-lg me-3 fa-fw"></i>
                                                        <div data-mdb-input-init class="form-outline flex-fill mb-0">
                                                            <label class="form-label" for="form3Example1c">Username</label>
                                                            <input type="text" id="form3Example1c" name="userName" class="form-control" />
                                                        </div>
                                                    </div>

                                                    <div class="d-flex flex-row align-items-center mb-4">
                                                        <i class="fas fa-envelope fa-lg me-3 fa-fw"></i>
                                                        <div data-mdb-input-init class="form-outline flex-fill mb-0">
                                                            <label class="form-label" for="form3Example3c">Email</label>
                                                            <input type="email" id="form3Example3c" name="emailUser" class="form-control" />
                                                        </div>
                                                    </div>
                                                    <?php
                                                    // if (isset($error)) {
                                                    //     echo "<div class='alert alert-danger' role='alert'>$error</div>";
                                                    // }
                                                    ?>
                                                    <div class="d-flex flex-row align-items-center mb-4">
                                                        <i class="fas fa-lock fa-lg me-3 fa-fw"></i>
                                                        <div data-mdb-input-init class="form-outline flex-fill mb-0">
                                                            <label class="form-label" for="form3Example4c">Password</label>
                                                            <input type="password" id="form3Example4c" name="passwordUser" class="form-control" />
                                                        </div>
                                                    </div>

                                                    <div class="d-flex flex-row align-items-center mb-4 ">
                                                        <i class="fas fa-key fa-lg me-3 fa-fw"></i>
                                                        <div data-mdb-input-init class="form-outline flex-fill mb-0">
                                                            <label class="form-label" for="form3Example4cd">Repeat Password</label>
                                                            <input type="password" id="form3Example4cd" name="rpasswordUser" class="form-control" />
                                                        </div>
                                                    </div>

                                                    <div class="d-flex flex-row align-items-center mb-4">
                                                        <i class="fas fa-upload fa-lg me-3 fa-fw"></i>
                                                        <div class="form-outline flex-fill mb-0">
                                                            <label class="form-label" for="formFile">Upload Profile Picture</label>
                                                            <input class="form-control" type="file" id="formFile" name="photoUser">
                                                        </div>
                                                    </div>

                                                    <div class="d-flex justify-content-center">
                                                        <input type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block btn-lg text-body" style="font-weight: bold;" value="Add">
                                                    </div>
                                                </form>

                                            </div>
                                        </div>
                                    </div>
                                </div>
=======
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
>>>>>>> 1b71aaafc9125ee132aefef79598b8f4fcfb0e50
                            </div>
                        </div>


                    </div>
<<<<<<< HEAD
                <?php endif; ?>

                <!-- Content Row -->
                <div class="row">

                    <!-- Content Column -->
                    <div class="col-lg-6 mb-4">
                        <!-- Project Card Example -->
                        <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Hub Locations</h6>
                            </div>
                            <div class="card-body">
                                <?php
                                $locations = Location::getAllLocations();
                                foreach ($locations as $location) :
                                ?>
                                    <h4 class="small font-weight-bold"><?php echo $location['location_name']; ?><span class="float-right">Hub: <?php echo $location['id']; ?></span></h4>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 mb-4">
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
                    <div class="popup" id="clockPopup">
                        <i class="fas fa-check-circle"></i>
                        <div id="clockPopupText"></div>
                    </div>
                    <script src="js/showPopup.js"></script>
                    <div class="col-lg-6 mb-4">

                        <!-- Illustrations -->
                        <!-- <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Illustrations</h6>
                            </div>
                            <div class="card-body">
                                <div class="text-center">
                                    <img class="img-fluid px-3 px-sm-4 mt-3 mb-4" style="width: 25rem;" src="img/undraw_posting_photo.svg" alt="...">
                                </div>
                                <p>Add some quality, svg illustrations to your project courtesy of <a target="_blank" rel="nofollow" href="https://undraw.co/">unDraw</a>, a
                                    constantly updated collection of beautiful svg images that you can use
                                    completely free and without attribution!</p>
                                <a target="_blank" rel="nofollow" href="https://undraw.co/">Browse Illustrations on
                                    unDraw &rarr;</a>
                            </div>
                        </div> -->

                        <!-- Approach -->
                        <!-- <div class="card shadow mb-4">
                            <div class="card-header py-3">
                                <h6 class="m-0 font-weight-bold text-primary">Development Approach</h6>
                            </div>
                            <div class="card-body">
                                <p>SB Admin 2 makes extensive use of Bootstrap 4 utility classes in order to reduce
                                    CSS bloat and poor page performance. Custom CSS classes are used to create
                                    custom components and custom utility classes.</p>
                                <p class="mb-0">Before working with this theme, you should become familiar with the
                                    Bootstrap framework, especially the utility classes.</p>
                            </div>
                        </div> -->

                    </div>
                </div>

=======
                </div>
>>>>>>> 1b71aaafc9125ee132aefef79598b8f4fcfb0e50
            </div>
            <!-- End of Main Content -->



        </div>
<<<<<<< HEAD
        <!-- End of Main Content -->

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span>Copyright &copy; LittleSun 2024</span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->

    </div>
    <!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->


<!-- Logout Modal-->
<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
            <div class="modal-footer">
                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                <a class="btn btn-primary" href="login.html">Logout</a>
            </div>
        </div>
    </div>
=======
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
>>>>>>> 1b71aaafc9125ee132aefef79598b8f4fcfb0e50
</div>

<script src="js/script.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</head>