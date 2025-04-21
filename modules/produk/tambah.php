<?php
session_start();

// Periksa autentikasi dan otorisasi
if (!in_array($_SESSION['role'], ['admin'])) {
    header("Location: ../../index.php");
    exit;
}

include '../../config/db.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../bootstrap-5/css/bootstrap.min.css">
    <title>Tambah Laptop</title>
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
                            <a class="nav-link active" aria-current="page" href="../../admin.php">Home</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Tabel
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="../user/">User</a></li>
                                <li><a class="dropdown-item" href="../transaksi/">Transaksi</a></li>
                                <li><a class="dropdown-item" href="../produk/">Laptop</a></a></li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active text-danger" aria-current="page" href="../auth/logout.php" onclick="return confirm('apakah anda yakin ingin logout?')">Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- navbar end -->

    <div class="mx-5 mb-4 mx-auto" style="max-width: 600px;">
        <h1 class="mb-4">Tambah Laptop</h1>
        <form action="tambah_proses.php" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
            <!-- Nama Laptop -->
            <div class="mb-3">
                <label for="nama_laptop" class="form-label">Nama Laptop:</label>
                <input type="text" class="form-control" id="nama_laptop" name="nama_laptop" required>
                <div class="invalid-feedback">Nama Laptop harus diisi.</div>
            </div>

            <!-- Processor Laptop -->
            <div class="mb-3">
                <label for="processor" class="form-label">Processor:</label>
                <input type="text" class="form-control" id="processor" name="processor" required placeholder="(Contoh: Intel Core i5-7600U)">
                <div class="invalid-feedback">Processor harus diisi.</div>
            </div>

            <!-- RAM Laptop -->
            <div class="mb-3">
                <label for="ram" class="form-label">RAM:</label>
                <input type="text" class="form-control" id="ram" name="ram" required placeholder="(Contoh: 4gb DDR5)">
                <div class="invalid-feedback">RAM harus diisi.</div>
            </div>

            <!-- ROM Laptop -->
            <div class="mb-3">
                <label for="rom" class="form-label">ROM:</label>
                <input type="text" class="form-control" id="rom" name="rom" required placeholder="(Contoh: 256gb SSD)">
                <div class="invalid-feedback">ROM harus diisi.</div>
            </div>

            <!-- GPU Laptop -->
            <div class="mb-3">
                <label for="gpu" class="form-label">GPU:</label>
                <input type="text" class="form-control" id="gpu" name="gpu" required placeholder="(Contoh: Intel UHD Graphics 600)">
                <div class="invalid-feedback">GPU harus diisi.</div>
            </div>

            <!-- Deskripsi Laptop -->
            <div class="mb-3">
                <label for="deskripsi" class="form-label">Deskripsi:</label>
                <textarea class="form-control" id="deskripsi" name="deskripsi" required></textarea>
                <div class="invalid-feedback">Deskripsi harus diisi.</div>
            </div>

            <!-- Harga Laptop -->
            <div class="mb-3">
                <label for="harga" class="form-label">Harga:</label>
                <input type="number" class="form-control" id="harga" name="harga" required>
                <div class="invalid-feedback">Harga harus diisi.</div>
            </div>

            <!-- Laptop Terjual -->
            <div class="mb-3">
                <label for="laptop_terjual" class="form-label">Laptop Terjual:</label>
                <input type="number" class="form-control" id="laptop_terjual" name="laptop_terjual" required>
                <div class="invalid-feedback">Jumlah Laptop Terjual harus diisi.</div>
            </div>

            <!-- Stok Laptop -->
            <div class="mb-3">
                <label for="stok" class="form-label">Stok:</label>
                <input type="number" class="form-control" id="stok" name="stok" required>
                <div class="invalid-feedback">Stok harus diisi.</div>
            </div>

            <!-- Foto Laptop -->
            <div class="mb-3">
                <label for="foto" class="form-label">Foto:</label>
                <input type="text" class="form-control" id="foto" placeholder="(ambil link online seperti di Google)" name="foto">
            </div>

            <!-- Button Submit -->
            <button type="submit" class="btn btn-primary">Tambah</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>


    <!-- footer -->
    <footer class="bottom-0 bg-dark text-white text-center justify-content-center py-2 sticky-bottom">
        <p>&copy; <?php echo date("Y"); ?> <span class="text-info">Tri Store</span>. All rights reserved.</p>
    </footer>
    <!-- footer end -->

    <script src="../../bootstrap-5/js/bootstrap.bundle.min.js"></script>
</body>

</html>