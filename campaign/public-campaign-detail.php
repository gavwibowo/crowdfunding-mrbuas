<?php
include "koneksi.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$query  = "SELECT * FROM campaigns WHERE id = '$id'";
$result = mysqli_query($koneksi, $query);
$data   = mysqli_fetch_assoc($result);

if (!$data) {
    header("Location: public-campaign-list.php");
    exit;
}

$target  = $data["target_amount"] > 0 ? (int)$data["target_amount"] : 1;
$current = (int)($data["current_amount"] ?? 0);
$persen  = round(($current / $target) * 100);
if ($persen > 100) $persen = 100;

$image = !empty($data["image"]) ? $data["image"] : "devin-hp.jpeg";
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($data['title']); ?> - MR. BUAS</title>

    <link rel="stylesheet" href="../assests/css/style.css">
    <link rel="stylesheet" href="../assests/css/campaign_css.css">
</head>
<body style="background-color: #f7f9fc;">

    <nav class="navbar">
        <div class="container nav-wrapper">
            <a href="../index.html" class="home-brand-logo teks-gradasi-biru">
                MR.<span>⚡</span><br>
                BUAS
            </a>
            <ul class="cmp-nav-menu">
                <li><a href="../index.html" class="cmp-nav-link">Beranda</a></li>
                <li><a href="public-campaign-list.php" class="cmp-nav-link active">Campaign</a></li>
            </ul>
        </div>
    </nav>

    <main class="container" style="padding: 40px 0;">
        <p style="color: #64748b; font-size: 0.9rem;">Campaign &gt; <?php echo htmlspecialchars($data['category']); ?> &gt; Detail</p>
        <h1 style="color: #071a40; margin-top: 8px; font-weight: 900;"><?php echo htmlspecialchars($data['title']); ?></h1>

        <div class="cmp-detail-grid">
            <div>
                <div class="cmp-banner-placeholder">
                    <img src="../assests/images/<?php echo htmlspecialchars($image); ?>" alt="<?php echo htmlspecialchars($data['title']); ?>" class="cmp-banner-img">
                </div>
                <div style="margin-top: 24px; line-height: 1.8; color: #334155;">
                    <h3 style="color: #071a40; margin-bottom: 8px;">Deskripsi Program</h3>
                    <p><?php echo nl2br(htmlspecialchars($data['description'])); ?></p>
                </div>
            </div>

            <div>
                <div class="cmp-card" style="position: sticky; top: 100px;">
                    <p style="font-size: 0.85rem; color: #64748b;">Total Terkumpul</p>
                    <h2 style="font-size: 2.2rem; color: #071a40; font-weight: 800;">Rp <?php echo number_format($current, 0, ',', '.'); ?></h2>
                    <p style="font-size: 0.85rem; color: #64748b;">Target Dana: <strong>Rp <?php echo number_format($target, 0, ',', '.'); ?></strong> (<?php echo $persen; ?>%)</p>

                    <div class="cmp-progress-track" style="margin-top: 16px;">
                        <div class="cmp-progress-fill" style="width: <?php echo $persen; ?>%;"></div>
                    </div>

                    <a href="../Donors/public-donor-form.html?campaign_id=<?php echo $data['id']; ?>" class="btn btn-primary" style="display: block; text-align: center; width: 100%; margin-top: 20px; font-size: 1.1rem; padding: 14px;">
                        Donasi Sekarang
                    </a>
                </div>
            </div>
        </div>
    </main>

</body>
</html>
