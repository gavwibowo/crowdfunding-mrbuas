<?php

require_once __DIR__ . '/../koneksi.php';

/*
|--------------------------------------------------------------------------
| Ambil seluruh data donatur
|--------------------------------------------------------------------------
*/

$query = "
    SELECT *
    FROM donors
    ORDER BY id DESC
";

$result = mysqli_query(
    $koneksi,
    $query
);

if (!$result) {
    die(
        "Query gagal: "
        . mysqli_error($koneksi)
    );
}

/*
|--------------------------------------------------------------------------
| Hitung jumlah donatur
|--------------------------------------------------------------------------
*/

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
        Data Donatur | MR. BUAS
    </title>

    <link
        rel="stylesheet"
        href="../assests/css/style.css"
    >

</head>

<body>

    <!-- =========================
         NAVBAR ADMIN
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
                        Dashboard
                    </a>
                </li>

                <li>
                    <a href="../campaign/admin-campaign-table.php">
                        Campaign
                    </a>
                </li>

                <li>
                    <a href="admin-donor-table.php">
                        Donatur
                    </a>
                </li>

                <li>
                    <a href="#">
                        Payment
                    </a>
                </li>

                <li>
                    <a href="#">
                        Partner
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
                Data Donatur
            </h1>

            <p>
                Kelola seluruh data donatur yang terdaftar
                pada platform crowdfunding MR. BUAS.
            </p>

        </section>


        <!-- =========================
             ACTION
             ========================= -->
        <section class="card">

            <div>

                <a
                    href="admin-donor-create.php"
                    class="btn-primary"
                >
                    + Tambah Donatur
                </a>

            </div>

            <br>


            <!-- Search belum dibuat dinamis -->
            <div class="form-group">

                <label for="search">
                    Cari Donatur
                </label>

                <input
                    type="text"
                    id="search"
                    class="form-control"
                    placeholder="Cari nama, email, atau nomor kontak..."
                >

            </div>

        </section>


        <!-- =========================
             DONOR TABLE
             ========================= -->
        <section>

            <table class="table">

                <thead>

                    <tr>

                        <th>No</th>

                        <th>
                            Nama Donatur
                        </th>

                        <th>
                            Email
                        </th>

                        <th>
                            Nomor Kontak
                        </th>

                        <th>
                            Status Nama
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

                            <td>
                                <?= $no++; ?>
                            </td>


                            <td>

                                <?= htmlspecialchars(
                                    $donor['name']
                                ); ?>

                            </td>


                            <td>

                                <?= htmlspecialchars(
                                    $donor['email']
                                ); ?>

                            </td>


                            <td>

                                <?= htmlspecialchars(
                                    $donor['phone']
                                ); ?>

                            </td>


                            <td>

                                <?= $donor['is_anonymous'] == 1
                                    ? 'Anonim'
                                    : 'Publik'; ?>

                            </td>


                            <td>

                                <!-- DETAIL -->
                                <a
                                    href="public-donor-detail.php?id=<?= $donor['id']; ?>"
                                    class="btn-outline"
                                >
                                    Detail
                                </a>


                                <!-- EDIT -->
                                <a
                                    href="admin-donor-edit.php?id=<?= $donor['id']; ?>"
                                    class="btn-outline"
                                >
                                    Edit
                                </a>


                                <!-- DELETE belum dibuat -->
<form
    action="admin-donor-delete.php"
    method="POST"
    style="display: inline;"
>

    <input
        type="hidden"
        name="id"
        value="<?= $donor['id']; ?>"
    >

    <button
        type="submit"
        class="btn-danger"
    >
        Hapus
    </button>

</form>

                            </td>

                        </tr>

                    <?php

                    }

                    ?>


                    <!-- Jika database kosong -->
                    <?php if ($totalDonor === 0) { ?>

                        <tr>

                            <td
                                colspan="6"
                                style="text-align: center;"
                            >
                                Belum ada data donatur.
                            </td>

                        </tr>

                    <?php } ?>

                </tbody>

            </table>

        </section>


        <!-- =========================
             TABLE INFO
             ========================= -->
        <section>

            <p>
                Menampilkan
                <strong>
                    <?= $totalDonor; ?>
                </strong>
                data donatur.
            </p>

        </section>

    </main>

</body>

</html>