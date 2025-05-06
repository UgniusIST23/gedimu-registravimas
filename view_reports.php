<?php
require 'autoload.php';
use App\Services\Database;

session_start();

// Neprisijungę vartotojai neturi prieigos
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$db = new Database();

// Gauname visus įrašus su prisijungusiu vartotoju
$stmt = $db->pdo->query("
    SELECT reports.*, users.username 
    FROM reports 
    JOIN users ON reports.user_id = users.id 
    ORDER BY reports.created_at DESC
");

$reports = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Gedimų sąrašas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">

<h3>Visi gedimų įrašai</h3>

<?php if (empty($reports)): ?>
    <p>Gedimų įrašų nėra.</p>
<?php else: ?>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Vartotojas</th>
                <th>Antraštė</th>
                <th>Aprašymas</th>
                <th>Vieta</th>
                <th>Data</th>
                <th>IP adresas</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reports as $report): ?>
                <tr>
                    <td><?php echo htmlspecialchars($report['username']); ?></td>
                    <td><?php echo htmlspecialchars($report['title']); ?></td>
                    <td><?php echo htmlspecialchars($report['description']); ?></td>
                    <td><?php echo htmlspecialchars($report['location']); ?></td>
                    <td><?php echo $report['created_at']; ?></td>
                    <td><?php echo $report['ip_address']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

</body>
</html>
