<?php
session_start();

// Periksa autentikasi dan otorisasi
if (!in_array($_SESSION['role'], ['admin'])) {
    header("Location: ../../index.php");
    exit;
}

include '../../config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_laptop = mysqli_real_escape_string($conn, $_POST['nama_laptop']);
    $processor = mysqli_real_escape_string($conn, $_POST['processor']);
    $ram = mysqli_real_escape_string($conn, $_POST['ram']);
    $rom = mysqli_real_escape_string($conn, $_POST['rom']);
    $gpu = mysqli_real_escape_string($conn, $_POST['gpu']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $harga = mysqli_real_escape_string($conn, $_POST['harga']);
    $laptop_terjual = mysqli_real_escape_string($conn, $_POST['laptop_terjual']);
    $stok = mysqli_real_escape_string($conn, $_POST['stok']);
    $foto = mysqli_real_escape_string($conn, $_POST['foto']);

    $sql = "INSERT INTO produk (nama_laptop, processor, ram, rom, gpu, deskripsi, harga, laptop_terjual, stok, foto) VALUES ('$nama_laptop', '$processor', '$ram', '$rom', '$gpu', '$deskripsi', '$harga', '$laptop_terjual', '$stok', '$foto')";

    if (mysqli_query($conn, $sql)) {
        header("Location: index.php");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
