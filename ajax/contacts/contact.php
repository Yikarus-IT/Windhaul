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
        'first_name'    => ['required', 'min' => 3],
        'last_name'     => ['required', 'min' => 3],
        'address'       => ['required', 'min' => 5],
        'email'         => ['required', 'email'],
        'phone_number'  => ['required', 'min' => 7],
        'phone_type'    => ['required', 'number'],
    ];


    //If $_POST['id_contact'] exists, add it to the rules
    if ($_POST['id_contact']) {
        $rules['id_contact'] = ['required', 'number'];
    }

    //Validate that all rules are met
    if (!$validator->validate($rules)) {
        $errors = $validator->getErrors();
        JsonResponse::error('Validation errors', $errors);
        exit;
    }

    // Collect POST data
    $data = [
        'first_name'    => $_POST['first_name'] ?? '',
        'last_name'     => $_POST['last_name'] ?? '',
        'address'       => $_POST['address'] ?? '',
        'phone_number'  => $_POST['phone_number'] ?? '',
        'phone_type'    => $_POST['phone_type'] ?? '',
        'email'         => $_POST['email'] ?? '',
    ];

    //If $_POST['id_contact'] exists, add it to the data
    if ($_POST['id_contact']) {
        $data['id_contact'] = $_POST['id_contact'];
    }

    $controller = new ContactController();
    if ($_POST['id_contact']) {
        $result = $controller->updateContact($data);
    } else {
        $result = $controller->createContact($data);
    }

    if ($result) {
        JsonResponse::success('Contact created successfully', $result);
    } else {
        JsonResponse::error('Failed to create contact.');
    }
} catch (Exception $e) {
    http_response_code(500);
    JsonResponse::error($e->getMessage());
}
