<?php
require_once realpath(__DIR__ . '/../autoload.php');
require_once BASE_PATH . '/classes/DataTable.php';

$layout = new Layout();
$layout->beginPage("Vehicles");

if (isset($_GET['error']) && $_GET['error'] == 'invalid_id') {
    // Optionally redirect or show error
    echo "<script>alert(\"Vehicle ID doesn't exist\");</script>";
}

$layout->renderHeader();
$layout->renderSidebar();

$controller = new VehicleController();
$vehicles = $controller->getAll();

$layout->renderVehicleList($vehicles);
$layout->renderFooter();
DataTable::render(
    'vehiclesTable'
);
$layout->endPage();
