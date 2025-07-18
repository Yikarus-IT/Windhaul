<?php

define('BASE_PATH', realpath(__DIR__));
require_once BASE_PATH . '/classes/Layout.php';

$layout = new Layout();
$layout->beginPage("Login");
session_start();
if (isset($_SESSION['user'])) {
    header("Location: dashboard.php");
    exit;
}
$layout->renderLogin();
$layout->endPage();
