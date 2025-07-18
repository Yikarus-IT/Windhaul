<?php
require_once realpath(__DIR__ . '/../autoload.php');
require_once BASE_PATH . '/classes/Validator.php';

// Validate the ID
$validator = new Validator($_GET);

$contact = [];

//we do this process only if id data exists in the url
if (isset($_GET['id'])) {
    $rules = [
        'id'    => ['required', 'number'],
    ];

    $basePath = dirname($_SERVER['SCRIPT_NAME'], 2);
    if (!$validator->validate($rules)) {
        // Optionally redirect or show error
        header("Location:/Voldhaul/contacts/list.php?error=invalid_id");
        exit;
    }

    $controller = new ContactController();
    $contact = $controller->getById($_GET['id']);
    if (empty($contact)) {
        header("Location:/Voldhaul/contacts/list.php?error=empty_id");
        exit;
    }
}

$layout = new Layout();
$layout->beginPage("Contacts");
$layout->renderHeader();
$layout->renderSidebar();

$layout->renderContact($contact);
$layout->renderFooter();
$layout->endPage();
