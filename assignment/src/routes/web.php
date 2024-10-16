<?php
require_once __DIR__ . '/../controller/UserController.php';


session_start();

$action = $_GET['action'] ?? 'showRegisterForm';

switch ($action) {
    case 'showRegisterForm':
        UserController::showRegisterForm();
        break;
    case 'registerUserDetails':
        UserController::registerUserDetails();
        break;
    case 'showRegisterCredentialsForm':
        UserController::showRegisterCredentialsForm();
        break;
    case 'registerUserCredentials':
        UserController::registerUserCredentials();
        break;
    case 'showLoginForm':
        UserController::showLoginForm();
        break;
    case 'login':
        UserController::login();
        break;
    default:
        UserController::showRegisterForm();
        break;
}