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
                    <h4 class="record-title">Add New Ranap Perina</h4>
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
                    <div class=""> <?php
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
                        $queryb = mysqli_query($koneksi, "select * from ranap_perina WHERE id='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        // ambil jumlah baris data hasil query
                        $rowsb = mysqli_num_rows($queryb);
                        if ($rowsb <> 0) {
                        $row   = mysqli_fetch_assoc($queryb); 
                        $id_igd=$row['id_igd'];
                        $id_poli=$row['id_poli'];
                        $no_rekam_medis=$row['no_rekam_medis'];
                        $nama_pasien=$row['nama_pasien'];
                        $alamat=$row['alamat'];
                        $no_hp=$row['no_hp'];
                        $tanggal_lahir=$row['tanggal_lahir'];
                        $jenis_kelamin=$row['jenis_kelamin'];
                        $email=$row['email'];
                        $umur=$row['umur'];
                        $no_ktp=$row['no_ktp'];
                        $tanggal_masuk=$row['tanggal_masuk'];
                        // $tensi=$row['tensi'];
                        $dokter=$row['dokter_ranap_perina'];
                        // $keluhan=$row['keluhan'];
                        //$nama_poli=$row['nama_poli'];
                        //$id_pendaftaran_poli=$row['id_pendaftaran_poli'];
                        //$pasien=$row['Pasien'];
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
                        /////////////////////////////////////////////////////////////    
                        if(isset($_POST['setatus'])){
                        $idpost = $_POST['precod'];
                        $id_igd = $_POST['id_igd'];
                        $id_poli = $_POST['id_poli'];
                        $sqlcek3 = mysqli_query($koneksi,"select * from ranap_perina WHERE id='$idpost'");
                        while ($row3=mysqli_fetch_array($sqlcek3)){
                        $no_rekam_medis=$row3['no_rekam_medis'];
                        }  
                        if($id_igd==0) { }else{
                        mysqli_query($koneksi,"UPDATE igd SET setatus='Closed' WHERE id_igd='$id_igd'");
                        mysqli_query($koneksi,"UPDATE data_rm SET setatus='Closed' WHERE id_daftar='$id_igd' and no_rekam_medis='$no_rekam_medis'");
                        }
                        if($id_poli==0) { }else{
                        mysqli_query($koneksi,"UPDATE pendaftaran_poli SET setatus='Closed' WHERE id_pendaftaran_poli='$id_poli'");
                        mysqli_query($koneksi,"UPDATE data_rm SET setatus='Closed' WHERE id_daftar='$id_poli' and no_rekam_medis='$no_rekam_medis'");
                        }
                        mysqli_query($koneksi,"UPDATE ranap_perina SET setatus='Chekin' WHERE id='$idpost'");
                        ?>
                        <script language="JavaScript">
                            alert('Chekin Pasien RANAP PERINA Berhasil!!');
                            document.location='<?php print_link("ranap_perina"); ?>';
                        </script>
                        <?php 
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses Add Langsung');
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
                                                RANAP PERINA
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
                    <form id="ranap_perina-chekin-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("ranap_perina/chekin?csrf_token=$csrf_token") ?>" method="post">
                        <input type="hidden" name="precod" value="<?php echo $original_plaintext;?>"/>
                            <div>
                                <input id="ctrl-id_igd"  value="<?php echo $id_igd;?>" type="hidden" placeholder="Enter Id Igd"  required="" name="id_igd"  class="form-control " />
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="setatus">Setatus <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <input id="ctrl-setatus"  value="<?php  echo $this->set_field_value('setatus',"Chekin"); ?>" type="text" placeholder="Enter Setatus"  readonly required="" name="setatus"  class="form-control " />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input id="ctrl-pasien"  value="<?php  echo $this->set_field_value('pasien',""); ?>" type="hidden" placeholder="Enter Pasien"  required="" name="pasien"  class="form-control " />
                                            <input id="ctrl-id_poli"  value="<?php echo $id_poli;?>" type="hidden" placeholder="Enter Id Poli"  required="" name="id_poli"  class="form-control " />
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
