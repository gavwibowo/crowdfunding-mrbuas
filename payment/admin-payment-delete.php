<?php
include '../koneksi.php';

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    mysqli_query($koneksi, "DELETE FROM payment_methods WHERE id = $id");
}

header("Location: admin-payment-table.php");
exit;
?>
