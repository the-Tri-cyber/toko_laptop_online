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

$id = $_GET['id'];
$sql = "SELECT * FROM transaksi WHERE id_transaksi='$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

// Ambil id transaksi dari URL
$id = $_GET['id'];

// Ambil data transaksi berdasarkan id
$sql = "SELECT * FROM transaksi WHERE id_transaksi='$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

// Saat form disubmit (POST)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Ambil data dari form
    $id_laptop = mysqli_real_escape_string($conn, $_POST['id_laptop']);
    $id_user = mysqli_real_escape_string($conn, $_POST['id_user']);
    $nama_penerima = mysqli_real_escape_string($conn, $_POST['nama_penerima']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $jumlah = mysqli_real_escape_string($conn, $_POST['jumlah']);

    // Cek jika harga dikirim melalui form, jika tidak gunakan harga dari database
    $harga = isset($_POST['harga']) && $_POST['harga'] != '' ? mysqli_real_escape_string($conn, $_POST['harga']) : $row['harga'];

    $metode_pembayaran = mysqli_real_escape_string($conn, $_POST['metode_pembayaran']);

    // Query untuk update data transaksi
    $sql = "UPDATE transaksi SET 
            id_laptop = '$id_laptop',
            id_user = '$id_user',
            nama_penerima = '$nama_penerima',
            email = '$email',
            telepon = '$telepon',
            alamat = '$alamat',
            jumlah = '$jumlah',
            harga = '$harga',
            metode_pembayaran = '$metode_pembayaran'
        WHERE id_transaksi = '$id'";

    // Eksekusi query dan cek apakah sukses
    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../bootstrap-5/css/bootstrap.min.css">
    <title>Edit Laptop</title>
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

    <div class="mx-5 my-4">
        <h1 class="mb-4">Edit Laptop</h1>
        <form action="#" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
            <!-- Pilih Laptop -->
            <div class="mb-3">
                <label for="id_laptop" class="form-label">Laptop:</label>
                <select class="form-select" id="id_laptop" name="id_laptop" required>
                    <?php while ($laptop = mysqli_fetch_assoc($query_laptop)) { ?>
                        <option value="<?php echo $laptop['id_laptop']; ?>" <?php if ($laptop['id_laptop'] == $row['id_laptop']) echo 'selected'; ?>>
                            <?php echo $laptop['id_laptop'] . " - " . $laptop['nama_laptop']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <!-- Pilih User -->
            <div class="mb-3">
                <label for="id_user" class="form-label">User:</label>
                <select class="form-select" id="id_user" name="id_user" required>
                    <?php while ($user = mysqli_fetch_assoc($query_user)) { ?>
                        <option value="<?php echo $user['id_user']; ?>" <?php if ($user['id_user'] == $row['id_user']) echo 'selected'; ?>>
                            <?php echo $user['id_user'] . " - " . $user['nama']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

            <!-- Nama Penerima -->
            <div class="mb-3">
                <label for="nama_penerima" class="form-label">Nama Penerima:</label>
                <input type="text" class="form-control" id="nama_penerima" name="nama_penerima" value="<?php echo $row['nama_penerima']; ?>" required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>" required>
            </div>

            <!-- Telepon -->
            <div class="mb-3">
                <label for="telepon" class="form-label">Telepon:</label>
                <input type="text" class="form-control" id="telepon" name="telepon" value="<?php echo $row['telepon']; ?>" required>
            </div>

            <!-- Alamat -->
            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat:</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $row['alamat']; ?>" required>
            </div>

            <!-- Jumlah -->
            <div class="mb-3">
                <label for="jumlah" class="form-label">Jumlah:</label>
                <input type="number" class="form-control" id="jumlah" name="jumlah"
                    value="<?php echo $row['jumlah']; ?>" required>
                <div class="invalid-feedback">Jumlah harus diisi.</div>
            </div>

            <!-- Harga -->
            <div class="mb-3">
                <label for="harga" class="form-label">Total Harga:</label>
                <div class="input-group">
                    <span class="input-group-text">Rp</span>
                    <input type="text" class="form-control" id="harga" name="harga"
                        value="<?php echo number_format($row['harga'], 0, ',', '.'); ?>" required>
                </div>
                <input type="hidden" id="harga_raw" name="harga_raw" value="<?php echo $row['harga']; ?>">
            </div>

            <!-- Metode Pembayaran -->
            <div class="mb-3">
                <label for="metode_pembayaran" class="form-label">Metode Pembayaran:</label>
                <select class="form-select" id="metode_pembayaran" name="metode_pembayaran" required>
                    <option value="Transfer Bank" <?php if ($row['metode_pembayaran'] == 'Transfer Bank') echo 'selected'; ?>>Transfer Bank</option>
                    <option value="COD" <?php if ($row['metode_pembayaran'] == 'COD') echo 'selected'; ?>>COD</option>
                    <option value="E-Wallet" <?php if ($row['metode_pembayaran'] == 'E-Wallet') echo 'selected'; ?>>E-Wallet</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>

        </form>
    </div>



    <!-- footer -->
    <footer class="bottom-0 bg-dark text-white text-center justify-content-center py-2 sticky-bottom">
        <p>&copy; <?php echo date("Y"); ?> <span class="text-info">Tri Store</span>. All rights reserved.</p>
    </footer>
    <!-- footer end -->

    <script>
        // Ambil harga satuan dari database
        const hargaSatuan = <?php echo $row['harga']; ?>;

        // Ambil referensi elemen input
        const jumlahInput = document.getElementById('jumlah');
        const hargaInput = document.getElementById('harga');
        const hargaRawInput = document.getElementById('harga_raw');

        // Fungsi untuk memformat angka menjadi format Rupiah dengan 2 desimal
        function formatRupiah(angka) {
            // Format angka menjadi dengan 2 desimal dan pisahkan ribuan dengan titik
            let numberString = angka.toFixed(2).replace(".", ","); // ubah desimal menjadi koma
            return numberString.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }

        // Event listener untuk menangani perubahan pada input jumlah
        jumlahInput.addEventListener('input', function() {
            // Ambil nilai jumlah dan lakukan perhitungan total harga
            const jumlah = parseInt(this.value) || 0; // Ambil jumlah, jika kosong maka set 0
            const total = jumlah * hargaSatuan;

            // Set input harga dengan format rupiah
            hargaInput.value = formatRupiah(total);

            // Set nilai harga raw yang akan digunakan untuk proses selanjutnya (misalnya simpan ke database)
            hargaRawInput.value = total;
        });

        // Fungsi untuk membersihkan format Rupiah sebelum form disubmit
        function cleanHarga() {
            // Menghapus titik dari format Rupiah dan menyimpan nilai angka mentah ke input hidden
            const hargaValue = hargaInput.value.replace(/\./g, ''); // Hapus titik pemisah ribuan
            hargaRawInput.value = hargaValue; // Menyimpan angka murni ke input hidden
            hargaInput.value = hargaValue; // Update input harga dengan angka murni tanpa titik
        }

        // Pastikan untuk memanggil cleanHarga sebelum form disubmit
        const form = document.querySelector('form');
        form.addEventListener('submit', cleanHarga);
    </script>


    <script src="../../bootstrap-5/js/bootstrap.bundle.min.js"></script>

</body>

</html>