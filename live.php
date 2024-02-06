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
if(isset($_POST['live'])){
		$nom=0;
		$isipesan="";
		$isiitem="";
		$koma=",";
	 $dtcek = mysqli_query($koneksi,"select * from data_barang");
$rodt = mysqli_num_rows($dtcek);
  if ($rodt  <> 0) {
while ($datdt = MySQLi_fetch_array($dtcek)) {

	$iddata=$datdt['id_barang'];
	$stmin=$datdt['warning_setok'];	
	$minsetok=$stmin + 1;
 $stcek = mysqli_query($koneksi,"select * from setok_barang where id_data='$iddata'");
$rost = mysqli_num_rows($stcek);
  if ($rost  <> 0) {
while ($datst = MySQLi_fetch_array($stcek)) {
		$juml=$datst['jumlah'];
		$kod=$datst['kode_barang'];
if($juml < 	$minsetok){
	$nom =$nom + 1;	
	$isipesan="$nom";
	if($isiitem==""){
	$isiitem="$kod";
	}else{
	$isiitem="$isiitem$koma$kod";
	}
	
}

	

	

}
}

}
  }
if($isipesan==""){
	$data["pesan"] = "";
	$data["kode"] = "";
	$data["total"] = "";
}else{
$data["pesan"] = "Ya";
$data["kode"] = "Ada $nom Barang Yang Sudah Di Level Ninimum";
$data["total"] = "$nom";
}
  echo json_encode($data);
  /*
 $pascek = mysqli_query($koneksi,"select * from data_pasien WHERE id_user='' or id_user='0'");
$ropas = mysqli_num_rows($pascek);
  if ($ropas  <> 0) {
while ($datpas = MySQLi_fetch_array($pascek)) {
	$id_pasien=$datpas['id_pasien'];
	$cekiduser=$datpas['id_user'];
	$nama_pasien=$datpas['nama_pasien'];
	$no_ktp=$datpas['no_ktp'];
	$email=$datpas['email'];
	$umur=$datpas['umur'];
	$tanggal_lahir=$datpas['tanggal_lahir'];
	$jenis_kelamin=$datpas['jenis_kelamin'];
	$no_hp=$datpas['no_hp'];
	$no_rekam_medis=$datpas['no_rekam_medis'];
	$alamat=$datpas['alamat'];
	
	$password_hash = password_hash("$no_rekam_medis", PASSWORD_DEFAULT);
mysqli_query($koneksi,"INSERT INTO `user_login` (`no_ktp`,`nama`, `username`, `email`, `password`, `user_role_id`) VALUES ('$no_ktp','$nama_pasien','$no_ktp', '$email', '$password_hash', '2')"); 
 $pasceku = mysqli_query($koneksi,"select * from user_login WHERE no_ktp='$no_ktp'");
$ropasu = mysqli_num_rows($pasceku);
  if ($ropasu  <> 0) {
	  $datauser = mysqli_fetch_assoc($pasceku);
	 $iduserlogin=$datauser['id_userlogin'];
	 if($cekiduser=="" or $cekiduser=="0"){
	    mysqli_query($koneksi, "UPDATE data_pasien SET id_user='$iduserlogin' WHERE id_pasien='$id_pasien='");
	 }
  }


}

}
  
$pascekp = mysqli_query($koneksi,"SELECT * FROM `data_pasien`");
$ropasp = mysqli_num_rows($pascekp);
  if ($ropasp  <> 0) {
while ($datpasp = MySQLi_fetch_array($pascekp)) {  
$passhash=$datpasp['no_rekam_medis'];
 
 $pascekuser = mysqli_query($koneksi,"select * from user_login WHERE no_ktp=".$datpasp['no_ktp']);
$ropasuse = mysqli_num_rows($pascekuser);
  if ($ropasuse  <> 0) {
  }else{
	  	$password_hashh = password_hash("$passhash", PASSWORD_DEFAULT);
mysqli_query($koneksi,"INSERT INTO `user_login` (`no_ktp`,`nama`, `username`, `email`, `password`, `user_role_id`) VALUES ('".$datpasp['no_ktp']."','".$datpasp['nama_pasien']."','".$datpasp['no_ktp']."', '".$datpasp['email']."', '$password_hashh', '2')"); 
 $pasceku = mysqli_query($koneksi,"select * from user_login WHERE no_ktp=".$datpasp['no_ktp']);
$ropasu = mysqli_num_rows($pasceku);
  if ($ropasu  <> 0) {
	  $datauser = mysqli_fetch_assoc($pasceku);
	 $iduserlogin=$datauser['id_userlogin'];
	    mysqli_query($koneksi, "UPDATE data_pasien SET id_user='$iduserlogin' WHERE no_ktp=".$datpasp['no_ktp']);
	    mysqli_query($koneksi, "UPDATE biodata SET id_user='$iduserlogin' WHERE no_ktp=".$datpasp['no_ktp']);
  }
  }
 
 
 $pascekb = mysqli_query($koneksi,"select * from biodata WHERE no_ktp=".$datpasp['no_ktp']);
$ropasb = mysqli_num_rows($pascekb);
  if ($ropasb  <> 0) {
	  //$databi = mysqli_fetch_assoc($pasceku);
	  //  mysqli_query($koneksi, "UPDATE data_pasien SET id_user='".$datauser['id_userlogin']."' WHERE id_pasien='$id_pasien='");
  }else{
 mysqli_query($koneksi, "INSERT INTO `biodata`(`id_user`, `no_rekam_medis`, `no_ktp`, `nama`, `tanggal_lahir`, `no_hp`, `alamat`, `jenis_kelamin`, `umur`, `email`) VALUES ('".$datpasp['id_user']."', '".$datpasp['no_rekam_medis']."', '".$datpasp['no_ktp']."', '".$datpasp['nama_pasien']."', '".$datpasp['tanggal_lahir']."', '".$datpasp['no_hp']."', '".$datpasp['alamat']."', '".$datpasp['jenis_kelamin']."', '".$datpasp['umur']."', '".$datpasp['email']."')");
  }
  
}
 
  }	
	 */
$live=trim($_POST['live']);
$dev=$_POST['dev'];
$now=$_POST['now'];
mysqli_query($koneksi, "UPDATE user_login SET device='$dev', chat='Online', setatus='Online', last_login='$now' WHERE id_userlogin='$live'");
}


?>