<?php

require_once __DIR__ . '/../koneksi.php';


/*
|--------------------------------------------------------------------------
| Hanya menerima POST
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header('Location: admin-donor-table.php');
    exit;

}


/*
|--------------------------------------------------------------------------
| Ambil data form
|--------------------------------------------------------------------------
*/

$id = (int) ($_POST['id'] ?? 0);

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');

$isAnonymous = (int) ($_POST['anonymous'] ?? -1);


/*
|--------------------------------------------------------------------------
| Validasi
|--------------------------------------------------------------------------
*/

if ($id <= 0) {
    die('ID donatur tidak valid.');
}

if (
    $name === '' ||
    $email === '' ||
    $phone === ''
) {
    die('Data donatur belum lengkap.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    die('Format email tidak valid.');
}

if (
    $isAnonymous !== 0 &&
    $isAnonymous !== 1
) {
    die('Status anonimitas tidak valid.');
}


/*
|--------------------------------------------------------------------------
| Query UPDATE
|--------------------------------------------------------------------------
*/

$query = "
    UPDATE donors
    SET
        name = ?,
        email = ?,
        phone = ?,
        is_anonymous = ?
    WHERE id = ?
";

$stmt = mysqli_prepare(
    $koneksi,
    $query
);


mysqli_stmt_bind_param(
    $stmt,
    'sssii',
    $name,
    $email,
    $phone,
    $isAnonymous,
    $id
);


/*
|--------------------------------------------------------------------------
| Jalankan UPDATE
|--------------------------------------------------------------------------
*/

if (!mysqli_stmt_execute($stmt)) {

    if (mysqli_stmt_errno($stmt) === 1062) {

        die(
            'Email tersebut sudah digunakan '
            . 'oleh donatur lain.'
        );

    }

    die(
        'Gagal mengubah data donatur: '
        . mysqli_stmt_error($stmt)
    );

}


mysqli_stmt_close($stmt);


/*
|--------------------------------------------------------------------------
| Kembali ke tabel donor
|--------------------------------------------------------------------------
*/

header(
    'Location: admin-donor-table.php'
);

exit;