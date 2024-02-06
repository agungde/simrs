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
                    <div class=""><?php
                        $usrnam  = "".USER_NAME;
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        $idtrace = "$id_user$usrnam";
                        if(!empty($_GET['precord'])){
                        //$precord=$_GET['precord']; 
                        $ciphertext = $_GET['precord'];
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
                        $queryb = mysqli_query($koneksi, "select * from data_pasien WHERE id_pasien='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
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
                        $no_ktp=$row['no_ktp'];
                        $tl=$row['tl'];
                        // $berat_badan=$row['berat_badan'];
                        // $tensi=$row['tensi'];
                        // $dokter=$row['dokter'];
                        // $keluhan=$row['keluhan'];
                        //$nama_poli=$row['nama_poli'];
                        //$id_pendaftaran_poli=$row['id_pendaftaran_poli'];
                        $pasien="IGD";
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses URL Tidak Valid');
                            document.location='<?php print_link(""); ?>';
                        </script>
                        <?php }
                        }else{
                        $nama_pasien="";
                        $alamat="";
                        $no_hp="";
                        $tanggal_lahir="";
                        $jenis_kelamin="";
                        $email="";
                        $umur=""; 
                        $pasien="IGD";
                        $no_ktp="";
                        $no_rekam_medis="";
                        }
                        if($no_ktp==0){
                        $no_ktp="";
                        }
                        ?>
                        <script>
                            function fill(Value) {
                            // $('#search').val(Value);
                            document.location='<?php print_link("igd/add?precord="); ?>'+Value;
                            }
                            $(document).ready(function() {
                            <?php if(!empty($_GET['precord'])){}else{?>
                            setTimeout(function(){
                            // window.location.reload();
                            $('#slideshow').hide();
                            $('#slideshow1').hide();
                            }, 30000);
                            <?php }?>
                            <?php if($jenis_kelamin==""){}else{
                            if($jenis_kelamin=="Laki-Laki"){
                            $indexval="1";
                            }else{
                            $indexval="2";
                            }
                            ?>
                            document.getElementById("ctrl-jenis_kelamin").selectedIndex = "<?php echo $indexval;?>";
                            <?php }?>
                            <?php if($tl==""){}else{
                            if($tl=="TN"){
                            $indexvalt="1";
                            }else if($tl=="NY"){
                            $indexvalt="2";
                            }else if($tl=="AN"){
                            $indexvalt="3";
                            }else if($tl=="BY"){
                            $indexvalt="4";
                            }
                            ?>
                            document.getElementById("ctrl-tl").selectedIndex = "<?php echo $indexvalt;?>";
                            <?php }?>
                            //On pressing a key on "Search box" in "search.php" file. This function will be called.
                            // $('#ctrl-nama_pasien').val("").focus();
                            $('#ctrl-nama_pasien').keyup(function(e){
                            var tex = $(this).val();
                            console.log(tex);
                            if(tex !=="" && e.keyCode===13){
                            }
                            e.preventDefault();
                            //Assigning search box value to javascript variable named as "name".
                            var name = $('#ctrl-nama_pasien').val();
                            //Validating, if "name" is empty.
                            if (name == "") {
                            //Assigning empty value to "display" div in "search.php" file.
                            $("#display").html("");
                            }
                            //If name is not empty.
                            else {
                            //AJAX is called.
                            $.ajax({
                            //AJAX type is "Post".
                            type: "POST",
                            //Data will be sent to "ajax.php".
                            url: "<?php print_link("caripasien.php") ?>",
                            //Data, that will be sent to "ajax.php".
                            data: {
                            //Assigning value of "name" into "search" variable.
                            search: name
                            },
                            //If result found, this funtion will be called.
                            success: function(html) {
                            //Assigning result to "display" div in "search.php" file.
                            $("#display").html(html).show();
                            }
                            });
                            }
                            });
                            $('#ctrl-pembayaran').on('change', function(){ 
                            //do something like 
                            //$(this).hide(); 
                            //$(#anotherfieldid).show();
                            //var pem = document.getElementById("ctrl-pembayaran").value;
                            var pem =  $('#ctrl-pembayaran').val();
                            //  alert('Tes' +pem);
                            if(pem==1){
                            //$('#ctrl-setatus_bpjs')..disabled=false;  
                            document.getElementById("ctrl-setatus_bpjs").disabled=false;
                            document.getElementById("ctrl-setatus_bpjs").selectedIndex = 0;
                            BPJSopenTab();
                            }else{
                            document.getElementById("ctrl-setatus_bpjs").selectedIndex = 1;
                            }
                            });  
                            });
                        </script>
                    </div><h4 class="record-title">Add New IGD</h4>
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
                    <div class=""><?php if(!empty($_GET['precord'])){}else{?>
                        <div id="slideshow" class="flash_message">Ketik Nama Pasien Akan Muncul data Pasien.</div>
                        <div id="slideshow1" class="flash_message"> Clik Data Yg Di Pilih Auto Isi Form<div>Apabila pasien Baru Isi Form Dengan Benar.</div><div class="flash_message1"> Form Auto Add pasien</div></div>
                        <?php }?>
                        <style>
                            .flash_message{
                            color: green;
                            }
                            .flash_message1 {
                            margin-bottom: 5px;
                            color: green;
                            }
                            a:hover {
                            cursor: pointer;
                            background-color: #F5F5DC;
                            }
                        </style>
                    <div id="display" ></div></div>
                    <?php $this :: display_page_errors(); ?>
                    <div  class="bg-light p-3 animated fadeIn page-content">
                        <form id="igd-add-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("igd/add?csrf_token=$csrf_token") ?>" method="post">
                            <div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="tanggal_masuk">Tanggal Masuk <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input id="ctrl-tanggal_masuk" class="form-control datepicker  datepicker" required="" value="<?php  echo $this->set_field_value('tanggal_masuk',datetime_now()); ?>" type="datetime"  name="tanggal_masuk" placeholder="Enter Tanggal Masuk" data-enable-time="true" data-min-date="" data-max-date="" data-date-format="Y-m-d H:i:S" data-alt-format="F j, Y - H:i" data-inline="false" data-no-calendar="false" data-mode="single" /> 
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
                                                <label class="control-label" for="tl">Tl </label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <select  id="ctrl-tl" name="tl"  placeholder="Select a value ..."    class="custom-select" >
                                                        <option value="">Select a value ...</option>
                                                        <?php
                                                        $tl_options = Menu :: $tl;
                                                        if(!empty($tl_options)){
                                                        foreach($tl_options as $option){
                                                        $value = $option['value'];
                                                        $label = $option['label'];
                                                        $selected = $this->set_field_selected('tl', $value, "");
                                                        ?>
                                                        <option <?php echo $selected ?> value="<?php echo $value ?>">
                                                            <?php echo $label ?>
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
                                                <label class="control-label" for="nama_pasien">Nama Pasien <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <input id="ctrl-nama_pasien"  value="<?php echo $nama_pasien;?>" type="text" placeholder="Cari NORM/Nama/Alamat"  required="" name="nama_pasien"  class="form-control " />
                                                    </div>
                                                    <small class="form-text">Cari No Rekam Medis / Nama /Alamat</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="control-label" for="no_ktp">No Ktp <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="">
                                                        <input id="ctrl-no_ktp"  value="<?php echo $no_ktp;?>" type="number" placeholder="Enter No Ktp" min="16" step="1"  required="" name="no_ktp"  class="form-control " />
                                                        </div>
                                                        <small class="form-text">Isi 16 Digit No Ktp</small>
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
                                                            <textarea placeholder="Enter Alamat" id="ctrl-alamat"  required="" rows="5" name="alamat" class=" form-control"><?php echo $alamat;?></textarea>
                                                            <!--<div class="invalid-feedback animated bounceIn text-center">Please enter text</div>-->
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label class="control-label" for="tanggal_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="input-group">
                                                            <input id="ctrl-tanggal_lahir" class="form-control datepicker  datepicker"  required="" value="<?php echo $tanggal_lahir;?>" type="datetime" name="tanggal_lahir" placeholder="Enter Tanggal Lahir" data-enable-time="false" data-min-date="" data-max-date="" data-date-format="Y-m-d" data-alt-format="F j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
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
                                                            <label class="control-label" for="jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="">
                                                                <select required=""  id="ctrl-jenis_kelamin" name="jenis_kelamin"  placeholder="Select a value ..."    class="custom-select" >
                                                                    <option value="">Select a value ...</option>
                                                                    <?php
                                                                    $jenis_kelamin_options = Menu :: $jenis_kelamin;
                                                                    if(!empty($jenis_kelamin_options)){
                                                                    foreach($jenis_kelamin_options as $option){
                                                                    $value = $option['value'];
                                                                    $label = $option['label'];
                                                                    $selected = $this->set_field_selected('jenis_kelamin', $value, "");
                                                                    ?>
                                                                    <option <?php echo $selected ?> value="<?php echo $value ?>">
                                                                        <?php echo $label ?>
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
                                                            <label class="control-label" for="no_hp">No Hp </label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="">
                                                                <input id="ctrl-no_hp"  value="<?php echo $no_hp;?>" type="text" placeholder="Enter No Hp"  name="no_hp"  class="form-control " />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label class="control-label" for="email">Email </label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <div class="">
                                                                    <input id="ctrl-email"  value="<?php echo  $email;?>" type="email" placeholder="Enter Email"  name="email"  class="form-control " />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label class="control-label" for="pembayaran">Pembayaran <span class="text-danger">*</span></label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <div class="">
                                                                        <select required=""  id="ctrl-pembayaran" name="pembayaran"  placeholder="Select a value ..."    class="custom-select" >
                                                                            <option value="">Select a value ...</option>
                                                                            <?php 
                                                                            $pembayaran_options = $comp_model -> igd_pembayaran_option_list();
                                                                            if(!empty($pembayaran_options)){
                                                                            foreach($pembayaran_options as $option){
                                                                            $value = (!empty($option['value']) ? $option['value'] : null);
                                                                            $label = (!empty($option['label']) ? $option['label'] : $value);
                                                                            $selected = $this->set_field_selected('pembayaran',$value, "");
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
                                                                    <label class="control-label" for="setatus_bpjs">Setatus Bpjs <span class="text-danger">*</span></label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <div class="">
                                                                        <select required=""  id="ctrl-setatus_bpjs" name="setatus_bpjs"  placeholder="Select Setatus Bpjs..."    class="custom-select" >
                                                                            <option value="">Select Setatus Bpjs...</option>
                                                                            <?php
                                                                            $setatus_bpjs_options = Menu :: $setatus_bpjs;
                                                                            if(!empty($setatus_bpjs_options)){
                                                                            foreach($setatus_bpjs_options as $option){
                                                                            $value = $option['value'];
                                                                            $label = $option['label'];
                                                                            $selected = $this->set_field_selected('setatus_bpjs', $value, "");
                                                                            ?>
                                                                            <option <?php echo $selected ?> value="<?php echo $value ?>">
                                                                                <?php echo $label ?>
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
                                                                    <label class="control-label" for="dokter">Dokter IGD <span class="text-danger">*</span></label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <div class="">
                                                                        <select required=""  id="ctrl-dokter" name="dokter"  placeholder="Select a value ..."    class="custom-select" >
                                                                            <option value="">Select a value ...</option>
                                                                            <?php 
                                                                            $dokter_options = $comp_model -> igd_dokter_option_list();
                                                                            if(!empty($dokter_options)){
                                                                            foreach($dokter_options as $option){
                                                                            $value = (!empty($option['value']) ? $option['value'] : null);
                                                                            $label = (!empty($option['label']) ? $option['label'] : $value);
                                                                            $selected = $this->set_field_selected('dokter',$value, "");
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
                                                                    <label class="control-label" for="penanggung_jawab">Penanggung Jawab <span class="text-danger">*</span></label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <div class="">
                                                                        <input id="ctrl-penanggung_jawab"  value="<?php  echo $this->set_field_value('penanggung_jawab',""); ?>" type="text" placeholder="Enter Penanggung Jawab"  required="" name="penanggung_jawab"  class="form-control " />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group ">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" for="id_penanggung_jawab">Id Penanggung Jawab <span class="text-danger">*</span></label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <div class="">
                                                                            <input id="ctrl-id_penanggung_jawab"  value="<?php  echo $this->set_field_value('id_penanggung_jawab',""); ?>" type="text" placeholder="Enter Id Penanggung Jawab"  required="" name="id_penanggung_jawab"  class="form-control " />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group ">
                                                                    <div class="row">
                                                                        <div class="col-sm-4">
                                                                            <label class="control-label" for="alamat_penanggung_jawab">Alamat Penanggung Jawab <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-sm-8">
                                                                            <div class="">
                                                                                <input id="ctrl-alamat_penanggung_jawab"  value="<?php  echo $this->set_field_value('alamat_penanggung_jawab',""); ?>" type="text" placeholder="Enter Alamat Penanggung Jawab"  required="" name="alamat_penanggung_jawab"  class="form-control " />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group ">
                                                                        <div class="row">
                                                                            <div class="col-sm-4">
                                                                                <label class="control-label" for="no_hp_penanggung_jawab">No Hp Penanggung Jawab <span class="text-danger">*</span></label>
                                                                            </div>
                                                                            <div class="col-sm-8">
                                                                                <div class="">
                                                                                    <input id="ctrl-no_hp_penanggung_jawab"  value="<?php  echo $this->set_field_value('no_hp_penanggung_jawab',""); ?>" type="text" placeholder="Enter No Hp Penanggung Jawab"  required="" name="no_hp_penanggung_jawab"  class="form-control " />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group ">
                                                                            <div class="row">
                                                                                <div class="col-sm-4">
                                                                                    <label class="control-label" for="hubungan">Hubungan <span class="text-danger">*</span></label>
                                                                                </div>
                                                                                <div class="col-sm-8">
                                                                                    <div class="">
                                                                                        <input id="ctrl-hubungan"  value="<?php  echo $this->set_field_value('hubungan',""); ?>" type="text" placeholder="Enter Hubungan"  required="" name="hubungan"  class="form-control " />
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <input id="ctrl-rawat_inap"  value="<?php  echo $this->set_field_value('rawat_inap',"None"); ?>" type="hidden" placeholder="Enter Rawat Inap" list="rawat_inap_list"  name="rawat_inap"  class="form-control " />
                                                                                <datalist id="rawat_inap_list">
                                                                                    <?php
                                                                                    $rawat_inap_options = Menu :: $rawat_inap;
                                                                                    if(!empty($rawat_inap_options)){
                                                                                    foreach($rawat_inap_options as $option){
                                                                                    $value = $option['value'];
                                                                                    $label = $option['label'];
                                                                                    $selected = $this->set_field_selected('rawat_inap', $value, "None");
                                                                                    ?>
                                                                                    <option><?php  echo $this->set_field_value('rawat_inap',"None"); ?></option>
                                                                                    <?php
                                                                                    }
                                                                                    }
                                                                                    ?>
                                                                                </datalist>
                                                                                <input id="ctrl-back_link"  value="<?php if(!empty($_GET['precord'])){$backlink=$_GET['precord'];}else{$backlink="Baru";} echo $backlink;?>" type="hidden" placeholder="Enter Back Link"  required="" name="back_link"  class="form-control " />
                                                                                    <input id="ctrl-no_rekam_medis"  value="<?php echo $no_rekam_medis;?>" type="hidden" placeholder="Enter No Rekam Medis"  name="no_rekam_medis"  class="form-control " />
                                                                                        <input id="ctrl-pasien"  value="<?php  echo $this->set_field_value('pasien',"IGD"); ?>" type="hidden" placeholder="Enter Pasien"  required="" name="pasien"  class="form-control " />
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
