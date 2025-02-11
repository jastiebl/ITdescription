<?php
include('../include/header.php');
include('../include/db.php'); // Include database connection

// Initialize success and error messages
$success = '';
$error = '';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure the user is logged in
    if (!isset($_SESSION['online_user'])) {
        $error = "You must be logged in to submit an estimate.";
    } else {
        // Get client ID from session
        $client_id = $_SESSION['online_user']['id'];

        // Process form data
        $services = isset($_POST['services']) ? implode(', ', $_POST['services']) : '';
        $additionalDetails = isset($_POST['additionalDetails']) ? $_POST['additionalDetails'] : '';

        // Validate form inputs
        if (empty($services)) {
            $error = "Please select at least one service.";
        } else {
            // Insert the estimate request into the database
            $sql = "INSERT INTO estimate_requests (client_id, services, additional_services, status, created_at)
                    VALUES ('$client_id', '$services', '$additionalDetails', 'pending', NOW())";

            if ($conn->query($sql) === TRUE) {
                $success = "Your estimate request has been submitted successfully.";
            } else {
                $error = "Error: " . $conn->error;
            }
        }
    }
}
?>

<div class="content-body">
    <div class="container-fluid">
        <!-- Estimate Form -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="estimate-container">
                            <h2 class="estimate-title">Request an Estimate</h2>

                            <!-- Display Success or Error Message -->
                            <?php if (!empty($success)): ?>
                                <div class="alert alert-success"><?= htmlspecialchars($success); ?></div>
                            <?php endif; ?>
                            <?php if (!empty($error)): ?>
                                <div class="alert alert-danger"><?= htmlspecialchars($error); ?></div>
                            <?php endif; ?>

                            <form class="needs-validation" method="POST" novalidate>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="service1" name="services[]" value="Audio System Installation">
                                    <label class="form-check-label" for="service1">Audio System Installation</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="service2" name="services[]" value="Video Conferencing Solutions">
                                    <label class="form-check-label" for="service2">Video Conferencing Solutions</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="service3" name="services[]" value="Lighting Solutions">
                                    <label class="form-check-label" for="service3">Lighting Solutions</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="service4" name="services[]" value="Home Theater Systems">
                                    <label class="form-check-label" for="service4">Home Theater Systems</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="service5" name="services[]" value="Security Solutions">
                                    <label class="form-check-label" for="service5">Security Solutions</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="service6" name="services[]" value="Networking Solutions">
                                    <label class="form-check-label" for="service6">Networking Solutions</label>
                                </div>
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" id="service7" name="services[]" value="Shading Solutions">
                                    <label class="form-check-label" for="service7">Shading Solutions</label>
                                </div>

                                <div class="additional-input mt-3">
                                    <label for="additionalDetails" class="form-label">Additional Services</label>
                                    <textarea class="form-control" id="additionalDetails" name="additionalDetails" rows="4" placeholder="Please provide any other information..."></textarea>
                                </div>
                                <button type="submit" class="btn btn-submit w-100 mt-3">Submit Estimate Request</button>
                            </form>

                            <div class="notification mt-3">
                                <p>Please allow 3-4 business days for a response.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card-body {
        background-color: #0047AB;
    }
    .estimate-container {
        margin: auto;
        width: 100%;
        max-width: 600px;
        padding: 30px;
        background: rgba(255, 255, 255, 0.95);
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
    .estimate-title {
        text-align: center;
        margin-bottom: 20px;
        color: #0047AB;
        font-weight: bold;
    }
    .form-check-label {
        margin-bottom: 10px;
        color: #0047AB;
    }
    .btn-submit {
        background-color: #0047AB;
        color: #ffffff;
        transition: background-color 0.3s;
    }
    .btn-submit:hover {
        background-color: #003580;
    }
</style>

<?php include('../include/footer.php'); ?>
