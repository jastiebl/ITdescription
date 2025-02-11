<?php include('../include/header.php'); ?>

<?php
// Initialize error and success messages
$error = '';
$success = '';

// Handle delete request if `delete_id` is set
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']); // Prevent SQL injection

    // Delete query for employees
    $sql_employee = "DELETE FROM employees WHERE id = $delete_id";
    if ($conn->query($sql_employee) === TRUE) {
        $success = 'Employee deleted successfully.';
    } else {
        $error = 'Failed to delete employee. Please try again.';
    }
}

// Fetch all employees
$sql_employees = "SELECT * FROM employees";
$result_employees = $conn->query($sql_employees);

if (!$result_employees) {
    $error = 'Failed to fetch employees. Please try again.';
}
?>

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="<?= $baseUrl ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Employees</a></li>
            </ol>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">All Employees</h4>
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
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Display employees
                                    if ($result_employees->num_rows > 0) {
                                        while ($row = $result_employees->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>" . htmlspecialchars($row['name']) . "</td>
                                                    <td>" . htmlspecialchars($row['email']) . "</td>
                                                    <td>
                                                        <div class='d-flex align-items-center justify-content-start'>
                                                            <a href='edit.php?id=" . $row['id'] . "' class='btn btn-primary btn-sm me-2'>Edit</a>
                                                            <a href='index.php?delete_id=" . $row['id'] . "' class='btn btn-danger btn-sm' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                                                        </div>
                                                    </td>
                                                  </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='3' class='text-center'>No employees found.</td></tr>";
                                    }
                                    ?>
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
