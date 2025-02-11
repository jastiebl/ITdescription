<?php include('include/header.php'); ?>
<?php
	$query_employees = "SELECT COUNT(*) as total_employees FROM employees";
	$result_employees = $conn->query($query_employees);
	$total_employees = $result_employees->fetch_assoc()['total_employees'];
	$query_clients = "SELECT COUNT(*) as total_clients FROM clients";
	$result_clients = $conn->query($query_clients);
	$total_clients = $result_clients->fetch_assoc()['total_clients'];
?>

		<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
			<div class="container-fluid">
				<div class="row">
					<div class="col-xl-12 card h-auto">
						<div class="card-body">
						<?php
							if ($_SESSION['online_user']['role'] == "admin"): ?>
								<!-- Admin Section -->
								<div class="row align-items-center">
									<!-- Total Employees -->
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 mb-3">
										<div class="card trading mb-sm-0 mb-3">
											<div class="card-body">
												<div class="income-data d-flex justify-content-between align-items-center mb-sm-0 mb-2 ps-lg-0">
													<div>
														<h3 class="font-w600 fs-2 mb-0 text-white">
															<?php echo $total_employees; ?>
														</h3>
														<span class="fs-6 font-w500 text-white">Total Employees</span>
													</div>
													<span class="income-icon style-2">
														<svg width="34" height="24" viewBox="0 0 34 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<path d="M33.5 22.5C33.5 22.8978 33.342 23.2793 33.0607 23.5606C32.7794 23.8419 32.3978 24 32 24H14C13.6022 24 13.2206 23.8419 12.9393 23.5606C12.658 23.2793 12.5 22.8978 12.5 22.5C12.5 20.113 13.4482 17.8238 15.136 16.136C16.8239 14.4482 19.1131 13.5 21.5 13.5H24.5C26.8869 13.5 29.1761 14.4482 30.864 16.136C32.5518 17.8238 33.5 20.113 33.5 22.5ZM23 0C21.8133 0 20.6533 0.351893 19.6666 1.01118C18.6799 1.67047 17.9108 2.60754 17.4567 3.7039C17.0026 4.80025 16.8838 6.00665 17.1153 7.17053C17.3468 8.33442 17.9182 9.40352 18.7574 10.2426C19.5965 11.0817 20.6656 11.6532 21.8295 11.8847C22.9933 12.1162 24.1997 11.9974 25.2961 11.5433C26.3925 11.0891 27.3295 10.3201 27.9888 9.33341C28.6481 8.34672 29 7.18668 29 5.99999C29 4.4087 28.3679 2.88257 27.2426 1.75736C26.1174 0.63214 24.5913 0 23 0ZM9.5 0C8.31331 0 7.15327 0.351893 6.16658 1.01118C5.17988 1.67047 4.41085 2.60754 3.95672 3.7039C3.5026 4.80025 3.38378 6.00665 3.61529 7.17053C3.8468 8.33442 4.41824 9.40352 5.25736 10.2426C6.09647 11.0817 7.16557 11.6532 8.32946 11.8847C9.49334 12.1162 10.6997 11.9974 11.7961 11.5433C12.8925 11.0891 13.8295 10.3201 14.4888 9.33341C15.1481 8.34672 15.5 7.18668 15.5 5.99999C15.5 4.4087 14.8679 2.88257 13.7426 1.75736C12.6174 0.63214 11.0913 0 9.5 0ZM9.5 22.5C9.49777 20.9244 9.80818 19.364 10.4133 17.9093C11.0183 16.4545 11.9061 15.1342 13.025 14.025C12.1093 13.6793 11.1388 13.5014 10.16 13.5H8.84C6.62931 13.504 4.5103 14.3839 2.94711 15.9471C1.38391 17.5103 0.503965 19.6293 0.5 21.84V22.5C0.5 22.8978 0.658035 23.2793 0.93934 23.5606C1.22064 23.8419 1.60218 24 2 24H9.77C9.59537 23.519 9.50406 23.0117 9.5 22.5Z" fill="#FFFFFF"/>
														</svg>
													</span>
												</div>
											</div>
										</div>
									</div>

									<!-- Total Clients -->
									<div class="col-xl-6 col-lg-6 col-md-6 col-sm-6 mb-3">
										<div class="card trading mb-sm-0 mb-3" style="background: var(--secondary) !important;">
											<div class="card-body">
												<div class="income-data d-flex justify-content-between align-items-center mb-sm-0 mb-2 ps-lg-0">
													<div>
														<h3 class="font-w600 fs-2 mb-0 text-white">
															<?php echo $total_clients; ?>
														</h3>
														<span class="fs-6 font-w500 text-white">Total Clients</span>
													</div>
													<span class="income-icon style-2">
														<svg width="34" height="24" viewBox="0 0 34 24" fill="none" xmlns="http://www.w3.org/2000/svg">
															<path d="M33.5 22.5C33.5 22.8978 33.342 23.2793 33.0607 23.5606C32.7794 23.8419 32.3978 24 32 24H14C13.6022 24 13.2206 23.8419 12.9393 23.5606C12.658 23.2793 12.5 22.8978 12.5 22.5C12.5 20.113 13.4482 17.8238 15.136 16.136C16.8239 14.4482 19.1131 13.5 21.5 13.5H24.5C26.8869 13.5 29.1761 14.4482 30.864 16.136C32.5518 17.8238 33.5 20.113 33.5 22.5ZM23 0C21.8133 0 20.6533 0.351893 19.6666 1.01118C18.6799 1.67047 17.9108 2.60754 17.4567 3.7039C17.0026 4.80025 16.8838 6.00665 17.1153 7.17053C17.3468 8.33442 17.9182 9.40352 18.7574 10.2426C19.5965 11.0817 20.6656 11.6532 21.8295 11.8847C22.9933 12.1162 24.1997 11.9974 25.2961 11.5433C26.3925 11.0891 27.3295 10.3201 27.9888 9.33341C28.6481 8.34672 29 7.18668 29 5.99999C29 4.4087 28.3679 2.88257 27.2426 1.75736C26.1174 0.63214 24.5913 0 23 0ZM9.5 0C8.31331 0 7.15327 0.351893 6.16658 1.01118C5.17988 1.67047 4.41085 2.60754 3.95672 3.7039C3.5026 4.80025 3.38378 6.00665 3.61529 7.17053C3.8468 8.33442 4.41824 9.40352 5.25736 10.2426C6.09647 11.0817 7.16557 11.6532 8.32946 11.8847C9.49334 12.1162 10.6997 11.9974 11.7961 11.5433C12.8925 11.0891 13.8295 10.3201 14.4888 9.33341C15.1481 8.34672 15.5 7.18668 15.5 5.99999C15.5 4.4087 14.8679 2.88257 13.7426 1.75736C12.6174 0.63214 11.0913 0 9.5 0ZM9.5 22.5C9.49777 20.9244 9.80818 19.364 10.4133 17.9093C11.0183 16.4545 11.9061 15.1342 13.025 14.025C12.1093 13.6793 11.1388 13.5014 10.16 13.5H8.84C6.62931 13.504 4.5103 14.3839 2.94711 15.9471C1.38391 17.5103 0.503965 19.6293 0.5 21.84V22.5C0.5 22.8978 0.658035 23.2793 0.93934 23.5606C1.22064 23.8419 1.60218 24 2 24H9.77C9.59537 23.519 9.50406 23.0117 9.5 22.5Z" fill="#FFFFFF"/>
														</svg>
													</span>
												</div>
											</div>
										</div>
									</div>
								</div>
							<?php elseif ($_SESSION['online_user']['role'] == "employee"): ?>
								<!-- Employee Section -->
								<div class="welcome-message text-center">
									<h1>Welcome, <?php echo $_SESSION['online_user']['name']; ?></h1>
								</div>
							<?php elseif ($_SESSION['online_user']['role'] == "client"): ?>
								<!-- Client Section -->
								<div class="welcome-message text-center">
									<h1>Welcome, <?php echo $_SESSION['online_user']['name']; ?></h1>
								</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->
<style>
.custom-dashboard-card {
    background-color: #f0f2f5;
    border: none;
    border-radius: 20px;
    padding: 20px;
}

.custom-card {
    border-radius: 15px;
    background: linear-gradient(135deg, #ffffff, #f1f3f6);
    transition: transform 0.4s ease, box-shadow 0.4s ease;
    padding: 15px;
    min-height: 150px; /* Adjusting min-height to make the card smaller */
}

.custom-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 12px 24px rgba(0, 0, 0, 0.15);
}

.icon-container {
    background: linear-gradient(135deg, #ff6f61, #ff9068);
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    justify-content: center;
    align-items: center;
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
}

.card-icon {
    font-size: 1.8rem;
    color: #ffffff;
}

.text-container h4 {
    font-weight: 700;
    color: #555555;
    font-size: 0.9rem;
    letter-spacing: 0.5px;
}

.text-container h2 {
    font-weight: 800;
    color: #333333;
    font-size: 1.5rem;
    margin-bottom: 0;
    line-height: 1.1;
}

.text-white {
    color: #ffffff !important;
}

.shadow-lg {
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.15);
}

h4, h2 {
    transition: color 0.4s ease;
}

.custom-card:hover h4, .custom-card:hover h2 {
    color: var(--primary);
}
.text-container {
	display: flex;
	gap: 14px;
	margin-bottom: 8px;
}


</style>
<?php include('include/footer.php'); ?>