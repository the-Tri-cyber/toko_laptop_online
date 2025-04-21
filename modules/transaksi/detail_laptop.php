<?php
session_start();

// Cek autentikasi
if (!in_array($_SESSION['role'], ['user'])) {
    header("Location: ../../modules/auth/login.php");
    exit;
}

$id_user = $_SESSION['id_user'];
$id_laptop = $_GET['id'];

if (!$id_user || !$id_laptop) {
    die("Data tidak lengkap");
}

include '../../config/db.php';

$sql = "SELECT * FROM produk WHERE id_laptop='$id_laptop'";
$result = mysqli_query($conn, $sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Detail Laptop</title>
    <link rel="stylesheet" href="../../bootstrap-5/css/bootstrap.min.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        .harga-total {
            font-size: 1.2rem;
            font-weight: bold;
            color: #198754;
        }
    </style>
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
                            <a class="nav-link active" aria-current="page" href="../../index.php">Home</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                Produk(Coming Soon)
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark">
                                <li><a class="dropdown-item" href="../../coming_soon.html">PC</a></li>
                                <li><a class="dropdown-item" href="../../coming_soon.html">AIO</a></li>
                                <li><a class="dropdown-item" href="../../coming_soon.html">Laptop 2-in-1</a></a></li>
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

    <div class="container py-5">
        <h1 class="text-center mb-4">Detail Laptop</h1>
        <div class="row pb-5">
            <!-- Gambar -->
            <div class="col-md-6 mb-4">
                <div class="card">
                    <img src="<?php echo $row['foto'] ?>" class="card-img-top" alt="Product Image">
                </div>
            </div>

            <!-- Detail -->
            <div class="col-md-6">
                <h2 class="text-capitalize"><?php echo $row['nama_laptop'] ?></h2>
                <div class="mb-2">
                    <span class="h4 text-danger">Rp.<?= number_format($row['harga'], 0, ',', '.') ?></span>
                </div>
                <p class="text-muted"><?php echo $row['deskripsi'] ?></p>

                <!-- Spesifikasi -->
                <ul class="list-group list-group-flush mb-3">
                    <li class="list-group-item"><strong>Processor:</strong> <?= $row['processor'] ?></li>
                    <li class="list-group-item"><strong>RAM:</strong> <?= $row['ram'] ?></li>
                    <li class="list-group-item"><strong>Storage:</strong> <?= $row['rom'] ?></li>
                    <li class="list-group-item"><strong>VGA:</strong> <?= $row['gpu'] ?></li>
                    <li class="list-group-item"><strong>Stok Tersedia:</strong> <?= $row['stok'] ?></li>
                </ul>

            </div>
            <div class="col-md-12">
                <form action="transaksi.php" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
                    <!-- Hidden Inputs -->
                    <input type="hidden" id="id_laptop" name="id_laptop" value="<?= $id_laptop ?>">
                    <input type="hidden" id="id_user" name="id_user" value="<?= $id_user ?>">
                    <input type="hidden" name="harga_satuan" id="harga_hidden" value="<?= $row['harga'] ?>">
                    <input type="hidden" name="harga" id="harga" value="<?= $row['harga'] ?>">

                    <div class="row justify-content-center">
                        <!-- Quantity -->
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Quantity:</label>
                            <select id="quantity" class="form-select" name="jumlah" onchange="updateTotal()">
                                <?php for ($i = 1; $i <= $row['stok']; $i++): ?>
                                    <option value="<?= $i ?>"><?= $i ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>

                        <!-- Total Harga -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Total Harga:</label>
                            <input type="text" class="form-control" id="totalHarga" readonly>
                        </div>

                        <!-- Nama Penerima -->
                        <div class="col-md-4 mb-3">
                            <label for="nama_penerima" class="form-label">Nama Penerima:</label>
                            <input type="text" class="form-control" id="nama_penerima" name="nama_penerima" required>
                            <div class="invalid-feedback">Nama penerima harus diisi.</div>
                        </div>

                        <!-- Email -->
                        <div class="col-md-4 mb-3">
                            <label for="email" class="form-label">Email:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <div class="invalid-feedback">Email harus diisi.</div>
                        </div>

                        <!-- Telepon -->
                        <div class="col-md-4 mb-3">
                            <label for="telepon" class="form-label">Telepon:</label>
                            <input type="text" class="form-control" id="telepon" name="telepon" required>
                            <div class="invalid-feedback">Telepon harus diisi.</div>
                        </div>

                        <!-- Alamat -->
                        <div class="col-md-6 mb-3">
                            <label for="alamat" class="form-label">Alamat Lengkap:</label>
                            <input type="text" class="form-control" id="alamat" name="alamat" required>
                            <div class="invalid-feedback">Alamat harus diisi.</div>
                        </div>

                        <!-- Metode Pembayaran -->
                        <div class="col-md-6 mb-3">
                            <label for="metode_pembayaran" class="form-label">Metode Pembayaran:</label>
                            <select class="form-select" id="metode_pembayaran" name="metode_pembayaran" required>
                                <option value="">-- Pilih Metode --</option>
                                <option value="Transfer Bank">Transfer Bank</option>
                                <option value="COD">COD</option>
                                <option value="E-Wallet">E-Wallet</option>
                            </select>
                            <div class="invalid-feedback">Metode Pembayaran harus dipilih.</div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="col-md-6 d-flex justify-content-between">
                            <button class="btn btn-primary" type="submit">Checkout</button>
                            <a href="../../index.php" class="btn btn-secondary">Kembali</a>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-2">
        <p>&copy; <?= date("Y"); ?> <span class="text-info">Tri Store</span>. All rights reserved.</p>
    </footer>

    <script src="../../bootstrap-5/js/bootstrap.bundle.min.js"></script>
    <script>
        function updateTotal() {
            const harga = parseInt(document.getElementById('harga_hidden').value);
            const jumlah = parseInt(document.getElementById('quantity').value);

            const total = harga * jumlah;

            // Format ke Rupiah
            const totalFormatted = new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(total);

            // Tampilkan ke user
            document.getElementById('totalHarga').value = totalFormatted;

            // Simpan ke input hidden supaya dikirim ke backend
            document.getElementById('total_harga_hidden').value = total;
        }

        // Trigger awal saat halaman load
        window.onload = function() {
            updateTotal();
        }
    </script>



</body>

</html>