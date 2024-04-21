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

                                <form class="mx-1 mx-md-4">

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <div data-mdb-input-init class="form-outline flex-fill mb-0">

                                            <label class="form-label" for="Name">Name</label>
                                            <input type="text" id="Name" class="form-control" />
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <div data-mdb-input-init class="form-outline flex-fill mb-0">

                                            <label class="form-label" for="Username">Username</label>
                                            <input type="text" id="Username" class="form-control" name="Username" />
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">
                                        <div data-mdb-input-init class="form-outline flex-fill mb-0">

                                            <label class="form-label" for="Email">Email</label>
                                            <input type="email" id="Email" class="form-control" name="Email" />
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4">

                                        <div data-mdb-input-init class="form-outline flex-fill mb-0">

                                            <label class="form-label" for="Password">Password</label>
                                            <input type="password" id="Password" class="form-control" name="Password" />
                                        </div>
                                    </div>

                                    <div class="d-flex flex-row align-items-center mb-4 ">
                                        <div data-mdb-input-init class="form-outline flex-fill mb-0">

                                            <label class="form-label" for="Password2">Repeat your password</label>
                                            <input type="password" id="Password2" class="form-control" name="Password2" />
                                        </div>
                                    </div>


                                    <div class="d-flex justify-content-center">
                                        <button type="button" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block btn-lg text-body" style="font-weight: bold;">Register</button>
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