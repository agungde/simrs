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

if(isset($_POST['tgl'])){
	$tgl=trim($_POST['tgl']);
	$rm=trim($_POST['rm']);

	  $Queryid = "SELECT * FROM rm_lama where no_rekam_medis='$rm' and tanggal_rm='$tgl'";
   $ExecQueryid = MySQLi_query($koneksi, $Queryid);
   $rowsid = mysqli_num_rows($ExecQueryid);
  if ($rowsid <> 0) {

			$data["passok"] = "NOT";

  }else{
	  $data["passok"] = "OK";
  }
  echo json_encode($data);
}

?>
