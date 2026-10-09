<?php

require_once __DIR__ . '/../koneksi.php';


/*
|--------------------------------------------------------------------------
| Ambil ID donor dari URL
|--------------------------------------------------------------------------
|
| Contoh:
| public-donor-detail.php?id=2
|
*/

$id = (int) ($_GET['id'] ?? 0);


if ($id <= 0) {

    die('ID donatur tidak valid.');

}


/*
|--------------------------------------------------------------------------
| Ambil data donor berdasarkan ID
|--------------------------------------------------------------------------
*/

$query = "
    SELECT
        id,
        name,
        is_anonymous,
        created_at
    FROM donors
    WHERE id = ?
";


$stmt = mysqli_prepare(
    $koneksi,
    $query
);


mysqli_stmt_bind_param(
    $stmt,
    'i',
    $id
);


mysqli_stmt_execute($stmt);


$result = mysqli_stmt_get_result($stmt);


$donor = mysqli_fetch_assoc($result);


/*
|--------------------------------------------------------------------------
| Jika donor tidak ditemukan
|--------------------------------------------------------------------------
*/

if (!$donor) {

    mysqli_stmt_close($stmt);

    die('Data donatur tidak ditemukan.');

}


mysqli_stmt_close($stmt);


/*
|--------------------------------------------------------------------------
| Tentukan nama yang ditampilkan ke publik
|--------------------------------------------------------------------------
*/

if ($donor['is_anonymous'] == 1) {

    $displayName = 'Orang Baik';

} else {

    $displayName = $donor['name'];

}


/*
|--------------------------------------------------------------------------
| Tentukan status
|--------------------------------------------------------------------------
*/

$statusName = $donor['is_anonymous'] == 1
    ? 'Anonim'
    : 'Publik';

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
        Detail Donatur | MR. BUAS
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

                <li>
                    <a href="#">
                        Tentang Kami
                    </a>
                </li>

            </ul>

        </div>

    </nav>


    <!-- =========================
         MAIN CONTENT
         ========================= -->
    <main class="container">


        <!-- PAGE HEADER -->
        <section>

            <h1>
                Detail Donatur
            </h1>

            <p>
                Informasi publik donatur
                MR. BUAS.
            </p>

        </section>


        <!-- =========================
             DONOR DETAIL
             ========================= -->
        <section class="card">

            <h2>
                <?= htmlspecialchars($displayName); ?>
            </h2>


            <div class="form-group">

                <p>

                    <strong>
                        Status Nama:
                    </strong>

                    <?= $statusName; ?>

                </p>

            </div>


            <div class="form-group">

                <p>

                    <strong>
                        Bergabung Sejak:
                    </strong>

                    <?= date(
                        'd-m-Y',
                        strtotime($donor['created_at'])
                    ); ?>

                </p>

            </div>


            <?php if ($donor['is_anonymous'] == 1) { ?>

                <div class="form-group">

                    <p>
                        Donatur memilih untuk
                        menyembunyikan identitasnya
                        dari halaman publik.
                    </p>

                </div>

            <?php } ?>


            <div>

                <a
                    href="public-donor-list.php"
                    class="btn-outline"
                >
                    Kembali ke Daftar Donatur
                </a>

            </div>

        </section>

    </main>

</body>

</html>