<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Pagrindinis</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="text-center">
        <h3>Sveiki, <?php echo htmlspecialchars($username); ?>!</h3>
        <p>Pasirinkite, ką norite daryti:</p>
        <a href="change_password.php" class="btn btn-primary">A. Pakeisti slaptažodį</a>
    </div>
</div>

</body>
</html>
