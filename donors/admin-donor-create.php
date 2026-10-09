<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Tambah Donatur | MR. BUAS</title>

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

        <section>

            <h1>
                Tambah Donatur
            </h1>

            <p>
                Tambahkan data donatur baru ke dalam
                sistem crowdfunding MR. BUAS.
            </p>

        </section>


        <!-- =========================
             FORM TAMBAH DONATUR
             ========================= -->
        <section class="card">

            <form
                action="admin-donor-store.php"
                method="POST"
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
                        placeholder="Masukkan nama lengkap donatur"
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


                <!-- Status Nama -->
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
                            value=""
                            disabled
                            selected
                        >
                            -- Pilih Status --
                        </option>

                        <option value="0">
                            Publik
                        </option>

                        <option value="1">
                            Anonim
                        </option>

                    </select>

                </div>


                <!-- Informasi Anonimitas -->
                <div class="form-group">

                    <p>
                        <strong>Catatan:</strong>
                        Jika donatur memilih anonim,
                        nama asli tetap tersimpan di database
                        untuk kebutuhan admin, tetapi pada
                        halaman publik akan ditampilkan sebagai
                        <strong>"Orang Baik"</strong>.
                    </p>

                </div>


                <!-- Tombol -->
                <div>

                    <button
                        type="submit"
                        class="btn-primary"
                    >
                        Simpan Donatur
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