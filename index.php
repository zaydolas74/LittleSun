<?php include_once 'bootstrap.php'; ?>
<nav class="navbar navbar-light bg-dark py-3">
    <div class="container justify-content-center">
        <a class="navbar-brand" href="#">
            <img src="images/Little-Sun-Logo.png" alt="" height="35">
        </a>
    </div>
</nav>
<section class="py-5">
    <div class="px-4 py-5 px-md-5  text-lg-start">
        <div class="container">
            <div class="row gx-lg-5 align-items-center">
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <h1 class="mb-5 display-4 ls-tight">
                        Welcome to <span class="text-primary" style="font-weight: bold;">Little Sun</span> shiftplanner
                    </h1>
                    <p style="color: hsl(217, 10%, 50.8%)">

                        Welcome to Little Sun Shiftplaner, the ultimate platform for shift planners in Zambia! At Little Sun Shiftpaner, we empower workers to take control of their schedules by defining their roles and selecting preferred work locations. Our user-friendly interface allows workers to plan their availability for shifts and even schedule well-deserved vacations with ease.
                    </p>
                </div>

                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="card">
                        <div class="card-body py-4 px-5">
                            <form>
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <label class="form-label" for="form3Example3">Email address</label>
                                    <input type="email" id="form3Example3" class="form-control" />
                                </div>
                                <div data-mdb-input-init class="form-outline mb-4">
                                    <label class="form-label" for="form3Example4">Password</label>
                                    <input type="password" id="form3Example4" class="form-control" />
                                </div>
                                <button type="submit" data-mdb-button-init data-mdb-ripple-init class="btn btn-primary btn-block w-100">
                                    <span style="font-weight: bold;">Sign in</span>
                                </button>
                            </form>
                        </div>
                        <div class="card-footer py-3 flex-column align-items-center justify-content-center">
                            <div class="text-center ">
                                <a href="#">
                                    <p style="font-weight: bold; margin:0;">Forgot password?</p>
                                </a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
</section>

<script>
    //go to home page after submitting the form
    document.querySelector('form').addEventListener('submit', function(e) {
        e.preventDefault();
        window.location.href = 'home.php';
    });
</script>

</body>
</head>