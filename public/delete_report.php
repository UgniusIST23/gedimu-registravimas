<?php
require __DIR__ . '/../config/autoload.php';
use App\Services\Database;
session_start();

if (!isset($_SESSION['username']) || !isset($_GET['id'])) {
    header("Location: login.php");
    exit;
}

$reportId = (int) $_GET['id'];
$db = new Database();

// Gauti prisijungusio vartotojo ID
$stmt = $db->pdo->prepare("SELECT id FROM users WHERE username = ?");
$stmt->execute([$_SESSION['username']]);
$user = $stmt->fetch();

if (!$user) {
    die("Naudotojo nerasta.");
}

// Patikrina ar įrašas priklauso prisijungusiam vartotojui
$check = $db->pdo->prepare("SELECT * FROM reports WHERE id = ? AND user_id = ?");
$check->execute([$reportId, $user['id']]);
$report = $check->fetch();

if ($report) {
    $delete = $db->pdo->prepare("DELETE FROM reports WHERE id = ?");
    $delete->execute([$reportId]);
}

header("Location: view_reports.php");
exit;
