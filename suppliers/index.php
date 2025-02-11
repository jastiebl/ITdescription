<?php include('../include/header.php'); ?>

<?php
// Initialize error and success messages
$error = '';
$success = '';

// Handle delete request if `delete_id` is set
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']); // Use intval to prevent SQL injection

    // Delete query for suppliers
    $sql_supplier = "DELETE FROM suppliers WHERE id = $delete_id";
    if ($conn->query($sql_supplier) === TRUE) {
        $success = 'Supplier deleted successfully.';
    } else {
        $error = 'Failed to delete supplier. Please try again.';
    }
}

// Fetch all suppliers
$sql_suppliers = "SELECT * FROM suppliers";
$result_suppliers = $conn->query($sql_suppliers);

if (!$result_suppliers) {
    $error = 'Failed to fetch suppliers. Please try again.';
}
?>

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="<?= $baseUrl ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Suppliers</a></li>
            </ol>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">All Suppliers</h4>
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
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Phone No</th>
                                        <th>Address</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Display suppliers
                                    if ($result_suppliers->num_rows > 0) {
                                        while ($row = $result_suppliers->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>" . htmlspecialchars($row['id']) . "</td>
                                                    <td>" . htmlspecialchars($row['name']) . "</td>
                                                    <td>" . htmlspecialchars($row['phone_no']) . "</td>
                                                    <td>" . htmlspecialchars($row['address']) . "</td>
                                                    <td>
                                                        <a href='edit.php?id=" . $row['id'] . "' class='btn btn-primary'>Edit</a>
                                                        <a href='index.php?delete_id=" . $row['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                                                    </td>
                                                </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='5' class='text-center'>No suppliers found.</td></tr>";
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
