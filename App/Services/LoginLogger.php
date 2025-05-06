<?php
namespace App\Services;

class LoginLogger {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function log($username, $success) {
        $ip = $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';

        $stmt = $this->db->pdo->prepare("
            INSERT INTO login_logs (username, success, ip_address)
            VALUES (?, ?, ?)
        ");
        $stmt->execute([$username, $success ? 1 : 0, $ip]);
    }
}
