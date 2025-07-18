<?php
// Make sure $layout is in scope when including this sidebar
?>

<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <a href="index.php" class="brand-link">
    <span class="brand-text font-weight-light">Admin Panel</span>
  </a>

  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">

        <!-- Dashboard Link -->
        <li class="nav-item">
          <a href="index.php" class="nav-link <?= $layout->isActive('/index.php') ?>">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>Dashboard</p>
          </a>
        </li>

        <!-- Drivers Menu Group -->
        <?php
        // Check if any driver page is active
        $driversActive = (
          $layout->isActive('/drivers/list.php') ||
          $layout->isActive('/drivers/create.php')
        );
        $treeViewClass = $driversActive ? 'menu-open' : '';
        $parentLinkClass = $driversActive ? 'active' : '';
        ?>
        <li class="nav-item has-treeview <?= $treeViewClass ?>">
          <a href="#" class="nav-link <?= $parentLinkClass ?>">
            <i class="nav-icon fas fa-car"></i>
            <p>
              Drivers
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="drivers/list.php" class="nav-link <?= $layout->isActive('/drivers/list.php') ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>List</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="drivers/create.php" class="nav-link <?= $layout->isActive('/drivers/create.php') ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Create</p>
              </a>
            </li>
          </ul>
        </li>
        <!-- End of Drivers Menu Group -->

        <!-- Vehicles Menu Group -->
        <?php
        // Check if any driver page is active
        $vehiclesActive = (
          $layout->isActive('/vehicles/list.php') ||
          $layout->isActive('/vehicles/create.php')
        );
        $treeViewClass = $vehiclesActive ? 'menu-open' : '';
        $parentLinkClass = $vehiclesActive ? 'active' : '';
        ?>
        <li class="nav-item has-treeview <?= $treeViewClass ?>">
          <a href="#" class="nav-link <?= $parentLinkClass ?>">
            <i class="nav-icon fas fa-truck"></i>
            <p>
              Vehicles
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="vehicles/list.php" class="nav-link <?= $layout->isActive('/vehicles/list.php') ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>List</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="vehicles/vehicle.php" class="nav-link <?= $layout->isActive('/vehicles/vehicle.php') ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Create</p>
              </a>
            </li>
          </ul>
        </li>
        <!-- End of Vehicles Menu Group -->

        <!-- Carriers Menu Group -->
        <?php
        // Check if any carrier page is active
        $driversActive = (
          $layout->isActive('/carriers/list.php') ||
          $layout->isActive('/carriers/create.php')
        );
        $treeViewClass = $driversActive ? 'menu-open' : '';
        $parentLinkClass = $driversActive ? 'active' : '';
        ?>
        <li class="nav-item has-treeview <?= $treeViewClass ?>">
          <a href="#" class="nav-link <?= $parentLinkClass ?>">
            <i class="nav-icon fas fa-institution"></i>
            <p>
              Carriers
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="carriers/list.php" class="nav-link <?= $layout->isActive('/carriers/list.php') ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>List</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="carriers/create.php" class="nav-link <?= $layout->isActive('/carriers/create.php') ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>Create</p>
              </a>
            </li>
          </ul>
        </li>
        <!-- End of Carriers Menu Group -->

        <!-- Contacts Menu Group -->
        <?php
        // Check if any contact page is active
        $contactsActive = (
          $layout->isActive('/contacts/list.php') ||
          $layout->isActive('/contacts/contact.php')
        );
        $treeViewClass = $contactsActive ? 'menu-open' : '';
        $parentLinkClass = $contactsActive ? 'active' : '';
        ?>
        <li class="nav-item has-treeview <?= $treeViewClass ?>">
          <a href="#" class="nav-link <?= $parentLinkClass ?>">
            <i class="nav-icon fas fa-users"></i>
            <p>
              Contacts
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="contacts/list.php" class="nav-link <?= $layout->isActive('/contacts/list.php') ?>">
                <i class="far fa-circle nav-icon"></i>
                <p>List</p>
              </a>
            </li>
            <?php
            if (UserController::getRoleName() != 'Viewer') {
            ?>
              <li class="nav-item">
                <a href="contacts/contact.php" class="nav-link <?= $layout->isActive('/contacts/contact.php') ?>">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create</p>
                </a>
              </li>
            <?php
            }
            ?>
          </ul>
        </li>
        <!-- End of Contacts Menu Group -->
      </ul>
    </nav>
  </div>
</aside>