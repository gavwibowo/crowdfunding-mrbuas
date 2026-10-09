<?php
include "../koneksi.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $title         = mysqli_real_escape_string($koneksi, $_POST["title"]);
    $category      = mysqli_real_escape_string($koneksi, $_POST["category"]);
    $target_amount = (int) $_POST["target_amount"];
    $description   = mysqli_real_escape_string($koneksi, $_POST["description"]);
    $default_image = "hero-home.jpg"; // placeholder gambar bawaan

    $query = "INSERT INTO campaigns (title, category, target_amount, current_amount, description, image)
              VALUES ('$title', '$category', '$target_amount', 0, '$description', '$default_image')";

    if (mysqli_query($koneksi, $query)) {
        header("Location: admin-campaign-table.php");
        exit;
    } else {
        echo "Gagal menyimpan data: " . mysqli_error($koneksi);
    }
} else {
    header("Location: admin-campaign-table.php");
    exit;
}
?>