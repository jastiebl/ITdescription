<div class="deznav">
    <div class="deznav-scroll">
        <div class="dropdown header-bx"> 
            <a class="nav-link header-profile2 position-relative" href="javascript:void(0);" role="button" data-bs-toggle="dropdown">
                <div class="header-content">
                    <h2 class="font-w500"><?= $_SESSION['online_user']['name']?></h2>
                    <span class="font-w400"><?= $_SESSION['online_user']['email']?></span>
                </div>
            </a> 
        </div>
        <ul class="metismenu" id="menu">
            <li>
                <a href="<?= $baseUrl ?>index.php">
                    <i class="flaticon-025-dashboard"></i>
                    <span class="nav-text">Dashboard</span>
                </a>
            </li>
            
            <!-- Admin Section -->
            <?php if ($_SESSION['online_user']['role'] == "admin"): ?>
                <li>
                    <a href="/~jastiebl/ITdescription/clients/index.php">
                        <i class="flaticon-381-user-9"></i>
                        <span class="nav-text">Clients</span>
                    </a>
                </li>
                <li>
                    <a href="/~jastiebl/ITdescription/employees/">
                        <i class="flaticon-381-user-9"></i>
                        <span class="nav-text">Employee</span>
                    </a>
                </li>
                <li>
                    <a href="/~jastiebl/ITdescription/assign/">
                        <i class="flaticon-381-zoom-out"></i>
                        <span class="nav-text">Assign Tasks</span>
                    </a>
                </li>
                <li>
                <li>
                    <a href="/~jastiebl/ITdescription/Estimate_Requests/">
                        <i class="flaticon-381-volume"></i>
                        <span class="nav-text">Estimate Requests</span>
                    </a>
                </li>
                <li>
                    <a href="/~jastiebl/ITdescription/suppliers/">
                        <i class="flaticon-381-user-9"></i>
                        <span class="nav-text">Suppliers</span>
                    </a>
                </li>
                <li>
                    <a href="/~jastiebl/ITdescription/Inventory/">
                        <i class="flaticon-025-dashboard"></i>
                        <span class="nav-text">Inventory</span>
                    </a>
                </li>
            <?php endif ?>

            <?php if ($_SESSION['online_user']['role'] == "employee"): ?>
                <li>
                    <a href="<?= $baseUrl ?>clients/">
                        <i class="flaticon-381-user-9"></i>
                        <span class="nav-text">Clients </span>
                    </a>
                </li>
                <li>
                    <a href="<?= $baseUrl ?>employee_task/">
                        <i class="flaticon-381-zoom-out"></i>
                        <span class="nav-text">Tasks</span>
                    </a>
                </li>
            <?php endif ?>

            <?php if ($_SESSION['online_user']['role'] == "client"): ?>
                <li>
                    <a href="<?= $baseUrl ?>client_estimates/">
                        <i class="flaticon-381-volume"></i>
                        <span class="nav-text">Estimate</span>
                    </a>
                </li>
                <li>
                    <a href="<?= $baseUrl ?>estimate/estimate.php">
                        <i class="flaticon-381-volume"></i>
                        <span class="nav-text">Estimate Request</span>
                    </a>
                </li>
            <?php endif ?>

            <li>
                <a href="<?= $baseUrl ?>logout.php/">
                    <i class="flaticon-061-outside"></i>
                    <span class="nav-text">Logout</span>
                </a>
            </li>
        </ul>
        <div class="sidebar-copyright-height"></div>
        <div class="copyright sidebar-copyright">
            <p class="fs-12 fw-bold">Illumi-Tech</p>
        </div>
    </div>
</div>
