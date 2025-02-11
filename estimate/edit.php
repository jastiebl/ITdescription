<?php include('../include/header.php'); ?>

<?php
$error = '';
$success = '';

session_start();

$sql_clients = "SELECT id, name FROM clients";
$result_clients = $conn->query($sql_clients);
$edit_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$estimate_item = null;

if ($edit_id > 0) {
    $sql_estimate = "SELECT * FROM estimates WHERE id = '$edit_id'";
    $result_estimate = $conn->query($sql_estimate);
    if ($result_estimate->num_rows > 0) {
        $estimate_item = $result_estimate->fetch_assoc();
    } else {
        $error = 'Estimate not found.';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    extract($_POST);

    if (empty($client_id) || empty($description) || empty($amount) || empty($status)) {
        $error = 'Client, project name, total amount, and status are required.';
    } else {

        if ($edit_id > 0) {
            $sql = "UPDATE estimates 
                    SET client_id = '$client_id', description = '$description', amount = '$amount', status = '$status' 
                    WHERE id = '$edit_id'";
            if ($conn->query($sql) === TRUE) {
                $success = 'Estimate updated successfully.';
            } else {
                $error = 'Failed to update estimate. Please try again.';
            }
        }
    }
}
?>

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="<?= $baseUrl ?>">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="index.php">Estimates</a></li>
                <li class="breadcrumb-item"><?= $edit_id > 0 ? 'Edit' : 'Add' ?></li>
            </ol>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?= $edit_id > 0 ? 'Edit' : 'Add' ?> Estimate</h4>
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
                            <form class="needs-validation" method="POST" enctype="multipart/form-data" novalidate>
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="clientSelect" class="form-label">Client</label>
                                        <select class="form-select" id="clientSelect" name="client_id" required>
                                            <option value="">Select a Client</option>
                                            <?php
                                            if ($result_clients->num_rows > 0) {
                                                while ($client = $result_clients->fetch_assoc()) {
                                                    $selected = $estimate_item && $estimate_item['client_id'] == $client['id'] ? 'selected' : '';
                                                    echo "<option value='" . htmlspecialchars($client['id']) . "' $selected>" . htmlspecialchars($client['name']) . "</option>";
                                                }
                                            } else {
                                                echo "<option value=''>No clients available</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="projectName" class="form-label">Project Name</label>
                                        <input type="text" class="form-control" id="projectName" name="description" value="<?= $estimate_item['description'] ?? '' ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="totalAmount" class="form-label">Total Amount</label>
                                        <input type="number" class="form-control" id="totalAmount" name="amount" step="0.01" min="0" value="<?= $estimate_item['amount'] ?? '' ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="statusSelect" class="form-label">Status</label>
                                        <select class="form-select" id="statusSelect" name="status" required>
                                            <option value="">Select Status</option>
                                            <option value="Pending" <?= $estimate_item && $estimate_item['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                            <option value="Approved" <?= $estimate_item && $estimate_item['status'] === 'approved' ? 'selected' : '' ?>>Approved</option>
                                            <option value="Rejected" <?= $estimate_item && $estimate_item['status'] === 'rejected' ? 'selected' : '' ?>>Rejected</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary"><?= $edit_id > 0 ? 'Update' : 'Add' ?> Estimate</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../include/footer.php'); ?>
