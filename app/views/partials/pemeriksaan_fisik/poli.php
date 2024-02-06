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
                    <h4 class="record-title">Add New Pemeriksaan Fisik POLI</h4>
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
                        }
                        if(!empty($_GET['backlink'])){
                        $original_plaintext=$_GET['datprecord'];
                        }
                        $id_daftar=$original_plaintext;
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
                        ?>
                    </div>
                </div>
                <div class=" ">
                    <?php  
                    $this->render_page("pendaftaran_poli/poli/$_GET[datprecord]"); 
                    ?>
                </div>
                <?php $this :: display_page_errors(); ?>
                <div  class="bg-light p-3 animated fadeIn page-content">
                    <form id="pemeriksaan_fisik-poli-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("pemeriksaan_fisik/poli?csrf_token=$csrf_token") ?>" method="post">
                        <div>
                            <input id="ctrl-tanggal"  value="<?php echo $tanggal_masuk;?>" type="hidden" placeholder="Enter Tanggal"  required="" name="tanggal"  class="form-control " />
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="TD">TD <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="ctrl-TD"  value="<?php  echo $this->set_field_value('TD',""); ?>" type="text" placeholder="Enter TD"  required="" name="TD"  class="form-control " />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="ND">ND <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <input id="ctrl-ND"  value="<?php  echo $this->set_field_value('ND',""); ?>" type="text" placeholder="Enter ND"  required="" name="ND"  class="form-control " />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="control-label" for="TB">TB </label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="">
                                                        <input id="ctrl-TB"  value="<?php  echo $this->set_field_value('TB',""); ?>" type="text" placeholder="Enter TB"  name="TB"  class="form-control " />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label class="control-label" for="SH">SH <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="">
                                                            <input id="ctrl-SH"  value="<?php  echo $this->set_field_value('SH',""); ?>" type="text" placeholder="Enter SH"  required="" name="SH"  class="form-control " />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label class="control-label" for="BB">BB </label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="">
                                                                <input id="ctrl-BB"  value="<?php  echo $this->set_field_value('BB',""); ?>" type="text" placeholder="Enter BB"  name="BB"  class="form-control " />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label class="control-label" for="RR">RR </label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <div class="">
                                                                    <input id="ctrl-RR"  value="<?php  echo $this->set_field_value('RR',""); ?>" type="text" placeholder="Enter RR"  name="RR"  class="form-control " />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label class="control-label" for="TFU">TFU </label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <div class="">
                                                                        <input id="ctrl-TFU"  value="<?php  echo $this->set_field_value('TFU',""); ?>" type="text" placeholder="Enter TFU"  name="TFU"  class="form-control " />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group ">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" for="LILA">LILA </label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <div class="">
                                                                            <input id="ctrl-LILA"  value="<?php  echo $this->set_field_value('LILA',""); ?>" type="text" placeholder="Enter LILA"  name="LILA"  class="form-control " />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group ">
                                                                    <div class="row">
                                                                        <div class="col-sm-4">
                                                                            <label class="control-label" for="HPHT">HPHT </label>
                                                                        </div>
                                                                        <div class="col-sm-8">
                                                                            <div class="">
                                                                                <input id="ctrl-HPHT"  value="<?php  echo $this->set_field_value('HPHT',""); ?>" type="text" placeholder="Enter HPHT"  name="HPHT"  class="form-control " />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group ">
                                                                        <div class="row">
                                                                            <div class="col-sm-4">
                                                                                <label class="control-label" for="SPO">SPO2 </label>
                                                                            </div>
                                                                            <div class="col-sm-8">
                                                                                <div class="">
                                                                                    <input id="ctrl-SPO"  value="<?php  echo $this->set_field_value('SPO',""); ?>" type="text" placeholder="Enter SPO22"  name="SPO"  class="form-control " />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group ">
                                                                            <div class="row">
                                                                                <div class="col-sm-4">
                                                                                    <label class="control-label" for="riwayat_batuk">Riwayat Batuk </label>
                                                                                </div>
                                                                                <div class="col-sm-8">
                                                                                    <div class="">
                                                                                        <input id="ctrl-riwayat_batuk"  value="<?php  echo $this->set_field_value('riwayat_batuk',""); ?>" type="text" placeholder="Enter Riwayat Batuk"  name="riwayat_batuk"  class="form-control " />
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group ">
                                                                                <div class="row">
                                                                                    <div class="col-sm-4">
                                                                                        <label class="control-label" for="riwayat_alergi">Riwayat Alergi </label>
                                                                                    </div>
                                                                                    <div class="col-sm-8">
                                                                                        <div class="">
                                                                                            <input id="ctrl-riwayat_alergi"  value="<?php  echo $this->set_field_value('riwayat_alergi',""); ?>" type="text" placeholder="Enter Riwayat Alergi"  name="riwayat_alergi"  class="form-control " />
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group ">
                                                                                    <div class="row">
                                                                                        <div class="col-sm-4">
                                                                                            <label class="control-label" for="riwayat_SCOP">Riwayat Scop </label>
                                                                                        </div>
                                                                                        <div class="col-sm-8">
                                                                                            <div class="">
                                                                                                <input id="ctrl-riwayat_SCOP"  value="<?php  echo $this->set_field_value('riwayat_SCOP',""); ?>" type="text" placeholder="Enter Riwayat Scop"  name="riwayat_SCOP"  class="form-control " />
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group ">
                                                                                        <div class="row">
                                                                                            <div class="col-sm-4">
                                                                                                <label class="control-label" for="riwayat_penyakit">Riwayat Penyakit </label>
                                                                                            </div>
                                                                                            <div class="col-sm-8">
                                                                                                <div class="">
                                                                                                    <input id="ctrl-riwayat_penyakit"  value="<?php  echo $this->set_field_value('riwayat_penyakit',""); ?>" type="text" placeholder="Enter Riwayat Penyakit"  name="riwayat_penyakit"  class="form-control " />
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
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
                                                                                            <input id="ctrl-nama_pasien"  value="<?php echo $nama_pasien;?>" type="hidden" placeholder="Enter Nama Pasien"  required="" name="nama_pasien"  class="form-control " />
                                                                                                <input id="ctrl-no_rekam_medis"  value="<?php echo $no_rekam_medis;?>" type="hidden" placeholder="Enter No Rekam Medis"  required="" name="no_rekam_medis"  class="form-control " />
                                                                                                    <input id="ctrl-jenis_kelamin"  value="<?php echo $jenis_kelamin;?>" type="hidden" placeholder="Enter Jenis Kelamin"  required="" name="jenis_kelamin"  class="form-control " />
                                                                                                        <input id="ctrl-alamat"  value="<?php echo $alamat;?>" type="hidden" placeholder="Enter Alamat"  required="" name="alamat"  class="form-control " />
                                                                                                            <input id="ctrl-tanggal_lahir"  value="<?php echo $tanggal_lahir;?>" type="hidden" placeholder="Enter Tanggal Lahir"  required="" name="tanggal_lahir"  class="form-control " />
                                                                                                                <input id="ctrl-id_daftar"  value="<?php echo $id_daftar;?>" type="hidden" placeholder="Enter Id Daftar"  required="" name="id_daftar"  class="form-control " />
                                                                                                                    <input id="ctrl-pasien"  value="<?php  echo $this->set_field_value('pasien',"POLI"); ?>" type="hidden" placeholder="Enter Pasien"  required="" name="pasien"  class="form-control " />
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
