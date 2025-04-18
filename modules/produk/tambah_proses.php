<?php
session_start();

// Periksa autentikasi dan otorisasi
if (!in_array($_SESSION['role'], ['admin'])) {
    header("Location: ../../index.php");
    exit;
}

include '../../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $role = mysqli_real_escape_string($conn, $_POST['role']);

    $sql = "INSERT INTO users (nama, email, password, telepon, alamat, role) VALUES ('$nama', '$email', '$password', '$telepon', '$alamat', '$role')";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
