<?php
require_once __DIR__ . '/../../autoload.php';
require_once BASE_PATH . '/classes/Validator.php';
require_once BASE_PATH . '/classes/JsonResponse.php';

try {

    //Validate that request method is POST
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        throw new Exception("Invalid request method.");
    }

    $validator = new Validator($_POST);

    $rules = [
        'id' => ['required', 'number']
    ];

    //Validat that id is a number
    if (!$validator->validate($rules)) {
        $errors = $validator->getErrors();
        JsonResponse::error('Validation errors', $errors);
        exit;
    }

    $controller = new ContactController();
    $result = $controller->delete($_POST['id']);

    if ($result) {
        JsonResponse::success('Contact deleted successfully', $result);
    } else {
        JsonResponse::error('Failed to delete contact.');
    }
} catch (Exception $e) {
    http_response_code(500);
    JsonResponse::error($e->getMessage());
    exit;
}
