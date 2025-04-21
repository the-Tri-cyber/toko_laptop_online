<?php
session_start();

// Periksa autentikasi dan otorisasi
if (!in_array($_SESSION['role'], ['admin'])) {
    header("Location: ../../index.php");
    exit;
}

include '../../config/db.php';


$id = $_GET['id'];
$sql = "DELETE FROM transaksi WHERE id_transaksi='$id'";

if (mysqli_query($conn, $sql)) {
    header("Location: index.php");
} else {
    echo "ERROR deleting record: " . mysqli_error($conn);
}
