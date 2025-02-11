<?php include('../include/header.php'); ?>

<?php
// Initialize error and success messages
$error = '';
$success = '';

// Start session if needed
session_start();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    extract($_POST);

    // Validate form data
    if (empty($name) || empty($email)) {
        $error = 'Name and email are required.';
    } else {
        // Hash the password if it's new or changed
        $hashed_password = $password ? password_hash($password, PASSWORD_DEFAULT) : '';

        // Insert new client
        $sql = "INSERT INTO clients (name, email, password) VALUES ('$name', '$email', '$hashed_password')";

        // Execute the query
        if ($conn->query($sql) === TRUE) {
            $success = 'Client added successfully.';
        } else {
            $error = 'Failed to save client. Please try again.';
        }
    }
}
?>

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="<?= $baseUrl ?>">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="index.php">Clients</a></li>
                <li class="breadcrumb-item">Add</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add Client</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-validation">
                            <?php if ($error): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <?= htmlspecialchars($error) ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php elseif ($success): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <?= htmlspecialchars($success) ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                            <form class="needs-validation" method="POST" novalidate>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="userName" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="userName" name="name" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="userEmail" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="userEmail" name="email" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="userPassword" class="form-label">Password (Leave blank if not changing)</label>
                                        <input type="password" class="form-control" id="userPassword" name="password">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Create Client</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../include/footer.php'); ?>
