<?php
// autoload.php

session_start();

define('BASE_PATH', realpath(__DIR__));

require_once BASE_PATH . '/classes/Config.php';
$config = new Config(BASE_PATH . '/config.php');

require_once BASE_PATH . '/classes/Layout.php';
require_once BASE_PATH . '/classes/Database.php';
require_once BASE_PATH . '/classes/GenericController.php';
foreach ($config->get('autoload_controllers') as $controllerName) {
    require_once BASE_PATH . '/classes/' . $controllerName . '.php';
}

// Session logic (skip on login page)
$currentFile = basename($_SERVER['SCRIPT_NAME']);
if ($currentFile !== 'login.php' && $currentFile !== 'login_check.php') {
    if (!LoginController::isUserLoggedIn()) {
        header('Location: /Voldhaul/login.php');
        exit;
    }
}
