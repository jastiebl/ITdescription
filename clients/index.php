<?php include('../include/header.php'); ?>

<?php
$error = '';
$success = '';

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']); // Sanitize input

    $stmt = $conn->prepare("DELETE FROM clients WHERE id = ?");
    if ($stmt) {
        $stmt->bind_param("i", $delete_id);

        if ($stmt->execute()) {
            $success = 'Client deleted successfully.';
            header("Location: index.php?message=deleted");
            exit();
        } else {
            $error = 'Failed to delete client: ' . $stmt->error;
        }
    } else {
        $error = 'SQL error: ' . $conn->error;
    }
}

// Fetch all clients
$sql_clients = "SELECT * FROM clients";
$result_clients = $conn->query($sql_clients);

if (!$result_clients) {
    $error = 'Failed to fetch clients: ' . $conn->error;
}
?>

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="<?= $baseUrl ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Clients</a></li>
            </ol>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">All Clients</h4>
                        <?php if ($_SESSION['online_user']['role'] == "admin"): ?>
                            <div>
                                <a href="create.php" class="btn btn-dark shadow btn-xs sharp me-1"><i class="fa fa-plus"></i></a>
                            </div>
                        <?php endif ?>
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
                                        <?php if ($_SESSION['online_user']['role'] == "admin"): ?>
                                        <th>Actions</th>
                                        <?php endif ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if ($result_clients->num_rows > 0) {
                                        while ($row = $result_clients->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>" . htmlspecialchars($row['name']) . "</td>
                                                    <td>" . htmlspecialchars($row['email']) . "</td>";

                                            if ($_SESSION['online_user']['role'] == "admin") {
                                                echo "<td>
                                                        <a href='edit.php?id=" . $row['id'] . "' class='btn btn-primary'>Edit</a>
                                                        <a href='index.php?delete_id=" . $row['id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                                                    </td>";
                                            }

                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='4' class='text-center'>No clients found.</td></tr>";
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
