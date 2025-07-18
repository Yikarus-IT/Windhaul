<?php
require_once realpath(__DIR__ . '/../autoload.php');
require_once BASE_PATH . '/classes/Validator.php';

// Validate the ID
$validator = new Validator($_GET);

$vehicle = [];

//we do this process only if id data exists in the url
if (isset($_GET['id'])) {
    $rules = [
        'id'    => ['required', 'number'],
    ];

    $basePath = dirname($_SERVER['SCRIPT_NAME'], 2);
    if (!$validator->validate($rules)) {
        // Optionally redirect or show error
        header("Location:/Voldhaul/vehicles/list.php?error=invalid_id");
        exit;
    }

    $controller = new VehicleController();
    $vehicle = $controller->getById($_GET['id']);
    if (empty($contact)) {
        header("Location:/Voldhaul/vehicles/list.php?error=empty_id");
        exit;
    }
}

$layout = new Layout();
$layout->beginPage("Vehicles");
$layout->renderHeader();
$layout->renderSidebar();

$layout->renderVehicle($vehicle);
$layout->renderFooter();
$layout->endPage();
