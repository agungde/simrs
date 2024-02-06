<?php
// pengecekan ajax request untuk mencegah direct access file, agar file tidak bisa diakses secara langsung dari browser
// jika ada ajax request
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
  // panggil file "database.php" untuk koneksi ke database
 require_once "config.php";
$usrnam  = "".USER_NAME;
$id_user = "".USER_ID;
$dbhost  = "".DB_HOST;
$dbuser  = "".DB_USERNAME;
$dbpass  = "".DB_PASSWORD;
$dbname  = "".DB_NAME;
$koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);

  // mengecek data post dari ajax
  if (isset($_POST['pid'])) {
    // ambil data hasil post dari ajax
    $id = mysqli_real_escape_string($koneksi, $_POST['pid']);
	$lok = mysqli_real_escape_string($koneksi, $_POST['lok']);
    // tentukan nilai status
    $status = "1";
    // ambil tanggal dan waktu update data
    $updated_date = gmdate("Y-m-d H:i:s", time() + 60 * 60 * 7);
date_default_timezone_set("Asia/Jakarta");
    // sql statement untuk update data di tabel "tbl_antrian" berdasarkan "id"
    $update = mysqli_query($koneksi, "UPDATE antrian
                                     SET status='$status', loket='$lok', updated_date='$updated_date'
                                     WHERE id='$id'")
                                     or die('Ada kesalahan pada query update : ' . mysqli_error($koneksi));
  }
}
