<?php
include('../include/header.php');
include('../lib/db.php'); // Ensure this path is correct

// Check the user's role to determine the data to fetch
$role = $_SESSION['online_user']['role'];
$client_id = $_SESSION['online_user']['id'];

// Fetch data based on the user's role
if ($role === 'admin') {
    // Fetch all estimate requests for admin
    $sql = "SELECT er.id, er.services, er.additional_services, er.status, er.created_at, c.name AS client_name
            FROM estimate_requests er
            JOIN clients c ON er.client_id = c.id
            ORDER BY er.created_at DESC";
} elseif ($role === 'client') {
    // Fetch both admin-assigned estimates and client-requested estimates
    $sql = "
        SELECT 
            id,
            'admin' AS source, 
            description AS services,
            NULL AS additional_services,
            amount,
            status,
            created_at
        FROM estimates
        WHERE client_id = $client_id

        UNION

        SELECT 
            id,
            'client' AS source,
            services,
            additional_services,
            NULL AS amount,
            status,
            created_at
        FROM estimate_requests
        WHERE client_id = $client_id

        ORDER BY created_at DESC";
} else {
    // Redirect if the role is neither admin nor client
    header('Location: ../login.php');
    exit();
}

$result = $conn->query($sql);
?>

<div class="content-body">
    <div class="container-fluid">
        <h4 class="card-title"><?= $role === 'admin' ? 'All Estimate Requests' : 'My Estimates' ?></h4>
        <table class="table">
            <thead>
                <tr>
                    <?php if ($role === 'admin'): ?>
                        <th>Client Name</th>
                    <?php endif; ?>
                    <th>Services</th>
                    <th>Additional Information</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Date Submitted</th>
                    <?php if ($role === 'admin'): ?>
                        <th>Actions</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <?php if ($role === 'admin'): ?>
                                <td><?= htmlspecialchars($row['client_name']) ?></td>
                            <?php endif; ?>
                            <td><?= htmlspecialchars($row['services']) ?></td>
                            <td><?= htmlspecialchars($row['additional_services'] ?? 'N/A') ?></td>
                            <td><?= $row['amount'] !== null ? "$" . number_format($row['amount'], 2) : 'N/A' ?></td>
                            <td>
                                <span class="badge bg-<?= $row['status'] === 'approved' ? 'success' : ($row['status'] === 'rejected' ? 'danger' : 'warning') ?>">
                                    <?= ucfirst($row['status']) ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($row['created_at']) ?></td>
                            <?php if ($role === 'admin'): ?>
                                <td>
                                    <?php if ($row['status'] === 'pending'): ?>
                                        <a href="approve.php?id=<?= $row['id'] ?>" class="btn btn-success btn-sm">Approve</a>
                                        <a href="reject.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Reject</a>
                                    <?php else: ?>
                                        <span class="text-muted">No actions available</span>
                                    <?php endif; ?>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="<?= $role === 'admin' ? 7 : 6 ?>" class="text-center">No estimates found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('../include/footer.php'); ?>
