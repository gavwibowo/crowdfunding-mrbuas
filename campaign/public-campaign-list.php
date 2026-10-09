<?php
include "koneksi.php";

$kategori = isset($_GET['category']) ? mysqli_real_escape_string($koneksi, trim($_GET['category'])) : '';
$keyword = isset($_GET['q']) ? mysqli_real_escape_string($koneksi, trim($_GET['q'])) : '';
$conditions = [];

if (!empty($kategori) && $kategori !== 'Semua') $conditions[] = "category = '$kategori'";
if (!empty($keyword)) $conditions[] = "(title LIKE '%$keyword%' OR description LIKE '%$keyword%')";

$sql_where = "";
if (count($conditions) > 0) $sql_where = "WHERE " . implode(" AND ", $conditions);

$query = "SELECT * FROM campaigns $sql_where ORDER BY id DESC";
$result = mysqli_query($koneksi, $query);

$query_cat = mysqli_query($koneksi, "SELECT DISTINCT category FROM campaigns WHERE category IS NOT NULL AND category != ''");
$categories = [];
while ($cat_row = mysqli_fetch_assoc($query_cat)) $categories[] = $cat_row['category'];
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

<nav class="navbar">
    <div class="container nav-wrapper">
        <a href="../index.html" class="home-brand-logo teks-gradasi-biru">MR.<span>⚡</span><br>BUAS</a>
        <ul class="cmp-nav-menu">
            <li><a href="../index.html" class="cmp-nav-link">Beranda</a></li>
            <li><a href="public-campaign-list.php" class="cmp-nav-link active">Campaign</a></li>
            <li><a href="../Donors/public-donor-list.html" class="cmp-nav-link">Donatur</a></li>
            <li><a href="../Partner/public-partner-list.html" class="cmp-nav-link">Mitra Penyalur</a></li>
            <li><a href="../About/public-about-list.html" class="cmp-nav-link">Tentang Kami</a></li>
        </ul>
    </div>
</nav>

<header class="cmp-header-bg">
    <div class="container">
        <h1 class="cmp-header-title">Program Penggalangan Dana</h1>
        <p class="cmp-header-subtitle">Pilih program kebaikan dan salurkan bantuanmu secara transparan.</p>

        <form action="public-campaign-list.php" method="GET" class="cmp-filter-section" style="display: flex; gap: 10px; justify-content: center; margin-top: 20px;">
            <input type="text" name="q" class="cmp-search-box" placeholder="Cari program campaign..." value="<?php echo htmlspecialchars($keyword); ?>">
            <select name="category" class="cmp-category-select" onchange="this.form.submit()">
                <option value="">Semua Kategori</option>
                <?php foreach ($categories as $cat) : ?>
                    <option value="<?php echo htmlspecialchars($cat); ?>" <?php echo ($kategori === $cat) ? 'selected' : ''; ?>><?php echo htmlspecialchars($cat); ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn btn-primary" style="padding: 10px 20px; font-weight: 700;">Cari</button>
            <?php if (!empty($kategori) || !empty($keyword)) : ?><a href="public-campaign-list.php" class="btn btn-outline" style="padding: 10px 16px; background: #fff; text-decoration: none; border-radius: 8px;">Reset</a><?php endif; ?>
        </form>
    </div>
</header>

<main class="container" style="padding: 30px 0 60px 0;">
    <div class="cmp-category-tabs">
        <a href="public-campaign-list.php<?php echo !empty($keyword) ? '?q='.urlencode($keyword) : ''; ?>" class="cmp-tab-chip <?php echo empty($kategori) ? 'active' : ''; ?>">Semua</a>
        <?php foreach ($categories as $cat) : ?>
            <a href="public-campaign-list.php?category=<?php echo urlencode($cat); ?><?php echo !empty($keyword) ? '&q='.urlencode($keyword) : ''; ?>" class="cmp-tab-chip <?php echo ($kategori === $cat) ? 'active' : ''; ?>"><?php echo htmlspecialchars($cat); ?></a>
        <?php endforeach; ?>
    </div>

    <div class="cmp-grid-3">
        <?php if (mysqli_num_rows($result) > 0) : ?>
            <?php while ($row = mysqli_fetch_assoc($result)) :
                $current = (int)($row["current_amount"] ?? 0);
                $target = $row["target_amount"] > 0 ? (int)$row["target_amount"] : 1;
                $persen = round(($current / $target) * 100);
                if ($persen > 100) $persen = 100;
                $gambar = !empty($row["image"]) ? $row["image"] : "hero-home.jpg";
            ?>
                <div class="cmp-card">
                    <div class="cmp-card-img-wrap">
                        <img src="../assests/images/<?php echo htmlspecialchars($gambar); ?>" alt="<?php echo htmlspecialchars($row['title']); ?>" class="cmp-card-img" style="width: 100%; height: 200px; object-fit: cover;">
                    </div>

                    <div class="cmp-card-body" style="padding: 20px;">
                        <span class="cmp-card-category" style="font-size: 0.8rem; font-weight: 700; color: #0284c7; text-transform: uppercase;"><?php echo htmlspecialchars($row['category']); ?></span>
                        <h3 class="cmp-card-title" style="margin: 10px 0; font-size: 1.15rem; color: #071a40;"><?php echo htmlspecialchars($row['title']); ?></h3>

                        <div class="cmp-progress-bar" style="background: #e2e8f0; height: 8px; border-radius: 4px; overflow: hidden; margin: 12px 0 8px 0;">
                            <div class="cmp-progress-fill" style="width: <?php echo $persen; ?>%; height: 100%; background: #ffc107;"></div>
                        </div>

                        <div style="display: flex; justify-content: space-between; font-size: 0.85rem; color: #64748b; margin-bottom: 16px;">
                            <span>Terkumpul: <strong>Rp <?php echo number_format($current, 0, ',', '.'); ?></strong></span>
                            <span><?php echo $persen; ?>%</span>
                        </div>

                        <a href="public-campaign-detail.php?id=<?php echo $row['id']; ?>" class="btn btn-primary" style="display: block; text-align: center; text-decoration: none; padding: 10px; border-radius: 8px; font-weight: 700;">Donasi Sekarang</a>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else : ?>
            <div style="grid-column: 1 / -1; text-align: center; padding: 60px 20px; background: #fff; border-radius: 12px; border: 1px dashed #cbd5e1;">
                <h3 style="color: #64748b;">Belum ada program campaign pada kategori ini</h3>
                <p style="color: #94a3b8; margin-top: 8px;">Coba pilih kategori lain atau bersihkan kata kunci pencarian.</p>
                <a href="public-campaign-list.php" class="btn btn-primary" style="margin-top: 16px; display: inline-block;">Lihat Semua Campaign</a>
            </div>
        <?php endif; ?>
    </div>
</main>

</body>
</html>