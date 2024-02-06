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
                    <h4 class="record-title">Add New Ijin Pulang</h4>
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
                        if(!empty($_GET['backlink'])){
                        $original_plaintext=$_GET['datprecord'];
                        }
                        if(!empty($_GET['darecord'])){
                        $darecord=$_GET['darecord'];
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses URL Tidak Valid');
                            document.location='<?php print_link(""); ?>';
                        </script>
                        <?php    
                        }
                        $id_daftar=$original_plaintext;
                        $queryb = mysqli_query($koneksi, "select * from $darecord WHERE id='$original_plaintext'")
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
                        $id_transaksi=$row['id_transaksi'];
                        $kamar_kelas=$row['kamar_kelas'];
                        $nama_kamar=$row['nama_kamar'];
                        $no_kamar=$row['no_kamar'];
                        $no_ranjang=$row['no_ranjang'];
                        /*  
                        $idigd=$row['id_igd'];
                        $dokter_pengirim=$row['dokter_rawat_inap'];
                        $penanggung_jawab=$row['penanggung_jawab'];
                        $id_penanggung_jawab=$row['id_penanggung_jawab'];
                        $alamat_penanggung_jawab=$row['alamat_penanggung_jawab'];
                        $no_hp_penanggung_jawab=$row['no_hp_penanggung_jawab'];
                        $hubungan=$row['hubungan'];
                        $id_transaksi=$row['id_transaksi'];
                        $tanggal_masuk=$row['tanggal_masuk'];
                        $poli=$row['poli'];   
                        */
                        // if($darecord=="rawat_inap"){
                        $dokter_pengirim=$row['dokter_'.$darecord];
                        // }else{
                        // $dokter_pengirim=$row['dokter'];
                        // }
                        $sqlcek3 = mysqli_query($koneksi,"select * from data_dokter WHERE id_dokter='$dokter_pengirim'");
                        while ($row3=mysqli_fetch_array($sqlcek3)){
                        $nama_dokter=$row3['nama_dokter'];
                        $nama_poli=$row3['specialist'];
                        }
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses URL Tidak Valid');
                            document.location='<?php print_link(""); ?>';
                        </script>
                        <?php }                                 
                        $dokter=$dokter_pengirim;                                
                        }
                        ?>
                    </div>
                    <script>
                        $(document).ready(function() {
                        <?php 
                        $cekpol=0;
                        $valid=0;
                        $querybp = mysqli_query($koneksi, "SELECT * FROM `data_poli`")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        while ($rowp=mysqli_fetch_array($querybp)){
                        $id_poli=$rowp['id_poli'];
                        $cekpol=$cekpol + 1;
                        if($id_poli==$poli){
                        $valid=$cekpol;
                        }
                        }
                        ?>
                        $('#ctrl-kontrol').on('change', function(){ 
                        //do something like 
                        //$(this).hide(); 
                        //$(#anotherfieldid).show();
                        var ctrlVal = $(this).val();
                        //$(#anotherfieldname).val(ctrlVal)
                        //  var kn = $('#ctrl-kontrol').val();
                        if(ctrlVal=="YA"){
                        document.getElementById("ctrl-tanggal_kontrol").disabled = false;
                        }else{
                        document.getElementById("ctrl-tanggal_kontrol").disabled = true;
                        }
                        });
                        //document.getElementById("ctrl-tanggal_kontrol").disabled = true;
                        document.getElementById("ctrl-poli").selectedIndex = "<?php echo $valid;?>";
                        });
                        function validateijin() { 
                        //var kas = $('#ctrl-kas_awal').val();
                        var ket = $('#ctrl-keterangan').val();
                        var kn = $('#ctrl-kontrol').val();
                        var ttd = $('#ctrl-ttd').val();
                        var tglk = $('#ctrl-tanggal_kontrol').val();
                        var cpoli = $('#ctrl-poli').val();
                        var cdok = $('#ctrl-dokter').val();
                        if(ttd==""){
                        // document.getElementById("ctrl-kontrol").focus();
                        alert("Silahkan TTD Dokter Dahulu!!");
                        return false;
                        }
                        if(ket==""){
                        document.getElementById("ctrl-keterangan").focus();
                        alert("Silahkan isi Keterangan!!");
                        return false;
                        }
                        if(kn==""){
                        document.getElementById("ctrl-kontrol").focus();
                        alert("Silahkan Pilih Kontrol Ya/Tidak");
                        return false;
                        }
                        if(kn=="YA"){   
                        document.getElementById("ctrl-tanggal_kontrol").disabled = false;
                        document.getElementById("ctrl-tanggal_kontrol").focus();
                        if(tglk==""){
                        alert("Silahkan Pilih Tanggal Kontrol");
                        return false;
                        }
                        if(cpoli==""){
                        alert("Silahkan Pilih Poli");
                        document.getElementById("ctrl-poli").focus();
                        return false;
                        }           
                        if(cdok==""){
                        alert("Silahkan Pilih Dokter");
                        document.getElementById("ctrl-dokter").focus();
                        return false;
                        }       
                        }
                        confirmsubmit();
                        }
                        function confirmsubmit() { 
                        var result = confirm("Proses ijin Pulang?");
                        if (result == true) {
                        document.getElementById("ijin_pulang-add-form").submit();
                        return true;
                        }
                        else {
                        return false;
                        }
                        }
                    </script></div>
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
                    <div class=""><div id="page-report-body" class="">
                        <table class="table table-hover table-borderless table-striped">
                            <!-- Table Body Start -->
                            <tbody class="page-data" id="page-data">
                                <tr  class="td-tanggal_masuk">
                                    <th class="title"> Tanggal Masuk: </th>
                                    <td class="value"> <?php echo $row['tanggal_masuk']; ?></td>
                                </tr>
                                <tr  class="td-no_rekam_medis">
                                    <th class="title"> No Rekam Medis: </th>
                                    <td class="value"> <?php echo $row['no_rekam_medis']; ?></td>
                                </tr>
                                <tr  class="td-nama_pasien">
                                    <th class="title"> Nama Pasien: </th>
                                    <td class="value"> <?php echo $row['nama_pasien']; ?></td>
                                </tr>
                                <tr  class="td-alamat">
                                    <th class="title"> Alamat: </th>
                                    <td class="value"> <?php echo $row['alamat']; ?></td>
                                </tr>
                                <tr  class="td-tanggal_lahir">
                                    <th class="title"> Tanggal Lahir: </th>
                                    <td class="value"> <?php echo $row['tanggal_lahir']; ?></td>
                                </tr>
                                <tr  class="td-jenis_kelamin">
                                    <th class="title"> Jenis Kelamin: </th>
                                    <td class="value"> <?php echo $row['jenis_kelamin']; ?></td>
                                </tr>
                                <tr  class="td-nama_kamar">
                                    <th class="title"> Nama Kamar: </th>
                                    <td class="value"> <?php 
                                        if($darecord=="rawat_inap"){
                                        $namakamar="nama_kamar_ranap";
                                        }else {
                                        $namakamar="nama_kamar_".$darecord;
                                        }
                                        $querybn = mysqli_query($koneksi, "select * from $namakamar WHERE id='".$row['nama_kamar']."'")
                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                        $rowsbn = mysqli_num_rows($querybn);
                                        if ($rowsbn <> 0) {
                                        $rown   = mysqli_fetch_assoc($querybn); 
                                        $nmkr=$rown['nama_kamar'];
                                        }                
                                    echo $nmkr; ?></td>
                                </tr>
                                <tr  class="td-no_kamar">
                                    <th class="title"> No Kamar: </th>
                                    <td class="value"> <?php echo $row['no_kamar']; ?></td>
                                </tr>
                                <tr  class="td-no_ranjang">
                                    <th class="title"> No Ranjang: </th>
                                    <td class="value"> <?php echo $row['no_ranjang']; ?></td>
                                </tr>
                            </tbody>
                            <!-- Table Body End -->
                        </table>
                    </div></div>
                    <?php $this :: display_page_errors(); ?>
                    <div  class="bg-light p-3 animated fadeIn page-content">
                        <form id="ijin_pulang-add-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("ijin_pulang/add?csrf_token=$csrf_token") ?>" method="post">
                            <div>
                                <input id="ctrl-id_daftar"  value="<?php echo $id_daftar;?>" type="hidden" placeholder="Enter Id Daftar"  required="" name="id_daftar"  class="form-control " />
                                    <input value="<?php echo $darecord;?>" type="hidden"  required="" name="darecord"/> 
                                        <input value="<?php echo $id_transaksi;?>" type="hidden"  required="" name="id_transaksi"/>         
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label class="control-label" for="tanggal">Tanggal Pulang <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="input-group">
                                                            <input id="ctrl-tanggal" class="form-control datepicker  datepicker"  required="" value="<?php  echo $this->set_field_value('tanggal',date_now()); ?>" type="datetime" name="tanggal" placeholder="Enter Tanggal Pulang" data-enable-time="false" data-min-date="" data-max-date="" data-date-format="Y-m-d" data-alt-format="F j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <input id="ctrl-nama_pasien"  value="<?php echo $nama_pasien;?>" type="hidden" placeholder="Enter Nama Pasien"  required="" name="nama_pasien"  class="form-control " />
                                                    <input id="ctrl-no_rekam_medis"  value="<?php echo $no_rekam_medis;?>" type="hidden" placeholder="Enter No Rekam Medis"  required="" name="no_rekam_medis"  class="form-control " />
                                                        <input id="ctrl-jenis_kelamin"  value="<?php echo $jenis_kelamin;?>" type="hidden" placeholder="Enter Jenis Kelamin"  required="" name="jenis_kelamin"  class="form-control " />
                                                            <input id="ctrl-alamat"  value="<?php echo $alamat;?>" type="hidden" placeholder="Enter Alamat"  required="" name="alamat"  class="form-control " />
                                                                <div class="form-group ">
                                                                    <div class="row">
                                                                        <div class="col-sm-4">
                                                                            <label class="control-label" for="keterangan">Keterangan <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-sm-8">
                                                                            <div class="">
                                                                                <textarea placeholder="Enter Keterangan" id="ctrl-keterangan"  required="" rows="5" name="keterangan" class=" form-control"><?php  echo $this->set_field_value('keterangan',""); ?></textarea>
                                                                                <!--<div class="invalid-feedback animated bounceIn text-center">Please enter text</div>-->
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group ">
                                                                    <div class="row">
                                                                        <div class="col-sm-4">
                                                                            <label class="control-label" for="ttd">Ttd <span class="text-danger">*</span></label>
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
                                                                                if(!empty($_GET['darecord'])){
                                                                                $darecord=$_GET['darecord'];
                                                                                }else{
                                                                                $darecord="";
                                                                                }
                                                                                if(!empty($_GET['datprecord'])){
                                                                                $datprecord=$_GET['datprecord'];
                                                                                }else{
                                                                                $datprecord="";
                                                                                }      
                                                                                if($ttddok==""){?>
                                                                                <a class="btn btn-sm btn-primary has-tooltip page-modal" href="<?php  print_link("ttd/add?precord=$no_rekam_medis&datdari=ijin_pulang&ttd=Dokter&datprecord=$datprecord&darecord=$darecord");?>"> Buat TTD Digital</a>   
                                                                                <?php }else{ echo "TTD Dokter Sudah Di Input"; }?>                                                  
                                                                                <input id="ctrl-ttd"  value="<?php  echo $this->set_field_value('ttd',"$ttddok"); ?>" type="hidden" placeholder="Enter Ttd"  required="" name="ttd"  class="form-control " />
                                                                                </div>
                                                                                <?php   if($ttddok==""){?>  <small class="form-text"><span class="text-danger">* isi TTD Dahulu</span></small><?php }?>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <input id="ctrl-kamar_kelas"  value="<?php echo $kamar_kelas;?>" type="hidden" placeholder="Enter Kamar Kelas"  name="kamar_kelas"  class="form-control " />
                                                                        <input id="ctrl-nama_kamar"  value="<?php echo $nama_kamar;?>" type="hidden" placeholder="Enter Nama Kamar"  name="nama_kamar"  class="form-control " />
                                                                            <input id="ctrl-no_kamar"  value="<?php echo $no_kamar;?>" type="hidden" placeholder="Enter No Kamar"  name="no_kamar"  class="form-control " />
                                                                                <input id="ctrl-no_ranjang"  value="<?php echo $no_ranjang;?>" type="hidden" placeholder="Enter No Ranjang"  name="no_ranjang"  class="form-control " />
                                                                                    <div class="form-group ">
                                                                                        <div class="row">
                                                                                            <div class="col-sm-4">
                                                                                                <label class="control-label" for="kontrol">Kontrol <span class="text-danger">*</span></label>
                                                                                            </div>
                                                                                            <div class="col-sm-8">
                                                                                                <div class="">
                                                                                                    <select required=""  id="ctrl-kontrol" name="kontrol"  placeholder="Select a value ..."    class="custom-select" >
                                                                                                        <option value="">Select a value ...</option>
                                                                                                        <?php
                                                                                                        $kontrol_options = Menu :: $kontrol;
                                                                                                        if(!empty($kontrol_options)){
                                                                                                        foreach($kontrol_options as $option){
                                                                                                        $value = $option['value'];
                                                                                                        $label = $option['label'];
                                                                                                        $selected = $this->set_field_selected('kontrol', $value, "");
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
                                                                                                <label class="control-label" for="tanggal_kontrol">Tanggal Kontrol </label>
                                                                                            </div>
                                                                                            <div class="col-sm-8">
                                                                                                <div class="input-group">
                                                                                                    <input id="ctrl-tanggal_kontrol" class="form-control datepicker  datepicker"  value="<?php  echo $this->set_field_value('tanggal_kontrol',""); ?>" type="datetime" name="tanggal_kontrol" placeholder="Enter Tanggal Kontrol" data-enable-time="false" data-min-date="<?php echo date('Y-m-d', strtotime('+3day')); ?>" data-max-date="" data-date-format="Y-m-d" data-alt-format="F j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
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
                                                                                                    <label class="control-label" for="poli">Poli </label>
                                                                                                </div>
                                                                                                <div class="col-sm-8">
                                                                                                    <div class="">
                                                                                                        <select  id="ctrl-poli" data-load-select-options="dokter" name="poli"  placeholder="Select a value ..."    class="custom-select" >
                                                                                                            <option value="">Select a value ...</option>
                                                                                                            <?php 
                                                                                                            $poli_options = $comp_model -> ijin_pulang_poli_option_list();
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
                                                                                                    <label class="control-label" for="dokter">Dokter </label>
                                                                                                </div>
                                                                                                <div class="col-sm-8">
                                                                                                    <div class="">
                                                                                                        <select  id="ctrl-dokter" data-load-path="<?php print_link('api/json/ijin_pulang_dokter_option_list') ?>" name="dokter"  placeholder="Select a value ..."    class="custom-select" >
                                                                                                            <option value="">Select a value ...</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>                                                           
                                                                                    </div>
                                                                                    <div class="form-group form-submit-btn-holder text-center mt-3">
                                                                                        <div class="form-ajax-status"></div>
                                                                                        <button class="btn btn-primary" type="button" onclick="validateijin();">
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
