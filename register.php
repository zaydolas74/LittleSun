<?php
include_once(__DIR__ . "/classes/User.php");
if (!empty($_POST)) {
    try {
        if ($_POST['password'] !== $_POST['rpassword']) {
            throw new Exception("The passwords do not match.");
        } else if (empty($_POST['name']) || empty($_POST['username']) || empty($_POST['email']) || empty($_POST['password'])) {
            throw new Exception("Please fill in all fields.");
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
            $user->save();
            session_start();
            $_SESSION['user'] = $user;
            header('Location: home.php');
        }
    } catch (Throwable $ex) {
        $error = $ex->getMessage();
    }
}
?>
<?php include_once 'bootstrap.php'; ?>
<nav class="navbar navbar-light bg-dark py-3">
    <div class="container justify-content-center">
        <a class="navbar-brand" href="index.php">
            <img src="images/Little-Sun-Logo.png" alt="" height="35">
        </a>
    </div>
</nav>
<section class="py-5">
    <div class="container h-100">
        <div class="row d-flex justify-content-center align-items-center h-100 ">
            <div class="col-lg-10 col-xl-8 ">
                <div class="card text-black shadow" style="border-radius: 25px;">
                    <div class="card-body p-md-5">
                        <div class="row justify-content-center">

                            <div class="col-md-8">

                                <p class="text-center h1 fw-bold mb-5 mx-1 mx-md-4 mt-4">Create Account</p>

                                <form action="" class="mx-1 mx-md-4" method="post">
                                    <?php
                                    if (isset($error)) {
                                        echo "<div class='alert alert-danger' role='alert'>$error</div>";
                                    }
                                    ?>
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
                                            <label class="form-label" for="form3Example4cd">Repeat your password</label>
                                            <input type="password" id="form3Example4cd" name="rpassword" class="form-control" />
                                        </div>
                                    </div>


                                    <div class="d-flex justify-content-center">
                                        <input type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block btn-lg text-body" style="font-weight: bold;" value="Register">
                                    </div>
                                </form>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
</body>
</head>