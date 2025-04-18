<?php
session_start();
include '../../config/db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nama = htmlspecialchars(trim($_POST['nama']));
    $telepon = htmlspecialchars(trim($_POST['telepon']));
    $alamat = htmlspecialchars(trim($_POST['alamat']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);
    $role = 'user'; // role ditetapkan sebagai 'user'

    // Cek apakah email sudah ada
    $query = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $query->bind_param("s", $email);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        // email sudah terdaftar
        $_SESSION['error'] = "email sudah terdaftar.";
        header("Location: sign_up.php");
        exit;
    } else {
        // Insert ke database
        $query = $conn->prepare("INSERT INTO users (nama, email, password, telepon, alamat, role) VALUES (?, ?, ?, ?, ?, ?)");
        $query->bind_param("ssssss", $nama, $email, $password, $telepon, $alamat, $role);

        if ($query->execute()) {
            $_SESSION['success'] = "Pendaftaran berhasil! Silakan login.";
            header("Location: login.php");
        } else {
            $_SESSION['error'] = "Terjadi kesalahan. Silakan coba lagi.";
            header("Location: sign_up.php");
        }
    }
}
