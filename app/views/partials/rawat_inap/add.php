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
                    <h4 class="record-title">Add New Rawat Inap</h4>
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
                <div class="col-md-8 comp-grid">
                    <div class=""><?php
                        $usrnam  = "".USER_NAME;
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        $idtrace = "$id_user$usrnam";
                        if(!empty($_GET['pasien'])){
                        $cekpasien = $_GET['pasien'];
                        }else{
                        $cekpasien="";
                        }
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
                        if($cekpasien=="IGD"){   
                        $queryb = mysqli_query($koneksi, "select * from igd WHERE id_igd='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        }else if($cekpasien=="POLI"){   
                        $queryb = mysqli_query($koneksi, "select * from pendaftaran_poli WHERE id_pendaftaran_poli='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        }else{
                        $queryb = mysqli_query($koneksi, "select * from data_pasien WHERE id_pasien='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));    
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
                        $tl=$row['tl'];
                        /////////////////////////////////////////
                        if($cekpasien=="IGD"){ 
                        $idigd=$row['id_igd'];
                        $dokter_pengirim=$row['dokter'];
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
                        }else{
                        $penanggung_jawab="";
                        $id_penanggung_jawab="";
                        $alamat_penanggung_jawab="";
                        $no_hp_penanggung_jawab="";
                        $hubungan="";
                        $tanggal_masuk="";
                        $dokter="";
                        $idigd="";
                        $id_transaksi="";
                        }
                        if( $umur==""){
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
                        if($cekpasien=="IGD"){ 
                        mysqli_query($koneksi,"UPDATE igd SET umur='$umurnya' WHERE id_igd='$original_plaintext'");
                        }
                        $umur=$umurnya;
                        }
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses URL Tidak Valid');
                            document.location='<?php print_link(""); ?>';
                        </script>
                        <?php }
                        }else{
                        if(isset($_POST['no_rekam_medis'])){  
                        }else{ ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses URL Tidak Valid');
                            document.location='<?php print_link(""); ?>';
                        </script>
                        <?php } }
                        if($no_ktp==0){
                        $no_ktp="";
                        }
                        ?>
                        </div><div class="">
                        <div id="page-report-body" class="table-responsive">
                            <table class=" bg-white">
                                <tr><td>
                                    <table >
                                        <tr >
                                            <th align="left"> Tanggal Masuk <?php echo $cekpasien; ?> : </th>
                                            <td >
                                                <?php echo $tanggal_masuk; ?> 
                                            </td>
                                        </tr> 
                                        <tr>
                                            <th align="left">Nama Pasien: </th>
                                            <td >
                                                <?php echo $nama_pasien; ?> 
                                            </td>
                                        </tr>           
                                        <tr>
                                            <th align="left">Dokter Pengirim: </th>
                                            <td >
                                                <?php echo $nama_dokter; ?> 
                                            </td>
                                        </tr>    
                                        <tr>
                                            <th align="left">Pasien: </th>
                                            <td >
                                                <?php echo $cekpasien; ?> 
                                            </td>
                                        </tr>    
                                    </table>
                                </td>
                                <td >  
                                    <table >
                                        <tr >
                                            <th align="left">&nbsp;&nbsp;  No Rekam Medis: </th>
                                            <td >
                                                <?php echo $no_rekam_medis; ?>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th align="left">&nbsp;&nbsp;  Alamat: </th>
                                            <td >
                                                <?php echo $alamat; ?> 
                                            </td>
                                        </tr>
                                        <tr>
                                            <th align="left">&nbsp;&nbsp;  Tanggal Lahir</th>
                                            <td >
                                                <?php echo $tanggal_lahir; ?> 
                                            </td>
                                        </tr> 
                                        <tr>
                                            <th align="left">&nbsp;&nbsp; Umur: </th>
                                            <td >
                                                <?php echo $umur; ?> 
                                            </td>
                                        </tr>       
                                    </table>         
                                </td>  
                            </tr>
                        </table>   
                    </div>
                    <script>
                        $(document).ready(function() {
                        <?php if($tl==""){
                        $indexvalt="0";
                        }else{
                        if($tl=="TN"){
                        $indexvalt="1";
                        }else if($tl=="NY"){
                        $indexvalt="2";
                        }else if($tl=="AN"){
                        $indexvalt="3";
                        }else if($tl=="BY"){
                        $indexvalt="4";
                        }
                        }
                        ?>
                        document.getElementById("ctrl-tl").selectedIndex = "<?php echo $indexvalt;?>";
                        <?php if($pembayaran==""){}else{
                        $querb = mysqli_query($koneksi, "select * from data_bank order by id_databank asc")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));  
                        $hitung=0;                    
                        while ($rowb=mysqli_fetch_array($querb)){
                        $cekidb = $rowb['id_databank'];
                        if($pembayaran=="$cekidb"){
                        $indexvalp="$hitung";
                        ?>
                        document.getElementById("ctrl-pembayaran").selectedIndex = "<?php echo $indexvalp;?>";
                        <?php
                        if($indexvalp=="1"){}else{?>
                        document.getElementById("ctrl-setatus_bpjs").selectedIndex = 1;
                        <?php }
                        }  
                        $hitung=$hitung + 1; 
                        }
                        }
                        ?>   
                        <?php if($jenis_kelamin==""){}else{
                        if($jenis_kelamin=="Laki-Laki"){
                        $indexval="1";
                        }else{
                        $indexval="2";
                        }
                        ?>
                        document.getElementById("ctrl-jenis_kelamin").selectedIndex = "<?php echo $indexval;?>";
                        <?php }?>
                        $('#ctrl-pembayaran').on('change', function(){ 
                        //do something like 
                        //$(this).hide(); 
                        //$(#anotherfieldid).show();
                        //var pem = document.getElementById("ctrl-pembayaran").value;
                        var pem =  $('#ctrl-pembayaran').val();
                        //  alert('Tes' +pem);
                        if(pem==2){
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
                </div>
                <?php $this :: display_page_errors(); ?>
                <div  class="bg-light p-3 animated fadeIn page-content">
                    <form id="rawat_inap-add-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("rawat_inap/add?csrf_token=$csrf_token") ?>" method="post">
                        <div>
                            <input id="ctrl-id_igd"  value="<?php echo $idigd;?>" type="hidden" placeholder="Enter Id Igd"  name="id_igd"  class="form-control " />
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
                                    <input id="ctrl-pasien"  value="<?php echo $cekpasien;?>" type="hidden" placeholder="Enter Pasien" list="pasien_list"  required="" name="pasien"  class="form-control " />
                                        <datalist id="pasien_list">
                                            <?php
                                            $pasien_options = Menu :: $pasien;
                                            if(!empty($pasien_options)){
                                            foreach($pasien_options as $option){
                                            $value = $option['value'];
                                            $label = $option['label'];
                                            $selected = $this->set_field_selected('pasien', $value);
                                            ?>
                                            <option><?php echo $cekpasien;?></option>
                                            <?php
                                            }
                                            }
                                            ?>
                                        </datalist>
                                        <input id="ctrl-dokter_pengirim"  value="<?php echo $dokter_pengirim;?>" type="hidden" placeholder="Enter Dokter Pengirim"  required="" name="dokter_pengirim"  class="form-control " />
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
                                                                $pembayaran_options = $comp_model -> rawat_inap_pembayaran_option_list();
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
                                                            <select required=""  id="ctrl-setatus_bpjs" name="setatus_bpjs"  placeholder="Select a value ..."    class="custom-select" >
                                                                <option value="">Select a value ...</option>
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
                                                        <label class="control-label" for="tl">TL </label>
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
                                                                $selected = $this->set_field_selected('tl', $value);
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
                                                            <input id="ctrl-nama_pasien"  value="<?php echo $nama_pasien;?>" type="text" placeholder="Enter Nama Pasien"  required="" name="nama_pasien"  class="form-control " />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input id="ctrl-no_rekam_medis"  value="<?php echo $no_rekam_medis;?>" type="hidden" placeholder="Enter No Rekam Medis"  name="no_rekam_medis"  class="form-control " />
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label class="control-label" for="poli">Specialist <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <div class="">
                                                                    <select required=""  id="ctrl-poli" data-load-select-options="dokter_rawat_inap" name="poli"  placeholder="Select a value ..."    class="custom-select" >
                                                                        <option value="">Select a value ...</option>
                                                                        <?php 
                                                                        $poli_options = $comp_model -> rawat_inap_poli_option_list();
                                                                        if(!empty($poli_options)){
                                                                        foreach($poli_options as $option){
                                                                        $value = (!empty($option['value']) ? $option['value'] : null);
                                                                        $label = (!empty($option['label']) ? $option['label'] : $value);
                                                                        $selected = $this->set_field_selected('poli',$value, "");
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
                                                                <label class="control-label" for="dokter_rawat_inap">Dokter Rawat Inap <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <div class="">
                                                                    <select required=""  id="ctrl-dokter_rawat_inap" data-load-path="<?php print_link('api/json/rawat_inap_dokter_rawat_inap_option_list') ?>" name="dokter_rawat_inap"  placeholder="Select a value ..."    class="custom-select" >
                                                                        <option value="">Select a value ...</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input id="ctrl-no_ktp"  value="<?php echo $no_ktp;?>" type="hidden" placeholder="Enter No Ktp"  required="" name="no_ktp"  class="form-control " />
                                                        <input id="ctrl-alamat"  value="<?php echo $alamat;?>" type="hidden" placeholder="Enter Alamat"  required="" name="alamat"  class="form-control " />
                                                            <input id="ctrl-tanggal_lahir"  value="<?php echo $tanggal_lahir;?>" type="hidden" placeholder="Enter Tanggal Lahir"  required="" name="tanggal_lahir"  class="form-control " />
                                                                <input id="ctrl-jenis_kelamin"  value="<?php echo $jenis_kelamin;?>" type="hidden" placeholder="Enter Jenis Kelamin" list="jenis_kelamin_list"  required="" name="jenis_kelamin"  class="form-control " />
                                                                    <datalist id="jenis_kelamin_list">
                                                                        <?php
                                                                        $jenis_kelamin_options = Menu :: $jenis_kelamin;
                                                                        if(!empty($jenis_kelamin_options)){
                                                                        foreach($jenis_kelamin_options as $option){
                                                                        $value = $option['value'];
                                                                        $label = $option['label'];
                                                                        $selected = $this->set_field_selected('jenis_kelamin', $value);
                                                                        ?>
                                                                        <option><?php echo $jenis_kelamin;?></option>
                                                                        <?php
                                                                        }
                                                                        }
                                                                        ?>
                                                                    </datalist>
                                                                    <input id="ctrl-umur"  value="<?php echo $umur;?>" type="hidden" placeholder="Enter Umur"  required="" name="umur"  class="form-control " />
                                                                        <input id="ctrl-no_hp"  value="<?php echo $no_hp;?>" type="hidden" placeholder="Enter No Hp"  name="no_hp"  class="form-control " />
                                                                            <input id="ctrl-email"  value="<?php echo $email;?>" type="hidden" placeholder="Enter Email"  name="email"  class="form-control " />
                                                                                <div class="form-group ">
                                                                                    <div class="row">
                                                                                        <div class="col-sm-4">
                                                                                            <label class="control-label" for="penanggung_jawab">Penanggung Jawab <span class="text-danger">*</span></label>
                                                                                        </div>
                                                                                        <div class="col-sm-8">
                                                                                            <div class="">
                                                                                                <input id="ctrl-penanggung_jawab"  value="<?php echo $penanggung_jawab;?>" type="text" placeholder="Enter Penanggung Jawab"  required="" name="penanggung_jawab"  class="form-control " />
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
                                                                                                    <input id="ctrl-id_penanggung_jawab"  value="<?php echo $id_penanggung_jawab;?>" type="text" placeholder="Enter Id Penanggung Jawab"  required="" name="id_penanggung_jawab"  class="form-control " />
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
                                                                                                        <input id="ctrl-alamat_penanggung_jawab"  value="<?php echo $alamat_penanggung_jawab;?>" type="text" placeholder="Enter Alamat Penanggung Jawab"  required="" name="alamat_penanggung_jawab"  class="form-control " />
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
                                                                                                            <input id="ctrl-no_hp_penanggung_jawab"  value="<?php echo $no_hp_penanggung_jawab;?>" type="text" placeholder="Enter No Hp Penanggung Jawab"  required="" name="no_hp_penanggung_jawab"  class="form-control " />
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
                                                                                                                <input id="ctrl-hubungan"  value="<?php echo $hubungan;?>" type="text" placeholder="Enter Hubungan"  required="" name="hubungan"  class="form-control " />
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <input id="ctrl-id_transaksi"  value="<?php echo $id_transaksi;?>" type="hidden" placeholder="Enter Id Transaksi"  required="" name="id_transaksi"  class="form-control " />
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
