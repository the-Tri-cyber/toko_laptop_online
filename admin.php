<?php
session_start();

// Periksa autentikasi dan otorisasi
if (!in_array($_SESSION['role'], ['admin'])) {
    header("Location: index.php");
    exit;
}

include 'config/db.php';

$query = "SELECT * FROM users ORDER BY id_user DESC";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-5/css/bootstrap.min.css">
    <title>Halaman Admin</title>
</head>

<body>

    <!-- navbar -->
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
                                Tabel
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="modules/user/">User</a></li>
                                <li><a class="dropdown-item" href="modules/transaksi/">Transaksi</a></li>
                                <li><a class="dropdown-item" href="modules/produk/">Laptop</a></a></li>
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

    <div class="container">
        <h1 class="mb-4">Dashboard</h1>
        <p>Selamat datang, <?php echo htmlspecialchars($_SESSION['nama']); ?>! Anda dapat mengelola produk, transaksi, dan pengguna dari sini.</p>

        <div class="row">
            <div class="col-md-4">
                <a href="/tristore/modules/barang" class="card text-white bg-primary mb-4">
                    <div class="card-header">Total Laptop</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $barangTersedia . " / " . $totalBarang; ?></h5>
                        <p class="card-text">Jumlah barang tersedia dibandingkan dengan total barang.</p>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="/tristore/modules/transaksi" class="card text-white bg-success mb-4">
                    <div class="card-header">Total Transaksi Harian</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $totalTransaksiHarian; ?></h5>
                        <p class="card-text">Jumlah total transaksi harian yang telah dilakukan.</p>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="/tristore/modules/transaksi" class="card text-white bg-warning mb-4">
                    <div class="card-header">Total Transaksi Bulanan</div>
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $totalTransaksiBulanan; ?></h5>
                        <p class="card-text">Jumlah total transaksi bulanan yang telah dilakukan.</p>
                    </div>
                </a>
            </div>
        </div>

        <h3 class="mt-5">Transaksi Terbaru</h3>
        <table class="table table-striped table-bordered mt-3">
            <thead class="table-dark">
                <tr>
                    <th>No.</th>
                    <th>ID Transaksi</th>
                    <th>Nama Barang</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                    <th>Tanggal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Query untuk mengambil semua transaksi
                $query = "
                SELECT t.id, b.nama_barang, t.jenis, t.jumlah, t.tanggal
                FROM transaksi t
                JOIN barang b ON t.id_barang = b.id
                ORDER BY t.tanggal DESC
                LIMIT 10
            ";
                $result = $conn->query($query);
                if ($result->num_rows > 0) {
                    $no = 1; // Inisialisasi nomor urut
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                        <td>{$no}</td>
                        <td>{$row['id']}</td>
                        <td>{$row['nama_barang']}</td>
                        <td>{$row['jenis']}</td>
                        <td>{$row['jumlah']}</td>
                        <td>" . date('d-m-Y', strtotime($row['tanggal'])) . "</td>";
                        echo "</tr>";
                        $no++;
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>Tidak ada transaksi terbaru.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- footer -->
    <footer class="bottom-0 bg-dark text-white text-center justify-content-center py-2">
        <p>&copy; <?php echo date("Y"); ?> <span class="text-info">Tri Store</span>. All rights reserved.</p>
    </footer>
    <!-- footer end -->

    <script src="bootstrap-5/js/bootstrap.bundle.min.js"></script>
</body>

</html>