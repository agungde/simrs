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
                    <h4 class="record-title">Proses Hasil Lab</h4>
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
                <div class="col-md-12 comp-grid">
                    <div class=""> <div>
                        <?php
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
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
                        $queryb = mysqli_query($koneksi, "select * from pendaftaran_lab WHERE id='$original_plaintext'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        // ambil jumlah baris data hasil query
                        $rowsb = mysqli_num_rows($queryb);
                        if ($rowsb <> 0) {
                        $row   = mysqli_fetch_assoc($queryb);
                        $no_rekam_medis=$row['no_rekam_medis'];
                        $nama_pasien=$row['nama_pasien'];
                        $alamat=$row['alamat'];
                        $no_hp=$row['no_hp'];
                        $tanggal=$row['tanggal'];
                        $dokter_pengirim=$row['dokter_pengirim'];
                        $nama_poli=$row['nama_poli'];
                        $keluhan=$row['keluhan'];
                        $pasien=$row['pasien'];
                        $jenis_pemeriksaan=$row['jenis_pemeriksaan'];
                        $nama_pemeriksaan=$row['nama_pemeriksaan'];
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses URL Tidak Valid');
                            document.location='<?php print_link(""); ?>';
                        </script>
                        <?php }
                        }else{
                        if(isset($_POST['precod'])){
                        $idpen=$_POST['precod'];
                        $dataid = $_POST['datid'];
                        $hasil = $_POST['hasil_pemeriksaan'];
                        for($a = 0; $a < count($hasil); $a++){ 
                        $hasils= trim($hasil[$a]);
                        $dataids= trim($dataid[$a]);
                        mysqli_query($koneksi,"UPDATE data_hasil_lab SET hasil_pemeriksaan='$hasils', date_updated='".date("Y-m-d H:i:s")."' WHERE id='$dataids'");
                        }
                        mysqli_query($koneksi,"UPDATE hasil_lab SET setatus='Closed', date_updated='".date("Y-m-d H:i:s")."' WHERE id_daftar_lab='$idpen'"); 
                        mysqli_query($koneksi,"UPDATE pendaftaran_lab SET setatus='Closed', date_updated='".date("Y-m-d H:i:s")."' WHERE id='$idpen'");   
                        ?>
                        <script language="JavaScript">
                            alert('Hasil Lab Berhasil Di Simpan');
                            document.location='<?php print_link("hasil_lab"); ?>';
                        </script>
                        <?php   
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
                    </div></div>
                    <?php $this :: display_page_errors(); ?>
                    <div  class="bg-light p-3 animated fadeIn page-content">
                        <div  class="bg-white p-1 animated fadeIn page-content">
                            <form id="hasil_lab-proses_lab-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("hasil_lab/proses_lab?csrf_token=$csrf_token") ?>" method="post">
                                <div>
                                    <table class="table table-hover table-borderless table-striped">
                                        <input type="hidden" name="precod" value="<?php echo $original_plaintext;?>"/>
                                            <input type="hidden" name="precodback" value="<?php echo $ciphertext;?>"/>
                                                <!-- Table Body Start -->
                                                <tbody class="page-data" id="page-data-view-page-amwxg0lkiqju">
                                                    <tr  class="td-tanggal">
                                                        <th class="title"> Tanggal: </th>
                                                        <td class="value">
                                                            <span >
                                                                <?php echo $tanggal;?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr  class="td-tanggal">
                                                        <th class="title"> Pasien: </th>
                                                        <td class="value">
                                                            <span >
                                                                <?php echo $pasien;?>
                                                            </span>
                                                        </td>
                                                    </tr>    
                                                    <tr  class="td-nama_poli">
                                                        <th class="title"> Nama Poli: </th>
                                                        <td class="value">
                                                            <span>
                                                                <?php echo $nama_poli;?>
                                                            </span>
                                                        </td>
                                                    </tr>                                    
                                                    <tr  class="td-no_rekam_medis">
                                                        <th class="title"> No Rekam Medis: </th>
                                                        <td class="value">
                                                            <span >
                                                                <?php echo $no_rekam_medis;?> 
                                                            </span>
                                                        </td>
                                                    </tr>                                    
                                                    <tr  class="td-nama_pasien">
                                                        <th class="title"> Nama Pasien: </th>
                                                        <td class="value">
                                                            <span >
                                                                <?php echo $nama_pasien;?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr  class="td-alamat">
                                                        <th class="title"> Alamat: </th>
                                                        <td class="value">
                                                            <span>
                                                                <?php echo $alamat;?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr  class="td-no_hp">
                                                        <th class="title"> No Hp: </th>
                                                        <td class="value">
                                                            <span>
                                                                <?php echo $no_hp;?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr  class="td-dokter_pemeriksa">
                                                        <th class="title"> Dokter Pengirim: </th>
                                                        <td class="value">
                                                            <span>
                                                                <?php echo $dokter_pengirim;?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr  class="td-keluhan">
                                                        <th class="title"> Keluhan: </th>
                                                        <td class="value">
                                                            <span>
                                                                <?php echo $keluhan;?>
                                                            </span>
                                                        </td>
                                                    </tr>                                    
                                                    <tr  class="td-jenis_pemeriksaan">
                                                        <th class="title"> Jenis Pemeriksaan: </th>
                                                        <td class="value">
                                                            <span>
                                                                <?php echo $jenis_pemeriksaan;?>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                    <tr  class="td-jenis_pemeriksaan">
                                                        <th class="title"> Nama Pemeriksaan: </th>
                                                        <td class="value">
                                                            <span>
                                                                <?php echo $nama_pemeriksaan;?>
                                                            </span>
                                                        </td>
                                                    </tr>                                  
                                                </tbody>
                                                <!-- Table Body End -->
                                            </table>                                
                                            <style type="text/css">
                                                hr {
                                                height: 10px;
                                                background-color: red;
                                                margin-right: auto;
                                                margin-left: auto;
                                                margin-top: 5px;
                                                margin-bottom: 5px;
                                                border-width: 2px;
                                                border-color: green;
                                                }
                                            </style>
                                            <table class="table table-striped table-sm" >
                                                <thead>
                                                    <tr><th class="bg-success"><label for="nama_pemeriksaan">Jenis Pemeriksaan</label></th>
                                                        <th class="bg-success"><label for="nama_pemeriksaan">Nama Pemeriksaan</label></th>
                                                        <th class="bg-success"><label for="hasil_pemeriksaan">Hasil Pemeriksaan</label></th>
                                                        <th class="bg-success"><label for="nilai_rujukan">Nilai Rujukan</label></th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    $Query = "SELECT * FROM data_hasil_lab WHERE id_daftar_lab='$original_plaintext'";
                                                    $ExecQuery = MySQLi_query($koneksi, $Query);
                                                    //$hitungrow = mysqli_num_rows($ExecQuery);
                                                    $b=1;
                                                    while ($Result = MySQLi_fetch_array($ExecQuery)) {
                                                    //for($b = 0; $b < $hitungrow; $b++){
                                                    ?>     
                                                    <input type="hidden" name="datid[]" value="<?php echo $Result['id'];?>"        
                                                        <tr class="input-row">
                                                            <td><?php echo $Result['jenis_pemeriksaan'];?></td>
                                                            <td>
                                                            <?php echo $Result['nama_pemeriksaan'];?></td>
                                                        </td>
                                                        <td>
                                                            <input id="ctrl-hasil_pemeriksaan"  type="text" placeholder="Enter Hasil Pemeriksaan"  required="" name="hasil_pemeriksaan[]"  class="form-control " />  
                                                        </td>
                                                        <td>
                                                        <?php echo $Result['nilai_rujukan'];?></td>
                                                    </td>
                                                </tr>
                                                <?php }?>                                     
                                            </tbody>
                                        </table>                                      
                                    </div>
                                    <div class="form-group form-submit-btn-holder text-center mt-3">
                                        <div class="form-ajax-status"></div>
                                        <button class="btn btn-primary" type="submit">
                                            Submit
                                            <i class="fa fa-send"></i>
                                        </button>
                                    </div>
                                </form>
                                <!--[table row template]-->
                                <!--[/table row template]-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
