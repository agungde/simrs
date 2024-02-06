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
                        }
                        if(!empty($_GET['ttdok'])){
                        $original_plaintext=$_GET['datprecord'];
                        }
                        $id_daftar=$original_plaintext;
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
                        }
                        ?>
                    </div>
                </div><h4 class="record-title">Add New Assesment Triase <?php echo $nama_pasien;?></h4>
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
                <div class=" ">
                    <?php  
                    $this->render_page("igd/triase/$_GET[datprecord]"); 
                    ?>
                </div>
                <?php $this :: display_page_errors(); ?>
                <div  class="bg-light p-3 animated fadeIn page-content">
                    <form id="assesment_triase-add-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("assesment_triase/add?csrf_token=$csrf_token") ?>" method="post">
                        <div>
                            <input id="ctrl-no_rekam_medis"  value="<?php echo $no_rekam_medis;?>" type="hidden" placeholder="Enter No Rekam Medis"  required="" name="no_rekam_medis"  class="form-control " />
                                <input id="ctrl-nama_pasien"  value="<?php echo $nama_pasien;?>" type="hidden" placeholder="Enter Nama Pasien"  required="" name="nama_pasien"  class="form-control " />
                                    <input id="ctrl-alamat"  value="<?php echo $alamat;?>" type="hidden" placeholder="Enter Alamat"  required="" name="alamat"  class="form-control " />
                                        <input id="ctrl-jenis_kelamin"  value="<?php echo $jenis_kelamin;?>" type="hidden" placeholder="Enter Jenis Kelamin"  required="" name="jenis_kelamin"  class="form-control " />
                                            <input id="ctrl-tgl_lahir"  value="<?php echo $tanggal_lahir;?>" type="hidden" placeholder="Enter Tgl Lahir"  required="" name="tgl_lahir"  class="form-control " />
                                                <input id="ctrl-umur"  value="<?php echo $umur;?>" type="hidden" placeholder="Enter Umur"  required="" name="umur"  class="form-control " />
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label class="control-label" for="keadaan_ke_igd">Keadaan Ke Igd <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <div class="">
                                                                    <input id="ctrl-keadaan_ke_igd"  value="<?php  echo $this->set_field_value('keadaan_ke_igd',""); ?>" type="text" placeholder="Enter Keadaan Ke Igd"  required="" name="keadaan_ke_igd"  class="form-control " />
                                                                    </div>
                                                                    <small class="form-text">Sendiri/ Keluarga / Polisi / Lainnya</small>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label class="control-label" for="rujukan_dari">Rujukan Dari </label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <div class="">
                                                                        <input id="ctrl-rujukan_dari"  value="<?php  echo $this->set_field_value('rujukan_dari',""); ?>" type="text" placeholder="Enter Rujukan Dari"  name="rujukan_dari"  class="form-control " />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group ">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" for="tgl_rujukan">Tgl Rujukan </label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <div class="input-group">
                                                                            <input id="ctrl-tgl_rujukan" class="form-control datepicker  datepicker"  value="<?php  echo $this->set_field_value('tgl_rujukan',""); ?>" type="datetime" name="tgl_rujukan" placeholder="Enter Tgl Rujukan" data-enable-time="false" data-min-date="" data-max-date="" data-date-format="Y-m-d" data-alt-format="F j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
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
                                                                            <label class="control-label" for="org_yg_bisa_di_hub">Org Yg Bisa Di Hub <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-sm-8">
                                                                            <div class="">
                                                                                <input id="ctrl-org_yg_bisa_di_hub"  value="<?php echo $penanggung_jawab;?>" type="text" placeholder="Enter Org Yg Bisa Di Hub"  required="" name="org_yg_bisa_di_hub"  class="form-control " />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group ">
                                                                        <div class="row">
                                                                            <div class="col-sm-4">
                                                                                <label class="control-label" for="tgl_masuk">Tgl Masuk IGD <span class="text-danger">*</span></label>
                                                                            </div>
                                                                            <div class="col-sm-8">
                                                                                <div class="input-group">
                                                                                    <input id="ctrl-tgl_masuk" class="form-control datepicker  datepicker"  required="" value="<?php  echo $this->set_field_value('tgl_masuk',date_now()); ?>" type="datetime" name="tgl_masuk" placeholder="Enter Tgl Masuk IGD" data-enable-time="false" data-min-date="" data-max-date="" data-date-format="Y-m-d" data-alt-format="F j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
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
                                                                                    <label class="control-label" for="jam">Jam <span class="text-danger">*</span></label>
                                                                                </div>
                                                                                <div class="col-sm-8">
                                                                                    <div class="input-group">
                                                                                        <input id="ctrl-jam" class="form-control datepicker  datepicker"  required="" value="<?php  echo $this->set_field_value('jam',time_now()); ?>" type="time" name="jam" placeholder="Enter Jam" data-enable-time="true" data-min-date="" data-max-date=""  data-alt-format="H:i" data-date-format="H:i:S" data-inline="false" data-no-calendar="true" data-mode="single" /> 
                                                                                            <div class="input-group-append">
                                                                                                <span class="input-group-text"><i class="fa fa-clock"></i></span>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group ">
                                                                                <div class="row">
                                                                                    <div class="col-sm-4">
                                                                                        <label class="control-label" for="dokter_pemeriksa">Dokter Pemeriksa <span class="text-danger">*</span></label>
                                                                                    </div>
                                                                                    <div class="col-sm-8">
                                                                                        <div class="">
                                                                                            <input id="ctrl-dokter_pemeriksa"  value="<?php echo $nama_dokter;?>" type="text" placeholder="Enter Dokter Pemeriksa"  required="" name="dokter_pemeriksa"  class="form-control " />
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
                                                                                                $queryttd = mysqli_query($koneksi, "select * from ttd WHERE id_daftar='$original_plaintext' and no_rekam_medis='$no_rekam_medis'")
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
                                                                                                <input id="ctrl-ttd_dokter"  value="<?php  echo $this->set_field_value('ttd_dokter',"$ttddok"); ?>" type="hidden" placeholder="Enter Ttd Dokter"  required="" name="ttd_dokter"  class="form-control " />
                                                                                                    <?php
                                                                                                    if($ttddok==""){?>
                                                                                                    <a class="btn btn-sm btn-primary has-tooltip page-modal" href="<?php  print_link("ttd/add?precord=$no_rekam_medis&datdari=assesment_triase&ttd=Dokter&darecord=igd&datprecord=".$_GET['datprecord']);?>"> Buat TTD Digital</a>   
                                                                                                    <?php }else{ echo "TTD Dokter Sudah Di Input"; }?>                                                                                
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group ">
                                                                                        <div class="row">
                                                                                            <div class="col-sm-4">
                                                                                                <label class="control-label" for="level">Level <span class="text-danger">*</span></label>
                                                                                            </div>
                                                                                            <div class="col-sm-8">
                                                                                                <div class="">
                                                                                                    <table style="width:100%;" >
                                                                                                        <tr>
                                                                                                            <th>&nbsp;Pilih &nbsp;<th>&nbsp;KETERANGAN</th><th>&nbsp;RESPONSE TIME</th>   
                                                                                                            </tr>
                                                                                                            <tr>
                                                                                                                <td style="background-color: #DC143C"> 
                                                                                                                    <label class="containerchek">
                                                                                                                        <input value="1" type="checkbox" name="level[]" class="checkoption" required="">
                                                                                                                            <div class="checkmark"></div>
                                                                                                                        </label>
                                                                                                                    </td> <td>&nbsp;Resusitasi Segera</td>  <td>Segera</td>
                                                                                                                </tr>
                                                                                                                <tr>
                                                                                                                    <td style="background-color:  #FFFF00">
                                                                                                                        <label class="containerchek">
                                                                                                                            <input value="3" type="checkbox" name="level[]" class="checkoption" required="">
                                                                                                                                <div class="checkmark"></div>
                                                                                                                            </label>
                                                                                                                            </td> <td>&nbsp;Urgent/ Darurat / Tidak Gawat</td>  <td>30 menit
                                                                                                                        </tr> 
                                                                                                                        <tr>
                                                                                                                            <td style="background-color:   #7FFF00">
                                                                                                                                <label class="containerchek">
                                                                                                                                    <input value="4" type="checkbox" name="level[]" class="checkoption" required="">
                                                                                                                                        <div class="checkmark"></div>
                                                                                                                                    </label>
                                                                                                                                    </td> <td>&nbsp;Semi Darurat</td>  <td>60 Menit
                                                                                                                                </tr>  
                                                                                                                                <tr>
                                                                                                                                    <td style="background-color: #000">
                                                                                                                                        <label class="containerchek">
                                                                                                                                            <input value="6" type="checkbox" name="level[]" class="checkoption" required="">
                                                                                                                                                <div class="checkmarkb"></div>
                                                                                                                                            </label>
                                                                                                                                            </td> <td>&nbsp;Meninggal</td>  <td>&nbsp;
                                                                                                                                        </tr>   
                                                                                                                                    </table>                                                                   
                                                                                                                                </div>
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <div class="form-group ">
                                                                                                                        <div class="row">
                                                                                                                            <div class="col-sm-4">
                                                                                                                                <label class="control-label" for="ttd_petugas">Ttd Petugas <span class="text-danger">*</span></label>
                                                                                                                            </div>
                                                                                                                            <div class="col-sm-8">
                                                                                                                                <div class="">
                                                                                                                                    <input id="ctrl-ttd_petugas"  value="<?php  echo $this->set_field_value('ttd_petugas',"$ttdpet"); ?>" type="hidden" placeholder="Enter Ttd Petugas"  required="" name="ttd_petugas"  class="form-control " />
                                                                                                                                        <?php  if($ttdpet==""){?>                                                                                     
                                                                                                                                        <a class="btn btn-sm btn-primary has-tooltip page-modal" href="<?php  print_link("ttd/add?precord=$no_rekam_medis&datdari=assesment_triase&ttd=Petugas&darecord=igd&datprecord=".$_GET['datprecord']);?>"> Buat TTD Digital</a>                                                                                         
                                                                                                                                        <?php }else{ echo "TTD Petugas Sudah Di Input"; }?>                                                                                         
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
                                                                                                                    <style>
                                                                                                                        table, th, td {
                                                                                                                        border: 1px solid black;
                                                                                                                        border-collapse: collapse;
                                                                                                                        }
                                                                                                                        /* Hide the default checkbox */
                                                                                                                        .containerchek input {
                                                                                                                        display: none;
                                                                                                                        }
                                                                                                                        .containerchek {
                                                                                                                        display: block;
                                                                                                                        position: relative;
                                                                                                                        cursor: pointer;
                                                                                                                        font-size: 20px;
                                                                                                                        user-select: none;
                                                                                                                        -webkit-tap-highlight-color: transparent;
                                                                                                                        }
                                                                                                                        /* Create a custom checkbox */
                                                                                                                        .checkmark {
                                                                                                                        position: relative;
                                                                                                                        top: 0;
                                                                                                                        left: 0;
                                                                                                                        height: 1.3em;
                                                                                                                        width: 1.3em;
                                                                                                                        background-color: #2196F300;
                                                                                                                        border-radius: 0.25em;
                                                                                                                        transition: all 0.25s;
                                                                                                                        }
                                                                                                                        .checkmarkb {
                                                                                                                        position: relative;
                                                                                                                        top: 0;
                                                                                                                        left: 0;
                                                                                                                        height: 1.3em;
                                                                                                                        width: 1.3em;
                                                                                                                        background-color: #fffccc;
                                                                                                                        border-radius: 0.25em;
                                                                                                                        transition: all 0.25s;
                                                                                                                        }
                                                                                                                        /* When the checkbox is checked, add a blue background */
                                                                                                                        .containerchek input:checked ~ .checkmark {
                                                                                                                        background-color: #2196F3;
                                                                                                                        }
                                                                                                                        .containerchek input:checked ~ .checkmarkb {
                                                                                                                        background-color: #2196F3;
                                                                                                                        }
                                                                                                                        /* Create the checkmark/indicator (hidden when not checked) */
                                                                                                                        .checkmark:after {
                                                                                                                        content: "";
                                                                                                                        position: absolute;
                                                                                                                        transform: rotate(0deg);
                                                                                                                        border: 0.1em solid black;
                                                                                                                        left: 0;
                                                                                                                        top: 0;
                                                                                                                        width: 1.05em;
                                                                                                                        height: 1.05em;
                                                                                                                        border-radius: 0.25em;
                                                                                                                        transition: all 0.25s, border-width 0.1s;
                                                                                                                        }
                                                                                                                        .checkmarkb:after {
                                                                                                                        content: "";
                                                                                                                        position: absolute;
                                                                                                                        transform: rotate(0deg);
                                                                                                                        border: 0.1em solid black;
                                                                                                                        left: 0;
                                                                                                                        top: 0;
                                                                                                                        width: 1.05em;
                                                                                                                        height: 1.05em;
                                                                                                                        border-radius: 0.25em;
                                                                                                                        transition: all 0.25s, border-width 0.1s;
                                                                                                                        }
                                                                                                                        /* Show the checkmark when checked */
                                                                                                                        .containerchek input:checked ~ .checkmark:after {
                                                                                                                        left: 0.45em;
                                                                                                                        top: 0.25em;
                                                                                                                        width: 0.25em;
                                                                                                                        height: 0.5em;
                                                                                                                        border-color: #fff0 white white #fff0;
                                                                                                                        border-width: 0 0.15em 0.15em 0;
                                                                                                                        border-radius: 0em;
                                                                                                                        transform: rotate(45deg);
                                                                                                                        }
                                                                                                                        .containerchek input:checked ~ .checkmarkb:after {
                                                                                                                        left: 0.45em;
                                                                                                                        top: 0.25em;
                                                                                                                        width: 0.25em;
                                                                                                                        height: 0.5em;
                                                                                                                        border-color: #fff0 white white #fff0;
                                                                                                                        border-width: 0 0.15em 0.15em 0;
                                                                                                                        border-radius: 0em;
                                                                                                                        transform: rotate(45deg);
                                                                                                                        }
                                                                                                                    </style>
                                                                                                                    <script type="text/javascript">
                                                                                                                        $(document).ready(function(){
                                                                                                                        $('.checkoption').click(function() {
                                                                                                                        $('.checkoption').not(this).prop('checked', false);
                                                                                                                        });
                                                                                                                        });
                                                                                                                    </script> 
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </section>
