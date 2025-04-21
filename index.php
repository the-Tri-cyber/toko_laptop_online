<?php
session_start();

// Periksa autentikasi dan otorisasi
if (!in_array($_SESSION['role'], ['user'])) {
    header("Location: modules/auth/login.php");
    exit;
}

include 'config/db.php'; // Sesuaikan path

// Ambil nilai dari form filter
$keyword     = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$hargaMin    = isset($_GET['hargaMin']) ? (int)$_GET['hargaMin'] : 0;
$hargaMax    = isset($_GET['hargaMax']) ? (int)$_GET['hargaMax'] : 0;
$processor   = isset($_GET['processor']) ? $_GET['processor'] : '';

// Bangun query dasar
$sql = "SELECT * FROM produk WHERE 1=1";
$result = mysqli_query($conn, $sql);

// Tambahkan filter nama
if (!empty($keyword)) {
    $sql .= " AND nama_laptop LIKE '%" . mysqli_real_escape_string($conn, $keyword) . "%'";
}

// Tambahkan filter processor
if (!empty($processor)) {
    $sql .= " AND processor LIKE '%" . mysqli_real_escape_string($conn, $processor) . "%'";
}

// Tambahkan filter harga minimum
if ($hargaMin > 0) {
    $sql .= " AND harga >= $hargaMin";
}

// Tambahkan filter harga maksimum
if ($hargaMax > 0) {
    $sql .= " AND harga <= $hargaMax";
}

$sql .= " ORDER BY id_laptop DESC";

$result = mysqli_query($conn, $sql);
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5/css/bootstrap.min.css">
    <title>Halaman User</title>
</head>

<body>

    <!-- navbar -->
    <nav class="navbar navbar-dark bg-dark sticky-top">
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
                            <a class="nav-link active" aria-current="page" href="index.php">Home</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Produk(Coming Soon)
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="coming_soon.html">PC</a></li>
                                <li><a class="dropdown-item" href="coming_soon.html">AIO</a></li>
                                <li><a class="dropdown-item" href="coming_soon.html">Laptop 2-in-1</a></li>
                                <li><a class="dropdown-item" href="coming_soon.html">Kode Kupon</a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active text-danger" aria-current="page" href="modules/auth/logout.php" onclick="return confirm('apakah anda yakin ingin logout?')">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- navbar end -->

    <!-- header -->
    <!-- Header Selamat Datang -->
    <div class="container-fluid text-white py-5 mb-4">
        <div class="container text-center text-dark">
            <h1 class="display-5 fw-bold">Selamat Datang di Toko Tristore</h1>
            <p class="lead mt-3">
                Temukan berbagai pilihan laptop terbaik dengan harga terjangkau dan kualitas terpercaya.
                Tristore siap membantu kebutuhan teknologi Anda!
            </p>
        </div>
    </div>

    <!-- header end -->

    <!-- konten -->
    <div class="container-fluid my-4">
        <div class="row">
            <!-- Sidebar Filter -->
            <div class="col-md-3">
                <h5 class="mb-3">Filter Laptop</h5>
                <form action="" method="GET">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Laptop</label>
                        <input type="text" class="form-control" id="nama" name="nama" placeholder="Contoh: Asus, Lenovo">
                    </div>
                    <div class="mb-3">
                        <label for="processor" class="form-label">Processor</label>
                        <select class="form-select" id="processor" name="processor">
                            <option value="">Semua</option>
                            <option value="Intel">Intel</option>
                            <option value="AMD">AMD</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="hargaMin" class="form-label">Harga Minimum</label>
                        <input type="number" class="form-control" id="hargaMin" name="hargaMin" placeholder="Rp.0">
                    </div>
                    <div class="mb-3">
                        <label for="hargaMax" class="form-label">Harga Maksimum</label>
                        <input type="number" class="form-control" id="hargaMax" name="hargaMax" placeholder="Rp.0">
                    </div>
                    <button type="submit" class="btn btn-primary w-100 mb-2">Terapkan Filter</button>
                    <a href="index.php" class="btn btn-warning w-100">Reset</a>
                </form>
            </div>

            <!-- Daftar Laptop -->
            <div class="col-md-9">
                <h4 class="mb-4">Daftar Laptop</h4>
                <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                    <?php if ($result && mysqli_num_rows($result) > 0): ?>
                        <?php while ($row = mysqli_fetch_assoc($result)): ?>
                            <div class="col">
                                <div class="card h-100">
                                    <img src="<?= $row['foto'] ?>" class="card-img-top" alt="Foto Laptop" style="object-fit: cover;">
                                    <div class="card-body">
                                        <h5 class="card-title text-capitalize"><?= $row['nama_laptop'] ?></h5>
                                        <p class="card-text small">
                                            <strong>Processor:</strong> <?= $row['processor'] ?><br>
                                            <strong>RAM:</strong> <?= $row['ram'] ?><br>
                                            <strong>Storage:</strong> <?= $row['rom'] ?><br>
                                            <strong>VGA:</strong> <?= $row['gpu'] ?><br>
                                            <strong>Harga:</strong><span class="text-danger"> Rp.<?= number_format($row['harga'], 0, ',', '.') ?></span><br>
                                            <strong>Stok:</strong> <?= $row['stok'] ?> | <strong>Terjual:</strong> <?= $row['laptop_terjual'] ?>
                                        </p>
                                        <a href="modules/transaksi/detail_laptop.php?id=<?php echo $row['id_laptop'] ?>" class="btn btn-outline-success w-100">Beli</a>
                                    </div>
                                    <div class="card-footer text-end">
                                        <small class="text-muted">Update: <?= $row['terakhir_update'] ?></small>
                                    </div>
                                </div>
                            </div>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <div class="col">
                            <div class="alert alert-warning">Tidak ada data ditemukan.</div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <!-- konten-end -->

    <!-- footer -->
    <footer class="bottom-0 bg-dark text-white text-center justify-content-center py-2 sticky-bottom">
        <p>&copy; <?php echo date("Y"); ?> <span class="text-info">Tri Store</span>. All rights reserved.</p>
    </footer>
    <!-- footer end -->

    <script src="bootstrap-5/js/bootstrap.bundle.min.js"></script>
</body>

</html>