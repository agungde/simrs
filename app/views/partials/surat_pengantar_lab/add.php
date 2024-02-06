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
                    <h4 class="record-title"><?php
                        if(!empty($_GET['pasien'])){
                        $pasien=$_GET['pasien'];
                        }else{
                        $pasien="";
                        }
                        echo "Add New Surat Pengantar Lab $pasien";
                        ?>
                    </h4>
                    <div class=""><div>
                        <?php
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        if(!empty($_GET['precord'])){
                        $ciphertext=$_GET['precord'];
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
                        if (hash_equals($hmac, $calcmac))// timing attack safe comparison
                        {
                        // echo $original_plaintext."\n";
                        }
                        if($pasien=="POLI"){   
                        $queryb = mysqli_query($koneksi, "select * from pendaftaran_poli WHERE id_pendaftaran_poli='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        }
                        if($pasien=="IGD"){        
                        $queryb = mysqli_query($koneksi, "select * from igd WHERE id_igd='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));                               
                        }    
                        if($pasien=="RAWAT INAP"){        
                        $queryb = mysqli_query($koneksi, "select * from rawat_inap WHERE id='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));                               
                        }  
                        // ambil jumlah baris data hasil query
                        $rowsb = mysqli_num_rows($queryb);
                        if ($rowsb <> 0) {
                        $row   = mysqli_fetch_assoc($queryb); 
                        $no_rekam_medis=$row['no_rekam_medis'];
                        $nama_pasien=$row['nama_pasien'];
                        $alamat=$row['alamat'];
                        $no_hp=$row['no_hp'];
                        $tanggal_lahir=$row['tanggal_lahir'];
                        $jenis_kelamin=$row['jenis_kelamin'];
                        $email=$row['email'];
                        $umur=$row['umur'];
                        //////////////////////////
                        // $tinggi=$row['tinggi'];
                        //$berat_badan=$row['berat_badan'];
                        // $tensi=$row['tensi'];
                        //dokter_pengirim
                        // $keluhan=$row['keluhan'];
                        if($pasien=="IGD"){ 
                        $keluhan="";
                        $id_daftar=$row['id_igd'];
                        $dokter=$row['dokter'];
                        }else if($pasien=="RAWAT INAP"){
                        $keluhan="";
                        $id_daftar=$row['id'];
                        $dokter=$row['dokter_rawat_inap'];
                        }else if($pasien=="POLI"){ 
                        $nama_poli=$row['nama_poli'];
                        $id_daftar=$row['id_pendaftaran_poli'];
                        $keluhan=$row['keluhan'];
                        $dokter=$row['dokter'];
                        }else{
                        $dokter=$row['dokter'];
                        }
                        $querybc = mysqli_query($koneksi, "select * from pemeriksaan_fisik WHERE id_daftar='$original_plaintext' and no_rekam_medis='$no_rekam_medis'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));  
                        $rowsbc = mysqli_num_rows($querybc);
                        if ($rowsbc <> 0) {
                        $rowc   = mysqli_fetch_assoc($querybc); 
                        $keluhan=$rowc['keluhan'];
                        }
                        ///////////////////
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses URL Tidak Valid');
                            document.location='<?php print_link(""); ?>';
                        </script>
                        <?php }
                        if($pasien=="POLI"){ 
                        $sqlp = mysqli_query($koneksi,"select * from data_poli WHERE id_poli='$nama_poli'");
                        while ($rowp=mysqli_fetch_array($sqlp)){
                        $nama_poli=$rowp['nama_poli'];
                        }
                        }else{
                        $nama_poli=$pasien; 
                        }
                        $sqld = mysqli_query($koneksi,"select * from data_dokter WHERE id_dokter='$dokter'");
                        while ($rowd=mysqli_fetch_array($sqld)){
                        $dokter=$rowd['nama_dokter'];
                        }
                        }else{
                        $no_rekam_medis="";
                        $nama_pasien="";
                        $alamat="";
                        $no_hp="";
                        $tanggal_lahir="";
                        $jenis_kelamin="";
                        $email="";
                        $umur="";
                        $tinggi="";
                        $berat_badan="";
                        $tensi="";
                        $dokter="";
                        $nama_poli="";
                        $keluhan="";
                        $id_daftar="";
                        }
                        if($pasien=="POLI"){
                        $bagian=$nama_poli;
                        }else{
                        $bagian=""; 
                        }
                        ?>
                    </div>
                </div>
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
                <?php $this :: display_page_errors(); ?>
                <div  class="bg-light p-3 animated fadeIn page-content">
                    <form id="surat_pengantar_lab-add-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("surat_pengantar_lab/add?csrf_token=$csrf_token") ?>" method="post">
                        <div>
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
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="dari_poli">Dari Poli <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="ctrl-dari_poli"  value="<?php echo "$pasien $bagian";?>" type="text" placeholder="Enter Dari Poli"  readonly required="" name="dari_poli"  class="form-control " />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="no_rekam_medis">No Rekam Medis <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <input id="ctrl-no_rekam_medis"  value="<?php echo $no_rekam_medis;?>" type="text" placeholder="Enter No Rekam Medis"  readonly required="" name="no_rekam_medis"  class="form-control " />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="control-label" for="nama_pasien">Nama Pasien <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="">
                                                        <input id="ctrl-nama_pasien"  value="<?php echo $nama_pasien;?>" type="text" placeholder="Enter Nama Pasien"  readonly required="" name="nama_pasien"  class="form-control " />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label class="control-label" for="tgl_lahir">Tgl Lahir <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="input-group">
                                                            <input id="ctrl-tgl_lahir"  value="<?php echo $tanggal_lahir;?>" type="text" placeholder="Enter Tgl Lahir"  readonly required="" name="tgl_lahir"  class="form-control " />
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
                                                            <label class="control-label" for="alamat">Alamat <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="">
                                                                <input id="ctrl-alamat"  value="<?php echo $alamat;?>" type="text" placeholder="Enter Alamat"  readonly required="" name="alamat"  class="form-control " />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php
                                                    if($pasien=="RAWAT INAP"){?>
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label class="control-label" for="ruangan">Ruangan </label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <div class="">
                                                                    <input id="ctrl-ruangan"  value="<?php  echo $this->set_field_value('ruangan',""); ?>" type="text" placeholder="Enter Ruangan"  name="ruangan"  class="form-control " />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label class="control-label" for="kelas">Kelas </label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <div class="">
                                                                        <input id="ctrl-kelas"  value="<?php  echo $this->set_field_value('kelas',""); ?>" type="text" placeholder="Enter Kelas"  name="kelas"  class="form-control " />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <?php }?>                                    
                                                            <div class="form-group ">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" for="hematologi">Hematologi </label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <div class="">
                                                                            <?php 
                                                                            $hematologi_options = $comp_model -> surat_pengantar_lab_hematologi_option_list();
                                                                            if(!empty($hematologi_options)){
                                                                            $ci = 0;
                                                                            foreach($hematologi_options as $option){
                                                                            $ci++;
                                                                            $value = (!empty($option['value']) ? $option['value'] : null);
                                                                            $label = (!empty($option['label']) ? $option['label'] : $value);
                                                                            $checked = $this->set_field_checked('hematologi', $value, "");
                                                                            ?>
                                                                            <label class="custom-control custom-checkbox custom-control-inline">
                                                                                <input id="ctrl-hematologi" class="custom-control-input" <?php echo $checked; ?> value="<?php echo $value; ?>" type="checkbox" name="hematologi[]"   />
                                                                                    <span class="custom-control-label"><?php echo $label; ?></span>
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
                                                                            <label class="control-label" for="imuniserologi">Imuniserologi </label>
                                                                        </div>
                                                                        <div class="col-sm-8">
                                                                            <div class="">
                                                                                <?php 
                                                                                $imuniserologi_options = $comp_model -> surat_pengantar_lab_imuniserologi_option_list();
                                                                                if(!empty($imuniserologi_options)){
                                                                                $ci = 0;
                                                                                foreach($imuniserologi_options as $option){
                                                                                $ci++;
                                                                                $value = (!empty($option['value']) ? $option['value'] : null);
                                                                                $label = (!empty($option['label']) ? $option['label'] : $value);
                                                                                $checked = $this->set_field_checked('imuniserologi', $value, "");
                                                                                ?>
                                                                                <label class="custom-control custom-checkbox custom-control-inline">
                                                                                    <input id="ctrl-imuniserologi" class="custom-control-input" <?php echo $checked; ?> value="<?php echo $value; ?>" type="checkbox" name="imuniserologi[]"   />
                                                                                        <span class="custom-control-label"><?php echo $label; ?></span>
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
                                                                                <label class="control-label" for="kimia_klinik">Kimia Klinik </label>
                                                                            </div>
                                                                            <div class="col-sm-8">
                                                                                <div class="">
                                                                                    <?php 
                                                                                    $kimia_klinik_options = $comp_model -> surat_pengantar_lab_kimia_klinik_option_list();
                                                                                    if(!empty($kimia_klinik_options)){
                                                                                    $ci = 0;
                                                                                    foreach($kimia_klinik_options as $option){
                                                                                    $ci++;
                                                                                    $value = (!empty($option['value']) ? $option['value'] : null);
                                                                                    $label = (!empty($option['label']) ? $option['label'] : $value);
                                                                                    $checked = $this->set_field_checked('kimia_klinik', $value, "");
                                                                                    ?>
                                                                                    <label class="custom-control custom-checkbox custom-control-inline">
                                                                                        <input id="ctrl-kimia_klinik" class="custom-control-input" <?php echo $checked; ?> value="<?php echo $value; ?>" type="checkbox" name="kimia_klinik[]"   />
                                                                                            <span class="custom-control-label"><?php echo $label; ?></span>
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
                                                                                    <label class="control-label" for="urin_faces">Urin Faces </label>
                                                                                </div>
                                                                                <div class="col-sm-8">
                                                                                    <div class="">
                                                                                        <?php 
                                                                                        $urin_faces_options = $comp_model -> surat_pengantar_lab_urin_faces_option_list();
                                                                                        if(!empty($urin_faces_options)){
                                                                                        $ci = 0;
                                                                                        foreach($urin_faces_options as $option){
                                                                                        $ci++;
                                                                                        $value = (!empty($option['value']) ? $option['value'] : null);
                                                                                        $label = (!empty($option['label']) ? $option['label'] : $value);
                                                                                        $checked = $this->set_field_checked('urin_faces', $value, "");
                                                                                        ?>
                                                                                        <label class="custom-control custom-checkbox custom-control-inline">
                                                                                            <input id="ctrl-urin_faces" class="custom-control-input" <?php echo $checked; ?> value="<?php echo $value; ?>" type="checkbox" name="urin_faces[]"   />
                                                                                                <span class="custom-control-label"><?php echo $label; ?></span>
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
                                                                                        <label class="control-label" for="microbiologi">Microbiologi </label>
                                                                                    </div>
                                                                                    <div class="col-sm-8">
                                                                                        <div class="">
                                                                                            <?php 
                                                                                            $microbiologi_options = $comp_model -> surat_pengantar_lab_microbiologi_option_list();
                                                                                            if(!empty($microbiologi_options)){
                                                                                            $ci = 0;
                                                                                            foreach($microbiologi_options as $option){
                                                                                            $ci++;
                                                                                            $value = (!empty($option['value']) ? $option['value'] : null);
                                                                                            $label = (!empty($option['label']) ? $option['label'] : $value);
                                                                                            $checked = $this->set_field_checked('microbiologi', $value, "");
                                                                                            ?>
                                                                                            <label class="custom-control custom-checkbox custom-control-inline">
                                                                                                <input id="ctrl-microbiologi" class="custom-control-input" <?php echo $checked; ?> value="<?php echo $value; ?>" type="checkbox" name="microbiologi[]"   />
                                                                                                    <span class="custom-control-label"><?php echo $label; ?></span>
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
                                                                                            <label class="control-label" for="lain_lain">Lain Lain </label>
                                                                                        </div>
                                                                                        <div class="col-sm-8">
                                                                                            <div class="">
                                                                                                <input id="ctrl-lain_lain"  value="<?php  echo $this->set_field_value('lain_lain',""); ?>" type="text" placeholder="Enter Lain Lain"  name="lain_lain"  class="form-control " />
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
                                                                                                    if($ttddok==""){?>
                                                                                                    <a class="btn btn-sm btn-primary has-tooltip page-modal" href="<?php  print_link("ttd/add?precord=$no_rekam_medis&datdari=surat_pengantar_lab&ttd=Dokter&darecord=pendaftaran_poli&datprecord=$id_daftar&pasien=".$_GET['pasien']);?>"> Buat TTD Digital</a>   
                                                                                                    <?php }else{ echo "TTD Dokter Sudah Di Input"; }?>                                                                                  
                                                                                                    <input id="ctrl-ttd_dokter"  value="<?php  echo $ttddok; ?>" type="hidden" placeholder="Enter Ttd Dokter"  required="" name="ttd_dokter"  class="form-control " />
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <input id="ctrl-id_daftar"  value="<?php echo $id_daftar;?>" type="hidden" placeholder="Enter Id Daftar"  required="" name="id_daftar"  class="form-control " />
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
