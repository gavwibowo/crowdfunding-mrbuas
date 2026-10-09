<?php
include '../koneksi.php';

$query = "SELECT * FROM payment_methods WHERE status = 'aktif' ORDER BY type ASC, bank_name ASC";
$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilih Pembayaran | MR. BUAS</title>
    <link rel="stylesheet" href="../assests/css/style.css">
    <link rel="stylesheet" href="../assests/css/campaign_css.css">
</head> 
<body>

<!-- NAVBAR DENGAN FLEXBOX PAKSA AGAR MENU PASTI MUNCUL DI SAMPING LOGO -->
<nav class="navbar">
    <div class="container nav-wrapper">
        <a href="../index.html" class="home-brand-logo teks-gradasi-biru">MR.<span>⚡</span><br>BUAS</a>
        <ul class="cmp-nav-menu">
            <li><a href="../index.html" class="cmp-nav-link">Beranda</a></li>
            <li><a href="public-campaign-list.php" class="cmp-nav-link active">Campaign</a></li>
            <li><a href="../donors/public-donor-list.html" class="cmp-nav-link">Donatur</a></li>
            <li><a href="../partner/public-partner-list.html" class="cmp-nav-link">Mitra Penyalur</a></li>
            <li><a href="../about/public-about-list.html" class="cmp-nav-link">Tentang Kami</a></li>
        </ul>
    </div>
</nav>
<main class="container" style="margin-top: 32px;">
    <section>
        <h1>Pilih Metode Pembayaran</h1>
        <p>Silakan pilih salah satu metode pembayaran untuk melanjutkan proses donasi.</p>
    </section>
    <br>

    <?php if (mysqli_num_rows($result) > 0): ?>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
        <section class="card" style="margin-bottom: 20px;">
            <h2><?= htmlspecialchars($row['bank_name']) ?></h2>
            <p><strong>Jenis:</strong> <?= ucfirst(htmlspecialchars($row['type'])) ?></p>
            <p><strong>Nomor Rekening:</strong> <?= htmlspecialchars($row['account_number']) ?></p>
            <p><strong>Atas Nama:</strong> <?= htmlspecialchars($row['owner_name']) ?></p>
            <p><strong>Status:</strong> <?= ucfirst(htmlspecialchars($row['status'])) ?></p>
            <br>
            <a href="public-payment-detail.php?id=<?= $row['id'] ?>" class="btn-primary">Pilih <?= htmlspecialchars($row['bank_name']) ?></a>
        </section>
        <?php endwhile; ?>
    <?php else: ?>
        <section class="card">
            <p>Belum ada metode pembayaran yang aktif saat ini.</p>
        </section>
    <?php endif; ?>

    <br>
    <a href="../donors/public-donor-list.php" class="btn-outline">Kembali ke Data Donatur</a>
</main>
</body>
</html>
