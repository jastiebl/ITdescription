<?php include('../include/header.php'); ?>

<?php
$error = '';
$success = '';

if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']); 

    $sql_delete = "DELETE FROM inventory WHERE id = $delete_id";
    if ($conn->query($sql_delete) === TRUE) {
        $success = 'Inventory item deleted successfully.';
    } else {
        $error = 'Failed to delete inventory item. Please try again.';
    }
}

$sql_inventory = "
    SELECT inventory.*, suppliers.name AS supplier_name
    FROM inventory
    JOIN suppliers ON inventory.supplier_id = suppliers.id
";
$result_inventory = $conn->query($sql_inventory);

if (!$result_inventory) {
    $error = 'Failed to fetch inventory items. Please try again.';
}
?>

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="<?= $baseUrl ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Inventory</a></li>
            </ol>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">Inventory</h4>
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
                                        <th>Supplier Name</th>
                                        <th>Product Name</th>
                                        <th>Quantity</th>
                                        <th>Price</th>
                                        <th>Product Image</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result_inventory->num_rows > 0) {
                                        while ($row = $result_inventory->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>" . htmlspecialchars($row['supplier_name']) . "</td>
                                                    <td>" . htmlspecialchars($row['product_name']) . "</td>
                                                    <td>" . htmlspecialchars($row['quantity']) . "</td>
                                                    <td>$" . number_format($row['price'], 2) . "</td>
                                                    <td><img src='../uploads/" . htmlspecialchars($row['product_image']) . "' alt='Product Image' style='width: 100px; height: auto;'></td>
                                                    <td>
                                                        <a href='edit.php?id=" . $row['id'] . "' class='btn btn-primary'>Edit</a>
                                                        <a href='index.php?delete_id=" . $row['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                                                    </td>
                                                </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='6' class='text-center'>No inventory items found.</td></tr>";
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
