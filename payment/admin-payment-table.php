<?php
include '../koneksi.php';

// Fitur pencarian
$search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';
$query = "SELECT * FROM payment_methods";
if (!empty($search)) {
    $query .= " WHERE bank_name LIKE '%$search%' OR owner_name LIKE '%$search%'";
}
$query .= " ORDER BY id ASC";
$result = mysqli_query($koneksi, $query);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Data Bank & Rekening | MR. BUAS</title>
    <link rel="stylesheet" href="../assests/css/style.css">
</head>
<body>
<main class="container">
    <section>
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
            <div>
                <h1>Data Bank & Rekening</h1>
                <p>Kelola data rekening dan metode pembayaran yang digunakan untuk menerima donasi.</p>
            </div>
            <a href="admin-payment-create.php" class="btn-primary">+ Tambah Metode</a>
        </div>
    </section>

    <!-- FORM PENCARIAN -->
    <section class="card">
        <form method="GET" action="admin-payment-table.php" class="form-group">
            <label for="search">Cari Bank / Metode Pembayaran</label>
            <div style="display: flex; gap: 10px; margin-top: 6px;">
                <input type="text" id="search" name="search" class="form-control" placeholder="Contoh: BCA, BRI, DANA..." value="<?= htmlspecialchars($search) ?>">
                <button type="submit" class="btn-primary">Cari</button>
            </div>
        </form>
    </section>

    <br>

    <!-- TABEL DATA -->
    <section>
        <table class="table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Bank / Metode</th>
                    <th>Jenis</th>
                    <th>Nomor Rekening</th>
                    <th>Nama Pemilik</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1;
                if (mysqli_num_rows($result) > 0):
                    while ($row = mysqli_fetch_assoc($result)): 
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><strong><?= htmlspecialchars($row['bank_name']) ?></strong></td>
                    <td><?= ucfirst(htmlspecialchars($row['type'])) ?></td>
                    <td><?= htmlspecialchars($row['account_number']) ?></td>
                    <td><?= htmlspecialchars($row['owner_name']) ?></td>
                    <td><?= ucfirst(htmlspecialchars($row['status'])) ?></td>
                    <td>
                        <a href="admin-payment-edit.php?id=<?= $row['id'] ?>" class="btn-outline">Edit</a>
                        <a href="admin-payment-delete.php?id=<?= $row['id'] ?>" class="btn-danger" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                    </td>
                </tr>
                <?php 
                    endwhile; 
                else: 
                ?>
                <tr>
                    <td colspan="7" style="text-align: center;">Data pembayaran tidak ditemukan.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>

    <br>
    <a href="../index.php" class="btn-outline">Kembali ke Beranda</a>
</main>
</body>
</html>
