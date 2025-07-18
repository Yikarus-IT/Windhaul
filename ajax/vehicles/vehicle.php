<?php

require_once __DIR__ . '/../../autoload.php';
require_once BASE_PATH . '/classes/Validator.php';
require_once BASE_PATH . '/classes/JsonResponse.php';

try {

    //Validate if request method is POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Invalid request method.");
    }

    $validator = new Validator($_POST);

    $rules = [
        'vehicle_name'    => ['required', 'min' => 3],
        'vehicle_number'     => ['required', 'min' => 3],
        'vehicle_make'       => ['required', 'number'],
        'vehicle_type'         => ['required', 'number'],
        'vehicle_year'  => ['required', 'length' => 4],
        'id_color'    => ['required', 'number']
    ];


    //If $_POST['id_contact'] exists, add it to the rules
    if ($_POST['id_vehicle']) {
        $rules['id_vehicle'] = ['required', 'number'];
    }

    //Validate that all rules are met
    if (!$validator->validate($rules)) {
        $errors = $validator->getErrors();
        JsonResponse::error('Validation errors', $errors);
        exit;
    }

    // Collect POST data
    $data = [
        'vehicle_name'    => $_POST['first_name'] ?? '',
        'vehicle_number'     => $_POST['last_name'] ?? '',
        'id_vehicle_make'       => $_POST['id_vehicle_make'] ?? '',
        'id_vehicle_type'  => $_POST['id_vehicle_type'] ?? '',
        'vehicle_year'    => $_POST['vehicle_year'] ?? '',
        'id_color'    => $_POST['id_color'] ?? ''
    ];

    //If $_POST['id_contact'] exists, add it to the data
    if ($_POST['id_vehicle']) {
        $data['id_vehicle'] = $_POST['id_vehicle'];
    }

    $controller = new VehicleController();
    if ($_POST['id_vehicle']) {
        $result = $controller->updateVehicle($data);
    } else {
        $result = $controller->createVehicle($data);
    }

    if ($result) {
        JsonResponse::success('Vehicle created successfully', $result);
    } else {
        JsonResponse::error('Failed to create vehicle.');
    }
} catch (Exception $e) {
    http_response_code(500);
    JsonResponse::error($e->getMessage());
}
