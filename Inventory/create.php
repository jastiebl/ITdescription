<?php include('../include/header.php'); ?>

<?php
$error = '';
$success = '';

session_start();

$sql_suppliers = "SELECT id, name FROM suppliers";
$result_suppliers = $conn->query($sql_suppliers);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    extract($_POST);

    if (empty($supplier_id) || empty($product_name) || empty($quantity) || empty($price)) {
        $error = 'Supplier, product name, quantity, and price are required.';
    } else {
        $product_image = '';
        if (isset($_FILES['product_image']) && $_FILES['product_image']['error'] == 0) {
            $target_dir = "../uploads/";
            $target_file = $target_dir . basename($_FILES['product_image']['name']);
            move_uploaded_file($_FILES['product_image']['tmp_name'], $target_file);
            $product_image = basename($_FILES['product_image']['name']);
        }

        $sql = "INSERT INTO inventory (supplier_id, product_name, quantity, price, product_image) 
                VALUES ('$supplier_id', '$product_name', '$quantity', '$price', '$product_image')";

        if ($conn->query($sql) === TRUE) {
            $success = 'Inventory item added successfully.';
        } else {
            $error = 'Failed to save inventory item. Please try again.';
        }
    }
}
?>

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="<?= $baseUrl ?>">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="index.php">Inventory</a></li>
                <li class="breadcrumb-item">Add</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Add Inventory Item</h4>
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
                                        <label for="supplierSelect" class="form-label">Supplier</label>
                                        <select class="form-select" id="supplierSelect" name="supplier_id" required>
                                            <option value="">Select a Supplier</option>
                                            <?php
                                            if ($result_suppliers->num_rows > 0) {
                                                while ($supplier = $result_suppliers->fetch_assoc()) {
                                                    echo "<option value='" . htmlspecialchars($supplier['id']) . "'>" . htmlspecialchars($supplier['name']) . "</option>";
                                                }
                                            } else {
                                                echo "<option value=''>No suppliers available</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="productName" class="form-label">Product Name</label>
                                        <input type="text" class="form-control" id="productName" name="product_name" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="productQuantity" class="form-label">Quantity</label>
                                        <input type="number" class="form-control" id="productQuantity" name="quantity" min="1" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="productPrice" class="form-label">Price</label>
                                        <input type="number" class="form-control" id="productPrice" name="price" step="0.01" min="0" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="productImage" class="form-label">Product Image</label>
                                        <input type="file" class="form-control" id="productImage" name="product_image" accept="image/*">
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Add Inventory Item</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../include/footer.php'); ?>