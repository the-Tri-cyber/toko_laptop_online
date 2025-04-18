<?php
session_start();

// Periksa autentikasi dan otorisasi
if (!in_array($_SESSION['role'], ['admin'])) {
    header("Location: ../../index.php");
    exit;
}

include '../../config/db.php';

$id = $_GET['id'];
$sql = "SELECT * FROM users WHERE id_user='$id'";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    if (!empty($_POST['password'])) {
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $sql = "UPDATE users SET nama='$nama', email='$email', password='$password', telepon='$telepon', alamat='$alamat', role='$role' WHERE id_user='$id'";
    } else {
        $sql = "UPDATE users SET nama='$nama', email='$email', telepon='$telepon', alamat='$alamat', role='$role' WHERE id_user='$id'";
    }

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
    <title>Edit Pengguna</title>
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
        <h1 class="mb-4">Edit Pengguna</h1>
        <form action="#" method="POST" class="needs-validation" enctype="multipart/form-data" novalidate>
            <div class="mb-3">
                <label for="nama" class="form-label">Nama:</label>
                <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $row['nama']; ?>" required>
                <div class="invalid-feedback">Nama harus diisi.</div>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email']; ?>" required>
                <div class="invalid-feedback">Email harus diisi.</div>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password:</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="(kosongkan jika tidak ingin diisi)" required>
            </div>

            <div class="mb-3">
                <label for="telepon" class="form-label">Telepon:</label>
                <input type="text" class="form-control" id="telepon" name="telepon" value="<?php echo $row['telepon']; ?>" required>
                <div class="invalid-feedback">Telepon harus diisi.</div>
            </div>

            <div class="mb-3">
                <label for="alamat" class="form-label">Alamat:</label>
                <input type="text" class="form-control" id="alamat" name="alamat" value="<?php echo $row['alamat']; ?>" required>
                <div class="invalid-feedback">Alamat harus diisi.</div>
            </div>

            <div class="mb-3">
                <label for="role" class="form-label">Role:</label>
                <select class="form-select" id="role" name="role" required>
                    <option value="admin" value="<?php echo ($row['role'] == 'admin') ? 'selected' : ''; ?>">Admin</option>
                    <option value="user" value="<?php echo ($row['role'] == 'user') ? 'selected' : ''; ?>">User </option>
                </select>
                <div class="invalid-feedback">Role harus diisi.</div>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
            <a href="index.php" class="btn btn-secondary">Kembali</a>
        </form>
    </div>


    <!-- footer -->
    <footer class="bottom-0 bg-dark text-white text-center justify-content-center py-2 fixed-bottom">
        <p>&copy; <?php echo date("Y"); ?> <span class="text-info">Tri Store</span>. All rights reserved.</p>
    </footer>
    <!-- footer end -->

    <script src="../../bootstrap-5/js/bootstrap.bundle.min.js"></script>

</body>

</html>