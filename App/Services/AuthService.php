<?php
namespace App\Services;

use App\Core\AuthInterface;

class AuthService {
    public function authenticate(AuthInterface $user, $email, $password) {
        return $user->login($email, $password);
    }

    private function log($message) {
        echo "[LOG] $message<br>";
    }
}
