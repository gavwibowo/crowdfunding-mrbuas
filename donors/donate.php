<?php

require_once __DIR__ . '/../koneksi.php';


/*
|--------------------------------------------------------------------------
| Ambil campaign_id dari URL
|--------------------------------------------------------------------------
|
| Contoh:
| donate.php?campaign_id=1
|
*/

$campaignId = (int) ($_GET['campaign_id'] ?? 0);

if ($campaignId <= 0) {
    die('Campaign tidak valid.');
}


/*
|--------------------------------------------------------------------------
| Ambil Campaign dari database
|--------------------------------------------------------------------------
*/

$query = "
    SELECT
        id,
        title,
        category,
        target_amount,
        current_amount,
        description,
        image
    FROM campaigns
    WHERE id = ?
";

$stmt = mysqli_prepare(
    $koneksi,
    $query
);

mysqli_stmt_bind_param(
    $stmt,
    'i',
    $campaignId
);

mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

$campaign = mysqli_fetch_assoc($result);

mysqli_stmt_close($stmt);


if (!$campaign) {
    die('Campaign tidak ditemukan.');
}


/*
|--------------------------------------------------------------------------
| Hitung progress campaign
|--------------------------------------------------------------------------
*/

$progress = 0;

if ($campaign['target_amount'] > 0) {

    $progress =
        ($campaign['current_amount']
        / $campaign['target_amount'])
        * 100;

}

if ($progress > 100) {
    $progress = 100;
}

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        Form Donasi | MR. BUAS
    </title>

    <link
        rel="stylesheet"
        href="../assests/css/style.css"
    >

</head>

<body>

    <!-- =========================
         NAVBAR PUBLIC
         ========================= -->
    <nav class="navbar">

        <div class="container nav-wrapper">

            <a
                href="../index.html"
                class="brand-logo"
            >
                MR. BUAS
            </a>

            <ul class="nav-menu">

                <li>
                    <a href="../index.html">
                        Beranda
                    </a>
                </li>

                <li>
                    <a href="../campaign/public-campaign-list.php">
                        Campaign
                    </a>
                </li>

                <li>
                    <a href="public-donor-list.php">
                        Donatur
                    </a>
                </li>

                <li>
                    <a href="../partner/public-partner-list.html">
                        Mitra Penyalur
                    </a>
                </li>

            </ul>

        </div>

    </nav>


    <!-- =========================
         MAIN
         ========================= -->
    <main class="container">

        <section>

            <h1>
                Form Donasi
            </h1>

            <p>
                Lengkapi data diri sebelum
                melanjutkan ke pembayaran.
            </p>

        </section>


        <!-- =========================
             CAMPAIGN YANG DIPILIH
             ========================= -->
        <section class="card">

            <p>
                Anda akan berdonasi untuk:
            </p>

            <h2>
                <?= htmlspecialchars(
                    $campaign['title']
                ); ?>
            </h2>

            <p>
                <strong>Kategori:</strong>

                <?= htmlspecialchars(
                    $campaign['category']
                ); ?>
            </p>

            <p>
                <strong>Dana Terkumpul:</strong>

                Rp <?= number_format(
                    $campaign['current_amount'],
                    0,
                    ',',
                    '.'
                ); ?>
            </p>

            <p>
                <strong>Target:</strong>

                Rp <?= number_format(
                    $campaign['target_amount'],
                    0,
                    ',',
                    '.'
                ); ?>
            </p>

            <p>
                <strong>Progress:</strong>

                <?= number_format(
                    $progress,
                    1
                ); ?>%
            </p>

        </section>


        <br>


        <!-- =========================
             FORM IDENTITAS DONATUR
             ========================= -->
        <section class="card">

            <form
                action="../payment/public-payment-list.php"
                method="POST"
            >

                <!-- Campaign ID -->
                <input
                    type="hidden"
                    name="campaign_id"
                    value="<?= $campaign['id']; ?>"
                >


                <!-- Nama -->
                <div class="form-group">

                    <label for="name">
                        Nama Lengkap
                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        class="form-control"
                        placeholder="Masukkan nama lengkap"
                        required
                    >

                </div>


                <!-- Email -->
                <div class="form-group">

                    <label for="email">
                        Email
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        class="form-control"
                        placeholder="contoh@email.com"
                        required
                    >

                </div>


                <!-- Nomor Kontak -->
                <div class="form-group">

                    <label for="phone">
                        Nomor Kontak
                    </label>

                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        class="form-control"
                        placeholder="Contoh: 081234567890"
                        required
                    >

                </div>


                <!-- Anonimitas -->
                <div class="form-group">

                    <label for="anonymous">
                        Pengaturan Nama
                    </label>

                    <select
                        id="anonymous"
                        name="anonymous"
                        class="form-control"
                        required
                    >

                        <option
                            value=""
                            disabled
                            selected
                        >
                            -- Pilih Status --
                        </option>

                        <option value="0">
                            Tampilkan Nama Saya
                        </option>

                        <option value="1">
                            Donasi Sebagai Anonim
                        </option>

                    </select>

                </div>


                <div class="form-group">

                    <p>
                        Jika memilih anonim,
                        nama Anda akan ditampilkan
                        sebagai <strong>"Orang Baik"</strong>
                        pada halaman publik.
                    </p>

                </div>


                <button
                    type="submit"
                    class="btn-primary"
                >
                    Lanjut ke Pembayaran
                </button>


                <a
                    href="../campaign/public-campaign-detail.php?id=<?= $campaign['id']; ?>"
                    class="btn-outline"
                >
                    Kembali
                </a>

            </form>

        </section>

    </main>

</body>

</html>