<!-- templates/header.php -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item d-none d-sm-inline-block">
      <a href="index.php" class="nav-link">Home</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link">Profile</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link">Settings</a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <div class="dropdown ml-auto">
    <button class="btn btn-link p-0" type="button" id="userMenu" data-bs-toggle="dropdown" aria-expanded="false">
      <i class="fas fa-user-circle"></i><span class="ml-1"><?= $_SESSION['user']['username'] ?></span>
    </button>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actionMenu<?= $contact['id_contact'] ?>">
      <li>
        <a href="logout.php" class="dropdown-item text-danger">
          <i class="fas fa-sign-out-alt mr-2"></i> Log out
        </a>
      </li>
    </ul>
  </div>
</nav>