<?php
include "koneksi.php";

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$query  = "SELECT * FROM campaigns WHERE id = '$id'";
$result = mysqli_query($koneksi, $query);
$data   = mysqli_fetch_assoc($result);

if (!$data) {
    header("Location: admin-campaign-table.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin - Edit Campaign</title>
    <link rel="stylesheet" href="../assests/css/style.css">
</head>
<body>
    <div class="container">
        <div class="card" style="max-width: 600px; margin: 0 auto;">
            <h2>Edit Program Campaign</h2>
            <form action="admin-campaign-update.php" method="POST">
                <input type="hidden" name="id" value="<?php echo $data['id']; ?>">

                <div class="form-group">
                    <label>Judul Campaign</label>
                    <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($data['title']); ?>" required>
                </div>
                <div class="form-group">
                    <label>Target Dana (Rp)</label>
                    <input type="number" name="target_amount" class="form-control" value="<?php echo htmlspecialchars($data['target_amount']); ?>" required>
                </div>
                <button type="submit" class="btn-primary">Update Campaign</button>
            </form>
        </div>
    </div>
</body>
</html>
