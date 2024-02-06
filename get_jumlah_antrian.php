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
  // ambil tanggal sekarang
  $tanggal = gmdate("Y-m-d", time() + 60 * 60 * 7);
  date_default_timezone_set("Asia/Jakarta");
$kod=$_GET['kode'];
  // sql statement untuk menampilkan jumlah data dari tabel "tbl_antrian" berdasarkan "tanggal"
  $query = mysqli_query($koneksi, "SELECT count(id) as jumlah FROM antrian 
                                  WHERE kode='$kod' and tanggal='$tanggal'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil data hasil query
  $data = mysqli_fetch_assoc($query);
  // buat variabel untuk menampilkan data
  $jumlah_antrian = $data['jumlah'];

  // tampilkan data
  echo number_format($jumlah_antrian, 0, '', '.');
}
