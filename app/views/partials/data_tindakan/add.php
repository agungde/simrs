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
                    <h4 class="record-title">Add New Data Tindakan</h4>
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
                    <div class=""><?php
                        $linksite="".SITE_ADDR;
                        $usrnam  = "".USER_NAME;
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        $idtrace = "$id_user$usrnam";
                        if(!empty($_GET['precord'])){
                        $pasien=$_GET['pasien']; 
                        $ciphertext = $_GET['precord'];
                        $idback=$ciphertext;
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
                        if($pasien=="IGD") {
                        $queryb = mysqli_query($koneksi, "select * from igd WHERE id_igd='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        }else  if($pasien=="POLI") {
                        $queryb = mysqli_query($koneksi, "select * from pendaftaran_poli WHERE id_pendaftaran_poli='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        }else  if($pasien=="RAWAT INAP") {
                        $queryb = mysqli_query($koneksi, "select * from rawat_inap WHERE id='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));    
                        }else  if($pasien=="RANAP ANAK") {
                        $queryb = mysqli_query($koneksi, "select * from ranap_anak WHERE id='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));    
                        }else  if($pasien=="RANAP BERSALIN") {
                        $queryb = mysqli_query($koneksi, "select * from ranap_bersalin WHERE id='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));    
                        }else  if($pasien=="RANAP PERINA") {
                        $queryb = mysqli_query($koneksi, "select * from ranap_perina WHERE id='$original_plaintext'")
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
                        $no_ktp=$row['no_ktp'];
                        if($pasien=="POLI") {
                        $tanggal_masuk=$row['tanggal'];
                        }else{
                        $tanggal_masuk=$row['tanggal_masuk'];
                        }
                        // $tensi=$row['tensi'];
                        if($pasien=="IGD") {
                        $dokter=$row['dokter'];
                        }else  if($pasien=="POLI") {
                        $dokter=$row['dokter'];
                        }else  if($pasien=="RAWAT INAP") {
                        $dokter=$row['dokter_rawat_inap']; 
                        }else  if($pasien=="RANAP ANAK") {
                        $dokter=$row['dokter_ranap_anak']; 
                        }else  if($pasien=="RANAP BERSALIN") {
                        $dokter=$row['dokter_ranap_bersalin']; 
                        }else  if($pasien=="RANAP PERINA") {
                        $dokter=$row['dokter_ranap_perina']; 
                        }
                        // $keluhan=$row['keluhan'];
                        //$nama_poli=$row['nama_poli'];
                        //$id_pendaftaran_poli=$row['id_pendaftaran_poli'];
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses URL Tidak Valid');
                            document.location='<?php print_link(""); ?>';
                        </script>
                        <?php }
                        $sqlcek3 = mysqli_query($koneksi,"select * from data_dokter WHERE id_dokter='$dokter'");
                        while ($row3=mysqli_fetch_array($sqlcek3)){
                        $nama_dokter=$row3['nama_dokter'];
                        $nama_poli=$row3['specialist'];
                        }
                        }else{
                        if(isset($_POST['pasien'])){
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses URL Tidak Valid');
                            document.location='<?php print_link(""); ?>';
                        </script>
                        <?php  
                        }
                        }
                        ?>
                        <div id="page-report-body" class="table-responsive">
                            <table class=" bg-white">
                                <tr><td>
                                    <table >
                                        <tr >
                                            <th align="left"> Tanggal Masuk: </th>
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
                                            <th align="left">Dokter: </th>
                                            <td >
                                                <?php echo $nama_dokter; ?> 
                                            </td>
                                        </tr>    
                                        <tr>
                                            <th align="left">Pasien: </th>
                                            <td >
                                                <?php echo $pasien;?>
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
                </div>
                <?php $this :: display_page_errors(); ?>
                <div  class="bg-light p-3 animated fadeIn page-content">
                    <form id="data_tindakan-add-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("data_tindakan/add?csrf_token=$csrf_token") ?>" method="post">
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
                                <input id="ctrl-no_rekam_medis"  value="<?php echo $no_rekam_medis;?>" type="hidden" placeholder="Enter No Rekam Medis"  readonly required="" name="no_rekam_medis"  class="form-control " />
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
                                                    <label class="control-label" for="tindakan">Tindakan <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="">
                                                        <select required="" data-endpoint="<?php print_link('api/json/data_tindakan_tindakan_option_list') ?>" id="ctrl-tindakan" name="tindakan[]"  placeholder="Select a value ..." multiple   class="selectize-ajax" >
                                                            <option value="">Select a value ...</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input id="ctrl-id_daftar"  value="<?php echo $original_plaintext;?>" type="hidden" placeholder="Enter Id Daftar"  name="id_daftar"  class="form-control " />
                                            <input id="ctrl-dokter_pemeriksa"  value="<?php echo $nama_dokter;?>" type="hidden" placeholder="Enter Dokter Pemeriksa"  required="" name="dokter_pemeriksa"  class="form-control " />
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
