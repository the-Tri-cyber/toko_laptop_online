<?php

?>

<nav class="navbar navbar-dark bg-dark fixed-top">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Tri <span class="text-info">Store</span></a>
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar" aria-controls="offcanvasDarkNavbar" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
      <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="offcanvasDarkNavbarLabel"></h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
      </div>
      <div class="offcanvas-body">
        <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
          <li class="nav-item">
            <a class="nav-link active" aria-current="page" href="#">Home</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Coming Soon
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li><a class="dropdown-item" href="#">Service Laptop</a></li>
              <li><a class="dropdown-item" href="#">Tukar Kode Promo</a></a></li>
            </ul>
          </li>
        </ul>
        <?php
        // Memeriksa jenis pengguna yang sedang login
        if (isset($_SESSION['role'])) {
          $role = $_SESSION['role'];

          // Menentukan sidebar yang akan digunakan berdasarkan peran pengguna
          switch ($role) {
            case 'admin':
        ?>
              <li class="nav-item">
                <a class="nav-link active text-danger" aria-current="page" href="modules/auth/logout.php">Logout</a>
              </li>
            <?php
              break;
            case 'user':
            ?>
              <li class="nav-item">
                <a class="nav-link active text-danger" aria-current="page" href="modules/auth/logout.php">Logout</a>
              </li>
            <?php
              break;
            default:
            ?>
              <li class="nav-item">
                <a class="nav-link active text-success text-opacity-75%" aria-current="page" href="../../modules/auth/login.php">Login</a> / <a class="nav-link active" aria-current="page" href="../../modules/auth/sign_up.php">Sign Up</a>
              </li>
        <?php // Sidebar untuk pengguna yang tidak terautentikasi
              break;
          }
        } else {
          include 'partials/header_user.php'; // Sidebar untuk pengguna yang tidak terautentikasi
        }
        ?>
      </div>
    </div>
  </div>
</nav>