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
if(isset($_POST['kod'])){
$kod=$_POST['kod'];
}else{
	$kod="";
}
if(isset($_POST['pol'])){
$pol=$_POST['pol'];
}else{
	$pol="";
}
  // ambil tanggal sekarang
  $tanggal = gmdate("Y-m-d", time() + 60 * 60 * 7);
  date_default_timezone_set("Asia/Jakarta");
  // membuat "no_antrian"
  // sql statement untuk menampilkan data "no_antrian" terakhir pada tabel "tbl_antrian" berdasarkan "tanggal"
 
/*
 $query = mysqli_query($mysqli, "SELECT max(no_antrian) as nomor FROM tbl_antrian WHERE tanggal='$tanggal'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($mysqli));
  */
  $query = mysqli_query($koneksi, "SELECT max(no_antrian) as nomor FROM antrian WHERE tanggal='$tanggal' and kode='$kod' and kode_poli='$pol'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
 


 // ambil jumlah baris data hasil query
  $rows = mysqli_num_rows($query);

  // cek hasil query
  // jika "no_antrian" sudah ada
  if ($rows <> 0) {
    // ambil data hasil query
    $data = mysqli_fetch_assoc($query);
    // "no_antrian" = "no_antrian" yang terakhir + 1
    $no_antrian = $data['nomor'] + 1;
  }
  // jika "no_antrian" belum ada
  else {
    // "no_antrian" = 1
    $no_antrian = 1;
  }

  // sql statement untuk insert data ke tabel "tbl_antrian"
  $insert = mysqli_query($koneksi, "INSERT INTO antrian(kode, kode_poli, tanggal, no_antrian) 
                                   VALUES('$kod','$pol','$tanggal', '$no_antrian')")
                                   or die('Ada kesalahan pada query insert : ' . mysqli_error($koneksi));
  // cek query
  // jika proses insert berhasil
  if ($insert) {
     $queryb = mysqli_query($koneksi, "SELECT * FROM antrian 
                                  WHERE tanggal='$tanggal'  
                                  ORDER BY id DESC LIMIT 1")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
	  $rowsb = mysqli_num_rows($queryb);

  // cek hasil query
  // jika "no_antrian" sudah ada
  if ($rowsb <> 0) {
    // ambil data hasil query
    $datab = mysqli_fetch_assoc($queryb);
    // "no_antrian" = "no_antrian" yang terakhir + 1
    $noa = $datab['no_antrian'];
	$kod = $datab['kode'];
	$kodp = $datab['kode_poli'];
	$print="$kod$kodp$noa";
		$array_hr= array(1=>"Senin","Selasa","Rabu","Kamis","Jumat","Sabtu","Minggu");
		$hr = $array_hr[date('N')];
  
		$tgl= date('j');

		$array_bln = array(1=>"Januari","Februari","Maret", "April", "Mei","Juni","Juli","Agustus","September","Oktober", "November","Desember");
		$bln = $array_bln[date('n')];
		/* script menentukan tahun */ 
		$thn = date('Y');
		/* script perintah keluaran*/ 
		$tanggal=$hr . ", " . $tgl . " " . $bln . " " . $thn . " " . date('H:i');	
     $queryc = mysqli_query($koneksi, "SELECT * FROM data_bank 
                                  WHERE kode='$kod' and type='1'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
	  $rowsc = mysqli_num_rows($queryc);

  // cek hasil query
  // jika "no_antrian" sudah ada
  if ($rowsc <> 0) {
    // ambil data hasil query
    $datac = mysqli_fetch_assoc($queryc);
	$namb = $datac['nama_bank'];
  }	
     $queryd = mysqli_query($koneksi, "SELECT * FROM data_poli 
                                  WHERE kode='$kodp'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
	  $rowsd = mysqli_num_rows($queryd);

  // cek hasil query
  // jika "no_antrian" sudah ada
  if ($rowsd <> 0) {
    // ambil data hasil query
    $datad = mysqli_fetch_assoc($queryd);
	$bampol = $datad['nama_poli'];
  }		
  }
	$data["print"] = "$print";
	$data["ambil"] = "OK";
	$data["tanggal"] = "$tanggal";
	$data["kodantrian"] = "Antrian $namb";
	$data["poli"] = "POLI $bampol";
	echo json_encode($data);
  }
}
