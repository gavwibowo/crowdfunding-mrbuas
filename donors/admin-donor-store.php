<?php

require_once __DIR__ . '/../koneksi.php';

/*
|--------------------------------------------------------------------------
| Pastikan request berasal dari form POST
|--------------------------------------------------------------------------
*/

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    header('Location: admin-donor-create.php');
    exit;

}


/*
|--------------------------------------------------------------------------
| Ambil data dari form
|--------------------------------------------------------------------------
*/

$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');
$phone = trim($_POST['phone'] ?? '');
$isAnonymous = (int) ($_POST['anonymous'] ?? -1);


/*
|--------------------------------------------------------------------------
| Validasi data
|--------------------------------------------------------------------------
*/

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
| Query INSERT
|--------------------------------------------------------------------------
*/

$query = "
    INSERT INTO donors
    (
        name,
        email,
        phone,
        is_anonymous
    )
    VALUES (?, ?, ?, ?)
";


$stmt = mysqli_prepare(
    $koneksi,
    $query
);


/*
|--------------------------------------------------------------------------
| Masukkan data ke prepared statement
|--------------------------------------------------------------------------
*/

mysqli_stmt_bind_param(
    $stmt,
    'sssi',
    $name,
    $email,
    $phone,
    $isAnonymous
);


/*
|--------------------------------------------------------------------------
| Jalankan query
|--------------------------------------------------------------------------
*/

if (!mysqli_stmt_execute($stmt)) {

    /*
    |--------------------------------------------------------------
    | Error 1062 = duplicate UNIQUE value
    | Email di tabel donors dibuat UNIQUE
    |--------------------------------------------------------------
    */

    if (mysqli_stmt_errno($stmt) === 1062) {

        die(
            'Email tersebut sudah terdaftar sebagai donatur.'
        );

    }

    die(
        'Gagal menyimpan data donatur: '
        . mysqli_stmt_error($stmt)
    );

}


/*
|--------------------------------------------------------------------------
| Tutup statement
|--------------------------------------------------------------------------
*/

mysqli_stmt_close($stmt);


/*
|--------------------------------------------------------------------------
| Setelah berhasil, kembali ke tabel donor
|--------------------------------------------------------------------------
*/

header(
    'Location: admin-donor-table.php'
);

exit;