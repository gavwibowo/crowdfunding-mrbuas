<?php
include '../koneksi.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$query = "SELECT * FROM payment_methods WHERE id = $id";
$result = mysqli_query($koneksi, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    header("Location: admin-payment-table.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $bank_name      = mysqli_real_escape_string($koneksi, $_POST['bank']);
    $type           = mysqli_real_escape_string($koneksi, $_POST['type']);
    $account_number = mysqli_real_escape_string($koneksi, $_POST['account_number']);
    $owner_name     = mysqli_real_escape_string($koneksi, $_POST['owner']);
    $status         = mysqli_real_escape_string($koneksi, $_POST['status']);

    $update_query = "UPDATE payment_methods SET 
                        bank_name = '$bank_name',
                        type = '$type',
                        account_number = '$account_number',
                        owner_name = '$owner_name',
                        status = '$status'
                     WHERE id = $id";

    if (mysqli_query($koneksi, $update_query)) {
        header("Location: admin-payment-table.php");
        exit;
    } else {
        $error = "Gagal memperbarui data: " . mysqli_error($koneksi);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Bank & Rekening | MR. BUAS</title>
    <link rel="stylesheet" href="../assests/css/style.css">
</head>
<body>
<main class="container">
    <section class="card">
        <h1>Edit Metode Pembayaran</h1>
        <p>Ubah informasi rekening atau metode pembayaran yang sudah tersedia.</p>
        <br>

        <?php if (isset($error)): ?>
            <p style="color: red;"><?= $error ?></p>
        <?php endif; ?>

        <form action="admin-payment-edit.php?id=<?= $id ?>" method="POST">
            <div class="form-group">
                <label for="bank">Nama Bank / Metode Pembayaran</label>
                <input type="text" id="bank" name="bank" class="form-control" value="<?= htmlspecialchars($data['bank_name']) ?>" required>
            </div>

            <div class="form-group">
                <label for="type">Jenis Pembayaran</label>
                <select id="type" name="type" class="form-control">
                    <option value="bank" <?= $data['type'] === 'bank' ? 'selected' : '' ?>>Bank</option>
                    <option value="ewallet" <?= $data['type'] === 'ewallet' ? 'selected' : '' ?>>E-Wallet</option>
                </select>
            </div>

            <div class="form-group">
                <label for="account_number">Nomor Rekening / Nomor E-Wallet</label>
                <input type="text" id="account_number" name="account_number" class="form-control" value="<?= htmlspecialchars($data['account_number']) ?>" required>
            </div>

            <div class="form-group">
                <label for="owner">Nama Pemilik Rekening</label>
                <input type="text" id="owner" name="owner" class="form-control" value="<?= htmlspecialchars($data['owner_name']) ?>" required>
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" class="form-control">
                    <option value="aktif" <?= $data['status'] === 'aktif' ? 'selected' : '' ?>>Aktif</option>
                    <option value="nonaktif" <?= $data['status'] === 'nonaktif' ? 'selected' : '' ?>>Tidak Aktif</option>
                </select>
            </div>

            <br>
            <button type="submit" class="btn-primary">Update Data</button>
            <a href="admin-payment-table.php" class="btn-outline">Batal</a>
        </form>
    </section>
</main>
</body>
</html>
