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
$kod=$_GET['kode'];
  // ambil tanggal sekarang
  $tanggal = gmdate("Y-m-d", time() + 60 * 60 * 7);
date_default_timezone_set("Asia/Jakarta");

  // sql statement untuk menampilkan data dari tabel "tbl_antrian" berdasarkan "tanggal"
  $query = mysqli_query($koneksi, "SELECT * FROM antrian 
                                  WHERE kode='$kod' and tanggal='$tanggal'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  // ambil jumlah baris data hasil query
  $rows = mysqli_num_rows($query);

  // cek hasil query
  // jika data ada
  if ($rows <> 0) {
    $response         = array();
    $response["data"] = array();
$no=0;
    // ambil data hasil query
    while ($row = mysqli_fetch_assoc($query)) {
		$no++;
		$kodes=$row["kode"];
		$kodepol=$row["kode_poli"];
      $data['id']         = $row["id"];
	  $data['kode']     = $row["kode"];
	  $data['kodepol']     =$kodepol;
      $data['antriantabel'] =$kodes."$kodepol".$row["no_antrian"];
      $data['status']     = $row["status"];
	  $data['nom']     = $no;
$data['no_antrian'] =$row["no_antrian"];
      array_push($response["data"], $data);
	  
    }

    // tampilkan data
    echo json_encode($response);
  }
  // jika data tidak ada
  else {
    $response         = array();
    $response["data"] = array();

    // buat data kosong untuk ditampilkan
	$data['nom']         = "";
    $data['id']         = "";
	$data['kode']     = "";
    $data['no_antrian'] = "-";
    $data['status']     = "";
	$data['antriantabel']     = "";
	$data['kodepol'] ="";
    array_push($response["data"], $data);

    // tampilkan data
    echo json_encode($response);
  }
}
