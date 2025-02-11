<?php include('../include/header.php'); ?>

<?php
$error = '';
$success = '';

session_start();

// Fetch employees and clients
$sql_employees = "SELECT id, name FROM employees"; // Replace with your employee table
$result_employees = $conn->query($sql_employees);

$sql_clients = "SELECT id, name FROM clients"; // Replace with your client table
$result_clients = $conn->query($sql_clients);

$edit_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$task = null;

if ($edit_id > 0) {
    $sql_task = "SELECT * FROM tasks WHERE id = '$edit_id'";
    $result_task = $conn->query($sql_task);
    if ($result_task->num_rows > 0) {
        $task = $result_task->fetch_assoc();
    } else {
        $error = 'Task not found.';
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    extract($_POST);

    if (empty($employee_id) || empty($title)) {
        $error = 'Employee and title are required.';
    } else {
        if ($edit_id > 0) {
            // Update the task
            $sql = "UPDATE tasks 
                    SET employee_id = '$employee_id', 
                        client_id = " . ($client_id ? "'$client_id'" : "NULL") . ", 
                        title = '$title', 
                        description = '$description', 
                        due_date = " . ($due_date ? "'$due_date'" : "NULL") . ", 
                        status = '$status' 
                    WHERE id = '$edit_id'";
            if ($conn->query($sql) === TRUE) {
                $success = 'Task updated successfully.';
            } else {
                $error = 'Failed to update task. Please try again.';
            }
        } else {
            // Insert a new task
            $sql = "INSERT INTO tasks (employee_id, client_id, title, description, due_date, status) 
                    VALUES ('$employee_id', " . ($client_id ? "'$client_id'" : "NULL") . ", '$title', '$description', " . ($due_date ? "'$due_date'" : "NULL") . ", '$status')";
            if ($conn->query($sql) === TRUE) {
                $success = 'Task assigned successfully.';
            } else {
                $error = 'Failed to assign task. Please try again.';
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
                <li class="breadcrumb-item active"><a href="index.php">Tasks</a></li>
                <li class="breadcrumb-item"><?= $edit_id > 0 ? 'Edit' : 'Assign' ?> Task</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title"><?= $edit_id > 0 ? 'Edit' : 'Assign' ?> Task</h4>
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
                                        <label for="employee" class="form-label">Assign To (Employee)</label>
                                        <select class="form-select" id="employee" name="employee_id" required>
                                            <option value="">Select an Employee</option>
                                            <?php
                                            if ($result_employees->num_rows > 0) {
                                                while ($employee = $result_employees->fetch_assoc()) {
                                                    $selected = $task && $task['employee_id'] == $employee['id'] ? 'selected' : '';
                                                    echo "<option value='" . htmlspecialchars($employee['id']) . "' $selected>" . htmlspecialchars($employee['name']) . "</option>";
                                                }
                                            } else {
                                                echo "<option value=''>No employees available</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="client" class="form-label">Related Client (Optional)</label>
                                        <select class="form-select" id="client" name="client_id">
                                            <option value="">Select a Client</option>
                                            <?php
                                            if ($result_clients->num_rows > 0) {
                                                while ($client = $result_clients->fetch_assoc()) {
                                                    $selected = $task && $task['client_id'] == $client['id'] ? 'selected' : '';
                                                    echo "<option value='" . htmlspecialchars($client['id']) . "' $selected>" . htmlspecialchars($client['name']) . "</option>";
                                                }
                                            } else {
                                                echo "<option value=''>No clients available</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="taskTitle" class="form-label">Task Title</label>
                                        <input type="text" class="form-control" id="taskTitle" name="title" value="<?= $task['title'] ?? '' ?>" required>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="dueDate" class="form-label">Due Date</label>
                                        <input type="date" class="form-control" id="dueDate" name="due_date" value="<?= $task['due_date'] ?? '' ?>">
                                    </div>
                                    <div class="col-md-12 mb-3">
                                        <label for="taskDescription" class="form-label">Task Description</label>
                                        <textarea class="form-control" id="taskDescription" name="description" rows="4"><?= $task['description'] ?? '' ?></textarea>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select" id="status" name="status" required>
                                            <option value="pending" <?= isset($task['status']) && $task['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                            <option value="in-progress" <?= isset($task['status']) && $task['status'] === 'in-progress' ? 'selected' : '' ?>>In Progress</option>
                                            <option value="completed" <?= isset($task['status']) && $task['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                                        </select>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary"><?= $edit_id > 0 ? 'Update' : 'Assign' ?> Task</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('../include/footer.php'); ?>
