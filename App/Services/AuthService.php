<?php
namespace App\Services;

use App\Core\AuthInterface;

class AuthService {
    public function authenticate(AuthInterface $user, $email, $password) {
        return $user->login($email, $password);
    }

    public function authenticateToDb($user) {
        $this->log("Autentifikuojamas naudotojas: " . $user->getName());

        // Įrašom į DB
        $db = new Database();
        $db->insertUser($user->getName(), $user->getRole());

        $this->log("Vartotojas įrašytas į duomenų bazę.");
    }

    private function log($message) {
        echo "[LOG] $message<br>";
    }
}
