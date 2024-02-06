<?php
if(isset($_POST['jenis_pemeriksaan'])){
	$jenisp     = $_POST['jenis_pemeriksaan'];
	//$namap      = $_POST['nama_pemeriksaan'];
	//for($a = 0; $a < count($jenisp); $a++){
 //  $jenisps = $jenisp[$a];
 //  if($jenisps==""){
	 for($a = 0; $a < count($jenisp); $a++){
   $jenisps = trim($jenisp[$a]);
   if($jenisps==""){
	   $data["passok"] = "Jenis";
   }else{
	   if(isset($_POST['nama_pemeriksaan'])){
	   $namap      = $_POST['nama_pemeriksaan'];
//$data["passok"] = "OK";
  for($b = 0; $b < count($namap); $b++){
      $namaps = trim($namap[$b]);
  if($namaps==""){  
 $data["passok"] = "Not";
  }else{
  $data["passok"] = "OK";
}

}

	   }else{
		   $data["passok"] = "Not";
	   }
   }

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
}
?>