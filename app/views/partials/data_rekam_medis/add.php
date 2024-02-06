<?php
$comp_model = new SharedController;
$page_element_id = "add-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
$show_header = $this->show_header;
$view_title = $this->view_title;
$redirect_to = $this->redirect_to;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="add"  data-display-type="" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-white p-1 mb-1">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Add New Rekam Medis</h4>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
    <div  class="">
        <div class="container">
            <div class="row ">
                <div class="col-md-4 comp-grid">
                    <div class=""><div>
                        <?php
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        //$koneksi=open_connection();
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        if(!empty($_GET['precord'])){
                        $ciphertext = $_GET['precord'];
                        // $pasien = $_GET['pasien'];
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
                        if (hash_equals($hmac, $calcmac))// timing attack safe comparison
                        {
                        // echo $original_plaintext."\n";
                        }
                        if(!empty($_GET['pasien'])){
                        $pasien=$_GET['pasien'];
                        }else{
                        $pasien="";
                        }
                        if($pasien=="IGD"){
                        $sqlcek2 = mysqli_query($koneksi,"select * from igd WHERE id_igd='$original_plaintext'");
                        }else if($pasien=="RANAP"){
                        $sqlcek2 = mysqli_query($koneksi,"select * from rawat_inap WHERE id='$original_plaintext'");
                        }else if($pasien=="RANAP ANAK"){
                        $sqlcek2 = mysqli_query($koneksi,"select * from ranap_anak WHERE id='$original_plaintext'");
                        }else if($pasien=="RANAP BERSALIN"){
                        $sqlcek2 = mysqli_query($koneksi,"select * from ranap_bersalin WHERE id='$original_plaintext'");
                        }else if($pasien=="RANAP PERINA"){
                        $sqlcek2 = mysqli_query($koneksi,"select * from ranap_perina WHERE id='$original_plaintext'");
                        }else{
                        $sqlcek2 = mysqli_query($koneksi,"select * from pendaftaran_poli WHERE id_pendaftaran_poli='$original_plaintext'");
                        }
                        $rowspa = mysqli_num_rows($sqlcek2);
                        if ($rowspa <> 0) {
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses URL Tidak Valid');
                            <?php 
                            if($pasien=="IGD"){?>
                            document.location='<?php print_link("igd"); ?>';
                            }else if($pasien=="RANAP"){?>
                            document.location='<?php print_link("rawat_inap"); ?>';
                            <?php ?>
                            }else if($pasien=="RANAP ANAK"){?>
                            document.location='<?php print_link("ranap_anak"); ?>';
                            <?php ?>
                            }else if($pasien=="RANAP BERSALIN"){?>
                            document.location='<?php print_link("ranap_bersalin"); ?>';
                            <?php ?>
                            }else if($pasien=="RANAP PERINA"){?>
                            document.location='<?php print_link("ranap_perina"); ?>';
                            <?php ?>
                            }else{
                            ?>
                            document.location='<?php print_link("pendaftaran_poli"); ?>';
                            <?php }?>
                        </script>
                        <?php } 
                        if($pasien=="IGD"){
                        $sqlcek1 = mysqli_query($koneksi,"select * from igd WHERE id_igd='$original_plaintext'");
                        $rows1 = mysqli_num_rows($sqlcek1);
                        if ($rows1 <> 0) {
                        $row= mysqli_fetch_assoc($sqlcek1); 
                        $no_rekam_medis=$row['no_rekam_medis'];
                        $nama_pasien=$row['nama_pasien'];
                        $alamat=$row['alamat'];
                        $no_hp=$row['no_hp'];
                        $tanggal_lahir=$row['tanggal_lahir'];
                        $jenis_kelamin=$row['jenis_kelamin'];
                        $email=$row['email'];
                        $umur=$row['umur'];
                        $iddokter=$row['dokter'];
                        $tinggi="";
                        $berat_badan="";
                        $tensi="";
                        $suhu_badan="";
                        $tanggal=$row['tanggal_masuk'];
                        //$keluhan=$row['keluhan'];
                        $idigd=$row['id_igd'];
                        $pembayaran=$row['pembayaran'];
                        $alergi_obat=$row['alergi_obat'];
                        $nama_poli=$pasien;
                        }
                        $sqf = mysqli_query($koneksi,"select * from pemeriksaan_fisik WHERE id_daftar='$idigd' and no_rekam_medis='$no_rekam_medis'");
                        $rowsf = mysqli_num_rows($sqf);
                        if ($rowsf <> 0) {
                        $rowi= mysqli_fetch_assoc($sqf); 
                        $keluhan=$rowi['keluhan'];
                        }else{
                        $keluhan="";
                        }
                        $sqlcek3 = mysqli_query($koneksi,"select * from data_dokter WHERE id_dokter='$iddokter'");
                        while ($row3=mysqli_fetch_array($sqlcek3)){
                        $nama_dokter=$row3['nama_dokter'];
                        $nama_poli=$row3['specialist'];
                        }
                        $namapoli="";
                        }else if($pasien=="RANAP"){
                        $sqlcek1 = mysqli_query($koneksi,"select * from rawat_inap WHERE id='$original_plaintext'");
                        $rows1 = mysqli_num_rows($sqlcek1);
                        if ($rows1 <> 0) {
                        $row= mysqli_fetch_assoc($sqlcek1); 
                        $no_rekam_medis=$row['no_rekam_medis'];
                        $nama_pasien=$row['nama_pasien'];
                        $alamat=$row['alamat'];
                        $no_hp=$row['no_hp'];
                        $tanggal_lahir=$row['tanggal_lahir'];
                        $jenis_kelamin=$row['jenis_kelamin'];
                        $email=$row['email'];
                        $umur=$row['umur'];
                        $iddokter=$row['dokter_rawat_inap'];
                        $tinggi="";
                        $berat_badan="";
                        $tensi="";
                        $suhu_badan="";
                        $tanggal=$row['tanggal_masuk'];
                        $keluhan=$row['keluhan'];
                        $pembayaran=$row['pembayaran'];
                        $alergi_obat=$row['alergi_obat'];
                        $nama_poli=$pasien;
                        }
                        $sqlcek3 = mysqli_query($koneksi,"select * from data_dokter WHERE id_dokter='$iddokter'");
                        while ($row3=mysqli_fetch_array($sqlcek3)){
                        $nama_dokter=$row3['nama_dokter'];
                        $nama_poli=$row3['specialist'];
                        }
                        $sqlcek4 = mysqli_query($koneksi,"select * from data_poli WHERE id_poli='".$row['poli']."'");
                        while ($row4=mysqli_fetch_array($sqlcek4)){
                        $namapoli=$row4['nama_poli'];
                        }
                        }else if($pasien=="RANAP ANAK"){
                        $sqlcek1 = mysqli_query($koneksi,"select * from ranap_anak WHERE id='$original_plaintext'");
                        $rows1 = mysqli_num_rows($sqlcek1);
                        if ($rows1 <> 0) {
                        $row= mysqli_fetch_assoc($sqlcek1); 
                        $no_rekam_medis=$row['no_rekam_medis'];
                        $nama_pasien=$row['nama_pasien'];
                        $alamat=$row['alamat'];
                        $no_hp=$row['no_hp'];
                        $tanggal_lahir=$row['tanggal_lahir'];
                        $jenis_kelamin=$row['jenis_kelamin'];
                        $email=$row['email'];
                        $umur=$row['umur'];
                        $iddokter=$row['dokter_ranap_anak'];
                        $tinggi="";
                        $berat_badan="";
                        $tensi="";
                        $suhu_badan="";
                        $tanggal=$row['tanggal_masuk'];
                        $keluhan=$row['keluhan'];
                        $pembayaran=$row['pembayaran'];
                        $alergi_obat=$row['alergi_obat'];
                        $nama_poli=$pasien;
                        }
                        $sqlcek3 = mysqli_query($koneksi,"select * from data_dokter WHERE id_dokter='$iddokter'");
                        while ($row3=mysqli_fetch_array($sqlcek3)){
                        $nama_dokter=$row3['nama_dokter'];
                        $nama_poli=$row3['specialist'];
                        }
                        $sqlcek4 = mysqli_query($koneksi,"select * from data_poli WHERE id_poli='".$row['poli']."'");
                        while ($row4=mysqli_fetch_array($sqlcek4)){
                        $namapoli=$row4['nama_poli'];
                        }
                        }else if($pasien=="RANAP BERSALIN"){
                        $sqlcek1 = mysqli_query($koneksi,"select * from ranap_bersalin WHERE id='$original_plaintext'");
                        $rows1 = mysqli_num_rows($sqlcek1);
                        if ($rows1 <> 0) {
                        $row= mysqli_fetch_assoc($sqlcek1); 
                        $no_rekam_medis=$row['no_rekam_medis'];
                        $nama_pasien=$row['nama_pasien'];
                        $alamat=$row['alamat'];
                        $no_hp=$row['no_hp'];
                        $tanggal_lahir=$row['tanggal_lahir'];
                        $jenis_kelamin=$row['jenis_kelamin'];
                        $email=$row['email'];
                        $umur=$row['umur'];
                        $iddokter=$row['dokter_ranap_bersalin'];
                        $tinggi="";
                        $berat_badan="";
                        $tensi="";
                        $suhu_badan="";
                        $tanggal=$row['tanggal_masuk'];
                        $keluhan=$row['keluhan'];
                        $pembayaran=$row['pembayaran'];
                        $alergi_obat=$row['alergi_obat'];
                        $nama_poli=$pasien;
                        }
                        $sqlcek3 = mysqli_query($koneksi,"select * from data_dokter WHERE id_dokter='$iddokter'");
                        while ($row3=mysqli_fetch_array($sqlcek3)){
                        $nama_dokter=$row3['nama_dokter'];
                        $nama_poli=$row3['specialist'];
                        }
                        $sqlcek4 = mysqli_query($koneksi,"select * from data_poli WHERE id_poli='".$row['poli']."'");
                        while ($row4=mysqli_fetch_array($sqlcek4)){
                        $namapoli=$row4['nama_poli'];
                        }
                        }else if($pasien=="RANAP PERINA"){
                        $sqlcek1 = mysqli_query($koneksi,"select * from ranap_perina WHERE id='$original_plaintext'");
                        $rows1 = mysqli_num_rows($sqlcek1);
                        if ($rows1 <> 0) {
                        $row= mysqli_fetch_assoc($sqlcek1); 
                        $no_rekam_medis=$row['no_rekam_medis'];
                        $nama_pasien=$row['nama_pasien'];
                        $alamat=$row['alamat'];
                        $no_hp=$row['no_hp'];
                        $tanggal_lahir=$row['tanggal_lahir'];
                        $jenis_kelamin=$row['jenis_kelamin'];
                        $email=$row['email'];
                        $umur=$row['umur'];
                        $iddokter=$row['dokter_ranap_perina'];
                        $tinggi="";
                        $berat_badan="";
                        $tensi="";
                        $suhu_badan="";
                        $tanggal=$row['tanggal_masuk'];
                        $keluhan=$row['keluhan'];
                        $pembayaran=$row['pembayaran'];
                        $alergi_obat=$row['alergi_obat'];
                        $nama_poli=$pasien;
                        }
                        $sqlcek3 = mysqli_query($koneksi,"select * from data_dokter WHERE id_dokter='$iddokter'");
                        while ($row3=mysqli_fetch_array($sqlcek3)){
                        $nama_dokter=$row3['nama_dokter'];
                        $nama_poli=$row3['specialist'];
                        }
                        $sqlcek4 = mysqli_query($koneksi,"select * from data_poli WHERE id_poli='".$row['poli']."'");
                        while ($row4=mysqli_fetch_array($sqlcek4)){
                        $namapoli=$row4['nama_poli'];
                        }
                        }else{ 
                        $sqlcek1 = mysqli_query($koneksi,"select * from pendaftaran_poli WHERE id_pendaftaran_poli='$original_plaintext'");
                        $rows1 = mysqli_num_rows($sqlcek1);
                        if ($rows1 <> 0) {
                        $row= mysqli_fetch_assoc($sqlcek1); 
                        $no_rekam_medis=$row['no_rekam_medis'];
                        $nama_pasien=$row['nama_pasien'];
                        $alamat=$row['alamat'];
                        $no_hp=$row['no_hp'];
                        $tanggal_lahir=$row['tanggal_lahir'];
                        $jenis_kelamin=$row['jenis_kelamin'];
                        $email=$row['email'];
                        $umur=$row['umur'];
                        $dokter=$row['dokter'];
                        $tinggi=$row['tinggi'];
                        $berat_badan=$row['berat_badan'];
                        $tensi=$row['tensi'];
                        $suhu_badan=$row['suhu_badan'];
                        $tanggal=$row['tanggal'];
                        $keluhan=$row['keluhan'];
                        $pembayaran=$row['pembayaran'];
                        $alergi_obat=$row['alergi_obat'];
                        $nama_poli=$row['nama_poli'];
                        }
                        $sqlcek3 = mysqli_query($koneksi,"select * from data_dokter WHERE id_dokter='$dokter'");
                        while ($row3=mysqli_fetch_array($sqlcek3)){
                        $nama_dokter=$row3['nama_dokter'];
                        $nama_poli=$row3['specialist'];
                        }
                        $sqlcek4 = mysqli_query($koneksi,"select * from data_poli WHERE id_poli='$nama_poli'");
                        while ($row4=mysqli_fetch_array($sqlcek4)){
                        $namapoli=$row4['nama_poli'];
                        }
                        }
                        }else{
                        if(isset($_POST['precord'])){
                        $iddaftar=$_POST['iddaftar'];
                        $datid=$_POST['precord'];
                        $backprecord=$_POST['backprecord'];
                        $catatan_medis=$_POST['catatan_medis'];
                        $tindakan=$_POST['tindakan'];
                        $diagnosa=$_POST['diagnosa'];
                        $namdok=$_POST['namdok'];
                        $nampoli=$_POST['nampoli'];
                        $keluhan=$_POST['keluhan'];
                        $sqlcek1 = mysqli_query($koneksi,"select * from pendaftaran_poli WHERE id_pendaftaran_poli='$iddaftar'");
                        $rows1 = mysqli_num_rows($sqlcek1);
                        if ($rows1 <> 0) {
                        $row= mysqli_fetch_assoc($sqlcek1); 
                        $fatnorm=$row['no_rekam_medis'];
                        $tanggal=$row['tanggal'];
                        }
                        /////////////////////////////Tindakan//////////////////////////////////////////
                        $kettindakan = "";
                        $tagtin=0;
                        if(isset($_POST['tindakan'])){
                        $cektindakan = $_POST['tindakan'];
                        if(!empty( $cektindakan)){
                        for($a = 0; $a < count( $cektindakan); $a++){
                        if(!empty( $cektindakan[$a])){
                        $idtin =  $cektindakan[$a];
                        $res = mysqli_query($koneksi, "SELECT * FROM list_biaya_tindakan WHERE id='$idtin'"); 
                        while ($rowii=mysqli_fetch_array($res)){
                        $biaya_tindakan = $rowii['harga'];
                        $tindakan       = $rowii['nama_tindakan'];
                        }
                        mysqli_query($koneksi,"INSERT INTO `data_tindakan` (`no_rekam_medis`,`dokter_pemeriksa`,`tindakan`,`pasien`,`tanggal`,`nama_tindakan`,`id_daftar`, `harga`) VALUES ('$fatnorm','$namdok','Tindakan Dari POLI','POLI','$tanggal','$tindakan',' $iddaftar', '$biaya_tindakan')"); 
                        if($kettindakan==""){
                        $kettindakan = "$tindakan";
                        $tagtin=$biaya_tindakan;
                        }else{
                        $kettindakan = "$kettindakan $tindakan";
                        $tagtin=$tagtin + $biaya_tindakan;
                        }
                        }
                        }
                        }    
                        }
                        if($kettindakan=="") {
                        }else{
                        $quetrx= mysqli_query($koneksi, "select * from transaksi WHERE no_rekam_medis='$fatnorm' and setatus_tagihan='Register'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        // ambil jumlah baris data hasil query
                        $rotrx = mysqli_num_rows($quetrx);
                        if ($rotrx <> 0) {
                        $dattrx      = mysqli_fetch_assoc($quetrx);
                        $idtrx       = $dattrx['id'];  
                        $tottagawal  = $dattrx['total_tagihan'];
                        $tottagakhir = $tottagawal + $tagtin;
                        mysqli_query($koneksi, "UPDATE transaksi SET total_tagihan='$tottagakhir' WHERE id='$idtrx'"); 
                        } 
                        mysqli_query($koneksi,"INSERT INTO `data_tagihan_pasien` (`id_transaksi`,`id_data`,`nama_tagihan`,`tanggal`,`no_rekam_medis`,`total_tagihan`,`setatus`,`pasien`,`keterangan`) VALUES (' $idtrx','$iddaftar','Tindakan','$tanggal','$fatnorm','$tagtin','Register','POLI','$kettindakan')");
                        }
                        mysqli_query($koneksi,"INSERT INTO `catatan_medis`( `id_daftar`, `tanggal`, `no_rekam_medis`, `catatan_medis`, `nama_poli`, `pasien`, `dokter`) VALUES ('$iddaftar','$tanggal','$fatnorm','$catatan_medis','$nampoli','POLI','$namdok')");
                        ////////////////////////////////////////////////////////////////////////// 
                        mysqli_query($koneksi,"UPDATE data_rekam_medis SET keluhan='$keluhan', diagnosa='$diagnosa', tindakan='$kettindakan', catatan_medis='$catatan_medis' WHERE id='$datid'");
                        ?>
                        <script language="JavaScript">
                            alert('Data Berhasil Di Simpan');
                            document.location='<?php print_link("pendaftaran_poli/dokter?precord=$backprecord&datrm=$fatnorm"); ?>';
                        </script>
                        <?php 
                        }  
                        if(isset($_POST['no_rekam_medis'])){
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses Add Langsung');
                            document.location='<?php print_link(""); ?>';
                        </script>
                        <?php 
                        }
                        }
                        /////////////////////////////////////////////////
                        ?>
                        </div></div><div class=""><div>
                        <table class="table  table-sm text-left bg-white">
                            <tr>
                                <th align="left"> Tanggal: </th>
                                <td > <?php echo $tanggal; ?> </td>
                            </tr>
                            <tr >
                                <th align="left"> No Rekam Medis: </th>
                                <td > <?php echo $no_rekam_medis; ?></td>
                            </tr>
                            <tr>
                                <th align="left"> Nama Pasien: </th>
                                <td ><?php echo $nama_pasien; ?> </td>
                            </tr>
                            <tr>
                                <th align="left"> Dokter Pemeriksa: </th>
                                <td > <?php echo $nama_dokter; ?> </td>
                            </tr> 
                            <tr >
                                <th align="left">Specialist: </th>
                                <td ><?php echo $namapoli; ?>  </td>
                            </tr> 
                        </table>    
                    </div>
                </div>
            </div>
            <div class="col-md-4 comp-grid">
                <div class=""><div>
                    <table class="table  table-sm text-left" >
                        <tr>
                            <th align="left">Alamat: </th>
                            <td > <?php echo $alamat; ?></td>
                        </tr>
                        <tr>
                            <th align="left">TGL Lahir</th>
                            <td ><?php echo $tanggal_lahir; ?></td>
                        </tr>          
                        <tr>
                            <th align="left">Umur: </th>
                            <td ><?php echo $umur; ?></td>
                        </tr> 
                    </table>     
                </div>
            </div>
        </div>
        <div class="col-md-9 comp-grid">
            <?php $this :: display_page_errors(); ?>
            <div  class="bg-light p-3 animated fadeIn page-content">
                <form id="data_rekam_medis-add-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("data_rekam_medis/add?csrf_token=$csrf_token") ?>" method="post">
                    <div>
                        <input id="ctrl-tanggal"  value="<?php echo $tanggal;?>" type="hidden" placeholder="Enter Tanggal"  required="" name="tanggal"  class="form-control " />
                            <input id="ctrl-no_rekam_medis"  value="<?php echo $no_rekam_medis;?>" type="hidden" placeholder="Enter No Rekam Medis"  required="" name="no_rekam_medis"  class="form-control " />
                                <input id="ctrl-nama_poli"  value="<?php echo $nama_poli;?>" type="hidden" placeholder="Enter Nama Poli" list="nama_poli_list"  name="nama_poli"  class="form-control " />
                                    <datalist id="nama_poli_list">
                                        <?php 
                                        $nama_poli_options = $comp_model -> data_rekam_medis_nama_poli_option_list();
                                        if(!empty($nama_poli_options)){
                                        foreach($nama_poli_options as $option){
                                        $value = (!empty($option['value']) ? $option['value'] : null);
                                        $label = (!empty($option['label']) ? $option['label'] : $value);
                                        ?>
                                        <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                                        <?php
                                        }
                                        }
                                        ?>
                                    </datalist>
                                    <input id="ctrl-nama_pasien"  value="<?php echo $nama_pasien;?>" type="hidden" placeholder="Enter Nama Pasien"  required="" name="nama_pasien"  class="form-control " />
                                        <input id="ctrl-tensi"  value="<?php echo $tensi;?>" type="hidden" placeholder="Enter Tensi"  name="tensi"  class="form-control " />
                                            <input id="ctrl-suhu_badan"  value="<?php echo $suhu_badan;?>" type="hidden" placeholder="Enter Suhu Badan"  name="suhu_badan"  class="form-control " />
                                                <input id="ctrl-tinggi"  value="<?php echo $tinggi;?>" type="hidden" placeholder="Enter Tinggi"  name="tinggi"  class="form-control " />
                                                    <input id="ctrl-berat_badan"  value="<?php echo $berat_badan;?>" type="hidden" placeholder="Enter Berat Badan"  name="berat_badan"  class="form-control " />
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label class="control-label" for="keluhan">Keluhan <span class="text-danger">*</span></label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <div class="">
                                                                        <input id="ctrl-keluhan"  value="<?php echo $keluhan;?>" type="text" placeholder="Enter Keluhan"  required="" name="keluhan"  class="form-control " />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group ">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" for="diagnosa">Diagnosa </label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <div class="">
                                                                            <select data-endpoint="<?php print_link('api/json/data_rekam_medis_diagnosa_option_list') ?>" id="ctrl-diagnosa" name="diagnosa"  placeholder="Select a value ..."    class="selectize-ajax" >
                                                                                <option value="">Select a value ...</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <input id="ctrl-dokter_pemeriksa"  value="<?php echo $nama_dokter;?>" type="hidden" placeholder="Enter Dokter Pemeriksa"  required="" name="dokter_pemeriksa"  class="form-control " />
                                                                <input id="ctrl-pasien"  value="<?php echo $pasien;?>" type="hidden" placeholder="Enter Pasien"  required="" name="pasien"  class="form-control " />
                                                                    <input id="ctrl-id_daftar"  value="<?php echo $original_plaintext;?>" type="hidden" placeholder="Enter Id Daftar"  required="" name="id_daftar"  class="form-control " />
                                                                        <div class="form-group ">
                                                                            <div class="row">
                                                                                <div class="col-sm-4">
                                                                                    <label class="control-label" for="alergi_obat">Alergi Obat </label>
                                                                                </div>
                                                                                <div class="col-sm-8">
                                                                                    <div class="">
                                                                                        <input id="ctrl-alergi_obat"  value="<?php echo $alergi_obat;?>" type="text" placeholder="Enter Alergi Obat"  name="alergi_obat"  class="form-control " />
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <input id="ctrl-catatan_medis"  value="<?php  echo $this->set_field_value('catatan_medis',""); ?>" type="hidden" placeholder="Enter Catatan Medis"  name="catatan_medis"  class="form-control " />
                                                                            </div>
                                                                            <div class="form-group form-submit-btn-holder text-center mt-3">
                                                                                <div class="form-ajax-status"></div>
                                                                                <button class="btn btn-primary" type="submit">
                                                                                    Submit
                                                                                    <i class="fa fa-send"></i>
                                                                                </button>
                                                                            </div>
                                                                        </form>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </section>
