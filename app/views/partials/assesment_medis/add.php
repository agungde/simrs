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
    <div  class=" p-1 mb-1">
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
                        if(!empty($_GET['datfrom'])){
                        $datfrom = $_GET['datfrom'];
                        }else{
                        if(!empty($_GET['darecord'])){
                        if($_GET['darecord']=="igd"){
                        $datfrom="IGD";
                        }else if($_GET['darecord']=="rawat_inap"){
                        $datfrom="RANAP"; 
                        }else if($_GET['darecord']=="ranap_anak"){
                        $datfrom="RANAP ANAK"; 
                        }else if($_GET['darecord']=="ranap_bersalin"){
                        $datfrom="RANAP BERSALIN"; 
                        }else if($_GET['darecord']=="ranap_perina"){
                        $datfrom="RANAP PERINA"; 
                        }
                        }
                        }
                        $backlink=$ciphertext;
                        $_SESSION['backlink'] ="$backlink";
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
                        }
                        if(!empty($_GET['backlink'])){
                        $original_plaintext=$_GET['datprecord'];
                        }
                        $id_daftar=$original_plaintext;
                        if($datfrom=="IGD"){
                        $queryb = mysqli_query($koneksi, "select * from igd WHERE id_igd='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $pasien="IGD";
                        }else if($datfrom=="RANAP"){
                        $queryb = mysqli_query($koneksi, "select * from rawat_inap WHERE id='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));    
                        $pasien="RANAP";
                        }else if($datfrom=="RANAP ANAK"){
                        $queryb = mysqli_query($koneksi, "select * from ranap_anak WHERE id='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));    
                        $pasien="RANAP ANAK";
                        }else if($datfrom=="RANAP BERSALIN"){
                        $queryb = mysqli_query($koneksi, "select * from ranap_bersalin WHERE id='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));    
                        $pasien="RANAP BERSALIN";
                        }else if($datfrom=="RANAP PERINA"){
                        $queryb = mysqli_query($koneksi, "select * from ranap_perina WHERE id='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));    
                        $pasien="RANAP PERINA";
                        }
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
                        $idigd=$row['id_igd'];
                        if($pasien=="IGD"){
                        $dokter_pengirim=$row['dokter'];
                        }else if($pasien=="RANAP"){
                        $dokter_pengirim=$row['dokter_rawat_inap'];
                        }else if($pasien=="RANAP ANAK"){
                        $dokter_pengirim=$row['dokter_ranap_anak'];
                        }else if($pasien=="RANAP BERSALIN"){
                        $dokter_pengirim=$row['dokter_ranap_bersalin'];
                        }else if($pasien=="RANAP PERINA"){
                        $dokter_pengirim=$row['dokter_ranap_perina'];
                        }
                        $penanggung_jawab=$row['penanggung_jawab'];
                        $id_penanggung_jawab=$row['id_penanggung_jawab'];
                        $alamat_penanggung_jawab=$row['alamat_penanggung_jawab'];
                        $no_hp_penanggung_jawab=$row['no_hp_penanggung_jawab'];
                        $hubungan=$row['hubungan'];
                        $id_transaksi=$row['id_transaksi'];
                        $tanggal_masuk=$row['tanggal_masuk'];
                        $sqlcek3 = mysqli_query($koneksi,"select * from data_dokter WHERE id_dokter='$dokter_pengirim'");
                        while ($row3=mysqli_fetch_array($sqlcek3)){
                        $nama_dokter=$row3['nama_dokter'];
                        $nama_poli=$row3['specialist'];
                        }
                        $dokter=$dokter_pengirim;
                        }
                        ?>
                    </div>
                </div><h4 class="record-title">Add New Assesment Medis</h4>
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
                    <form id="assesment_medis-add-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("assesment_medis/add?csrf_token=$csrf_token") ?>" method="post">
                        <div>
                            <input id="ctrl-id_daftar"  value="<?php echo $id_daftar;?>" type="hidden" placeholder="Enter Id Daftar"  required="" name="id_daftar"  class="form-control " />
                                <input id="ctrl-tgl_masuk"  value="<?php echo $tanggal_masuk;?>" type="hidden" placeholder="Enter Tgl Masuk"  required="" name="tgl_masuk"  class="form-control " />
                                    <input id="ctrl-no_rekam_medis"  value="<?php echo $no_rekam_medis;?>" type="hidden" placeholder="Enter No Rekam Medis"  required="" name="no_rekam_medis"  class="form-control " />
                                        <input id="ctrl-nama_pasien"  value="<?php echo $nama_pasien;?>" type="hidden" placeholder="Enter Nama Pasien"  required="" name="nama_pasien"  class="form-control " />
                                            <input id="ctrl-tanggal_lahir"  value="<?php echo $tanggal_lahir;?>" type="hidden" placeholder="Enter Tanggal Lahir"  required="" name="tanggal_lahir"  class="form-control " />
                                                <input id="ctrl-umur"  value="<?php echo $umur;?>" type="hidden" placeholder="Enter Umur"  required="" name="umur"  class="form-control " />
                                                    <input id="ctrl-jenis_kelamin"  value="<?php echo $jenis_kelamin;?>" type="hidden" placeholder="Enter Jenis Kelamin"  required="" name="jenis_kelamin"  class="form-control " />
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label class="control-label" for="scor_gcs">SCOR/GCS </label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <div class="">
                                                                        <?php
                                                                        $scor_gcs_options = Menu :: $scor_gcs;
                                                                        if(!empty($scor_gcs_options)){
                                                                        foreach($scor_gcs_options as $option){
                                                                        $value = $option['value'];
                                                                        $label = $option['label'];
                                                                        //check if current option is checked option
                                                                        $checked = $this->set_field_checked('scor_gcs', $value, "");
                                                                        ?>
                                                                        <label class="custom-control custom-checkbox custom-control-inline option-btn">
                                                                            <input id="ctrl-scor_gcs" class="checkoption1 custom-control-input" value="<?php echo $value ?>" <?php echo $checked ?> type="checkbox"  name="scor_gcs[]" />
                                                                                <span class="custom-control-label"><?php echo $label ?></span>
                                                                            </label>
                                                                            <?php
                                                                            }
                                                                            }
                                                                            ?>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group ">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" for="td">TD <span class="text-danger">*</span></label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <div class="">
                                                                            <input id="ctrl-td"  value="<?php  echo $this->set_field_value('td',""); ?>" type="text" placeholder="Enter TD"  required="" name="td"  class="form-control " />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group ">
                                                                    <div class="row">
                                                                        <div class="col-sm-4">
                                                                            <label class="control-label" for="dj">DJ </label>
                                                                        </div>
                                                                        <div class="col-sm-8">
                                                                            <div class="">
                                                                                <input id="ctrl-dj"  value="<?php  echo $this->set_field_value('dj',""); ?>" type="text" placeholder="Enter DJ"  name="dj"  class="form-control " />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group ">
                                                                        <div class="row">
                                                                            <div class="col-sm-4">
                                                                                <label class="control-label" for="djj">DJJ </label>
                                                                            </div>
                                                                            <div class="col-sm-8">
                                                                                <div class="">
                                                                                    <input id="ctrl-djj"  value="<?php  echo $this->set_field_value('djj',""); ?>" type="text" placeholder="Enter DJJ"  name="djj"  class="form-control " />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group ">
                                                                            <div class="row">
                                                                                <div class="col-sm-4">
                                                                                    <label class="control-label" for="sh">SH <span class="text-danger">*</span></label>
                                                                                </div>
                                                                                <div class="col-sm-8">
                                                                                    <div class="">
                                                                                        <input id="ctrl-sh"  value="<?php  echo $this->set_field_value('sh',""); ?>" type="text" placeholder="Enter SH"  required="" name="sh"  class="form-control " />
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group ">
                                                                                <div class="row">
                                                                                    <div class="col-sm-4">
                                                                                        <label class="control-label" for="spo">SPO2 </label>
                                                                                    </div>
                                                                                    <div class="col-sm-8">
                                                                                        <div class="">
                                                                                            <input id="ctrl-spo"  value="<?php  echo $this->set_field_value('spo',""); ?>" type="text" placeholder="Enter SPO"  name="spo"  class="form-control " />
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group ">
                                                                                    <div class="row">
                                                                                        <div class="col-sm-4">
                                                                                            <label class="control-label" for="nd">ND </label>
                                                                                        </div>
                                                                                        <div class="col-sm-8">
                                                                                            <div class="">
                                                                                                <input id="ctrl-nd"  value="<?php  echo $this->set_field_value('nd',""); ?>" type="text" placeholder="Enter ND"  name="nd"  class="form-control " />
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group ">
                                                                                        <div class="row">
                                                                                            <div class="col-sm-4">
                                                                                                <label class="control-label" for="kondisi_umum">Kondisi Umum <span class="text-danger">*</span></label>
                                                                                            </div>
                                                                                            <div class="col-sm-8">
                                                                                                <div class="">
                                                                                                    <?php
                                                                                                    $kondisi_umum_options = Menu :: $kondisi_umum;
                                                                                                    if(!empty($kondisi_umum_options)){
                                                                                                    foreach($kondisi_umum_options as $option){
                                                                                                    $value = $option['value'];
                                                                                                    $label = $option['label'];
                                                                                                    //check if current option is checked option
                                                                                                    $checked = $this->set_field_checked('kondisi_umum', $value, "");
                                                                                                    ?>
                                                                                                    <label class="custom-control custom-checkbox custom-control-inline option-btn">
                                                                                                        <input id="ctrl-kondisi_umum" class="checkoption2 custom-control-input" value="<?php echo $value ?>" <?php echo $checked ?> type="checkbox" required=""  name="kondisi_umum[]" />
                                                                                                            <span class="custom-control-label"><?php echo $label ?></span>
                                                                                                        </label>
                                                                                                        <?php
                                                                                                        }
                                                                                                        }
                                                                                                        ?>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group ">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-4">
                                                                                                    <label class="control-label" for="pemeriksaan_penunjang">Pemeriksaan Penunjang </label>
                                                                                                </div>
                                                                                                <div class="col-sm-8">
                                                                                                    <div class="">
                                                                                                        <input id="ctrl-pemeriksaan_penunjang"  value="<?php  echo $this->set_field_value('pemeriksaan_penunjang',""); ?>" type="text" placeholder="Enter Pemeriksaan Penunjang"  name="pemeriksaan_penunjang"  class="form-control " />
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group ">
                                                                                                <div class="row">
                                                                                                    <div class="col-sm-4">
                                                                                                        <label class="control-label" for="diagnosa_kerja">Diagnosa Kerja </label>
                                                                                                    </div>
                                                                                                    <div class="col-sm-8">
                                                                                                        <div class="">
                                                                                                            <select  data-endpoint="<?php print_link('api/json/data_rekam_medis_diagnosa_option_list') ?>" id="ctrl-diagnosa_kerja" name="diagnosa_kerja"  placeholder="Select a value ..."    class="selectize-ajax" >
                                                                                                                <option value="">Select a value ...</option>
                                                                                                            </select>                                                                                           
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group ">
                                                                                                <div class="row">
                                                                                                    <div class="col-sm-4">
                                                                                                        <label class="control-label" for="diagnosa_banding">Diagnosa Banding </label>
                                                                                                    </div>
                                                                                                    <div class="col-sm-8">
                                                                                                        <div class="">
                                                                                                            <select  data-endpoint="<?php print_link('api/json/data_rekam_medis_diagnosa_option_list') ?>" id="ctrl-diagnosa_banding" name="diagnosa_banding"  placeholder="Select a value ..."    class="selectize-ajax" >
                                                                                                                <option value="">Select a value ...</option>
                                                                                                            </select>                                                                                               
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group ">
                                                                                                <div class="row">
                                                                                                    <div class="col-sm-4">
                                                                                                        <label class="control-label" for="tindakan_pengobatan">Tindakan Pengobatan </label>
                                                                                                    </div>
                                                                                                    <div class="col-sm-8">
                                                                                                        <div class="">
                                                                                                            <input id="ctrl-tindakan_pengobatan"  value="<?php  echo $this->set_field_value('tindakan_pengobatan',""); ?>" type="text" placeholder="Enter Tindakan Pengobatan"  name="tindakan_pengobatan"  class="form-control " />
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group ">
                                                                                                    <div class="row">
                                                                                                        <div class="col-sm-4">
                                                                                                            <label class="control-label" for="instruksi_selanjutnya">Instruksi Selanjutnya <span class="text-danger">*</span></label>
                                                                                                        </div>
                                                                                                        <div class="col-sm-8">
                                                                                                            <div class="">
                                                                                                                <?php
                                                                                                                $instruksi_selanjutnya_options = Menu :: $instruksi_selanjutnya;
                                                                                                                if(!empty($instruksi_selanjutnya_options)){
                                                                                                                foreach($instruksi_selanjutnya_options as $option){
                                                                                                                $value = $option['value'];
                                                                                                                $label = $option['label'];
                                                                                                                //check if current option is checked option
                                                                                                                $checked = $this->set_field_checked('instruksi_selanjutnya', $value, "");
                                                                                                                ?>
                                                                                                                <label class="custom-control custom-checkbox custom-control-inline option-btn">
                                                                                                                    <input id="ctrl-instruksi_selanjutnya" class="checkoption3 custom-control-input" value="<?php echo $value ?>" <?php echo $checked ?> type="checkbox" required=""  name="instruksi_selanjutnya[]" />
                                                                                                                        <span class="custom-control-label"><?php echo $label ?></span>
                                                                                                                    </label>
                                                                                                                    <?php
                                                                                                                    }
                                                                                                                    }
                                                                                                                    ?>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group ">
                                                                                                        <div class="row">
                                                                                                            <div class="col-sm-4">
                                                                                                                <label class="control-label" for="diteruskan_dokter">Diteruskan Dokter </label>
                                                                                                            </div>
                                                                                                            <div class="col-sm-8">
                                                                                                                <div class="">
                                                                                                                    <select  id="ctrl-diteruskan_dokter" name="diteruskan_dokter"  placeholder="Select a value ..."    class="custom-select" >
                                                                                                                        <option value="">Select a value ...</option>
                                                                                                                        <?php 
                                                                                                                        $diteruskan_dokter_options = $comp_model -> assesment_medis_diteruskan_dokter_option_list();
                                                                                                                        if(!empty($diteruskan_dokter_options)){
                                                                                                                        foreach($diteruskan_dokter_options as $option){
                                                                                                                        $value = (!empty($option['value']) ? $option['value'] : null);
                                                                                                                        $label = (!empty($option['label']) ? $option['label'] : $value);
                                                                                                                        $selected = $this->set_field_selected('diteruskan_dokter',$value, "");
                                                                                                                        ?>
                                                                                                                        <option <?php echo $selected; ?> value="<?php echo $value; ?>">
                                                                                                                            <?php echo $label; ?>
                                                                                                                        </option>
                                                                                                                        <?php
                                                                                                                        }
                                                                                                                        }
                                                                                                                        ?>
                                                                                                                    </select>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group ">
                                                                                                        <div class="row">
                                                                                                            <div class="col-sm-4">
                                                                                                                <label class="control-label" for="tgl_keluar">Tgl Keluar </label>
                                                                                                            </div>
                                                                                                            <div class="col-sm-8">
                                                                                                                <div class="input-group">
                                                                                                                    <input id="ctrl-tgl_keluar" class="form-control datepicker  datepicker" value="<?php  echo $this->set_field_value('tgl_keluar',""); ?>" type="datetime"  name="tgl_keluar" placeholder="Enter Tgl Keluar" data-enable-time="true" data-min-date="" data-max-date="" data-date-format="Y-m-d H:i:S" data-alt-format="F j, Y - H:i" data-inline="false" data-no-calendar="false" data-mode="single" /> 
                                                                                                                        <div class="input-group-append">
                                                                                                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <div class="form-group ">
                                                                                                            <div class="row">
                                                                                                                <div class="col-sm-4">
                                                                                                                    <label class="control-label" for="keadaan_keluar_igd">Keadaan Keluar Igd </label>
                                                                                                                </div>
                                                                                                                <div class="col-sm-8">
                                                                                                                    <div class="">
                                                                                                                        <input id="ctrl-keadaan_keluar_igd"  value="<?php  echo $this->set_field_value('keadaan_keluar_igd',""); ?>" type="text" placeholder="Enter Keadaan Keluar Igd"  name="keadaan_keluar_igd"  class="form-control " />
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="form-group ">
                                                                                                                <div class="row">
                                                                                                                    <div class="col-sm-4">
                                                                                                                        <label class="control-label" for="ttd_dokter">Ttd Dokter <span class="text-danger">*</span></label>
                                                                                                                    </div>
                                                                                                                    <div class="col-sm-8">
                                                                                                                        <div class="">
                                                                                                                            <?php
                                                                                                                            $ttddok="";
                                                                                                                            $ttdpet="";
                                                                                                                            $ttdpas="";
                                                                                                                            $valdok="";
                                                                                                                            $valpet="";
                                                                                                                            $valpas="";
                                                                                                                            $queryttd = mysqli_query($koneksi, "select * from ttd WHERE id_daftar='$id_daftar' and no_rekam_medis='$no_rekam_medis'")
                                                                                                                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                                                                            $rowsttd = mysqli_num_rows($queryttd);
                                                                                                                            if ($rowsttd <> 0) {
                                                                                                                            while ($datacek = MySQLi_fetch_array($queryttd)) {
                                                                                                                            $cekuntuk=$datacek['untuk'];
                                                                                                                            $cekttd=$datacek['ttd'];
                                                                                                                            if($cekuntuk=="Dokter"){
                                                                                                                            $ttddok="$cekttd";
                                                                                                                            $valdok="1";
                                                                                                                            }else if($cekuntuk=="Petugas"){
                                                                                                                            $ttdpet="$cekttd";
                                                                                                                            $valpet="1";
                                                                                                                            }else   if($cekuntuk=="Pasien"){
                                                                                                                            $ttdpas="$cekttd";
                                                                                                                            $valpas="1";
                                                                                                                            }
                                                                                                                            }
                                                                                                                            }
                                                                                                                            ?>                                                                           
                                                                                                                            <?php
                                                                                                                            if($ttddok==""){
                                                                                                                            if(!empty($_GET['datfrom'])){
                                                                                                                            $datfrom=$_GET['datfrom'];
                                                                                                                            if($datfrom=="IGD"){
                                                                                                                            $datfrom="igd";
                                                                                                                            }else if($datfrom=="RANAP"){
                                                                                                                            $datfrom="rawat_inap";
                                                                                                                            }else{
                                                                                                                            $datfrom="ranap_anak";
                                                                                                                            }
                                                                                                                            }else{
                                                                                                                            $datfrom="";
                                                                                                                            }
                                                                                                                            ?>
                                                                                                                            <a class="btn btn-sm btn-primary has-tooltip page-modal" href="<?php  print_link("ttd/add?precord=$no_rekam_medis&datdari=assesment_medis&ttd=Dokter&darecord=$datfrom&datfrom=$original_plaintext&datprecord=".$_GET['datprecord']);?>"> Buat TTD Digital</a>   
                                                                                                                            <?php }else{ echo "TTD Dokter Sudah Di Input"; }?>                                                                                                               
                                                                                                                            <input id="ctrl-ttd_dokter"  value="<?php  echo $this->set_field_value('ttd_dokter',"$ttddok"); ?>" type="hidden" placeholder="Enter Ttd Dokter"  required="" name="ttd_dokter"  class="form-control " />
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <input id="ctrl-pasien"  value="<?php echo $pasien;?>" type="hidden" placeholder="Enter Pasien"  required="" name="pasien"  class="form-control " />                                                                                 
                                                                                                                </div>
                                                                                                                <div class="form-group form-submit-btn-holder text-center mt-3">
                                                                                                                    <div class="form-ajax-status"></div>
                                                                                                                    <button class="btn btn-primary" type="submit">
                                                                                                                        Submit
                                                                                                                        <i class="fa fa-send"></i>
                                                                                                                    </button>
                                                                                                                </div>                </form>
                                                                                                                <script type="text/javascript">
                                                                                                                    $(document).ready(function(){
                                                                                                                    $('.checkoption1').click(function() {
                                                                                                                    $('.checkoption1').not(this).prop('checked', false);
                                                                                                                    });
                                                                                                                    $('.checkoption2').click(function() {
                                                                                                                    $('.checkoption2').not(this).prop('checked', false);
                                                                                                                    });
                                                                                                                    $('.checkoption3').click(function() {
                                                                                                                    $('.checkoption3').not(this).prop('checked', false);
                                                                                                                    });      
                                                                                                                    });
                                                                                                                </script>                                                                                              
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </section>
