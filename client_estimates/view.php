<?php include('../include/header.php'); ?>

<?php
// Session initialization

// Error and success messages
$error = '';
$success = '';

$client_id = $_SESSION['online_user']['id'];
$estimate_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch the estimate details for the client
if ($estimate_id > 0) {
    $sql_estimate = "SELECT id, description, amount, status, created_at, pdf_path 
                     FROM estimates 
                     WHERE id = '$estimate_id' AND client_id = '$client_id'";
    $result_estimate = $conn->query($sql_estimate);
    if ($result_estimate->num_rows > 0) {
        $estimate = $result_estimate->fetch_assoc();
    } else {
        $error = 'Estimate not found or you do not have access to this estimate.';
    }
} else {
    $error = 'Invalid estimate ID.';
}
?>

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="<?= $baseUrl ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="./index.php">Estimates</a></li>
                <li class="breadcrumb-item">View Estimate</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">View Estimate #<?= htmlspecialchars($estimate_id) ?></h4>
                    </div>
                    <div class="card-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?= htmlspecialchars($error) ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>

                        <?php if ($estimate): ?>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="estimateDescription" class="form-label">Description</label>
                                    <textarea class="form-control" id="estimateDescription" rows="4" readonly><?= htmlspecialchars($estimate['description']) ?></textarea>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="estimateAmount" class="form-label">Amount</label>
                                    <input type="text" class="form-control" id="estimateAmount" value="$<?= number_format($estimate['amount'], 2) ?>" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="estimateStatus" class="form-label">Status</label>
                                    <input type="text" class="form-control" id="estimateStatus" value="<?= ucfirst($estimate['status']) ?>" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="estimateCreatedAt" class="form-label">Created At</label>
                                    <input type="text" class="form-control" id="estimateCreatedAt" value="<?= htmlspecialchars(date('Y-m-d', strtotime($estimate['created_at']))) ?>" readonly>
                                </div>
                            </div>

                            <?php if (!empty($estimate['pdf_path']) && file_exists($estimate['pdf_path'])): ?>
                                <div class="col-md-12 mt-3">
                                    <label for="attachedPDF" class="form-label">Attached PDF:</label>
                                    <!-- Link to view or download the PDF -->
                                    <a href="<?= htmlspecialchars($estimate['pdf_path']) ?>" target="_blank" class="btn btn-secondary">View/Download PDF</a>

                                    <!-- Optional: Embed the PDF -->
                                    <div class="mt-4">
                                        <embed src="<?= htmlspecialchars($estimate['pdf_path']) ?>" width="100%" height="500px" type="application/pdf">
                                    </div>
                                </div>
                            <?php else: ?>
                                <div class="col-md-12 mt-3">
                                    <p><strong>Attached PDF:</strong> No PDF uploaded.</p>
                                </div>
                            <?php endif; ?>

                            <div class="mt-4">
                                <a href="./index.php" class="btn btn-secondary">Back to Estimates</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../include/footer.php'); ?>
