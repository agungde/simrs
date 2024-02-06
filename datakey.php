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

if(isset($_POST['pin'])){
	$role=trim($_POST['role']);
	$datid=trim($_POST['datid']);
	
	$pin=trim($_POST['pin']);
	$pass=($_POST['password']);
	
	$pinhash = password_hash("$pin", PASSWORD_DEFAULT);
	$passhash = password_hash("$pass", PASSWORD_DEFAULT);
	  $Queryid = "SELECT * FROM data_key where nama='$datid' and user_role_id='$role'";
   $ExecQueryid = MySQLi_query($koneksi, $Queryid);
   $rowsid = mysqli_num_rows($ExecQueryid);
  if ($rowsid <> 0) {
	 // $datain= mysqli_fetch_assoc($ExecQueryid);
while ($datain = MySQLi_fetch_array($ExecQueryid)) {
	
 	if(password_verify($pass,$datain['password']) and password_verify($pin,$datain['pin'])){
			$data["passok"] = "OK";
		}
		else{
			$data["passok"] = "NOT";
		}
}	
		
  }else{
	  $data["passok"] = "NOT";
  }
  
  //$data["passok"] = "not";
  echo json_encode($data);
}

?>
