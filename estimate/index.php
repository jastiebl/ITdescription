<?php include('../include/header.php'); ?>

<?php
$error = '';
$success = '';

// Ensure database connection is available
if (!isset($conn)) {
    die("Database connection error: " . mysqli_connect_error());
}

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']);
    $stmt = $conn->prepare("DELETE FROM estimates WHERE id = ?");
    $stmt->bind_param("i", $delete_id);
    if ($stmt->execute()) {
        $success = 'Estimate deleted successfully.';
    } else {
        $error = 'Failed to delete estimate: ' . $conn->error;
        error_log("Delete Error: " . $stmt->error); // Log the error
    }
    $stmt->close();
}

// Fetch all estimates with client information
$sql_estimates = "SELECT e.id, e.description, e.amount, e.status, c.name AS client_name, c.email AS client_email 
                  FROM estimates e
                  JOIN clients c ON e.client_id = c.id";
$result_estimates = $conn->query($sql_estimates);

if (!$result_estimates) {
    $error = 'Failed to fetch estimates. Please try again.';
    error_log("Fetch Error: " . $conn->error); // Log the error
}
?>

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="<?= $baseUrl ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Estimates</a></li>
            </ol>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">All Estimates</h4>
                        <div>
                            <a href="create.php" class="btn btn-dark shadow btn-xs sharp me-1"><i class="fa fa-plus"></i></a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <!-- Display Messages -->
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
                            <!-- Table -->
                            <table id="example" class="display" style="min-width: 845px">
                                <thead>
                                    <tr>
                                        <th>Client Name</th>
                                        <th>Client Email</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php if ($result_estimates->num_rows > 0): ?>
                                        <?php while ($row = $result_estimates->fetch_assoc()): ?>
                                            <tr>
                                                <td><?= htmlspecialchars($row['client_name']) ?></td>
                                                <td><?= htmlspecialchars($row['client_email']) ?></td>
                                                <td><?= htmlspecialchars($row['description']) ?></td>
                                                <td>$<?= htmlspecialchars(number_format($row['amount'], 2)) ?></td>
                                                <td>
                                                    <span class="badge bg-<?= $row['status'] === 'approved' ? 'success' : ($row['status'] === 'rejected' ? 'danger' : 'warning') ?>">
                                                        <?= ucfirst(htmlspecialchars($row['status'] ?? 'Pending')) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                                                    <a href="index.php?delete_id=<?= $row['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</a>
                                                </td>
                                            </tr>
                                        <?php endwhile; ?>
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="6" class="text-center">No estimates found.</td>
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
