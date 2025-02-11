<?php include('../include/header.php'); ?>

<?php
// Initialize error and success messages
$error = '';
$success = '';

// Handle delete request if `delete_id` is set
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']); // Use intval to prevent SQL injection

    // Delete query for clients and employees
    $sql_check_user = "SELECT user_type FROM users WHERE id = $delete_id";
    $result_check = $conn->query($sql_check_user);

    if ($result_check && $result_check->num_rows > 0) {
        $user_type = $result_check->fetch_assoc()['user_type'];

        if ($user_type == 'client') {
            // Delete client
            $sql_client = "DELETE FROM clients WHERE id = $delete_id";
            if ($conn->query($sql_client) === TRUE) {
                $success = 'Client deleted successfully.';
            } else {
                $error = 'Failed to delete client. Please try again.';
            }
        } else if ($user_type == 'employee') {
            // Delete employee
            $sql_employee = "DELETE FROM employees WHERE id = $delete_id";
            if ($conn->query($sql_employee) === TRUE) {
                $success = 'Employee deleted successfully.';
            } else {
                $error = 'Failed to delete employee. Please try again.';
            }
        }
    } else {
        $error = 'User not found.';
    }
}

// Fetch all users (both clients and employees) from the respective tables
$sql_clients = "SELECT * FROM clients";
$sql_employees = "SELECT * FROM employees";
$result_clients = $conn->query($sql_clients);
$result_employees = $conn->query($sql_employees);

if (!$result_clients || !$result_employees) {
    $error = 'Failed to fetch users. Please try again.';
}
?>

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="<?= $baseUrl ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Users</a></li>
            </ol>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">All Users</h4>
                        <div>
                            <a href="create.php" class="btn btn-dark shadow btn-xs sharp me-1"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
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
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>User Type</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Display clients
                                    if ($result_clients->num_rows > 0) {
                                        while ($row = $result_clients->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>" . htmlspecialchars($row['name']) . "</td>
                                                    <td>" . htmlspecialchars($row['email']) . "</td>
                                                    <td>Client</td>
                                                    <td>
                                                        <a href='edit.php?id=" . $row['id'] . "' class='btn btn-primary'>Edit</a>
                                                        <a href='index.php?delete_id=" . $row['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                                                    </td>
                                                </tr>";
                                        }
                                    }

                                    // Display employees
                                    if ($result_employees->num_rows > 0) {
                                        while ($row = $result_employees->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>" . htmlspecialchars($row['name']) . "</td>
                                                    <td>" . htmlspecialchars($row['email']) . "</td>
                                                    <td>Employee</td>
                                                    <td>
                                                        <a href='edit.php?id=" . $row['id'] . "' class='btn btn-primary'>Edit</a>
                                                        <a href='index.php?delete_id=" . $row['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                                                    </td>
                                                </tr>";
                                        }
                                    }
                                    ?>
                                    <?php if ($result_clients->num_rows == 0 && $result_employees->num_rows == 0): ?>
                                        <tr>
                                            <td colspan="4" class="text-center">No users found.</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../include/footer.php'); ?>
