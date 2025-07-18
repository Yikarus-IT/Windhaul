<?php
require_once __DIR__ . '/../classes/Layout.php';

$layout = new Layout();
$layout->beginPage("Drivers List");
$layout->renderHeader();
$layout->renderSidebar();
?>

<!-- Main content area -->
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <h1 class="m-0">Driver's List</h1>
    </div>
  </div>
  <section class="content">
    <div class="container-fluid">
      <p>This page lists all the driver's information.</p>
    </div>
  </section>
</div>

<?php
$layout->renderFooter();
$layout->endPage();