<?php
require __DIR__ . '/../config/autoload.php';

use App\Services\Database;

session_start();

// Tikriname, ar vartotojas prisijungęs
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$zinute = '';
$klaida = '';
$username = $_SESSION['username'];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $dabartinis = $_POST['current_password'] ?? '';
    $naujas = $_POST['new_password'] ?? '';

    if (empty($dabartinis) || empty($naujas)) {
        $klaida = "Visi laukai yra privalomi.";
    } else {
        $db = new Database();
        $stmt = $db->pdo->prepare("SELECT password FROM users WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch();

        if ($user && password_verify($dabartinis, $user['password'])) {
            $hashedNew = password_hash($naujas, PASSWORD_BCRYPT);
            $update = $db->pdo->prepare("UPDATE users SET password = ? WHERE username = ?");
            $update->execute([$hashedNew, $username]);
            $zinute = "Slaptažodis sėkmingai pakeistas.";
        } else {
            $klaida = "Dabartinis slaptažodis neteisingas.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Slaptažodžio keitimas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
    
<a href="index.php" class="btn btn-secondary">Grįžti į pradžią</a>

<h3>Slaptažodžio keitimas</h3>

<?php if ($klaida): ?>
    <div class="alert alert-danger"><?php echo $klaida; ?></div>
<?php endif; ?>

<?php if ($zinute): ?>
    <div class="alert alert-success"><?php echo $zinute; ?></div>
<?php endif; ?>

<form method="POST">
    <div class="mb-3">
        <label>Dabartinis slaptažodis</label>
        <div class="input-group">
            <input type="password" name="current_password" id="current_password" class="form-control" required>
            <button type="button" class="btn btn-outline-secondary" onclick="rodyti('current_password')">👁️</button>
        </div>
    </div>
    <div class="mb-3">
        <label>Naujas slaptažodis</label>
        <div class="input-group">
            <input type="password" name="new_password" id="new_password" class="form-control" required>
            <button type="button" class="btn btn-outline-secondary" onclick="rodyti('new_password')">👁️</button>
            <button type="button" class="btn btn-warning" onclick="generuoti()">Generuoti</button>
        </div>
    </div>
    <button type="submit" class="btn btn-primary">Pakeisti slaptažodį</button>
</form>

<script>
function rodyti(id) {
    const field = document.getElementById(id);
    field.type = field.type === "password" ? "text" : "password";
}

function generuoti() {
    const sugeneruotas = Math.random().toString(36).slice(-8) + "!@";
    document.getElementById("new_password").value = sugeneruotas;
}
</script>

</body>
</html>
