<?php
require 'autoload.php';
use App\Services\Database;
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$db = new Database();
$stmt = $db->pdo->prepare("
    SELECT reports.*, users.username 
    FROM reports 
    JOIN users ON reports.user_id = users.id 
    ORDER BY reports.created_at DESC
");
$stmt->execute();
$reports = $stmt->fetchAll();

// Dabartinio vartotojo ID išgavimas
$userStmt = $db->pdo->prepare("SELECT id FROM users WHERE username = ?");
$userStmt->execute([$_SESSION['username']]);
$currentUser = $userStmt->fetch();
$currentUserId = $currentUser['id'];
?>

<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Įrašai</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">

<h3>Visi įrašai</h3>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Vartotojas</th>
            <th>Antraštė</th>
            <th>Tekstas</th>
            <th>Vieta</th>
            <th>IP</th>
            <th>Data</th>
            <th>Veiksmai</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($reports as $report): ?>
            <tr>
                <td><?php echo htmlspecialchars($report['username']); ?></td>
                <td><?php echo htmlspecialchars($report['title']); ?></td>
                <td><?php echo htmlspecialchars($report['description']); ?></td>
                <td><?php echo htmlspecialchars($report['location']); ?></td>
                <td><?php echo htmlspecialchars($report['ip_address']); ?></td>
                <td><?php echo $report['created_at']; ?></td>
                <td>
                    <?php if ($report['user_id'] == $currentUserId): ?>
                        <a href="delete_report.php?id=<?php echo $report['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Ar tikrai norite ištrinti įrašą?')">Trinti</a>
                    <?php else: ?>
                        —
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
