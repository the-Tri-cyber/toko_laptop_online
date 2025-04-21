<?php
session_start();

// Periksa autentikasi dan otorisasi
if (!in_array($_SESSION['role'], ['admin'])) {
    header("Location: ../../index.php");
    exit;
}

include '../../config/db.php';

// Ambil data laptop
$query_laptop = mysqli_query($conn, "SELECT id_laptop, nama_laptop, harga FROM produk");

// Ambil data user
$query_user = mysqli_query($conn, "SELECT id_user, nama FROM users");

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
        <h1 class="mb-4">Tambah Transaksi</h1>
        <form action="tambah_proses.php" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
            <!-- Pilih Laptop -->
            <div class="mb-3">
                <label for="id_laptop" class="form-label">Pilih Laptop:</label>
                <select class="form-select" id="id_laptop" name="id_laptop" required>
                    <option value="">-- Pilih Laptop --</option>
                    <?php while ($laptop = mysqli_fetch_assoc($query_laptop)) { ?>
                        <option value="<?php echo $laptop['id_laptop']; ?>" data-harga="<?php echo $laptop['harga']; ?>">
                            <?php echo $laptop['id_laptop'] . " - " . $laptop['nama_laptop']; ?>
                        </option>
                    <?php } ?>
                </select>
                <div class="invalid-feedback">Laptop harus dipilih.</div>
            </div>


            <!-- Pilih User -->
            <div class="mb-3">
                <label for="id_user" class="form-label">Pilih User:</label>
                <select class="form-select" id="id_user" name="id_user" required>
                    <option value="">-- Pilih User --</option>
                    <?php while ($user = mysqli_fetch_assoc($query_user)) { ?>
                        <option value="<?php echo $user['id_user']; ?>">
                            <?php echo $user['id_user'] . " - " . $user['nama']; ?>
                        </option>
                    <?php } ?>
                </select>
                <div class="invalid-feedback">User harus dipilih.</div>
            </div>


            <!-- Nama Penerima -->
            <div class="mb-3">
                <label for="nama_penerima" class="form-label">Nama Penerima:</label>
                <input type="text" class="form-control" id="nama_penerima" name="nama_penerima" required>
                <div class="invalid-feedback">Nama penerima harus diisi.</div>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
                <div class="invalid-feedback">Email harus diisi.</div>
            </div>

            <!-- Telepon -->
            <div class="mb-3">
                <label for="telepon" class="form-label">Telepon:</label>
                <input type="text" class="form-control" id="telepon" name="telepon" required>
                <div class="invalid-feedback">Telepon harus diisi.</div>
            </div>

            <!-- Alamat -->
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat:</label>
                <input type="text" class="form-control" id="alamat" name="alamat" required>
                <div class="invalid-feedback">Alamat harus diisi.</div>
            </div>

            <!-- Jumlah Pembelian -->
            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah:</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                <div class="invalid-feedback">Jumlah harus diisi.</div>
            </div>

            <!-- Harga -->
            <div class="mb-3">
                <label for="harga_tampil" class="form-label">Harga:</label>
                <input type="text" class="form-control" id="harga_tampil" readonly>
                <!-- Harga asli dikirim ke server -->
                <input type="hidden" id="harga" name="harga">
            </div>

            <!-- Metode Pembayaran -->
            <div class="mb-3">
                <label for="metode_pembayaran" class="form-label">Metode Pembayaran:</label>
                <select class="form-select" id="metode_pembayaran" name="metode_pembayaran" required>
                    <option value="">-- Pilih Metode --</option>
                    <option value="Transfer Bank">Transfer Bank</option>
                    <option value="COD">COD</option>
                    <option value="E-Wallet">E-Wallet</option>
                </select>
                <div class="invalid-feedback">Metode Pembayaran harus dipilih.</div>
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

    <script>
        const laptopSelect = document.getElementById('id_laptop');
        const jumlahInput = document.getElementById('jumlah');
        const hargaTampil = document.getElementById('harga_tampil');
        const hargaHidden = document.getElementById('harga');

        function formatRupiah(angka) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0
            }).format(angka);
        }

        function updateHarga() {
            const selectedOption = laptopSelect.options[laptopSelect.selectedIndex];
            const hargaSatuan = parseInt(selectedOption.getAttribute('data-harga')) || 0;
            const jumlah = parseInt(jumlahInput.value) || 0;
            const totalHarga = hargaSatuan * jumlah;

            hargaTampil.value = formatRupiah(totalHarga);
            hargaHidden.value = totalHarga;
        }

        laptopSelect.addEventListener('change', updateHarga);
        jumlahInput.addEventListener('input', updateHarga);
    </script>


    <script src="../../bootstrap-5/js/bootstrap.bundle.min.js"></script>
</body>

</html>