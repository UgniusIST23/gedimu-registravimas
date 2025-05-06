<?php
namespace App\Core;

abstract class AbstractUser {
    protected $name;
    protected $email;
    protected $password;

    public function __construct($name, $email, $password) {
        $this->name = $name;
        $this->email = $email;
        $this->password = password_hash($password, PASSWORD_DEFAULT);
    }

    public function getName() {
        return $this->name;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getRole() { //Kad galėtume iš AuthService klasės gauti naudotojo rolę ir ją įrašyti į duomenų bazę
        return $this->userRole();
    }

    abstract public function userRole();
}

?>
