<?php
include '../koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bank_name      = mysqli_real_escape_string($koneksi, $_POST['bank']);
    $type           = mysqli_real_escape_string($koneksi, $_POST['type']);
    $account_number = mysqli_real_escape_string($koneksi, $_POST['account_number']);
    $owner_name     = mysqli_real_escape_string($koneksi, $_POST['owner']);
    $status         = mysqli_real_escape_string($koneksi, $_POST['status']);

    $query = "INSERT INTO payment_methods (bank_name, type, account_number, owner_name, status) 
              VALUES ('$bank_name', '$type', '$account_number', '$owner_name', '$status')";

    if (mysqli_query($koneksi, $query)) {
        header("Location: admin-payment-table.php");
        exit;
    } else {
        $error = "Gagal menyimpan data: " . mysqli_error($koneksi);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Bank & Rekening | MR. BUAS</title>
    <link rel="stylesheet" href="../assests/css/style.css">
</head>
<body>
<main class="container">
    <section class="card">
        <h1>Tambah Metode Pembayaran</h1>
        <p>Tambahkan data bank atau e-wallet yang digunakan untuk menerima donasi.</p>
        <br>

        <?php if (isset($error)): ?>
            <p style="color: red;"><?= $error ?></p>
        <?php endif; ?>

        <form action="admin-payment-create.php" method="POST">
            <div class="form-group">
                <label for="bank">Nama Bank / Metode Pembayaran</label>
                <input type="text" id="bank" name="bank" class="form-control" placeholder="Contoh: BCA" required>
            </div>

            <div class="form-group">
                <label for="type">Jenis Pembayaran</label>
                <select id="type" name="type" class="form-control" required>
                    <option value="">-- Pilih Jenis --</option>
                    <option value="bank">Bank</option>
                    <option value="ewallet">E-Wallet</option>
                </select>
            </div>

            <div class="form-group">
                <label for="account_number">Nomor Rekening / Nomor E-Wallet</label>
                <input type="text" id="account_number" name="account_number" class="form-control" placeholder="Contoh: 1234567890" required>
            </div>

            <div class="form-group">
                <label for="owner">Nama Pemilik Rekening</label>
                <input type="text" id="owner" name="owner" class="form-control" placeholder="Contoh: Yayasan MR. BUAS" required>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-control">
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Tidak Aktif</option>
                </select>
            </div>

            <br>
            <button type="submit" class="btn-primary">Simpan Data</button>
            <a href="admin-payment-table.php" class="btn-outline">Batal</a>
        </form>
    </section>
</main>
</body>
</html>
