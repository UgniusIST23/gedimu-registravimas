<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Prisijungimas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container py-4">

<h3>Prisijungimo forma</h3>

<form method="POST" action="">
    <input type="text" name="username" class="form-control mb-2" placeholder="Prisijungimo vardas" required>

    <div class="input-group mb-3">
        <input type="password" name="password" id="password" class="form-control" placeholder="Slaptažodis" required>
        <button type="button" class="btn btn-outline-secondary" onclick="rodytiSlaptazodi()" title="Rodyti/slėpti slaptažodį">👁️</button>
    </div>

    <button type="submit" class="btn btn-primary">Prisijungti</button>
</form>

<script>
function rodytiSlaptazodi() {
    const laukas = document.getElementById("password");
    laukas.type = laukas.type === "password" ? "text" : "password";
}
</script>

</body>
</html>
