  <style>
                           td{
                               font-size: 10px;
                           }
						                              th{
                               font-size: 11px;
                           }
						                     table, th, td {
  border: 1px solid black;
}
                       </style>
  <?php
  
$sekarang = gmdate("Y-m-d", time() + 60 * 60 * 7);
  if(!empty($_GET['precord'])){
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

$ciphertext = $_GET['precord'];
$backlink=$ciphertext;
$ciphertext=str_replace(' ', '+', $ciphertext);

$resep=$ciphertext;
$key="dermawangroup";

$c = base64_decode($ciphertext);
$ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
$iv = substr($c, 0, $ivlen);
$hmac = substr($c, $ivlen, $sha2len=32);
$ciphertext_raw = substr($c, $ivlen+$sha2len);
$original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
$calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);

 if(!empty($_GET['pasien'])){
	 $datpas=$_GET['pasien'];
 }else{
	 $datpas="";
 }
 if($datpas=="IGD"){
	  $sqlcek = mysqli_query($koneksi,"select * from igd WHERE id_igd='$original_plaintext'");
 }else if($datpas=="RANAP"){
	  $sqlcek = mysqli_query($koneksi,"select * from rawat_inap WHERE id='$original_plaintext'");
 }else{
 $sqlcek = mysqli_query($koneksi,"select * from pendaftaran_poli WHERE id_pendaftaran_poli='$original_plaintext'");
 }
  $rowsp = mysqli_num_rows($sqlcek);
  if ($rowsp <> 0) {
$cdt= mysqli_fetch_assoc($sqlcek);
$norm=$cdt['no_rekam_medis']; 
  }

 
  ?>
  <link rel="stylesheet" href="<?php echo $linksite;?>assets/css/bootstrap-theme-pulse-blue.css" />
   <table class="table  table-sm text-left">
                                    <thead class="table-header bg-success">
                                        <tr>
                                            <th  class="td-tanggal" > Tanggal</th>
                                            <th  class="td-nama_poli"> Nama Poli</th>
                                            <th  class="td-dokter_pemeriksa"> Dokter Pemeriksa</th>
                                            <th  class="td-keluhan"> Keluhan</th>
                                            <th  class="td-pemeriksaan_fisik"> Pemeriksaan Fisik</th>
											<th  class="td-catatan_medis" width="150"> Catatan Medis</th>
                                            <th  class="td-tindakan"> Tindakan</th>
											 <th  class="td-diagnosa"> Diagnosa</th>
                                            <th  class="td-resep_obat" width="150"> Resep Obat</th> 
                                           
                                        </tr>
                                    </thead>
                                     <tbody class="page-data" id="page-data-list-page-6rthbuykzo2a">
                                        <!--record-->
						<?php
$sqlrm = mysqli_query($koneksi,"select * from data_rekam_medis WHERE no_rekam_medis='$norm' ORDER BY id DESC");
 while ($drm = MySQLi_fetch_array($sqlrm)) {
?>
					
<tr>
<td class="td-tanggal"> <?php echo $drm['tanggal'];?></td>
<td class="td-nama_poli"> <?php echo $drm['nama_poli'];?></td>
<td class="td-dokter_pemeriksa"><?php echo $drm['dokter_pemeriksa'];?> </td>
<td class="td-keluhan"> <?php echo $drm['keluhan'];?></td>
 <td class="td-pemeriksaan_fisik"><span><?php echo $drm['pemeriksaan_fisik'];?></span></td> 
 <td class="td-catatan_medis" width="150"> <span><?php echo $drm['catatan_medis'];?></span></td>
  <td class="td-tindakan"> <span><?php echo $drm['tindakan'];?></span></td>
  <td class="td-diagnosa"> <span> <?php
   $qudtpa = mysqli_query($koneksi, "SELECT * from diagnosa WHERE id='".$drm['diagnosa']."'")
                                  or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
  $rodtpa = mysqli_num_rows($qudtpa);
  if ($rodtpa <> 0) {
 $cdt= mysqli_fetch_assoc($qudtpa);
$descr=$cdt['description'];
echo $descr;
  }else{
  echo $drm['diagnosa'];
  }
  ?></span></td>
  <td class="td-resep_obat" width="150"> <span> <?php echo $drm['resep_obat'];?> </span></td>

                                      
                                    </tr>
<?php
 }
 ?>
                                     <!--endrecord-->
                                </tbody>
                                <tbody class="search-data" id="search-data-list-page-6rthbuykzo2a"></tbody>
                                </table>      
	
  <?php }?>