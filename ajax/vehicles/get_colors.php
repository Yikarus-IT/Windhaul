<?php
require_once __DIR__ . '/../../autoload.php';
require_once BASE_PATH . '/classes/JsonResponse.php';

try {
    $controller = new VehicleController();
    $types = $controller->getColors();
    JsonResponse::success('Colors retrieved successfully', $types);
} catch (Exception $e) {
    http_response_code(500);
    JsonResponse::error($e->getMessage());
}
