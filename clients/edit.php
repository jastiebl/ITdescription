<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

include('../include/header.php');

// Initialize error and success messages
$error = '';
$success = '';

// Start session if needed
session_start();

// Check if we are in edit mode (update)
$is_edit = isset($_GET['id']);
$user_id = $is_edit ? intval($_GET['id']) : null; // Only for edit

// If it's an edit, fetch client data
if ($is_edit) {
    $sql = "SELECT * FROM clients WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $client = $result->fetch_assoc();
    } else {
        $error = "Client not found.";
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract form data
    $name = $_POST['name'] ?? null;
    $email = $_POST['email'] ?? null;
    $password = $_POST['password'] ?? null;

    // Validate form data
    if (empty($name) || empty($email)) {
        $error = 'Name and email are required.';
    } else {
        // Hash the password if it's new or changed
        $hashed_password = !empty($password) ? password_hash($password, PASSWORD_DEFAULT) : ($is_edit ? $client['password'] : null);

        if ($is_edit) {
            // Update client details
            $sql = "UPDATE clients SET name = ?, email = ?, password = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $name, $email, $hashed_password, $user_id);
        } else {
            // Insert new client if no `id` is passed
            $sql = "INSERT INTO clients (name, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sss", $name, $email, $hashed_password);
        }

        // Execute the query
        if ($stmt->execute()) {
            $success = $is_edit ? 'Client updated successfully.' : 'Client added successfully.';
            // Redirect to the clients list
            header('Location: index.php');
            exit();
        } else {
            $error = 'Failed to save client: ' . $stmt->error;
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
                <li class="breadcrumb-item"><?= $is_edit ? 'Edit' : 'Add' ?> Client</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?= $is_edit ? 'Edit' : 'Add' ?> Client</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-validation">
                            <!-- Error and success messages -->
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

                            <!-- Form -->
                            <form class="needs-validation" method="POST" novalidate>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="userName" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="userName" name="name" value="<?= isset($client) ? htmlspecialchars($client['name']) : '' ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="userEmail" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="userEmail" name="email" value="<?= isset($client) ? htmlspecialchars($client['email']) : '' ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="userPassword" class="form-label">Password (Leave blank if not changing)</label>
                                        <input type="password" class="form-control" id="userPassword" name="password">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary"><?= $is_edit ? 'Update' : 'Create' ?> Client</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../include/footer.php'); ?>
