<?php
require __DIR__ . '/../config/autoload.php';
use App\Services\UserRegistration;

$zinute = '';
$klaida = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'] ?? '';
    $firstname = $_POST['firstname'] ?? '';
    $lastname = $_POST['lastname'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    if (empty($password)) {
        $klaida = "Prašome įvesti slaptažodį arba paspausti \"Generuoti\".";
    } else {
        try {
            $reg = new UserRegistration();
            $reg->register($username, $firstname, $lastname, $email, $password);
            $zinute = "Registracija sėkminga!";
            $_POST = [];
        } catch (Exception $e) {
            $klaida = $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Registracija</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">
<h3>Registracijos forma</h3>

<?php if ($klaida): ?>
    <div class="alert alert-danger"><?php echo $klaida; ?></div>
<?php endif; ?>

<?php if ($zinute): ?>
    <div class="alert alert-success"><?php echo $zinute; ?></div>
<?php endif; ?>

<form method="POST" action="">
    <input class="form-control mb-2" type="text" name="username" placeholder="Prisijungimo vardas" required value="<?php echo htmlspecialchars($_POST['username'] ?? ''); ?>">
    <input class="form-control mb-2" type="text" name="firstname" placeholder="Vardas" required value="<?php echo htmlspecialchars($_POST['firstname'] ?? ''); ?>">
    <input class="form-control mb-2" type="text" name="lastname" placeholder="Pavardė" required value="<?php echo htmlspecialchars($_POST['lastname'] ?? ''); ?>">
    <input class="form-control mb-2" type="email" name="email" placeholder="El. paštas" required value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>">

    <div class="input-group mb-3">
        <input type="password" class="form-control" name="password" id="password" placeholder="Slaptažodis">
        <button type="button" class="btn btn-outline-secondary" onclick="rodytiSlaptazodi()">👁️</button>
        <button type="button" class="btn btn-warning" onclick="generuotiSlaptazodi()">Generuoti</button>
    </div>

    <button class="btn btn-primary" type="submit">Registruotis</button>
    <a href="login.php" class="btn btn-outline-secondary">Prisijungti</a>
</form>


<script>
function generuotiSlaptazodi() {
    const pwd = Math.random().toString(36).slice(-8) + "!@";
    document.getElementById("password").value = pwd;
}
function rodytiSlaptazodi() {
    const laukas = document.getElementById("password");
    laukas.type = laukas.type === "password" ? "text" : "password";
}
</script>

</body>
</html>
