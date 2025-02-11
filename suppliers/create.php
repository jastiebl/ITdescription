<?php include('../include/header.php'); ?>

<?php
$error = '';
$success = '';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    extract($_POST);

    if (empty($name) || empty($phone_no) || empty($address)) {
        $error = 'Name, phone number, and address are required.';
    } else {
        $sql = "INSERT INTO suppliers (name, phone_no, address) VALUES ('$name', '$phone_no', '$address')";

        if ($conn->query($sql) === TRUE) {
            $success = 'Supplier added successfully.';
        } else {
            $error = 'Failed to save supplier. Please try again.';
        }
    }
}
?>

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="<?= $baseUrl ?>">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="index.php">Suppliers</a></li>
                <li class="breadcrumb-item">Add</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add Supplier</h4>
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
                                        <label for="supplierName" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="supplierName" name="name" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="supplierPhone" class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" id="supplierPhone" name="phone_no" required>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <label for="supplierAddress" class="form-label">Address</label>
                                        <textarea class="form-control" id="supplierAddress" name="address" rows="3" required></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Create Supplier</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../include/footer.php'); ?>
