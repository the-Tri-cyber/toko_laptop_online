<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>bootstrap-5.3.3/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>bootstrap-5.3.3/bootstrap-icons/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/assets/css/style.css" />
    <title><?php echo htmlspecialchars($title); ?></title>
</head>

<body>
    <!-- layout start -->
    <div class="d-flex">
        <div class="main">
            <?php
            // Memeriksa jenis pengguna yang sedang login
            if (isset($_SESSION['role'])) {
                $role = $_SESSION['role'];

                // Menentukan sidebar yang akan digunakan berdasarkan peran pengguna
                switch ($role) {
                    case 'admin':
                        include 'partials/header.php';
                        break;
                    case 'user':
                        include 'partials/header_user.php';
                        break;
                    default:
                        include 'partials/header_user.php'; // Sidebar untuk pengguna yang tidak terautentikasi
                        break;
                }
            } else {
                include 'partials/header_user.php'; // Sidebar untuk pengguna yang tidak terautentikasi
            }
            ?>
            <div class="content">
                <?php echo $content; ?>
            </div>
            <?php include 'partials/footer.php'; ?>
        </div>
    </div>
    <!-- layout end -->

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="/inventory-app/bootstrap-5.3.3/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>

</html>