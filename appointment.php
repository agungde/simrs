 <div id="appointment-liveap-records">    
    <div id="page-report-body" class="table-responsive">
  <table class="table  table-striped table-sm text-left">
                                        <thead class="table-header bg-success text-dark">
                                            <tr>
                                                <th  class="td-tanggal"> Tanggal</th>
                                                <th  class="td-no_antri_poli"> Nama</th>
                                                <th  class="td-alamat"> Alamat</th>
                                                <th  class="td-nama_poli">Status</th>
                                            </tr>
                                        </thead>
                                        <tbody class="page-data" id="page-data-list-page-8rt4hbl3u9f5">
                                            <!--record-->

                                            <!--record-->

                                                                                        <!--endrecord-->
                                     
  
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

///////////////////////////////////////////////////////////
/*
   $qudtpab = mysqli_query($koneksi, "SELECT * from setok_barang")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi)); 
     while ($datpb = MySQLi_fetch_array($qudtpab)) {
        $kode= $datpb['kode_barang'];
        $jumreq= $datpb['jumlah'];
        $nama_barang= $datpb['nama_barang'];
        $category_barang= $datpb['category_barang'];
         $operator= $datpb['operator'];
    $quset = mysqli_query($koneksi, "SELECT * from data_setok WHERE kode_barang='$kode' and divisi='FARMASI' and bagian='FARMASI'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi)); 
 $rod = mysqli_num_rows($quset);
  if ($rod <> 0) {
     $cdt= mysqli_fetch_assoc($quset);
     $iddat=$cdt['id'];
  $datjum=$cdt['jumlah'];
  $jumsek=$datjum + $jumreq;
      mysqli_query($koneksi,"UPDATE data_setok SET jumlah='$jumsek' WHERE id='$iddat'");
  }else{
 mysqli_query($koneksi,"INSERT INTO `data_setok`( `kode_barang`, `nama_barang`, `category_barang`, `jumlah`, `divisi`, `bagian`, `operator`) VALUES ('$kode','$nama_barang','$category_barang','500','FARMASI','FARMASI','$operator')");
  }
     
     }
	 */
	 //////////////////////////////////////////////////////////

 $appcek = mysqli_query($koneksi,"select * from appointment WHERE setatus=''");
$roapp = mysqli_num_rows($appcek );
  if ($roapp  <> 0) {
while ($datapp = MySQLi_fetch_array($appcek)) {
	$id_appointment=$datapp['id_appointment'];
	$id_pendaftaran_poli=$datapp['id_pendaftaran_poli'];
	$id_user=$datapp['id_user'];
	$nama_poli=$datapp['nama_poli'];
	$keluhan=$datapp['keluhan'];
	$no_antri_poli=$datapp['no_antri_poli'];
	$dokter=$datapp['dokter'];
	$nama_pasien=$datapp['nama_pasien'];
	$no_rekam_medis=$datapp['no_rekam_medis'];
	$no_hp=$datapp['no_hp'];
	$alamat=$datapp['alamat'];
	$jenis_kelamin=$datapp['jenis_kelamin'];
	$tanggal_lahir=$datapp['tanggal_lahir'];
	$email=$datapp['email'];
	$no_ktp=$datapp['no_ktp'];
	$tanggal_appointment=$datapp['tanggal_appointment'];
	

$polcek = mysqli_query($koneksi,"select * from pendaftaran_poli WHERE id_pendaftaran_poli='$id_pendaftaran_poli'");
$ropol= mysqli_num_rows($polcek);
  if ($ropol  <> 0) {	  
  }else{
  $query = mysqli_query($koneksi, "SELECT max(no_antri_poli) as nomor from pendaftaran_poli WHERE nama_poli='$nama_poli' and tanggal='$tanggal_appointment'")
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
$no_antri_poli = $no_antrian;


$sekarang = gmdate("Y-m-d", time() + 60 * 60 * 7);
    $thn  = substr($tanggal_lahir, 0, 4);
    $taun = date("Y");
    $umur = $taun - $thn;
    $umur = substr($umur, 0, 2);
  
function hitung_umur($thn){
    $birthDate = new DateTime($thn);
    $today = new DateTime("today");
    if ($birthDate > $today) { 
        exit("0 tahun 0 bulan 0 hari");
    }
    $y = $today->diff($birthDate)->y;
    $m = $today->diff($birthDate)->m;
    $d = $today->diff($birthDate)->d;
    return $y."Tahun ".$m."Bulan ".$d."Hari";
}
$umurnya=hitung_umur("$tanggal_lahir");
mysqli_query($koneksi,"INSERT INTO `pendaftaran_poli` (`no_ktp`,`umur`,`email`,`keluhan`,`nama_pasien`, `nama_poli`, `dokter`, `no_rekam_medis`, `no_hp`, `alamat`, `jenis_kelamin`, `tanggal_lahir`, `tanggal`,`id_appointment`) VALUES ('$no_ktp','$umurnya','$email','$keluhan','$nama_pasien', '$nama_poli', '$dokter', '$no_rekam_medis', '$no_hp', '$alamat', '$jenis_kelamin', '$tanggal_lahir', '$tanggal_appointment',  '$id_appointment')");   
 	   $queryb = mysqli_query($koneksi, "select * from pendaftaran_poli WHERE id_appointment='$id_appointment'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  $rowsb = mysqli_num_rows($queryb);
  if ($rowsb <> 0) {
$data   = mysqli_fetch_assoc($queryb);
$idpoli = $data['id_pendaftaran_poli'];
      mysqli_query($koneksi, "UPDATE appointment SET id_pendaftaran_poli='$idpoli', no_antri_poli='$no_antri_poli' WHERE id_appointment='$id_appointment'");
  }

 }
	
}
  }



$sekarang = gmdate("Y-m-d", time() + 60 * 60 * 7);
//Getting value of "search" variable from "script.js".
if (isset($_POST['search'])) {
//Search box value assigning to $Name variable.
   $Name = $_POST['search'];
   $poli = $_POST['poli'];
   $ckid = $_POST['cekid'];
   
  $Queryid = "SELECT * FROM user_login WHERE id_userlogin='$ckid'";
   $ExecQueryid = MySQLi_query($koneksi, $Queryid);
   $rowsid = mysqli_num_rows($ExecQueryid);
  if ($rowsid <> 0) {
  $dataid        = mysqli_fetch_assoc($ExecQueryid);
   $idakses=$dataid['id_userlogin'];
   $rol=$dataid['user_role_id'];
   
   if( $Name==""){
	   if($poli=="All"){
	    $Query = "SELECT * FROM appointment  where tanggal_appointment='$sekarang'  order by id_appointment desc LIMIT 10 ";
	 $ExecQuery = MySQLi_query($koneksi, $Query);
	   }else{
	$Query = "SELECT * FROM appointment where tanggal_appointment='$sekarang' and nama_poli='$poli'  order by id_appointment desc LIMIT 10 ";
	 $ExecQuery = MySQLi_query($koneksi, $Query);
	   }
//Search query.
  
//Creating unordered list to display result.
}else{
	
	 $Query = "SELECT * FROM appointment WHERE tanggal_appointment='$sekarang' and  nama_pasien LIKE '%$Name%'   LIMIT 3 ";
//Query execution
   $ExecQuery = MySQLi_query($koneksi, $Query);

}
   $rows = mysqli_num_rows($ExecQuery);
  // cek hasil query
  // jika "no_antrian" sudah ada
  if ($rows <> 0) {
	  
	  ?>
	  
	 <?php 
   //Fetching result from database.
   while ($Result = MySQLi_fetch_array($ExecQuery)) {
	   $tglap=$Result['tanggal_appointment'];
	   $namap=$Result['nama_pasien'];
	   $alap=$Result['alamat'];
	   $polap=$Result['nama_poli'];
	   //$pemap=$Result['pembayaran'];
	   $setap=$Result['setatus'];
	   
	   $Queryp = "SELECT * FROM data_poli WHERE id_poli='$polap'";
	   $ExecQueryp = MySQLi_query($koneksi, $Queryp);
	   while ($Resultp = MySQLi_fetch_array($ExecQueryp)) {
		   $nampol=$Resultp['nama_poli'];
	   }
	   
	
       ?>
	                                              
                            <tr>                    <td > <?php echo $tglap;?></td>
                                                <td > <div><?php echo $namap;?></div>
     <?php
     $datapoli=$Result['id_pendaftaran_poli']; 
	 
	 
      $sekarang       = gmdate("Y-m-d", time() + 60 * 60 * 7);
	  $linkcek="pendaftaran_poli/chekin/$datapoli";
     if($Result['tanggal_appointment']=="$sekarang" and $Result['setatus']==""){
		if($rol=="1" or $rol=="4" or $rol=="12"){
         ?>
                                    <a class="btn btn-sm btn-info has-tooltip" title="Chekin" href="<?php echo "$linksite$linkcek"; ?>">
                            <i class="fa fa-edit"></i> Chekin
                        </a> 
         <?php
		}
    }
     ?>

												</td>
                                                <td > <?php echo $alap;?></td>
                                                
	<?php
		if($setap==""){
		   $setap="Register";
		 ?>
		   <td ><div align="center" style="background-color:#32CD32;color:#ffffff;"><?php echo $setap;?></div></td>
	 <?php
	   }else if($setap=="Cancel"){
		   $setap=$setap;
		   ?>
		   <td ><div align="center" style="background-color:#32CD32;color:#ffffff;"><?php echo $setap;?></div></td>
		   <?php		   
	   }else{
		   $setap="Hadir";
		   ?>
		   <td ><div align="center" style="background-color:#32CD32;color:#ffffff;"><?php echo $setap;?></div></td>
		   <?php		   
	   }
	   ?>
                                                
												
                                                                                                    
                                              <tr> 
	   
	   

   <?php
}
$not="";
  }else{
	$not="ok";
} 
  }


$akses="";
}else{
	$akses="no";
}
?>
                                                             <!--endrecord-->
                                        </tbody>
                                        <tbody class="search-data" id="search-data-list-page-8rt4hbl3u9f5"></tbody>
                                                                            </table>
	<?php if($not=="ok"){?>																		
<div align="center"><b>Data Tidak ada</b></div>
	<?php }?>
	<?php if($akses=="no"){?>																		
<div align="center"><b>Tidak Dapat Akses</b></div>
	<?php }?>	
	
	</div></div>