<?php
include '../koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$query = "SELECT * FROM payment_methods WHERE id = $id AND status = 'aktif'";
$result = mysqli_query($koneksi, $query);
$payment = mysqli_fetch_assoc($result);

if (!$payment) {
    header("Location: public-payment-list.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Pembayaran | MR. BUAS</title>
    <link rel="stylesheet" href="../assests/css/style.css">
    <link rel="stylesheet" href="../assests/css/campaign_css.css">
</head>
<body>
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
<main class="container">
    <section class="card">
        <h1>Detail Pembayaran</h1>
        <p>Silakan lakukan transfer sesuai informasi pembayaran di bawah ini.</p>
        <br>

        <div class="form-group">
            <strong>Metode Pembayaran</strong>
            <p><?= htmlspecialchars($payment['bank_name']) ?></p>
        </div>

        <div class="form-group">
            <strong>Nomor Rekening / HP</strong>
            <p><?= htmlspecialchars($payment['account_number']) ?></p>
        </div>

        <div class="form-group">
            <strong>Atas Nama</strong>
            <p><?= htmlspecialchars($payment['owner_name']) ?></p>
        </div>

        <div class="form-group">
            <strong>Status Rekening</strong>
            <p><?= ucfirst(htmlspecialchars($payment['status'])) ?></p>
        </div>
    </section>

    <br>

    <section class="card">
        <h2>Cara Pembayaran</h2>
        <ol>
            <li>Buka aplikasi atau ATM bank Anda.</li>
            <li>Pilih menu transfer.</li>
            <li>Masukkan nomor rekening <strong><?= htmlspecialchars($payment['account_number']) ?></strong>.</li>
            <li>Pastikan nama penerima adalah <strong><?= htmlspecialchars($payment['owner_name']) ?></strong>.</li>
            <li>Masukkan nominal donasi sesuai jumlah yang ingin disumbangkan.</li>
            <li>Selesaikan proses transfer.</li>
        </ol>
    </section>

    <br>

    <section class="card">
        <h2>Konfirmasi Pembayaran</h2>
        <p>Silakan klik tombol di bawah setelah menyelesaikan transfer.</p>
        <br>
        <a href="../index.php" class="btn-primary" onclick="alert('Terima kasih! Pembayaran Anda sedang diproses.')">Saya Sudah Transfer</a>
    </section>

    <br>

    <a href="public-payment-list.php" class="btn-outline">Kembali Pilih Pembayaran</a>
    <a href="../index.php" class="btn-outline">Kembali ke Beranda</a>
</main>
</body>
</html>
