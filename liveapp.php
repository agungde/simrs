<?php
$usrnam  = "".USER_NAME;
$id_user = "".USER_ID;
$dbhost  = "".DB_HOST;
$dbuser  = "".DB_USERNAME;
$dbpass  = "".DB_PASSWORD;
$dbname  = "".DB_NAME;
$koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
$idtrace = "$id_user$usrnam";

function sisten_antri()
{
$sistem=array();
			$sistem[]=array(
				'sistemon'=>'offline', ////// online / offline ////
				'sistemsuara'=>'Female', ////// Female / Male ////  Hamua berlaku online /////
				'sistemloket'=>'konter', ////// loket / konter ////
			);
return $sistem;	
}
  
?>

<script src="https://code.responsivevoice.org/responsivevoice.js?key=jQZ2zcdq"></script>
  <script type="text/javascript" src="<?php print_link("datatables.min.js") ?>"></script>
      <script type="text/javascript" src="<?php print_link("responsive-voice.js") ?>"></script>
      <script type="text/javascript" src="<?php print_link("suara.js") ?>"></script>
 <audio id="tingtung" src="<?php print_link("assets/audio/tingtung.mp3") ?>"></audio>
<style>
.blink_me {
	margin-left:5px;
	color:red;
	fomt:bold;
  animation: blinker 1s linear infinite;
}

@keyframes blinker {
  50% {
    opacity: 0;
  }
}
</style>
<div align="right" class="blink_me" id="notif<?php echo USER_ROLE;?>">
					  <script type="text/javascript">
     	  setInterval(function(){
				var lok=<?php echo USER_ROLE;?>;
		        $.ajax({
		        type:"POST",
		        url: "<?php print_link("notif.php") ?>",
		        data: "untuk="+lok,
		        success:function(data){	
			        document.getElementById("notif<?php echo USER_ROLE;?>").innerHTML = data;
		       		 }
		   	 	})
       		 }, 1000);
  </script>
  </div>
<?php

/*
 $appcek = mysqli_query($koneksi,"select * from data_rekam_medis");
$roapp = mysqli_num_rows($appcek );
  if ($roapp  <> 0) {
while ($datapp = MySQLi_fetch_array($appcek)) {
	$iddtr=$datapp['id'];
	$id_daftar=$datapp['id_daftar'];
	$no_rekam_medis=$datapp['no_rekam_medis'];
	$tanggal=$datapp['tanggal'];
	$nama_poli=$datapp['nama_poli'];
	$pasien=$datapp['pasien'];
	$dokter_pemeriksa=$datapp['dokter_pemeriksa'];
	$catatan_medis=$datapp['catatan_medis'];
	    $query = mysqli_query($koneksi, "SELECT * from data_poli WHERE id_poli='$nama_poli'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
   $rows = mysqli_num_rows($query);
  if ($rows <> 0) {
      $datacek= mysqli_fetch_assoc($query);
      $nampol=$datacek['nama_poli'];
	   mysqli_query($koneksi, "UPDATE data_rekam_medis SET  nama_poli='$nampol' WHERE id='$iddtr'");
  }else{
     $nampol="$nama_poli" ;
  }
  
  
  	    $querydtr = mysqli_query($koneksi, "SELECT * from catatan_medis WHERE no_rekam_medis='$no_rekam_medis'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
   $rowsdtr = mysqli_num_rows($querydtr);
  if ($rowsdtr <> 0) {
      $datacekdtr= mysqli_fetch_assoc($querydtr);
     // $nampol=$datacekdtr['nama_poli'];
  }else{
     mysqli_query($koneksi,"INSERT INTO `catatan_medis` (`id_daftar`,`tanggal`,`no_rekam_medis`,`catatan_medis`,`pasien`,`nama_poli`,`dokter`) VALUES ('$id_daftar','$tanggal','$no_rekam_medis','$catatan_medis','$pasien','$nampol','$dokter_pemeriksa')");   

  }
  }
}


 $appcektd = mysqli_query($koneksi,"select * from data_tindakan");
$roapptd = mysqli_num_rows($appcektd);
  if ($roapptd  <> 0) {
while ($datapptd = MySQLi_fetch_array($appcektd)) {
	$iddt=$datapptd['id'];
	$pasien=$datapptd['pasien'];
	$iddaftar=$datapptd['id_daftar'];
	$norekam=$datapptd['no_rekam_medis'];
	$dokpem=$datapptd['dokter_pemeriksa'];
	
	if($dokpem==""){
	if($pasien=="IGD"){
	$queryp = mysqli_query($koneksi, "SELECT * from igd WHERE id_igd='$iddaftar'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
   $rowsp = mysqli_num_rows($queryp);
  if ($rowsp <> 0) {
      $datacekp= mysqli_fetch_assoc($queryp);
      $dok=$datacekp['dokter'];
	  	$queryd= mysqli_query($koneksi, "SELECT * from data_dokter WHERE id_dokter='$dok'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
   $rowsd = mysqli_num_rows($queryd);
  if ($rowsp <> 0) {
      $datacekd= mysqli_fetch_assoc($queryd);
	  $namdok=$datacekd['nama_dokter'];
  }
	   mysqli_query($koneksi, "UPDATE data_tindakan SET no_rekam_medis='$no_rekam_medis', dokter_pemeriksa='$namdok' WHERE id='$iddt'");
  }	
		
}else if($pasien=="POLI"){
	$queryp = mysqli_query($koneksi, "SELECT * from pendaftaran_poli WHERE id_pendaftaran_poli='$iddaftar'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
   $rowsp = mysqli_num_rows($queryp);
  if ($rowsp <> 0) {
      $datacekp= mysqli_fetch_assoc($queryp);
      $dok=$datacekp['dokter'];
	  	$queryd= mysqli_query($koneksi, "SELECT * from data_dokter WHERE id_dokter='$dok'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
   $rowsd = mysqli_num_rows($queryd);
  if ($rowsp <> 0) {
      $datacekd= mysqli_fetch_assoc($queryd);
	  $namdok=$datacekd['nama_dokter'];
  }	  
	   mysqli_query($koneksi, "UPDATE data_tindakan SET no_rekam_medis='$no_rekam_medis', dokter_pemeriksa='$namdok' WHERE id='$iddt'");
  }		
}else{
	$queryp = mysqli_query($koneksi, "SELECT * from rawat_inap WHERE id='$iddaftar'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
   $rowsp = mysqli_num_rows($queryp);
  if ($rowsp <> 0) {
      $datacekp= mysqli_fetch_assoc($queryp);
      $dok=$datacekp['dokter_rawat_inap'];
	  	$queryd= mysqli_query($koneksi, "SELECT * from data_dokter WHERE id_dokter='$dok'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
   $rowsd = mysqli_num_rows($queryd);
  if ($rowsp <> 0) {
      $datacekd= mysqli_fetch_assoc($queryd);
	  $namdok=$datacekd['nama_dokter'];
  }	  
	   mysqli_query($koneksi, "UPDATE data_tindakan SET no_rekam_medis='$no_rekam_medis', dokter_pemeriksa='$namdok' WHERE id='$iddt'");
  }		
}
	}
}
  }
*/

$agent=$_SERVER["HTTP_USER_AGENT"];
$isMob = is_numeric(strpos(strtolower($_SERVER["HTTP_USER_AGENT"]), "mobile"));  
if($isMob){ 
   // echo 'Using Mobile Device...'; 
	 echo '<input type="hidden" id="device" value="Mobile">';
	 $device="Mobile";
}else{ 
   // echo 'Using Desktop...'; 
	echo '<input type="hidden" id="device" value="Desktop">';
	$device="Desktop";
}

  $Queryid = "SELECT * FROM user_login WHERE id_userlogin='$id_user'";
   $ExecQueryid = MySQLi_query($koneksi, $Queryid);
   $rowsid = mysqli_num_rows($ExecQueryid);
  if ($rowsid <> 0) {
  $dataid        = mysqli_fetch_assoc($ExecQueryid);
   $namacek=$dataid['nama'];
   $devcek=$dataid['device'];
   $ceksetatus=$dataid['setatus'];
   $lastlogincek=$dataid['last_login'];
   $date_created=$dataid['date_created'];
  }
  
  function get_the_browser()
{
if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== false)
   return 'Internet explorer';
 elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== false)
    return 'Internet explorer';
 elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== false)
   return 'Mozilla Firefox';
 elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== false)
   return 'Google Chrome';
 elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== false)
   return "Opera Mini";
 elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== false)
   return "Opera";
 elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== false)
   return "Safari";
 else
   return 'Other';
}
  
 //echo get_the_browser();

 // if($lastlogin=="" or $lastlogin=="NULL" or $lastlogin="0000-00-00 00:00:00"){
//	  $lastlogin=$date_created;
 // }
  
         $waktu_awal        =strtotime("$lastlogin");
        $saatini    =date("Y-m-d H:i:s"); // bisa juga waktu sekarang now()
        
		
		       // $waktu_awal        =strtotime("2019-10-11 00:01:25");
        $waktu_akhir    =strtotime("$saatini"); // bisa juga waktu sekarang now()
        

        //menghitung selisih dengan hasil detik
        $diff    =$waktu_akhir - $waktu_awal;
        
        //membagi detik menjadi jam
        $jam    =floor($diff / (60 * 60));
        
        //membagi sisa detik setelah dikurangi $jam menjadi menit
        $menit    =$diff - $jam * (60 * 60);

        //menampilkan / print hasil
       // echo 'Hasilnya adalah '.number_format($diff,0,",",".").' detik<br /><br />';
      //  echo 'Sehingga Anda memiliki sisa waktu promosi selama: ' . $jam .  ' jam dan ' . floor( $menit / 60 ) . ' menit';
   $lastlogin=floor( $menit / 60 );
 // echo $lastlogin;
 
 $seen = floor(($diff)/60);
                $more = false;	
                if($seen > 60) {
                    $more = true;
                    $hours = floor($seen/60);
                    $minutes = $seen-($hours*60);
                    if(($seen > 24) && ($more == true)) {
                        $days = floor(($seen/60)/24);
                        $hours = floor($seen/60)-($days*24);
                    }
                    if($minutes == 1) {
                        $minute = ' minute ';  
                    } else {
                        $minute = ' minutes ';
                    }
                    if($hours == 1) {
                        $hour = ' hour ';  
                    } else {
                        $hour = ' hours ';
                    }
                    if($days == 1) {
                        $day = ' day ';  
                    } else {
                        $day = ' days ';
                    }
                    if($days > 0) {  
                        $seen = $days . $day . $hours . $hour . $minutes . $minute . 'ago';
                    } else {
                        $seen = $hours . $hour . $minutes . $minute . 'ago';
                    }
                } else {
                    if($seen == 1) {
                        $minute = ' minute ';  
                    } else {
                        $minute = ' minutes ';
                    }    
                    $seen = $seen . $minute . 'ago';
                }
			//echo  $seen;	
			/*
$tglmsk=$data['$lastlogincek'];
$awal  = new DateTime($tglmsk);
$akhir = new DateTime(); // Waktu sekarang
$diff  = $awal->diff($akhir);

//echo 'Selisih waktu: ';
//echo $diff->y . ' tahun, ';
//echo $diff->m . ' bulan, ';
//echo $diff->d . ' hari, ';
//echo $diff->h . ' jam, ';
//echo $diff->i . ' menit, ';
//echo $diff->s . ' detik, ';

//$thun=$diff->y . ' Tahun, ';
//$buln=$diff->m . ' Bulan, ';
//$hri=$diff->d . ' Hari';
//$jam=$diff->h . ' jam, ';

$thun=$diff->y . '';
$buln=$diff->m . '';
$hri=$diff->d . '';
$jam=$diff->h . '';
$men=$diff->i . '';
if($hri < 0){
}else{
	if($jam < 0){
	}else{
		if($men < 4){
		}else{
			if($ceksetatus=="Online"){
								?>
				  <script language="JavaScript">
   alert('User <?php echo $namacek;?> Sedang Online!!);
   document.location='<?php print_link(""); ?>';
   </script>  
				<?php
			}else{

			}
		}
	}
}

$umrskrng="$thun$buln$hri$jam";
*/
?>


    <link rel="stylesheet" type="text/css" href="css/flashy.min.css">	 
   <script src="js/flashy.min.js"></script>

  <script type="text/javascript" src="flash.js"></script>
<input type="hidden" id="liveid" value="<?php $id_user = "".USER_ID; echo $id_user;?>">
<?php

	?>
<script>
		$('.flashy__success').click(function() {
			flashy('<a title="Awesome web design code & scripts" href="https://www.codehim.com?source=demo-page" >Flasher your users with flashy</a>', {
				type : 'flashy__success'
			});
		});

<?php
$qust = mysqli_query($koneksi, "SELECT COUNT(*) AS jumst from setok_barang")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
$rostk = mysqli_num_rows($qust);
 if ($rostk <> 0) {
     $datstk=mysqli_fetch_assoc($qust);
     $stall=$datstk['jumst'];
 }else{
     $stall="0";
 }
 

 ?>
  function linkopen() {
	  window.open("https://systempintar.com", "_BPJS");
  }
$(document).ready(function(){ 
liveapp();
 sessionStorage.clear();
       setInterval(function(){   
           liveapp();
        }, 3000);


 function liveapp() {

	 var datetime = "<?php echo datetime_now();?>";
	  var liveid = $('#liveid').val();
	  var device = $('#device').val();
	 $.ajax({
    url:"<?php print_link("");?>live.php",
    method:"POST",
    data:{live:liveid,dev:device,now:datetime},
    dataType:"json",
    success:function(data)
    {

		var pe=""+ data.pesan; 
		var kd=""+ data.kode; 
		var tot=""+ data.total; 
		if(pe=="Ya"){
  if (sessionStorage.clickcount) {
    sessionStorage.clickcount= Number(sessionStorage.clickcount) + 1;
  } else {
 <?php if(USER_ROLE==5){?>
			flashy(''+kd, {
				type : 'flashy__warning',
				stop : true
			});
 <?php }?>
	  		 //  flash(''+kd,{
		 //  'autohide' : false,	
   // 'bgColor' : '#C0392B'
//  } ) ;

    sessionStorage.clickcount= 1;
    }
	

}



}



   });
}
 
 setInterval(function(){
	liveapp();
 }, 1000);
 
});
</script>