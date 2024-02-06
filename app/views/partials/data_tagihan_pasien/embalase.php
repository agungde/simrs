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
    <div  class=" p-2 mb-2">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Add New Data Tagihan Embalase</h4>
                    <div class=""><div>
                        <?php
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        //$koneksi=open_connection();
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
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
                        if (hash_equals($hmac, $calcmac))// timing attack safe comparison
                        {
                        // echo $original_plaintext."\n";
                        }
                        $id_data=$original_plaintext;
                        $id_transaksi=$original_plaintext;
                        $sql = mysqli_query($koneksi,"select * from transaksi WHERE id='$original_plaintext'");
                        $rows = mysqli_num_rows($sql);
                        if ($rows<> 0) {
                        $datt     = mysqli_fetch_assoc($sql);
                        $idtrx       = $datt['id']; 
                        $pasien       = $datt['pasien'];
                        $no_rekam_medis= $datt['no_rekam_medis'];
                        if($pasien=="IGD" ){
                        $sqli = mysqli_query($koneksi,"select * from rawat_inap WHERE id_transaksi='$original_plaintext'");
                        $rowsi = mysqli_num_rows($sqli);
                        if ($rowsi<> 0) {
                        $pasien="RAWAT INAP";
                        }
                        }
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses URL Tidak Valid');
                            document.location='<?php print_link("pendaftaran_poli"); ?>';
                        </script>
                        <?php } 
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
                    <form id="data_tagihan_pasien-embalase-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("data_tagihan_pasien/embalase?csrf_token=$csrf_token") ?>" method="post">
                        <div>
                            <input id="ctrl-id_data"  value="<?php echo $id_data;?>" type="hidden" placeholder="Enter Id Data"  required="" name="id_data"  class="form-control " />
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="nama_tagihan">Nama Tagihan <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="ctrl-nama_tagihan"  value="<?php  echo $this->set_field_value('nama_tagihan',"Tagihan Embalase"); ?>" type="text" placeholder="Enter Nama Tagihan"  readonly required="" name="nama_tagihan"  class="form-control " />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="control-label" for="tanggal">Tanggal <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input id="ctrl-tanggal" class="form-control datepicker  datepicker" required="" value="<?php  echo $this->set_field_value('tanggal',date_now()); ?>" type="datetime"  name="tanggal" placeholder="Enter Tanggal" data-enable-time="true" data-min-date="" data-max-date="" data-date-format="Y-m-d H:i:S" data-alt-format="F j, Y - H:i" data-inline="false" data-no-calendar="false" data-mode="single" /> 
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
                                                        <label class="control-label" for="total_tagihan">Total Tagihan <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="">
                                                            <input id="ctrl-total_tagihan"  value="<?php  echo $this->set_field_value('total_tagihan',""); ?>" type="number" placeholder="Enter Total Tagihan" step="1"  required="" name="total_tagihan"  class="form-control " />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label class="control-label" for="tagihan_r">Tambahan R <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="">
                                                                <input id="ctrl-tagihan_r"  value="" type="number" placeholder="Enter Tagihan R" step="1"  required="" name="tagihan_r"  class="form-control " />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>                            
                                                <input id="ctrl-no_rekam_medis"  value="<?php echo $no_rekam_medis;?>" type="hidden" placeholder="Enter No Rekam Medis"  required="" name="no_rekam_medis"  class="form-control " />
                                                    <input id="ctrl-setatus"  value="<?php  echo $this->set_field_value('setatus',"Register"); ?>" type="hidden" placeholder="Enter Setatus"  required="" name="setatus"  class="form-control " />
                                                        <input id="ctrl-id_transaksi"  value="<?php echo $id_transaksi;?>" type="hidden" placeholder="Enter Id Transaksi"  required="" name="id_transaksi"  class="form-control " />
                                                            <div class="form-group ">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" for="keterangan">Keterangan <span class="text-danger">*</span></label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <div class="">
                                                                            <input id="ctrl-keterangan"  value="<?php  echo $this->set_field_value('keterangan',"Tagihan Embalase"); ?>" type="text" placeholder="Enter Keterangan"  readonly required="" name="keterangan"  class="form-control " />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group form-submit-btn-holder text-center mt-3">
                                                                <div class="form-ajax-status"></div>
                                                                <button class="btn btn-primary" type="submit" onclick="setTimeout(function(){ window.location.reload();}, 1000);">
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
