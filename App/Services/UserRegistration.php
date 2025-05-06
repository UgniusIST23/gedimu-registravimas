<?php
namespace App\Services;

use App\Services\Database;
use PDO;
use Exception;

class UserRegistration {
    public function register($username, $firstname, $lastname, $email, $password) {
        $db = new Database();

        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        try {
            $stmt = $db->pdo->prepare("
                INSERT INTO users (username, firstname, lastname, email, password)
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->execute([$username, $firstname, $lastname, $email, $hashedPassword]);
        } catch (\PDOException $e) {
            if ($e->getCode() === '23000') {
                if (str_contains($e->getMessage(), 'username')) {
                    throw new Exception("Vartotojo vardas jau egzistuoja.");
                } elseif (str_contains($e->getMessage(), 'email')) {
                    throw new Exception("Šis el. paštas jau užregistruotas.");
                }
            }
            throw new Exception("Įvyko klaida registruojant naudotoją.");
        }
    }
}
