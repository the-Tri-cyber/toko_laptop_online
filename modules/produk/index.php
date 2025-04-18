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
    <title>USER</title>
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
        <h1 class="text-center mb-4">Daftar Pengguna</h1>
        <div class="d-flex justify-content-evenly">
            <a href="tambah.php" class="btn btn-primary mb-3">Tambah Pengguna</a>
            <form class="d-flex" role="search">
                <input class="form-control me-2" name="keyword" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success me-2" type="submit">Search</button>
                <a href="index.php" class="btn btn-outline-warning">Reset</a>
            </form>
            <a target="_blank" href="../laporan/laporan_users.php" class="btn btn-secondary mb-3 ms-2"><i class="bi bi-floppy me-2"></i>Laporan Pengguna</a>
        </div>

        <table class="table table-info table-hover mb-4">
            <tr class="table-dark text-center">
                <th>No</th>
                <th>Nama Laptop</th>
                <th>Deskripsi</th>
                <th>Harga</th>
                <th>Sell Out</th>
                <th>Stok</th>
                <th>Terakhir Direstok</th>
                <th>Foto</th>
                <th>Aksi</th>
            </tr>
            <?php
            $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
            $sql = "SELECT * FROM produk";
            if (!empty($keyword)) {
                $sql .= " WHERE nama_laptop LIKE '%$keyword%'";
            }
            $sql .= " ORDER BY id_laptop DESC";
            $result = mysqli_query($conn, $sql);

            if ($result->num_rows > 0) {
                $no = 1;
                while ($row = $result->fetch_assoc()) {
            ?>
                    <tr class="text-center align-middle">
                        <td><?php echo $no++ ?></td>
                        <td><?php echo $row['nama_laptop'] ?></td>
                        <td><?php echo $row['deskripsi'] ?></td>
                        <td><?php echo $row['harga'] ?></td>
                        <td><?php echo $row['laptop_terjual'] ?></td>
                        <td><?php echo $row['stok'] ?></td>
                        <td><?php echo $row['terakhir_update'] ?></td>
                        <td><img src="path/to/foto/<?php echo $row['foto']; ?>" alt="Foto Laptop" width="100"></td>
                        <td>
                            <a href="edit.php?id=<?php echo $row['id_laptop'] ?>">Edit</a> |
                            <a href="hapus.php?id=<?php echo $row['id_laptop'] ?>">Hapus</a>
                        </td>
                    </tr>
                <?php
                }
            } else {
                ?>
                <tr>
                    <td colspan="9">TIDAK ADA DATA!</td>
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
</body>

</html>