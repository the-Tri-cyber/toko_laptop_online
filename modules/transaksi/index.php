<?php
session_start();

// Periksa autentikasi dan otorisasi
if (!in_array($_SESSION['role'], ['admin'])) {
    header("Location: ../../index.php");
    exit;
}

include '../../config/db.php';
?>

<html>

<head>
    <link rel="stylesheet" href="../../bootstrap-5/css/bootstrap.min.css">
    <title>TRANSAKSI</title>
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

    <div class="mx-5">
        <h1 class="text-center mb-4">Daftar Transaksi</h1>
        <div class="d-flex justify-content-evenly">
            <a href="tambah.php" class="btn btn-primary mb-3">Tambah Transaksi</a>
            <form class="d-flex" role="search">
                <input class="form-control me-2" name="keyword" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success me-2" type="submit">Search</button>
                <a href="index.php" class="btn btn-outline-warning">Reset</a>
            </form>
        </div>

        <table class="table table-info table-hover mb-4">
            <tr class="table-dark text-center">
                <th>No</th>
                <th>ID Laptop</th>
                <th>ID User</th>
                <th>Nama Penerima</th>
                <th>Email</th>
                <th>Telepon</th>
                <th>Alamat</th>
                <th>Jumlah</th>
                <th>Harga</th>
                <th>Metode Pembayaran</th>
                <th>Waktu</th>
                <th>Aksi</th>
            </tr>
            <?php
            $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
            $sql = "SELECT * FROM transaksi";
            if (!empty($keyword)) {
                $sql .= " WHERE id_laptop LIKE '%$keyword%' OR 
                nama_penerima LIKE '%$keyword%' OR 
                email LIKE '%$keyword%' OR 
                telepon LIKE '%$keyword%' OR
                alamat LIKE '%$keyword%'";
            }
            $sql .= " ORDER BY id_transaksi DESC";
            $result = mysqli_query($conn, $sql);

            if ($result->num_rows > 0) {
                $no = 1;
                while ($row = $result->fetch_assoc()) {
                    $id_laptop = $row['id_laptop'];
                    $laptopQuery = mysqli_query($conn, "SELECT nama_laptop FROM produk WHERE id_laptop='$id_laptop'");
                    $laptop = mysqli_fetch_assoc($laptopQuery);
                    $id_user = $row['id_user'];
                    $userQuery = mysqli_query($conn, "SELECT nama FROM users WHERE id_user='$id_user'");
                    $user = mysqli_fetch_assoc($userQuery);
            ?>
                    <tr class="text-center align-middle">
                        <td><?php echo $no++ ?></td>
                        <td data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="Nama Laptop: <?php echo $laptop['nama_laptop']; ?>"><?php echo $row['id_laptop'] ?></td>
                        <td data-bs-toggle="tooltip"
                            data-bs-placement="top"
                            title="Nama User: <?php echo $user['nama']; ?>"><?php echo $row['id_user'] ?></td>
                        <td><?php echo $row['nama_penerima'] ?></td>
                        <td><?php echo $row['email'] ?></td>
                        <td><?php echo $row['telepon'] ?></td>
                        <td><?php echo $row['alamat'] ?></td>
                        <td><?php echo $row['jumlah'] ?></td>
                        <td>Rp.<?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                        <td><?php echo $row['metode_pembayaran'] ?></td>
                        <td><?php echo $row['tanggal'] ?></td>
                        <td>
                            <a href="edit.php?id=<?php echo $row['id_transaksi'] ?>" class="btn btn-warning btn-sm">Edit</a> |
                            <a href="hapus.php?id=<?php echo $row['id_transaksi'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="12">TIDAK ADA DATA!</td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>


    <!-- footer -->
    <footer class="bottom-0 bg-dark text-white text-center justify-content-center py-2 fixed-bottom">
        <p>&copy; <?php echo date("Y"); ?> <span class="text-info">Tri Store</span>. All rights reserved.</p>
    </footer>
    <!-- footer end -->

    <script src="../../bootstrap-5/js/bootstrap.bundle.min.js"></script>

    <script>
        // Inisialisasi tooltip Bootstrap
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
</body>

</html>