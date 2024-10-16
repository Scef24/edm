<?php
require_once __DIR__ . '../../Database.php';

class UserModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    public function saveUserDetails($details) {
        $stmt = $this->db->prepare("INSERT INTO user_details (fname, lname, address, age, bday) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$details['fname'], $details['lname'], $details['address'], $details['age'], $details['bday']]);
        return $this->db->lastInsertId();
    }

    public function saveUserCredentials($credentials) {
        $stmt = $this->db->prepare("INSERT INTO user_cred (username, password, user_details_id) VALUES (?, ?, ?)");
        $stmt->execute([$credentials['username'], $credentials['password'], $credentials['user_details_id']]);
    }

    public function authenticate($username, $password) {
        $stmt = $this->db->prepare("SELECT * FROM user_cred WHERE username = ?");
        $stmt->execute([$username]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            return true;
        }
        return false;
    }
}