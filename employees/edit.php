<?php include('../include/header.php'); ?>

<?php
// Initialize error and success messages
$error = '';
$success = '';

// Start session if needed
session_start();

// Check if we are in edit mode (update)
$is_edit = isset($_GET['id']);
$user_id = $is_edit ? $_GET['id'] : null; // Only for edit

// If it's an edit, fetch employee data
if ($is_edit) {
    // Assuming you have a connection established with $conn
    $sql = "SELECT * FROM employees WHERE id = $user_id";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $employee = $result->fetch_assoc();
    } else {
        $error = "Employee not found.";
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    extract($_POST);

    // Validate form data
    if (empty($name) || empty($email)) {
        $error = 'Name and email are required.';
    } else {
        // Hash the password if it's new or changed
        $hashed_password = $password ? password_hash($password, PASSWORD_DEFAULT) : ($is_edit ? $employee['password'] : '');

        // Update employee details
        if ($is_edit) {
            $sql = "UPDATE employees SET name='$name', email='$email', password='$hashed_password' WHERE id = $user_id";
        } else {
            // Insert new employee if no `id` is passed
            $sql = "INSERT INTO employees (name, email, password) VALUES ('$name', '$email', '$hashed_password')";
        }

        // Execute the query
        if ($conn->query($sql) === TRUE) {
            $success = $is_edit ? 'Employee updated successfully.' : 'Employee added successfully.';
        } else {
            $error = 'Failed to save employee. Please try again.';
        }
    }
}
?>

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="<?= $baseUrl ?>">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="index.php">Employees</a></li>
                <li class="breadcrumb-item"><?= $is_edit ? 'Edit' : 'Add' ?> Employee</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?= $is_edit ? 'Edit' : 'Add' ?> Employee</h4>
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
                                        <input type="text" class="form-control" id="userName" name="name" value="<?= isset($employee) ? htmlspecialchars($employee['name']) : '' ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="userEmail" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="userEmail" name="email" value="<?= isset($employee) ? htmlspecialchars($employee['email']) : '' ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="userPassword" class="form-label">Password (Leave blank if not changing)</label>
                                        <input type="password" class="form-control" id="userPassword" name="password">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary"><?= $is_edit ? 'Update' : 'Create' ?> Employee</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../include/footer.php'); ?>
