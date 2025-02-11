<?php
include('../include/header.php');
include('../include/db_connection.php');

// Fetch all estimate requests
$sql = "SELECT er.id, er.services, er.additional_services, er.status, er.created_at, c.name AS client_name
        FROM estimate_requests er
        JOIN clients c ON er.client_id = c.id
        ORDER BY er.created_at DESC";

$result = $conn->query($sql);
?>

<div class="content-body">
    <div class="container-fluid">
        <h4 class="card-title">Estimate Requests</h4>
        <table class="table">
            <thead>
                <tr>
                    <th>Client Name</th>
                    <th>Services</th>
                    <th>Additional Information</th>
                    <th>Status</th>
                    <th>Date Submitted</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($result->num_rows > 0): ?>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['client_name']) ?></td>
                            <td><?= htmlspecialchars($row['services']) ?></td>
                            <td><?= htmlspecialchars($row['additional_services']) ?></td>
                            <td><?= ucfirst($row['status']) ?></td>
                            <td><?= htmlspecialchars($row['created_at']) ?></td>
                            <td>
                                <a href="approve.php?id=<?= $row['id'] ?>" class="btn btn-success btn-sm">Approve</a>
                                <a href="reject.php?id=<?= $row['id'] ?>" class="btn btn-danger btn-sm">Reject</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6">No estimate requests found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include('../include/footer.php'); ?>
