<?php
namespace App\Services;
use PDO;

class Database {
    // DB prisijungimai
    private $host = 'localhost';
    private $db   = 'user_management';
    private $user = 'root';
    private $pass = '';
    private $charset = 'utf8mb4';

    public $pdo; // Užklausoms vykdyti

    //Panaudotas konstruktius kuris automatiškai prisijungia prie DB kai sukuriamas objektas
    public function __construct() {
        $dsn = "mysql:host=$this->host;dbname=$this->db;charset=$this->charset";
        //PDO nustatymai
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        try {
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (\PDOException $e) {
            die("DB connection failed: " . $e->getMessage());
        }
    }
}
