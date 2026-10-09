<?php

require_once __DIR__ . '/../koneksi.php';

/*
|--------------------------------------------------------------------------
| Ambil ID donor dari URL
|--------------------------------------------------------------------------
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
    SELECT *
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

if (!$donor) {
    die('Data donatur tidak ditemukan.');
}

mysqli_stmt_close($stmt);

?>

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Edit Donatur | MR. BUAS</title>

    <link
        rel="stylesheet"
        href="../assests/css/style.css"
    >

</head>

<body>

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


    <main class="container">

        <section>

            <h1>
                Edit Donatur
            </h1>

            <p>
                Ubah data donatur yang tersimpan
                di database MR. BUAS.
            </p>

        </section>


        <section class="card">

            <form
                action="admin-donor-update.php"
                method="POST"
            >

                <!-- ID -->
                <input
                    type="hidden"
                    name="id"
                    value="<?= $donor['id']; ?>"
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
                        value="<?= htmlspecialchars($donor['name']); ?>"
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
                        value="<?= htmlspecialchars($donor['email']); ?>"
                        required
                    >

                </div>


                <!-- Phone -->
                <div class="form-group">

                    <label for="phone">
                        Nomor Kontak
                    </label>

                    <input
                        type="tel"
                        id="phone"
                        name="phone"
                        class="form-control"
                        value="<?= htmlspecialchars($donor['phone']); ?>"
                        required
                    >

                </div>


                <!-- Anonimitas -->
                <div class="form-group">

                    <label for="anonymous">
                        Pengaturan Nama Donatur
                    </label>

                    <select
                        id="anonymous"
                        name="anonymous"
                        class="form-control"
                        required
                    >

                        <option
                            value="0"
                            <?= $donor['is_anonymous'] == 0
                                ? 'selected'
                                : ''; ?>
                        >
                            Publik
                        </option>

                        <option
                            value="1"
                            <?= $donor['is_anonymous'] == 1
                                ? 'selected'
                                : ''; ?>
                        >
                            Anonim
                        </option>

                    </select>

                </div>


                <div>

                    <button
                        type="submit"
                        class="btn-primary"
                    >
                        Simpan Perubahan
                    </button>

                    <a
                        href="admin-donor-table.php"
                        class="btn-outline"
                    >
                        Batal
                    </a>

                </div>

            </form>

        </section>

    </main>

</body>

</html>