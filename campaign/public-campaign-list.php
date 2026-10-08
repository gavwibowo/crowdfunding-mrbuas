<?php
include "koneksi.php";

$query  = "SELECT * FROM campaigns ORDER BY id DESC";
$result = mysqli_query($koneksi,$query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Campaign - MR. BUAS</title>

    <link rel="stylesheet" href="../assests/css/style.css">
    <link rel="stylesheet" href="../assests/css/campaign_css.css">
</head>
<body style="background-color: #f7f9fc;">

<!-- NAVBAR PUBLIK BERSAMA -->
<nav class="navbar">
    <div class="container nav-wrapper">
        <a href="../index.html" class="home-brand-logo teks-gradasi-biru">
            MR.<span>⚡</span><br>
            BUAS
        </a>

        <!-- MENU NAVIGASI -->
        <ul class="cmp-nav-menu">
            <li><a href="../index.html" class="cmp-nav-link">Beranda</a></li>
            <li><a href="public-campaign-list.php" class="cmp-nav-link active">Campaign</a></li>
            <li><a href="../Donors/public-donor-list.html" class="cmp-nav-link">Donatur</a></li>
            <li><a href="../Partner/public-partner-list.html" class="cmp-nav-link">Mitra Penyalur</a></li>
            <li><a href="../About/public-about-list.html" class="cmp-nav-link">Tentang Kami</a></li>
        </ul>
    </div>
</nav>

<!-- HEADER TITLE & SEARCH -->
<header class="cmp-header-bg">
    <div class="container">
        <h1 class="cmp-header-title">Program Penggalangan Dana</h1>
        <p class="cmp-header-subtitle">Pilih program kebaikan dan salurkan bantuanmu secara transparan.</p>

        <div class="cmp-filter-section">
            <input type="text" class="cmp-search-box" placeholder="Cari program campaign...">
            <select class="cmp-category-select">
                <option>Semua Kategori</option>
                <option>lifestyle devin</option>
            </select>
        </div>
    </div>
</header>

<!-- MAIN CONTENT DAFTAR CAMPAIGN -->
<main class="container" style="padding: 30px 0 60px 0;">
    <!-- CATEGORY CHIPS -->
    <div class="cmp-category-tabs">
        <a href="#" class="cmp-tab-chip active">Semua</a>
        <a href="#" class="cmp-tab-chip">lifestyle devin</a>
    </div>

    <!-- GRID KARTU CAMPAIGN (DINAMIS DARI DATABASE) -->
    <div class="cmp-grid-3">
        <?php
        if (mysqli_num_rows($result) > 0) :
            while ($row = mysqli_fetch_assoc($result)) :
                // Menghitung persentase capaian donasi
                $current = $row["current_amount"] ?? 0;
                $target  = $row["target_amount"] > 0 ? $row["target_amount"] : 1;

                $persen  = min(100, round(($current / $target) * 100));

                // Gambar default jika belum ada gambar yang diunggah
                $gambar  = !empty($row["image"]) ? $row["image"] : "devin-hp.jpeg";
        ?>
        <!-- KARTU CAMPAIGN DINAMIS -->
        <div class="cmp-card">
            <div>
                <span class="cmp-badge cmp-badge-devin"><?= htmlspecialchars($row["category"]); ?></span>
                <img src="../assests/images/<?= htmlspecialchars($gambar); ?>" alt="<?= htmlspecialchars($row["title"]); ?>" class="cmp-card-image">
                <h3 style="font-size: 1.2rem; font-weight: 800; color: #172033;"><?= htmlspecialchars($row["title"]); ?></h3>
                <p style="color: #64748b; font-size: 0.9rem; margin-top: 8px; line-height: 1.5;">
                    <?= htmlspecialchars(mb_strimwidth($row["description"], 0, 110, "...")); ?>
                </p>
            </div>
            <div style="margin-top: 20px;">
                <div class="cmp-progress-track">
                    <div class="cmp-progress-fill" style="width: <?= $persen; ?>%;"></div>
                </div>
                <div style="display: flex; justify-content: space-between; font-size: 0.85rem; color: #475569; font-weight: 600;">
                    <span>Terkumpul: <strong style="color: #071a40;">Rp <?= number_format($current, 0, ",", "."); ?></strong></span>
                    <span>Target: <strong>Rp <?= number_format($row["target_amount"], 0, ",", "."); ?></strong> (<?= $persen; ?>%)</span>
                </div>
                <a href="public-campaign-detail.php?id=<?= $row["id"]; ?>" class="btn btn-primary" style="display: block; text-align: center; margin-top: 18px; width: 100%;">
                    Donasi Sekarang
                </a>
            </div>
        </div>
        <?php
            endwhile;
        else :
        ?>
        <div style="grid-column: 1 / -1; text-align: center; padding: 40px; background: #ffffff; border-radius: 12px; border: 1px dashed #cbd5e1;">
            <p style="color: #64748b; font-size: 1rem;">Belum ada program campaign yang aktif saat ini.</p>
        </div>
        <?php endif; ?>
    </div>
</main>

</body>
</html>