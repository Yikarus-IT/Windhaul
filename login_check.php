<?php
require_once realpath(__DIR__ . '/autoload.php');

$login = new LoginController();

// Step 1: Check if username and password are set
if (empty($_POST['username']) || empty($_POST['password'])) {
    header('Location: login.php?error=' . urlencode('Username and password are required.'));
    exit;
}

$username = trim($_POST['username']);
$password = $_POST['password'];

// Step 2: Attempt login
if ($login->login($username, $password)) {
    header('Location: index.php');
    exit;
} else {
    header('Location: login.php?error=' . urlencode('Invalid credentials.'));
    exit;
}
