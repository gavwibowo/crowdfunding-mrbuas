<?php

require_once __DIR__ . '/../koneksi.php';


/*
|--------------------------------------------------------------------------
| Ambil data donor untuk halaman publik
|--------------------------------------------------------------------------
|
| Kita sengaja hanya mengambil:
| - id
| - name
| - is_anonymous
|
| Email dan nomor kontak tidak perlu ditampilkan ke publik.
|
*/

$query = "
    SELECT
        id,
        name,
        is_anonymous
    FROM donors
    ORDER BY id DESC
";


$result = mysqli_query(
    $koneksi,
    $query
);


if (!$result) {

    die(
        'Query gagal: '
        . mysqli_error($koneksi)
    );

}


$totalDonor = mysqli_num_rows($result);

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
        Daftar Donatur | MR. BUAS
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
                Daftar Donatur
            </h1>

            <p>
                Terima kasih kepada seluruh orang baik
                yang telah ikut membantu melalui MR. BUAS.
            </p>

        </section>


        <!-- =========================
             DONOR TABLE
             ========================= -->
        <section>

            <table class="table">

                <thead>

                    <tr>

                        <th>
                            No
                        </th>

                        <th>
                            Nama Donatur
                        </th>

                        <th>
                            Status
                        </th>

                        <th>
                            Aksi
                        </th>

                    </tr>

                </thead>


                <tbody>

                    <?php

                    $no = 1;

                    while (
                        $donor = mysqli_fetch_assoc($result)
                    ) {

                    ?>

                        <tr>

                            <!-- Nomor -->
                            <td>
                                <?= $no++; ?>
                            </td>


                            <!-- Nama -->
                            <td>

                                <?php

                                if (
                                    $donor['is_anonymous'] == 1
                                ) {

                                    echo 'Orang Baik';

                                } else {

                                    echo htmlspecialchars(
                                        $donor['name']
                                    );

                                }

                                ?>

                            </td>


                            <!-- Status -->
                            <td>

                                <?= $donor['is_anonymous'] == 1
                                    ? 'Anonim'
                                    : 'Publik'; ?>

                            </td>


                            <!-- Detail -->
                            <td>

                                <a
                                    href="public-donor-detail.php?id=<?= $donor['id']; ?>"
                                    class="btn-outline"
                                >
                                    Lihat Detail
                                </a>

                            </td>

                        </tr>

                    <?php

                    }

                    ?>


                    <!-- Jika belum ada donor -->
                    <?php if ($totalDonor === 0) { ?>

                        <tr>

                            <td
                                colspan="4"
                                style="text-align: center;"
                            >
                                Belum ada donatur.
                            </td>

                        </tr>

                    <?php } ?>

                </tbody>

            </table>

        </section>


        <!-- =========================
             TOTAL DONOR
             ========================= -->
        <section>

            <p>

                Total:

                <strong>
                    <?= $totalDonor; ?>
                </strong>

                donatur.

            </p>

        </section>

    </main>

</body>

</html>