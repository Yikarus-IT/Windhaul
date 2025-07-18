<?php
require_once __DIR__ . '/../../autoload.php';
require_once BASE_PATH . '/classes/JsonResponse.php';

try {
    $controller = new ContactController();
    $types = $controller->getPhoneTypes();
    JsonResponse::success('Phone types retrieved successfully', $types);
} catch (Exception $e) {
    http_response_code(500);
    JsonResponse::error($e->getMessage());
}
