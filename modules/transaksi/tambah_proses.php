<?php
session_start();

// Periksa autentikasi dan otorisasi
if (!in_array($_SESSION['role'], ['admin'])) {
    header("Location: ../../index.php");
    exit;
}

include '../../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_laptop = mysqli_real_escape_string($conn, $_POST['id_laptop']);
    $id_user = mysqli_real_escape_string($conn, $_POST['id_user']);
    $nama_penerima = mysqli_real_escape_string($conn, $_POST['nama_penerima']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $telepon = mysqli_real_escape_string($conn, $_POST['telepon']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);
    $jumlah = mysqli_real_escape_string($conn, $_POST['jumlah']);
    $harga = mysqli_real_escape_string($conn, $_POST['harga']);
    $metode_pembayaran = mysqli_real_escape_string($conn, $_POST['metode_pembayaran']);

    $sql = "INSERT INTO transaksi (id_laptop, id_user, nama_penerima, email, telepon, alamat, jumlah, harga, metode_pembayaran) VALUES ('$id_laptop', '$id_user', '$nama_penerima', '$email', '$telepon', '$alamat', '$jumlah', '$harga', '$metode_pembayaran')";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
