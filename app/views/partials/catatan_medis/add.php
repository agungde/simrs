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
    <div  class="bg-light p-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <div class=""><div>
                        <?php
                        $usrnam  = "".USER_NAME;
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        $idtrace = "$id_user$usrnam";
                        if(!empty($_GET['precord'])){
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
                        $pasien=$_GET['pasien'];
                        }
                        if(!empty($_GET['backlink'])){
                        $original_plaintext=$_GET['datprecord'];
                        }
                        $id_daftar=$original_plaintext;
                        if($pasien=="POLI"){
                        $queryb = mysqli_query($koneksi, "select * from pendaftaran_poli WHERE id_pendaftaran_poli='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsb = mysqli_num_rows($queryb);
                        if ($rowsb <> 0) {
                        $row   = mysqli_fetch_assoc($queryb); 
                        $no_rekam_medis=$row['no_rekam_medis'];
                        $nama_pasien=$row['nama_pasien'];
                        $alamat=$row['alamat'];
                        $no_hp=$row['no_hp'];
                        $tanggal_lahir=$row['tanggal_lahir'];
                        $email=$row['email'];
                        $umur=$row['umur'];
                        $no_ktp=$row['no_ktp'];
                        $jenis_kelamin=$row['jenis_kelamin'];
                        $pembayaran=$row['pembayaran'];
                        $setatus_bpjs=$row['setatus_bpjs'];
                        $keluhan=$row['keluhan'];
                        $dokter_pengirim=$row['dokter'];
                        // $penanggung_jawab=$row['penanggung_jawab'];
                        // $id_penanggung_jawab=$row['id_penanggung_jawab'];
                        //  $alamat_penanggung_jawab=$row['alamat_penanggung_jawab'];
                        //  $no_hp_penanggung_jawab=$row['no_hp_penanggung_jawab'];
                        //  $hubungan=$row['hubungan'];
                        //$id_transaksi=$row['id_transaksi'];
                        $tanggal_masuk=$row['tanggal'];
                        $sqlcek3 = mysqli_query($koneksi,"select * from data_dokter WHERE id_dokter='$dokter_pengirim'");
                        while ($row3=mysqli_fetch_array($sqlcek3)){
                        $nama_dokter=$row3['nama_dokter'];
                        $nama_poli=$row3['specialist'];
                        }
                        $dokter=$dokter_pengirim;
                        }
                        }else  if($pasien=="IGD"){
                        $queryb = mysqli_query($koneksi, "select * from igd WHERE id_igd='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsb = mysqli_num_rows($queryb);
                        if ($rowsb <> 0) {
                        $row   = mysqli_fetch_assoc($queryb); 
                        $no_rekam_medis=$row['no_rekam_medis'];
                        $nama_pasien=$row['nama_pasien'];
                        $alamat=$row['alamat'];
                        $no_hp=$row['no_hp'];
                        $tanggal_lahir=$row['tanggal_lahir'];
                        $email=$row['email'];
                        $umur=$row['umur'];
                        $no_ktp=$row['no_ktp'];
                        $jenis_kelamin=$row['jenis_kelamin'];
                        $pembayaran=$row['pembayaran'];
                        $setatus_bpjs=$row['setatus_bpjs'];
                        $keluhan=$row['keluhan'];
                        $dokter_pengirim=$row['dokter'];
                        // $penanggung_jawab=$row['penanggung_jawab'];
                        // $id_penanggung_jawab=$row['id_penanggung_jawab'];
                        //  $alamat_penanggung_jawab=$row['alamat_penanggung_jawab'];
                        //  $no_hp_penanggung_jawab=$row['no_hp_penanggung_jawab'];
                        //  $hubungan=$row['hubungan'];
                        //$id_transaksi=$row['id_transaksi'];
                        $tanggal_masuk=$row['tanggal_masuk'];
                        $sqlcek3 = mysqli_query($koneksi,"select * from data_dokter WHERE id_dokter='$dokter_pengirim'");
                        while ($row3=mysqli_fetch_array($sqlcek3)){
                        $nama_dokter=$row3['nama_dokter'];
                        $nama_poli=$row3['specialist'];
                        }
                        $dokter=$dokter_pengirim;
                        }
                        }else  if($pasien=="RAWAT INAP"){
                        $queryb = mysqli_query($koneksi, "select * from rawat_inap WHERE id='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsb = mysqli_num_rows($queryb);
                        if ($rowsb <> 0) {
                        $row   = mysqli_fetch_assoc($queryb); 
                        $no_rekam_medis=$row['no_rekam_medis'];
                        $nama_pasien=$row['nama_pasien'];
                        $alamat=$row['alamat'];
                        $no_hp=$row['no_hp'];
                        $tanggal_lahir=$row['tanggal_lahir'];
                        $email=$row['email'];
                        $umur=$row['umur'];
                        $no_ktp=$row['no_ktp'];
                        $jenis_kelamin=$row['jenis_kelamin'];
                        $pembayaran=$row['pembayaran'];
                        $setatus_bpjs=$row['setatus_bpjs'];
                        //$keluhan=$row['keluhan'];
                        $dokter_pengirim=$row['dokter_rawat_inap'];
                        // $penanggung_jawab=$row['penanggung_jawab'];
                        // $id_penanggung_jawab=$row['id_penanggung_jawab'];
                        //  $alamat_penanggung_jawab=$row['alamat_penanggung_jawab'];
                        //  $no_hp_penanggung_jawab=$row['no_hp_penanggung_jawab'];
                        //  $hubungan=$row['hubungan'];
                        //$id_transaksi=$row['id_transaksi'];
                        $tanggal_masuk=$row['tanggal_masuk'];
                        $sqlcek3 = mysqli_query($koneksi,"select * from data_dokter WHERE id_dokter='$dokter_pengirim'");
                        while ($row3=mysqli_fetch_array($sqlcek3)){
                        $nama_dokter=$row3['nama_dokter'];
                        $nama_poli=$row3['specialist'];
                        }
                        $dokter=$dokter_pengirim;
                        }
                        }else  if($pasien=="RANAP BERSALIN"){
                        $queryb = mysqli_query($koneksi, "select * from ranap_bersalin WHERE id='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsb = mysqli_num_rows($queryb);
                        if ($rowsb <> 0) {
                        $row   = mysqli_fetch_assoc($queryb); 
                        $no_rekam_medis=$row['no_rekam_medis'];
                        $nama_pasien=$row['nama_pasien'];
                        $alamat=$row['alamat'];
                        $no_hp=$row['no_hp'];
                        $tanggal_lahir=$row['tanggal_lahir'];
                        $email=$row['email'];
                        $umur=$row['umur'];
                        $no_ktp=$row['no_ktp'];
                        $jenis_kelamin=$row['jenis_kelamin'];
                        $pembayaran=$row['pembayaran'];
                        $setatus_bpjs=$row['setatus_bpjs'];
                        //$keluhan=$row['keluhan'];
                        $dokter_pengirim=$row['dokter_ranap_bersalin'];
                        // $penanggung_jawab=$row['penanggung_jawab'];
                        // $id_penanggung_jawab=$row['id_penanggung_jawab'];
                        //  $alamat_penanggung_jawab=$row['alamat_penanggung_jawab'];
                        //  $no_hp_penanggung_jawab=$row['no_hp_penanggung_jawab'];
                        //  $hubungan=$row['hubungan'];
                        //$id_transaksi=$row['id_transaksi'];
                        $tanggal_masuk=$row['tanggal_masuk'];
                        $sqlcek3 = mysqli_query($koneksi,"select * from data_dokter WHERE id_dokter='$dokter_pengirim'");
                        while ($row3=mysqli_fetch_array($sqlcek3)){
                        $nama_dokter=$row3['nama_dokter'];
                        $nama_poli=$row3['specialist'];
                        }
                        $dokter=$dokter_pengirim;
                        }
                        }else  if($pasien=="RANAP ANAK"){
                        $queryb = mysqli_query($koneksi, "select * from ranap_anak WHERE id='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsb = mysqli_num_rows($queryb);
                        if ($rowsb <> 0) {
                        $row   = mysqli_fetch_assoc($queryb); 
                        $no_rekam_medis=$row['no_rekam_medis'];
                        $nama_pasien=$row['nama_pasien'];
                        $alamat=$row['alamat'];
                        $no_hp=$row['no_hp'];
                        $tanggal_lahir=$row['tanggal_lahir'];
                        $email=$row['email'];
                        $umur=$row['umur'];
                        $no_ktp=$row['no_ktp'];
                        $jenis_kelamin=$row['jenis_kelamin'];
                        $pembayaran=$row['pembayaran'];
                        $setatus_bpjs=$row['setatus_bpjs'];
                        //$keluhan=$row['keluhan'];
                        $dokter_pengirim=$row['dokter_ranap_anak'];
                        // $penanggung_jawab=$row['penanggung_jawab'];
                        // $id_penanggung_jawab=$row['id_penanggung_jawab'];
                        //  $alamat_penanggung_jawab=$row['alamat_penanggung_jawab'];
                        //  $no_hp_penanggung_jawab=$row['no_hp_penanggung_jawab'];
                        //  $hubungan=$row['hubungan'];
                        //$id_transaksi=$row['id_transaksi'];
                        $tanggal_masuk=$row['tanggal_masuk'];
                        $sqlcek3 = mysqli_query($koneksi,"select * from data_dokter WHERE id_dokter='$dokter_pengirim'");
                        while ($row3=mysqli_fetch_array($sqlcek3)){
                        $nama_dokter=$row3['nama_dokter'];
                        $nama_poli=$row3['specialist'];
                        }
                        $dokter=$dokter_pengirim;
                        }
                        }else  if($pasien=="RANAP PERINA"){
                        $queryb = mysqli_query($koneksi, "select * from ranap_perina WHERE id='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsb = mysqli_num_rows($queryb);
                        if ($rowsb <> 0) {
                        $row   = mysqli_fetch_assoc($queryb); 
                        $no_rekam_medis=$row['no_rekam_medis'];
                        $nama_pasien=$row['nama_pasien'];
                        $alamat=$row['alamat'];
                        $no_hp=$row['no_hp'];
                        $tanggal_lahir=$row['tanggal_lahir'];
                        $email=$row['email'];
                        $umur=$row['umur'];
                        $no_ktp=$row['no_ktp'];
                        $jenis_kelamin=$row['jenis_kelamin'];
                        $pembayaran=$row['pembayaran'];
                        $setatus_bpjs=$row['setatus_bpjs'];
                        //$keluhan=$row['keluhan'];
                        $dokter_pengirim=$row['dokter_ranap_perina'];
                        // $penanggung_jawab=$row['penanggung_jawab'];
                        // $id_penanggung_jawab=$row['id_penanggung_jawab'];
                        //  $alamat_penanggung_jawab=$row['alamat_penanggung_jawab'];
                        //  $no_hp_penanggung_jawab=$row['no_hp_penanggung_jawab'];
                        //  $hubungan=$row['hubungan'];
                        //$id_transaksi=$row['id_transaksi'];
                        $tanggal_masuk=$row['tanggal_masuk'];
                        $sqlcek3 = mysqli_query($koneksi,"select * from data_dokter WHERE id_dokter='$dokter_pengirim'");
                        while ($row3=mysqli_fetch_array($sqlcek3)){
                        $nama_dokter=$row3['nama_dokter'];
                        $nama_poli=$row3['specialist'];
                        }
                        $dokter=$dokter_pengirim;
                        }
                        }
                        }
                        ?>
                    </div>
                </div><h4 class="record-title">Add New Catatan Medis</h4>
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
            <div class="col-md-7 comp-grid">
                <div class=" ">
                    <?php  
                    $this->render_page("data_pasien/pasien/$_GET[datprecord]"); 
                    ?>
                </div>
                <?php $this :: display_page_errors(); ?>
                <div  class="bg-light p-3 animated fadeIn page-content">
                    <form id="catatan_medis-add-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("catatan_medis/add?csrf_token=$csrf_token") ?>" method="post">
                        <div>
                            <input id="ctrl-id_daftar"  value="<?php echo $original_plaintext;?>" type="hidden" placeholder="Enter Id Daftar"  required="" name="id_daftar"  class="form-control " />
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="tanggal">Tanggal <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input id="ctrl-tanggal" class="form-control datepicker  datepicker"  required="" value="<?php  echo $this->set_field_value('tanggal',date_now()); ?>" type="datetime" name="tanggal" placeholder="Enter Tanggal" data-enable-time="false" data-min-date="" data-max-date="" data-date-format="Y-m-d" data-alt-format="F j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input id="ctrl-no_rekam_medis"  value="<?php echo $no_rekam_medis;?>" type="hidden" placeholder="Enter No Rekam Medis"  required="" name="no_rekam_medis"  class="form-control " />
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="control-label" for="pasien">Pasien <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="">
                                                        <input id="ctrl-pasien"  value="<?php echo $pasien;?>" type="text" placeholder="Enter Pasien"  readonly required="" name="pasien"  class="form-control " />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <input id="ctrl-nama_poli"  value="<?php echo $nama_poli;?>" type="hidden" placeholder="Enter Nama Poli"  name="nama_poli"  class="form-control " />
                                                <input id="ctrl-dokter"  value="<?php echo $dokter;?>" type="hidden" placeholder="Enter Dokter"  required="" name="dokter"  class="form-control " />
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label class="control-label" for="catatan_medis">Catatan Medis <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <div class="">
                                                                    <textarea placeholder="Enter Catatan Medis" id="ctrl-catatan_medis"  required="" rows="5" name="catatan_medis" class=" form-control"><?php  echo $this->set_field_value('catatan_medis',""); ?></textarea>
                                                                    <!--<div class="invalid-feedback animated bounceIn text-center">Please enter text</div>-->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
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
