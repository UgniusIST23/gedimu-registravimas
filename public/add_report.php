<?php
require __DIR__ . '/../config/autoload.php';
use App\Services\Database;

session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$db = new Database();
$zinute = '';
$klaida = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title = $_POST['title'] ?? '';
    $description = $_POST['description'] ?? '';
    $location = $_POST['location'] ?? '';
    $ip = $_SERVER['REMOTE_ADDR'];
    $username = $_SESSION['username'];

    // Gaunamas user_id pagal username
    $stmt = $db->pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && !empty($title) && !empty($description)) {
        $insert = $db->pdo->prepare("INSERT INTO reports (user_id, title, description, location, ip_address) VALUES (?, ?, ?, ?, ?)");
        $insert->execute([$user['id'], $title, $description, $location, $ip]);
        $zinute = "Įrašas sėkmingai išsaugotas.";
    } else {
        $klaida = "Būtina užpildyti pavadinimą ir aprašymą!";
    }
}
?>

<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Pridėti įrašą</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">

<a href="index.php" class="btn btn-secondary">Grįžti į pradžią</a>

<h3>Naujas gedimo įrašas</h3>

<?php if ($zinute): ?>
    <div class="alert alert-success"><?php echo $zinute; ?></div>
<?php endif; ?>
<?php if ($klaida): ?>
    <div class="alert alert-danger"><?php echo $klaida; ?></div>
<?php endif; ?>

<form method="POST">
    <div class="mb-3">
        <label for="title">Antraštė</label>
        <input type="text" class="form-control" name="title" id="title">
    </div>
    <div class="mb-3">
        <label for="description">Aprašymas</label>
        <textarea class="form-control" name="description" id="description" rows="4"></textarea>
    </div>
    <div class="mb-3">
        <label for="location">Vieta (neprivaloma)</label>
        <input type="text" class="form-control" name="location" id="location">
    </div>
    <button type="submit" class="btn btn-primary">Pateikti įrašą</button>
</form>

</body>
</html>
