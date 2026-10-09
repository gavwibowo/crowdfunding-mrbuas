<?php
include "../koneksi.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id            = (int)$_POST["id"];
    $title         = mysqli_real_escape_string($koneksi, $_POST["title"]);
    $target_amount = (int)$_POST["target_amount"];

    $query = "UPDATE campaigns 
              SET title = '$title', target_amount = '$target_amount' 
              WHERE id = '$id'";

    if (mysqli_query($koneksi, $query)) {
        header("Location: admin-campaign-table.php");
        exit;
    } else {
        echo "Gagal memperbarui data: " . mysqli_error($koneksi);
    }
} else {
    header("Location: admin-campaign-table.php");
    exit;
}
?>
