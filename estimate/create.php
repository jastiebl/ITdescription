<?php include('../include/header.php'); ?>

<?php
$error = '';
$success = '';

session_start();

// Fetch clients for the dropdown
$sql_clients = "SELECT id, name, email FROM clients";
$result_clients = $conn->query($sql_clients);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Extract form data
    $client_id = $_POST['client_id'] ?? null;
    $description = $_POST['description'] ?? '';
    $amount = $_POST['amount'] ?? null;

    // Check required fields
    if (empty($client_id) || empty($description) || empty($amount)) {
        $error = 'Client, description, and amount are required.';
    } else {
        $pdfPath = null; // Default to null if no file is uploaded

        // Handle file upload
        if (!empty($_FILES['pdfUpload']['name']) && $_FILES['pdfUpload']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/'; // Directory for uploaded files
            $fileName = time() . "_" . basename($_FILES['pdfUpload']['name']); // Unique file name
            $filePath = $uploadDir . $fileName;

            // Validate file type
            if (mime_content_type($_FILES['pdfUpload']['tmp_name']) === 'application/pdf') {
                if (move_uploaded_file($_FILES['pdfUpload']['tmp_name'], $filePath)) {
                    $pdfPath = $filePath; // Save the file path for database entry
                } else {
                    $error = 'Failed to upload the PDF file.';
                }
            } else {
                $error = 'Invalid file type. Please upload a PDF.';
            }
        }

        // Insert data into the database if no errors
        if (!$error) {
            $stmt = $conn->prepare("INSERT INTO estimates (client_id, description, amount, pdf_path) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("isds", $client_id, $description, $amount, $pdfPath);

            if ($stmt->execute()) {
                $success = 'Estimate created successfully.';
                // Redirect to the estimates list page
                header('Location: index.php');
                exit();
            } else {
                $error = 'Failed to create estimate. Please try again.';
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
                <li class="breadcrumb-item">Add</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Create Estimate</h4>
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
                                                    echo "<option value='" . htmlspecialchars($client['id']) . "'>" . htmlspecialchars($client['name']) . " (" . htmlspecialchars($client['email']) . ")</option>";
                                                }
                                            } else {
                                                echo "<option value=''>No clients available</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="amount" class="form-label">Amount</label>
                                        <input type="number" class="form-control" id="amount" name="amount" step="0.01" min="0" required>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="description" class="form-label">Description</label>
                                        <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="pdfUpload" class="form-label">Upload PDF</label>
                                        <input type="file" class="form-control" id="pdfUpload" name="pdfUpload" accept=".pdf">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Create Estimate</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../include/footer.php'); ?>
