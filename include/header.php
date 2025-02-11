<?php
// Define the base URL for referencing assets
$baseUrl = '/~jastiebl/ITdescription/'; // Adjust this if necessary based on your server

// Include necessary files and start the session
require_once(__DIR__ . '/../lib/db.php');
session_start();

// Redirect to the login page if the user is not logged in
if (!isset($_SESSION['online_user']['role'])) {
    header("Location: admin_login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="keywords" content="" />
    <meta name="author" content="" />
    <meta name="robots" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="ITdescription " />
    <meta property="og:title" content="ITdescription " />
    <meta property="og:description" content="ITdescription " />
    <meta property="og:image" content="social-image.png" />
    <meta name="format-detection" content="telephone=no">
    
    <!-- Page Title -->
    <title>ITdescription</title>
    
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/png" href="<?= $baseUrl ?>assets/images/logo.png" />
    
    <!-- Vendor CSS -->
    <link href="<?= $baseUrl ?>assets/vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= $baseUrl ?>assets/vendor/dotted-map/css/contrib/jquery.smallipop-0.3.0.min.css" type="text/css" media="all" />
    <link href="<?= $baseUrl ?>assets/vendor/owl-carousel/owl.carousel.css" rel="stylesheet">
    <link href="<?= $baseUrl ?>assets/vendor/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet">
    <link href="<?= $baseUrl ?>assets/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="<?= $baseUrl ?>assets/vendor/datepicker/css/bootstrap-datepicker.min.css" rel="stylesheet">
    <link href="<?= $baseUrl ?>assets/vendor/swiper/css/swiper-bundle.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link href="<?= $baseUrl ?>assets/css/style.css" rel="stylesheet">
</head>
<body>

    <!-- Preloader -->
    <div id="preloader">
        <div class="lds-ripple">
            <div></div>
            <div></div>
        </div>
    </div>

    <!-- Main Wrapper -->
    <div id="main-wrapper">

        <!-- Nav Header -->
        <div class="nav-header">
            <a href="#" class="brand-logo">
                <img src="<?= $baseUrl ?>assets/images/logo.png" alt="">
            </a>
            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>

        <!-- Header -->
        <div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="headaer-title">
                                <h1 class="font-w600 mb-0">Dashboard</h1>
                            </div>
                        </div>
                        <ul class="navbar-nav header-right">
                            <li class="nav-item dropdown header-profile">
                                <div id="datepicker" class="input-group date dz-calender" data-date-format="mm-dd-yyyy">
                                    <span class="input-group-addon d-flex align-items-center">
                                        <svg width="18" height="18" viewBox="0 0 18 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M14.8337 3.16667H14.0003V1.50001C14.0003 1.27899 13.9125 1.06703 13.7563 0.910749C13.6 0.754469 13.388 0.666672 13.167 0.666672C12.946 0.666672 12.734 0.754469 12.5777 0.910749C12.4215 1.06703 12.3337 1.27899 12.3337 1.50001V3.16667H5.66699V1.50001C5.66699 1.27899 5.5792 1.06703 5.42292 0.910749C5.26663 0.754469 5.05467 0.666672 4.83366 0.666672C4.61265 0.666672 4.40068 0.754469 4.2444 0.910749C4.08812 1.06703 4.00033 1.27899 4.00033 1.50001V3.16667H3.16699C2.50395 3.16667 1.86807 3.43006 1.39923 3.8989C0.930384 4.36775 0.666992 5.00363 0.666992 5.66667V6.5H17.3337V5.66667C17.3337 5.00363 17.0703 4.36775 16.6014 3.8989C16.1326 3.43006 15.4967 3.16667 14.8337 3.16667Z" fill="#F66F4D"/>
                                            <path d="M0.666992 14.8333C0.666992 15.4964 0.930384 16.1322 1.39923 16.6011C1.86807 17.0699 2.50395 17.3333 3.16699 17.3333H14.8337C15.4967 17.3333 16.1326 17.0699 16.6014 16.6011C17.0703 16.1322 17.3337 15.4964 17.3337 14.8333V8.16666H0.666992V14.8333Z" fill="#F66F4D"/>
                                        </svg>
                                    </span>
                                    <input class="form-control" type="text" readonly />
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>

        <!-- Include Sidebar -->
        <?php include(__DIR__ . '/../include/sidebar.php'); ?>
