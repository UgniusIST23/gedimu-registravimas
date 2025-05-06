<?php
require 'autoload.php';

use App\Services\Database;
use App\Services\LoginLogger;

session_start();

$klaida = '';
$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $db = new Database();

    $stmt = $db->pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    $prisijungimasPavyko = false;

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['username'] = $user['username'];
        $prisijungimasPavyko = true;

        $logger = new LoginLogger();
        $logger->log($username, true);

        header("Location: index.php");
        exit;
    } else {
        $klaida = "Neteisingas vartotojo vardas arba slaptažodis.";
        
        $logger = new LoginLogger();
        $logger->log($username, $prisijungimasPavyko);
    }

}
?>

<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Prisijungimas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">

<h3>Prisijungimas</h3>

<?php if ($klaida): ?>
    <div class="alert alert-danger"><?php echo $klaida; ?></div>
<?php endif; ?>

<form method="POST" action="">
    <input class="form-control mb-2" type="text" name="username" placeholder="Prisijungimo vardas" required value="<?php echo htmlspecialchars($username); ?>">

    <div class="input-group mb-3">
        <input type="password" class="form-control" name="password" id="password" placeholder="Slaptažodis" required>
        <button type="button" class="btn btn-outline-secondary" onclick="rodytiSlaptazodi()" title="Rodyti/slėpti slaptažodį">👁️</button>
    </div>

    <button class="btn btn-primary" type="submit">Prisijungti</button>
</form>

<script>
function rodytiSlaptazodi() {
    const laukas = document.getElementById("password");
    laukas.type = laukas.type === "password" ? "text" : "password";
}
</script>

</body>
</html>
