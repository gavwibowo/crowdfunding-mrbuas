<?php
// 1. Hubungkan koneksi database
include "koneksi.php";

// 2. Ambil ID dari URL
$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

// 3. Eksekusi query hapus jika ID valid
if ($id > 0) {
    $query = "DELETE FROM campaigns WHERE id = '$id'";
    mysqli_query($koneksi, $query);
}

// 4. Kembalikan tampilan ke tabel admin
header("Location: admin-campaign-table.php");
exit;
?>