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
                    <h4 class="record-title">Add New Perintah Opname</h4>
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
                        $this->render_page("igd/opname/$_GET[datprecord]"); 
                        ?>
                    </div>
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
                        $_SESSION['backlink']="$backlink";
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
                </div>
                <?php $this :: display_page_errors(); ?>
                <div  class="bg-light p-3 animated fadeIn page-content">
                    <form id="perintah_opname-add-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("perintah_opname/add?csrf_token=$csrf_token") ?>" method="post">
                        <div>
                            <input id="ctrl-tanggal"  value="<?php echo $tanggal_masuk;?>" type="hidden" placeholder="Enter Tanggal"  required="" name="tanggal"  class="form-control " />
                                <input id="ctrl-no_rekam_medis"  value="<?php echo $no_rekam_medis;?>" type="hidden" placeholder="Enter No Rekam Medis"  required="" name="no_rekam_medis"  class="form-control " />
                                    <input id="ctrl-nama_pasien"  value="<?php echo $nama_pasien;?>" type="hidden" placeholder="Enter Nama Pasien"  required="" name="nama_pasien"  class="form-control " />
                                        <input id="ctrl-jenis_kelamin"  value="<?php echo $jenis_kelamin;?>" type="hidden" placeholder="Enter Jenis Kelamin"  required="" name="jenis_kelamin"  class="form-control " />
                                            <input id="ctrl-alamat"  value="<?php echo $alamat;?>" type="hidden" placeholder="Enter Alamat"  required="" name="alamat"  class="form-control " />
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label class="control-label" for="diagnosa">Diagnosa <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="">
                                                                <select required="" data-endpoint="<?php print_link('api/json/perintah_opname_diagnosa_option_list') ?>" id="ctrl-diagnosa" name="diagnosa"  placeholder="Select a value ..."    class="selectize-ajax" >
                                                                    <option value="">Select a value ...</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label class="control-label" for="therapi">Therapi </label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="">
                                                                <input id="ctrl-therapi"  value="<?php  echo $this->set_field_value('therapi',""); ?>" type="text" placeholder="Enter Therapi"  name="therapi"  class="form-control " />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input id="ctrl-dokter_pemeriksa"  value="<?php echo $nama_dokter;?>" type="hidden" placeholder="Enter Dokter Pemeriksa"  required="" name="dokter_pemeriksa"  class="form-control " />
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
                                                                        if($ttddok==""){?>
                                                                        <a class="btn btn-sm btn-primary has-tooltip page-modal" href="<?php  print_link("ttd/add?precord=$no_rekam_medis&datdari=perintah_opname&ttd=Dokter&datprecord=".$_GET['datprecord']);?>"> Buat TTD Digital</a>   
                                                                        <?php }else{ echo "TTD Dokter Sudah Di Input"; }?>                                                               
                                                                        <input id="ctrl-ttd"  value="<?php  echo $this->set_field_value('ttd',"$ttddok"); ?>" type="hidden" placeholder="Enter Ttd"  required="" name="ttd"  class="form-control " />
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
