<?php
require_once('lib/db.php');
require_once('lib/session_check.php');

if ($_POST) {
    extract($_POST);

    // Query to get user data by email
    $sql = "SELECT * FROM employees WHERE email='$email'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify the password using password_verify
        if (password_verify($password, $user['password'])) {
            $user['role'] = 'employee';
            $_SESSION['online_user'] = $user;

            header("Location: index.php");
            exit;
        } else {
            $error = "Wrong credentials. Please try again.";
        }
    } else {
        $error = "Wrong credentials. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en" class="h-100">
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="" />
	<meta name="author" content="" />
	<meta name="robots" content="" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta property="og:image" content="social-image.png" />
	<meta name="format-detection" content="telephone=no">

	<title>ITdescription </title>
    <link rel="shortcut icon" type="image/png" href="assets/images/favicon.png" />
	 <link href="assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
	 <link href="assets/vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <link href="assets/css/style.css" rel="stylesheet">

</head>

<body class="vh-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
									<div class="text-center mb-3">
										<a href="assets/index.html">
                                        <a href="#"><img src="assets/images/logo.png" alt="" class="w-50"></a>
									    </a>
									</div>
                                    <h2 class="text-center mb-4">Login Employee</h2>
                                    <form class="form-valide-with-icon needs-validation" method="POST" novalidate>
                                        <div class="mb-3">
                                            <label class="text-label form-label" for="validationCustomEmail">Email</label>
                                            <div class="input-group">
												<span class="input-group-text"> <i class="fa fa-user"></i> </span>
                                                <input type="email" name="email" class="form-control" id="validationCustomEmail" placeholder="Enter your Email.." required>
												<div class="invalid-feedback">
													Please enter a valid email.
												  </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="text-label form-label" for="dz-password">Password *</label>
                                            <div class="input-group transparent-append">
												<span class="input-group-text"> <i class="fa fa-lock"></i> </span>
                                                <input type="password" name="password" class="form-control" id="dz-password" placeholder="Enter your Password" required>
												<span class="input-group-text show-pass"> 
													<i class="fa fa-eye-slash"></i>
													<i class="fa fa-eye"></i>
												</span>
                                                <div class="invalid-feedback">
                                                 Please enter a password.
												</div>
                                            </div>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Login</button>
                                        </div>
                                    </form>
                                    <div class="new-account row mt-3 justify-content-center">
                                        <div class="col-lg-4 col-md-4">
                                            <a href="client_login.php" class="btn btn-block btn-dark h-auto">Clients</a>
                                        </div>
                                        <div class="col-lg-4 col-md-4">
                                            <a href="admin_login.php" class="btn btn-block btn-dark h-auto">Admin</a>
                                        </div>
                                    </div>
                                    <?php if (isset($error)): ?>
                                        <div class="alert alert-danger mt-3">
                                            <?= htmlspecialchars($error) ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="assets/vendor/global/global.min.js"></script>
    <script src="assets/js/custom.min.js"></script>
    <script src="assets/js/deznav-init.js"></script>
	<script src="assets/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
	<script src="assets/vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
	<script src="assets/js/demo.js"></script>
	<script src="assets/js/page-validation-script.js"></script>
</body>
</html>