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
  // sql statement untuk menampilkan data "no_antrian" dari tabel "tbl_antrian" berdasarkan "tanggal" dan "status = 1"
  $query = mysqli_query($koneksi, "SELECT * FROM antrian 
                                  WHERE kode='$kod' and tanggal='$tanggal' AND status='1' 
                                  ORDER BY updated_date DESC LIMIT 1")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rows = mysqli_num_rows($query);

  // cek hasil query
  // jika data "no_antrian" ada
  if ($rows <> 0) {
    // ambil data hasil query
    $data = mysqli_fetch_assoc($query);
    // buat variabel untuk menampilkan data
    $no_antrian = $data['no_antrian'];
$kode = $data['kode'];
$kodepol = $data['kode_poli'];
    // tampilkan data
    echo $kode."$kodepol".number_format($no_antrian, 0, '', '.');
  } 
  // jika data "no_antrian" tidak ada
  else {
    // tampilkan "-"
    echo "-";
  }
}
