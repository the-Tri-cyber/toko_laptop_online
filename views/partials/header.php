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
            <a class="nav-link active" aria-current="page" href="<?php echo BASE_URL; ?>">Home</a>
          </li>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="<?php echo BASE_URL; ?>" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Tabel
            </a>
            <ul class="dropdown-menu dropdown-menu-dark">
              <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>modules/user/">User</a></li>
              <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>modules/transaksi">Transaksi</a></li>
              <li><a class="dropdown-item" href="<?php echo BASE_URL; ?>modules/produk">Laptop</a></a></li>
            </ul>
          </li>
        </ul>
        <li class="nav-item">
          <a class="nav-link active text-danger" aria-current="page" href="<?php echo BASE_URL; ?>modules/auth/logout.php" onclick="return confirm('apakah anda yakin ingin logout?')">Logout</a>
        </li>
      </div>
    </div>
  </div>
</nav>