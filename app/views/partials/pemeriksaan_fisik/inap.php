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
                    <h4 class="record-title">Add New Pemeriksaan Fisik <?php echo $_GET['datfrom'];?></h4>
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
                        $datfrom=$_GET['datfrom'];
                        if($datfrom=="RANAP"){
                        $queryb = mysqli_query($koneksi, "select * from rawat_inap WHERE id='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        }else  if($datfrom=="RANAP ANAK"){
                        $queryb = mysqli_query($koneksi, "select * from ranap_anak WHERE id='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        }else  if($datfrom=="RANAP BERSALIN"){
                        $queryb = mysqli_query($koneksi, "select * from ranap_bersalin WHERE id='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        }else{
                        $queryb = mysqli_query($koneksi, "select * from ranap_perina WHERE id='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        }
                        $pasien=$datfrom;
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
                        if($datfrom=="RANAP"){
                        $dokter_pengirim=$row['dokter_rawat_inap'];
                        }else if($datfrom=="RANAP ANAK"){
                        $dokter_pengirim=$row['dokter_ranap_anak'];
                        }else if($datfrom=="RANAP BERSALIN"){
                        $dokter_pengirim=$row['dokter_ranap_bersalin'];
                        }if($datfrom=="RANAP PERINA"){
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
                                    if($datfrom=="RANAP"){
                                    $namakamar="nama_kamar_ranap";
                                    }else if($datfrom=="RANAP ANAK"){
                                    $namakamar="nama_kamar_ranap_anak";
                                    }else if($datfrom=="RANAP BERSALIN"){
                                    $namakamar="nama_kamar_ranap_bersalin";
                                    }else if($datfrom=="RANAP PERINA"){
                                    $namakamar="nama_kamar_ranap_perina";
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
                    <form id="pemeriksaan_fisik-inap-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("pemeriksaan_fisik/inap?csrf_token=$csrf_token") ?>" method="post">
                        <div>
                            <input id="ctrl-tanggal"  value="<?php echo $tanggal_masuk;?>" type="hidden" placeholder="Enter Tanggal"  required="" name="tanggal"  class="form-control " />
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="keluhan">Keluhan <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="ctrl-keluhan"  value="<?php  echo $this->set_field_value('keluhan',""); ?>" type="text" placeholder="Enter Keluhan"  required="" name="keluhan"  class="form-control " />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                                                <label class="control-label" for="SH">SH </label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <div class="">
                                                                    <input id="ctrl-SH"  value="<?php  echo $this->set_field_value('SH',""); ?>" type="text" placeholder="Enter SH"  name="SH"  class="form-control " />
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
                                                                        <label class="control-label" for="LILA">LLA </label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <div class="">
                                                                            <input id="ctrl-LILA"  value="<?php  echo $this->set_field_value('LILA',""); ?>" type="text" placeholder="Enter LLA"  name="LILA"  class="form-control " />
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
                                                                                <label class="control-label" for="ND">ND </label>
                                                                            </div>
                                                                            <div class="col-sm-8">
                                                                                <div class="">
                                                                                    <input id="ctrl-ND"  value="<?php  echo $this->set_field_value('ND',""); ?>" type="text" placeholder="Enter ND"  name="ND"  class="form-control " />
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
                                                                                        <input id="ctrl-SPO"  value="<?php  echo $this->set_field_value('SPO',""); ?>" type="text" placeholder="Enter SPO2"  name="SPO"  class="form-control " />
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
                                                                                                <label class="control-label" for="riwayat_SCOP">Riwayat SOP </label>
                                                                                            </div>
                                                                                            <div class="col-sm-8">
                                                                                                <div class="">
                                                                                                    <input id="ctrl-riwayat_SCOP"  value="<?php  echo $this->set_field_value('riwayat_SCOP',""); ?>" type="text" placeholder="Enter Riwayat SOP"  name="riwayat_SCOP"  class="form-control " />
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group ">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-4">
                                                                                                    <label class="control-label" for="riwayat_penyakit">Riwayat Penyakit <span class="text-danger">*</span></label>
                                                                                                </div>
                                                                                                <div class="col-sm-8">
                                                                                                    <div class="">
                                                                                                        <input id="ctrl-riwayat_penyakit"  value="<?php  echo $this->set_field_value('riwayat_penyakit',""); ?>" type="text" placeholder="Enter Riwayat Penyakit"  required="" name="riwayat_penyakit"  class="form-control " />
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group ">
                                                                                                <div class="row">
                                                                                                    <div class="col-sm-4">
                                                                                                        <label class="control-label" for="EKG">Ekg </label>
                                                                                                    </div>
                                                                                                    <div class="col-sm-8">
                                                                                                        <div class="">
                                                                                                            <div class="dropzone " input="#ctrl-EKG" fieldname="EKG"    data-multiple="false" dropmsg="Choose files or drag and drop files to upload"    btntext="Browse" extensions=".jpg,.png,.gif,.jpeg" filesize="30" maximum="5">
                                                                                                                <input name="EKG" id="ctrl-EKG" class="dropzone-input form-control" value="<?php  echo $this->set_field_value('EKG',""); ?>" type="text"  />
                                                                                                                    <!--<div class="invalid-feedback animated bounceIn text-center">Please a choose file</div>-->
                                                                                                                    <div class="dz-file-limit animated bounceIn text-center text-danger"></div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group ">
                                                                                                    <div class="row">
                                                                                                        <div class="col-sm-4">
                                                                                                            <label class="control-label" for="CTG">Ctg </label>
                                                                                                        </div>
                                                                                                        <div class="col-sm-8">
                                                                                                            <div class="">
                                                                                                                <div class="dropzone " input="#ctrl-CTG" fieldname="CTG"    data-multiple="false" dropmsg="Choose files or drag and drop files to upload"    btntext="Browse" extensions=".jpg,.png,.gif,.jpeg" filesize="30" maximum="5">
                                                                                                                    <input name="CTG" id="ctrl-CTG" class="dropzone-input form-control" value="<?php  echo $this->set_field_value('CTG',""); ?>" type="text"  />
                                                                                                                        <!--<div class="invalid-feedback animated bounceIn text-center">Please a choose file</div>-->
                                                                                                                        <div class="dz-file-limit animated bounceIn text-center text-danger"></div>
                                                                                                                    </div>
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
                                                                                                                            <input id="ctrl-pasien"  value="<?php echo $pasien;?>" type="hidden" placeholder="Enter Pasien"  required="" name="pasien"  class="form-control " />
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
