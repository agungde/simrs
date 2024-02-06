<?php
  require('config.php');
$usrnam  = "".USER_NAME;
$id_user = "".USER_ID;
$dbhost  = "".DB_HOST;
$dbuser  = "".DB_USERNAME;
$dbpass  = "".DB_PASSWORD;
$dbname  = "".DB_NAME;
$koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
$idtrace = "$id_user$usrnam";
$linksite="".SITE_ADDR;

if (isset($_POST['untuk'])) {	
  $tanggal = gmdate("Y-m-d", time() + 60 * 60 * 7);
date_default_timezone_set("Asia/Jakarta");

	$untuk = $_POST['untuk'];
	//////////Umum////////////////
	if($untuk==9){	
 $Query = "SELECT * FROM `permintaan_barang` WHERE `setatus`='Register'";
$ExecQuery = MySQLi_query($koneksi, $Query);
  $rows = mysqli_num_rows($ExecQuery);
  if ($rows <> 0) {
	  $itung=0;
	  while ($Result = MySQLi_fetch_array($ExecQuery)) {
		  $itung++;
	  }		  
	  $linkapp="permintaan_barang/approval";
	  echo " <a href=\"$linksite$linkapp\"><div style=\"color:red;\"><b>$itung Permintaann Barang</b></div></a>";
	  }	  
	}

////////////////////Farmasi//////////////////
	if($untuk==5){
 $Query = "SELECT * FROM `permintaan_barang` WHERE `setatus`='Di Kirim'";
$ExecQuery = MySQLi_query($koneksi, $Query);
  $rows = mysqli_num_rows($ExecQuery);
  if ($rows <> 0) {
	  $itung=0;
	  while ($Result = MySQLi_fetch_array($ExecQuery)) {
		  $itung++;
	  }		  
	  $linkapp="permintaan_barang";
	  echo "<a href=\"$linksite$linkapp\"><div style=\"color:red;\"><b>$itung Permintaan Sedang Di Kirim</b></div></a>";
	  }

 $Query = "SELECT * FROM `resep_obat` WHERE `setatus`='Register'";
$ExecQuery = MySQLi_query($koneksi, $Query);
  $rows = mysqli_num_rows($ExecQuery);
  if ($rows <> 0) {
	  $itung=0;
	  while ($Result = MySQLi_fetch_array($ExecQuery)) {
		  $itung++;
	  }		  
	  $linkapp="resep_obat";
	  echo "<a href=\"$linksite$linkapp\"><div style=\"color:red;\"><b>$itung Resep Obat Register</b></div></a>";
	  }
	  
 $Query = "SELECT * FROM `data_setok` WHERE jumlah < 4 and `divisi`='FARMASI' and `bagian`='FARMASI'";
$ExecQuery = MySQLi_query($koneksi, $Query);
  $rows = mysqli_num_rows($ExecQuery);
  if ($rows <> 0) {
	  $itung=0;
	  while ($Result = MySQLi_fetch_array($ExecQuery)) {
		  $itung++;
	  }		  
	  $linkapp="resep_obat";
	  echo "<div style=\"color:red;\"><b>$itung Data Obat Di Bawah Minimum</b></div>";
	  }
	  
	}

////////////////////Gudang//////////////////
	if($untuk==20){
 $Query = "SELECT * FROM `permintaan_barang` WHERE `setatus`='Approv'";
$ExecQuery = MySQLi_query($koneksi, $Query);
  $rows = mysqli_num_rows($ExecQuery);
  if ($rows <> 0) {
	  $itung=0;
	  while ($Result = MySQLi_fetch_array($ExecQuery)) {
		  $itung++;
	  }		  
	  $linkapp="permintaan_barang";
	  echo "<a href=\"$linksite$linkapp\"><div style=\"color:red;\"><b>$itung Permintaan Di Setujui</b></div></a>";
	  }	
 $Query = "SELECT * FROM `setok_barang` WHERE `jumlah`<4";
$ExecQuery = MySQLi_query($koneksi, $Query);
  $rows = mysqli_num_rows($ExecQuery);
  if ($rows <> 0) {
	  $itung=0;
	  while ($Result = MySQLi_fetch_array($ExecQuery)) {
		  $itung++;
	  }		  
	  $linkapp="permintaan_barang";
	  echo "<div style=\"color:red;\"><b>$itung Setok Barang Di Bawah Minimum</b></div>";
	  }
	  
	}

////////////////////admin IGD//////////////////
	if($untuk==8){
 $Query = "SELECT * FROM `permintaan_barang` WHERE `setatus`='Di Kirim'";
$ExecQuery = MySQLi_query($koneksi, $Query);
  $rows = mysqli_num_rows($ExecQuery);
  if ($rows <> 0) {
	  $itung=0;
	  while ($Result = MySQLi_fetch_array($ExecQuery)) {
		  $itung++;
	  }		  
	  $linkapp="permintaan_barang";
	  echo "<a href=\"$linksite$linkapp\"><div style=\"color:red;\"><b>$itung Permintaan Sedang Di Kirim</b></div></a>";
	  }	  
	}
	
////////////////////Kasir//////////////////
	if($untuk==7){
 $Query = "SELECT * FROM `penjualan` WHERE `setatus`='Register'";
$ExecQuery = MySQLi_query($koneksi, $Query);
  $rows = mysqli_num_rows($ExecQuery);
  if ($rows <> 0) {
	  $itung=0;
	  while ($Result = MySQLi_fetch_array($ExecQuery)) {
		  $itung++;
	  }		  
	  $linkapp="penjualan/kasir";
	  echo "<a href=\"$linksite$linkapp\"><div style=\"color:red;\"><b>$itung Penjualan Register</b></div></a>";
	  }	  
	}	
	
	
	
}
?>