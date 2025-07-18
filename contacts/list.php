<?php
require_once realpath(__DIR__ . '/../autoload.php');
require_once BASE_PATH . '/classes/DataTable.php';

$layout = new Layout();
$layout->beginPage("Contacts");

if (isset($_GET['error'])) {
    if ($_GET['error'] == 'invalid_id') {
        echo "<script>alert(\"Invalid contact ID\");</script>";
    } elseif ($_GET['error'] == 'empty_id') {
        // Optionally redirect or show error
        echo "<script>alert(\"Contact ID doesn't exist\");</script>";
    }
}

$layout->renderHeader();
$layout->renderSidebar();

$controller = new ContactController();
$contacts = $controller->getAll();

$layout->renderContactList($contacts);
$layout->renderFooter();
DataTable::render(
    'contactsTable'
);
$layout->endPage();
