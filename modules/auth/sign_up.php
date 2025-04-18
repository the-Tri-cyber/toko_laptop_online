<?php
session_start();

$error_message = isset($_SESSION['error']) ? $_SESSION['error'] : '';
unset($_SESSION['error']);
$success_message = isset($_SESSION['success']) ? $_SESSION['success'] : '';
unset($_SESSION['success']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../bootstrap-5/css/bootstrap.min.css">
    <title>Login</title>
</head>

<body class="bg-col">
    <section class="vh-100 gradient-custom">
        <div class="container py-5 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-12 col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-dark text-white" style="border-radius: 1rem;">
                        <div class="card-body p-5 text-center">

                            <form class="mb-md-5 mt-md-4 pb-3" action="sign_up_proses.php" method="POST">

                                <h2 class="fw-bold mb-2 text-uppercase">Sign Up</h2>
                                <p class="text-white-50 mb-5">Please enter your sign up and password!</p>
                                <?php if ($error_message): ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php echo $error_message; ?>
                                    </div>
                                <?php endif; ?>
                                <?php if ($error_message): ?>
                                    <div class="alert alert-danger" role="alert">
                                        <?php echo $error_message; ?>
                                    </div>
                                <?php endif; ?>
                                <div data-mdb-input-init class="form-outline form-white mb-3">
                                    <input type="text" name="nama" id="nama" class="form-control form-control-lg" />
                                    <label class="form-label" for="nama">Your Name</label>
                                </div>
                                <div data-mdb-input-init class="form-outline form-white mb-3">
                                    <input type="text" name="telepon" id="telepon" class="form-control form-control-lg" />
                                    <label class="form-label" for="telepon">Telepon</label>
                                </div>
                                <div data-mdb-input-init class="form-outline form-white mb-3">
                                    <input type="text" name="alamat" id="alamat" class="form-control form-control-lg" />
                                    <label class="form-label" for="alamat">Alamat</label>
                                </div>
                                <div data-mdb-input-init class="form-outline form-white mb-3">
                                    <input type="email" name="email" id="typeEmailX" class="form-control form-control-lg" />
                                    <label class="form-label" for="typeEmailX">Email</label>
                                </div>

                                <div data-mdb-input-init class="form-outline form-white mb-3">
                                    <input type="password" name="password" id="typePasswordX" class="form-control form-control-lg" />
                                    <label class="form-label" for="typePasswordX">Password</label>
                                </div>

                                <button data-mdb-button-init data-mdb-ripple-init class="btn btn-outline-light btn-lg px-5" type="submit">Sign Up</button>

                            </form>

                            <div>
                                <p class="mb-0">Have an account? <a href="login.php" class="text-white-50 fw-bold">Login</a>
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <script src="../../bootstrap-5/js/bootstrap.bundle.min.js"></script>
</body>

</html>