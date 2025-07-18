<?php
require_once realpath(__DIR__ . '/autoload.php');

$layout = new Layout();

$layout->beginPage("Admin Dashboard");
$layout->renderHeader();
$layout->renderSidebar();
?>

<!-- Main content area -->
<div class="content-wrapper">
  <div class="content-header">
    <div class="container-fluid">
      <h1 class="m-0">Dashboard</h1>
    </div>
  </div>
  <section class="content">
    <div class="container-fluid">
      <p>This is your main dashboard content.</p>
    </div>
  </section>
</div>

<?php
$layout->renderFooter(); // Optional, if you create footer.php
$layout->endPage();
?>