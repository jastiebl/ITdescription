<?php include('../include/header.php'); ?>

<?php
$error = '';
$success = '';

session_start();

// Fetch employees for the dropdown
$sql_employees = "SELECT id, name FROM employees";
$result_employees = $conn->query($sql_employees);

// Fetch clients for the dropdown
$sql_clients = "SELECT id, name FROM clients";
$result_clients = $conn->query($sql_clients);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    extract($_POST);

    if (empty($employee_id) || empty($client_id) || empty($task_title) || empty($due_date)) {
        $error = 'Employee, client, task title, and due date are required.';
    } else {
        $sql = "INSERT INTO tasks (employee_id, client_id, title, description, due_date, status) 
                VALUES ('$employee_id', '$client_id', '$task_title', '$task_description', '$due_date', 'pending')";

        if ($conn->query($sql) === TRUE) {
            $success = 'Task assigned successfully.';
        } else {
            $error = 'Failed to assign task. Please try again.';
        }
    }
}
?>

<div class="content-body">
    <div class="container-fluid">
        <div class="row page-titles">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active"><a href="<?= $baseUrl ?>">Dashboard</a></li>
                <li class="breadcrumb-item active"><a href="index.php">Assign Tasks</a></li>
                <li class="breadcrumb-item">Add</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Assign Task</h4>
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
                                        <label for="employeeSelect" class="form-label">Assign To Employee</label>
                                        <select class="form-select" id="employeeSelect" name="employee_id" required>
                                            <option value="">Select an Employee</option>
                                            <?php
                                            if ($result_employees->num_rows > 0) {
                                                while ($employee = $result_employees->fetch_assoc()) {
                                                    echo "<option value='" . htmlspecialchars($employee['id']) . "'>" . htmlspecialchars($employee['name']) . "</option>";
                                                }
                                            } else {
                                                echo "<option value=''>No employees available</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="clientSelect" class="form-label">Assign To Client</label>
                                        <select class="form-select" id="clientSelect" name="client_id" required>
                                            <option value="">Select a Client</option>
                                            <?php
                                            if ($result_clients->num_rows > 0) {
                                                while ($client = $result_clients->fetch_assoc()) {
                                                    echo "<option value='" . htmlspecialchars($client['id']) . "'>" . htmlspecialchars($client['name']) . "</option>";
                                                }
                                            } else {
                                                echo "<option value=''>No clients available</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="taskTitle" class="form-label">Task Title</label>
                                        <input type="text" class="form-control" id="taskTitle" name="task_title" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="dueDate" class="form-label">Due Date</label>
                                        <input type="date" class="form-control" id="dueDate" name="due_date" required>
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="taskDescription" class="form-label">Task Description</label>
                                        <textarea class="form-control" id="taskDescription" name="task_description" rows="4"></textarea>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">Assign Task</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../include/footer.php'); ?>
