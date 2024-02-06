<?php
	   if(isset($_POST['setok'])){
	  $namap      = $_POST['nama_barang'];
	   $set      = $_POST['setok'];
//$data["passok"] = "OK";
  for($b = 0; $b < count($set); $b++){
      $namaps = trim($namap[$b]);
	  $sets= trim($set[$b]);
  if($sets==""){  
 $data["passok"] = "NOT";
  }else{
  $data["passok"] = "OK";
}

}

	   }else{
		   $data["passok"] = "Not";
	   }
   //}
	//}
	/*
	$jenisp     = $_POST['jenis_pemeriksaan'];
$namap      = $_POST['nama_pemeriksaan'];
$precord    = $_POST['precord'];
$pasien     = $_POST['pasien'];
$datprecord = $_POST['datprecord'];


for($a = 0; $a < count($jenisp); $a++){
   $jenisps = $jenisp[$a];
   
  for($b = 0; $b < count($jenisp); $b++){
      $namaps = trim($namap[$b]);
  if($namaps==""){ 
 $data["passok"] = "OK";
  }else{
  $data["passok"] = "OK";
}

}
   
} 
	*/
//$data["passok"] = "NOTOK";

	echo json_encode($data);
//}
?>