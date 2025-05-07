<?php
session_start();

// Sesijos panaikinimas
session_unset();
session_destroy();

// Cookies ištrinimas
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Grįžimas į prisijungimo langą
header("Location: login.php");
exit;
