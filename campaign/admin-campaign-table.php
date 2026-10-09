<?php
// 1. Hubungkan ke database
include '../koneksi.php';

// 2. Ambil seluruh data dari tabel campaigns (diurutkan dari yang terbaru)
$query  = "SELECT * FROM campaigns ORDER BY id DESC";
$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Data Campaign</title>

    <link rel="stylesheet" href="../assests/css/style.css">
    <link rel="stylesheet" href="../assests/css/campaign_css.css">
</head>
<body style="background-color: #f7f9fc;">

<div class="container" style="padding: 40px 0;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h2 style="color: #071a40; font-weight: 900;">Kelola Data Campaign (Admin)</h2>
            <p style="color: #64748b; font-size: 0.95rem;">Manajemen daftar program penggalangan dana sosial.</p>
        </div>
        <!-- Diarahkan ke file form create berekstensi .php -->
        <a href="admin-campaign-create.php" class="btn btn-primary">+ Tambah Campaign</a>
    </div>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>Judul Campaign</th>
                <th>Kategori</th>
                <th>Target Dana</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $no = 1;
            // 3. Perulangan untuk membaca setiap baris data dari database
            while ($row = mysqli_fetch_assoc($result)) :
            ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><strong><?= htmlspecialchars($row['title']); ?></strong></td>
                <td>
                    <span class="cmp-badge cmp-badge-devin">
                        <?= htmlspecialchars($row['category']); ?>
                    </span>
                </td>
                <td>Rp <?= number_format($row['target_amount'], 0, ',', '.'); ?></td>
                <td>
                    <!-- Mengirim ID data campaign yang ingin diedit atau dihapus -->
                    <a href="admin-campaign-edit.php?id=<?= $row['id']; ?>" class="btn btn-outline" style="padding: 4px 12px; font-size: 0.85rem;">Edit</a>
                    <a href="admin-campaign-delete.php?id=<?= $row['id']; ?>" class="btn btn-danger" style="padding: 4px 12px; font-size: 0.85rem;" onclick="return confirm('Apakah Anda yakin ingin menghapus campaign ini?')">Hapus</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>