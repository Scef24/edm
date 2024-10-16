<?php
require_once __DIR__ . '/../model/UserModel.php';

class UserController {
    public static function showRegisterForm() {
        require_once __DIR__ . '/../view/register.php';
    }

    public static function registerUserDetails() {
        $userDetails = [
            'fname' => $_POST['fname'],
            'lname' => $_POST['lname'],
            'address' => $_POST['address'],
            'age' => $_POST['age'],
            'bday' => $_POST['bday']
        ];
        $userModel = new UserModel();
        $userDetailsId = $userModel->saveUserDetails($userDetails);
        $_SESSION['user_details_id'] = $userDetailsId;
        header('Location: index.php?action=showRegisterCredentialsForm');
    }

    public static function showRegisterCredentialsForm() {
        require_once __DIR__ . '/../view/register_credentials.php';
    }

    public static function registerUserCredentials() {
        $userCred = [
            'username' => $_POST['username'],
            'password' => password_hash($_POST['password'], PASSWORD_BCRYPT),
            'user_details_id' => $_SESSION['user_details_id']
        ];
        $userModel = new UserModel();
        $userModel->saveUserCredentials($userCred);
        header('Location: index.php?action=showLoginForm');
    }

    public static function showLoginForm() {
        require_once __DIR__ . '/../view/login.php';
    }
    public static function showDashboard() {
        require_once __DIR__ . '/../view/Dashboard.php';
    }

    public static function login() {
        try {
            $username = $_POST['username'];
            $password = $_POST['password'];
            $userModel = new UserModel();

            if ($userModel->authenticate($username, $password)) {
                session_start();
                $_SESSION['authenticated'] = true;
                $_SESSION['username'] = $username; 
                header('Location: Dashboard.php');
                exit();
            } else {
                echo "Invalid credentials";
            }
        } catch (Exception $e) {

            error_log($e->getMessage());

          
            echo "An error occurred during login. Please try again later.";
        }
    }
}
