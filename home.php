<?php include_once 'bootstrap.php'; ?>

<?php

// If upload button is clicked ...
$uploadOk = 1;

//Dit werkt nu moet gy proberen omda naar de database te sturen
if (!empty($_POST)) {

    if (empty($_POST['Name']) || empty($_POST['Email']) || empty($_POST['Password']) || empty($_FILES['profilePic'])) {
        $uploadOk = 0;
    } else {
        $Name = $_POST['Name'];
        $Email = $_POST['Email'];
        $Password = $_POST['Password'];
        $UserType = $_POST['UserType'];
        $filename = $_FILES["profilePic"]["name"];
        $tempname = $_FILES["profilePic"]["tmp_name"];
        $folder = "images/" . $filename;

        if ($_FILES["profilePic"]["size"] > 500000) {
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
        } else if (move_uploaded_file($tempname, $folder)) {
        }
    }
}
?>

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
            <a class="nav-link" href="index.html">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            TEST
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
                <i class="fas fa-fw fa-cog"></i>
                <span>TEST</span>
            </a>
            <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Custom Components:</h6>
                    <a class="collapse-item" href="buttons.html">Buttons</a>
                    <a class="collapse-item" href="cards.html">Cards</a>
                </div>
            </div>
        </li>

        <!-- Nav Item - Utilities Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities" aria-expanded="true" aria-controls="collapseUtilities">
                <i class="fas fa-fw fa-wrench"></i>
                <span>TEST</span>
            </a>
        </li>

        <!-- Divider -->
        <hr class="sidebar-divider">

        <!-- Heading -->
        <div class="sidebar-heading">
            TEST
        </div>

        <!-- Nav Item - Pages Collapse Menu -->
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages" aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-fw fa-folder"></i>
                <span>TEST</span>
            </a>
        </li>

        <!-- Nav Item - Charts -->
        <li class="nav-item">
            <a class="nav-link" href="charts.html">
                <i class="fas fa-fw fa-chart-area"></i>
                <span>TEST</span></a>
        </li>

        <!-- Nav Item - Tables -->
        <li class="nav-item">
            <a class="nav-link" href="tables.html">
                <i class="fas fa-fw fa-table"></i>
                <span>TEST</span></a>
        </li>




    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">


                <!-- Topbar Search -->
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

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">
                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img class="img-profile rounded-circle mx-2" src="images/profile.jpg">
                            <div class="container flex-column  align-items-start">
                                <span class="small">
                                    <?php

                                    ?>
                                    admin
                                </span>
                                <span class="mr-2 d-none d-lg-inline text-dark ">Joris Hens</span>
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
            <div class="container-fluid">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-dark">Create Manager</h6>
                    </div>
                    <div class="card-body">
                        <form class="mx-1 mx-md-4" action="" method="POST" enctype="multipart/form-data">
                            <div class="form-group ">
                                <label for="Name">Name</label>
                                <input type="text" class="form-control" id="Name" name="Name" required>
                            </div>
                            <div class="form-group">
                                <label for="Email">Email</label>
                                <input type="email" class="form-control" id="Email" aria-describedby="emailHelp" name="Email" required>
                            </div>
                            <div class="form-group">
                                <label for="Password">Password</label>
                                <input type="password" class="form-control" id="Password" name="Password" required>
                            </div>
                            <div class="form-group">
                                <label for="profilePic">Profile picture</label>
                                <label for="profilePic" id="label-profile-pic" class=" btn btn-primary">
                                    Add picture
                                </label>
                                <input type="file" accept="image/jpeg, image/png, image/jpg" id="profilePic" name="profilePic" required>
                            </div>
                            <div class="form-group">
                                <label for="UserType">User Type</label>
                                <select class="custom-select" id="UserType" name="UserType" required>
                                    <option value="User">User</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Manager">Manager</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary px-4"><strong>Submit</strong></button>
                        </form>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-dark">Create Location</h6>
                    </div>
                    <h1> IK WEET NIET WAT ER HIER ALLEMAAL IN MOET MAAR GY KAN DA MAKKELIJK AANPASSEN</h1>
                    <div class="card-body">
                        <form class="mx-1 mx-md-4" action="" method="POST">
                            <div class="form-group">
                                <label for="Name">Name</label>
                                <input type="text" class="form-control" id="Name" required>
                            </div>
                            <div class="form-group">
                                <label for="Email">Email</label>
                                <input type="email" class="form-control" id="Email" required>
                            </div>
                            <div class="form-group">
                                <label for="Password">Password</label>
                                <input type="password" class="form-control" id="Password" required>
                            </div>
                            <div class="form-group">
                                <label for="UserType">User Type</label>
                                <select class="custom-select" id="UserType">
                                    <option value="User">User</option>
                                    <option value="Admin">Admin</option>
                                    <option value="Manager">Manager</option>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-dark">Location Hub</h6>
                    </div>
                    <div class="card-body">
                        <h1>Huidige Locatiehubs</h1>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Locatie</th>
                                        <th>Adres</th>
                                        <th>Aantal gebruikers</th>
                                        <th>Actie</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Locatie 1</td>
                                        <td>Adres 1</td>
                                        <td>10</td>
                                        <td>
                                            <button class="btn btn-danger">
                                                <i class="fas fa-trash"></i> Verwijderen
                                            </button>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>Locatie 2</td>
                                        <td>Adres 2</td>
                                        <td>15</td>
                                        <td>
                                            <button class="btn btn-danger">
                                                <i class="fas fa-trash"></i> Verwijderen
                                            </button>
                                        </td>
                                    </tr>
                                    <!-- Voeg hier meer rijen toe voor andere locaties -->
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
            <!-- End of Main Content -->



        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->


    <script src="js/script.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
    </head>