<?php include('../include/header.php'); ?>

<?php
// Initialize error and success messages
$error = '';
$success = '';

// Handle delete request if `delete_id` is set
if (isset($_GET['delete_id'])) {
    $delete_id = intval($_GET['delete_id']); // Use intval to prevent SQL injection

    // Delete query for tasks
    $sql_task = "DELETE FROM tasks WHERE id = $delete_id";
    if ($conn->query($sql_task) === TRUE) {
        $success = 'Task deleted successfully.';
    } else {
        $error = 'Failed to delete task. Please try again.';
    }
}

// Fetch all assigned tasks
$sql_tasks = "
    SELECT 
        tasks.id AS task_id, 
        tasks.title, 
        tasks.description, 
        tasks.due_date, 
        tasks.status, 
        employees.name AS employee_name,
        clients.name AS client_name
    FROM 
        tasks
    LEFT JOIN employees ON tasks.employee_id = employees.id
    LEFT JOIN clients ON tasks.client_id = clients.id
";
$result_tasks = $conn->query($sql_tasks);

if (!$result_tasks) {
    $error = 'Failed to fetch tasks. Please try again.';
}
?>

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="<?= $baseUrl ?>">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="#">Assign Tasks</a></li>
            </ol>
        </div>
        <!-- row -->
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">All Assigned Tasks</h4>
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
                                        <th>Task Title</th>
                                        <th>Employee</th>
                                        <th>Client</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Display tasks
                                    if ($result_tasks->num_rows > 0) {
                                        while ($row = $result_tasks->fetch_assoc()) {
                                            echo "<tr>
                                                    <td>" . htmlspecialchars($row['title']) . "</td>
                                                    <td>" . htmlspecialchars($row['employee_name'] ?: 'Unassigned') . "</td>
                                                    <td>" . htmlspecialchars($row['client_name'] ?: 'N/A') . "</td>
                                                    <td>" . htmlspecialchars($row['due_date'] ?: 'No Due Date') . "</td>
                                                    <td>" . htmlspecialchars(ucfirst($row['status'])) . "</td>
                                                    <td>
                                                        <a href='edit.php?id=" . $row['task_id'] . "' class='btn btn-primary'>Edit</a>
                                                        <a href='index.php?delete_id=" . $row['task_id'] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                                                    </td>
                                                </tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='6' class='text-center'>No tasks assigned.</td></tr>";
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
