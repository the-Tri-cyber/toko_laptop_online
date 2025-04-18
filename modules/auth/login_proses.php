<?php
session_start();
include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    if (!empty($email) && !empty($password)) {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['nama'] = $user['nama'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['id_user'] = $user['id_user'];

                // Redirect berdasarkan peran pengguna
                if ($user['role'] === 'admin') {
                    header("Location: ../../admin.php"); // Halaman untuk admin dan manager
                } else {
                    header("Location: ../../index.php"); // Halaman untuk pengguna biasa
                }
                exit;
            } else {
                $_SESSION['error_message'] = "Password salah!";
            }
        } else {
            $_SESSION['error_message'] = "Email tidak ditemukan!";
        }
    } else {
        $_SESSION['error_message'] = "Email dan password tidak boleh kosong!";
    }
    header("Location: login.php");
    exit;
}
