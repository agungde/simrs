<?php
/*
if(isset($_POST['signature'])){ 
$limit = 3 * 1024;
    $signature         = $_POST['signature'];
    $signatureFileName = uniqid().'.png';
    $signature         = str_replace('data:image/png;base64,', '', $signature);
    $signature         = str_replace(' ', '+', $signature);
    $data              = base64_decode($signature);
    $file              = 'uploads/ttd/'.$signatureFileName;
   // file_put_contents($file, $data);
    // $msg = "<div class='alert alert-success'>Signature Uploaded</div>";
	if($data > $limit){
		$data["passok"] = "OK";
	}else{
		$data["passok"] = "not";
	}
	
	  
  echo json_encode($data);
} else{
	$data["passok"] = "not";
	 echo json_encode($data);
}
*/
if(isset($_POST['signaturesubmit'])){ 
$limit = 3072;
    $signature         = $_POST['signature'];
   $signatureFileName = uniqid().'.png';
  $signature         = str_replace('data:image/png;base64,', '', $signature);
   $signature         = str_replace(' ', '+', $signature);

				 $jumlah_karakter    =strlen($signature);
				 if($jumlah_karakter > 3036){
					 $data["passok"] = "OK";
				 }else{
				$data["passok"] = "$jumlah_karakter";
				 }
		
		 echo json_encode($data);
}
?>