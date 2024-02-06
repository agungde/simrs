<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("kunjungan_dokter/add");
$can_edit = ACL::is_allowed("kunjungan_dokter/edit");
$can_view = ACL::is_allowed("kunjungan_dokter/view");
$can_delete = ACL::is_allowed("kunjungan_dokter/delete");
?>
<?php
$comp_model = new SharedController;
$page_element_id = "list-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
//Page Data From Controller
$view_data = $this->view_data;
$records = $view_data->records;
$record_count = $view_data->record_count;
$total_records = $view_data->total_records;
$field_name = $this->route->field_name;
$field_value = $this->route->field_value;
$view_title = $this->view_title;
$show_header = $this->show_header;
$show_footer = $this->show_footer;
$show_pagination = $this->show_pagination;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="list"  data-display-type="table" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-light p-3 mb-3">
        <div class="container-fluid">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Kunjungan Dokter</h4>
                </div>
            </div>
        </div>
    </div>
    <?php
    }
    ?>
    <div  class="">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-md-12 comp-grid">
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
                            // alert('Dilarang Akses URL Tidak Valid');
                            // document.location='<?php print_link(""); ?>';
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
                            // alert('Dilarang Akses URL Tidak Valid');
                            //  document.location='<?php print_link(""); ?>';
                        </script>
                        <?php }                                 
                        $dokter=$dokter_pengirim;                                
                        }
                        ?>
                    </div>
                    <?php
                    if(!empty($_GET['precord'])){
                    ?>
                    <div id="page-report-body" class="">
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
                    </div>
                <?php }?></div>
                <?php $this :: display_page_errors(); ?>
                <div  class=" animated fadeIn page-content">
                    <div id="kunjungan_dokter-list-records">
                        <div id="page-report-body" class="table-responsive">
                            <table class="table  table-sm text-left">
                                <thead class="table-header bg-success text-dark">
                                    <tr>
                                        <th  class="td-tanggal"> Tanggal</th>
                                        <th  class="td-no_rekam_medis"> No Rekam Medis</th>
                                        <th  class="td-dokter"> Dokter</th>
                                        <th  class="td-specialist"> Specialist</th>
                                        <th  class="td-keterangan"> Keterangan</th>
                                        <th  class="td-operator"> Operator</th>
                                        <th class="td-btn"></th>
                                    </tr>
                                </thead>
                                <?php
                                if(!empty($records)){
                                ?>
                                <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                    <!--record-->
                                    <?php
                                    $counter = 0;
                                    foreach($records as $data){
                                    $rec_id = (!empty($data['id']) ? urlencode($data['id']) : null);
                                    $counter++;
                                    ?>
                                    <tr>
                                        <td class="td-tanggal"> <?php echo $data['tanggal']; ?></td>
                                        <td class="td-no_rekam_medis"> <?php echo $data['no_rekam_medis']; ?></td>
                                        <td class="td-dokter">
                                            <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("data_dokter/view/" . urlencode($data['dokter'])) ?>">
                                                <i class="fa fa-eye"></i> <?php echo $data['data_dokter_nama_dokter'] ?>
                                            </a>
                                        </td>
                                        <td class="td-specialist">
                                            <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("data_poli/view/" . urlencode($data['specialist'])) ?>">
                                                <i class="fa fa-eye"></i> <?php echo $data['data_poli_nama_poli'] ?>
                                            </a>
                                        </td>
                                        <td class="td-keterangan"> <?php echo $data['keterangan']; ?></td>
                                        <td class="td-operator">
                                            <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("user_login/view/" . urlencode($data['operator'])) ?>">
                                                <i class="fa fa-eye"></i> <?php echo $data['user_login_nama'] ?>
                                            </a>
                                        </td>
                                        <td class="page-list-action td-btn">
                                            <div class="dropdown" >
                                                <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                                                    <i class="fa fa-bars"></i> 
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <?php if($can_view){ ?>
                                                    <a class="dropdown-item" href="<?php print_link("kunjungan_dokter/view/$rec_id"); ?>">
                                                        <i class="fa fa-eye"></i> View 
                                                    </a>
                                                    <?php } ?>
                                                    <?php if($can_edit){ ?>
                                                    <a class="dropdown-item" href="<?php print_link("kunjungan_dokter/edit/$rec_id"); ?>">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>
                                                    <?php } ?>
                                                </ul>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php 
                                    }
                                    ?>
                                    <!--endrecord-->
                                </tbody>
                                <tbody class="search-data" id="search-data-<?php echo $page_element_id; ?>"></tbody>
                                <?php
                                }
                                ?>
                            </table>
                            <?php 
                            if(empty($records)){
                            ?>
                            <h4 class="bg-light text-center border-top text-muted animated bounce  p-3">
                                <i class="fa fa-ban"></i> No record found
                            </h4>
                            <?php
                            }
                            ?>
                        </div>
                        <?php
                        if( $show_footer && !empty($records)){
                        ?>
                        <div class=" border-top mt-2">
                            <div class="row justify-content-center">    
                                <div class="col-md-auto justify-content-center">    
                                    <div class="p-3 d-flex justify-content-between">    
                                    </div>
                                </div>
                                <div class="col">   
                                    <?php
                                    if($show_pagination == true){
                                    $pager = new Pagination($total_records, $record_count);
                                    $pager->route = $this->route;
                                    $pager->show_page_count = true;
                                    $pager->show_record_count = true;
                                    $pager->show_page_limit =true;
                                    $pager->limit_count = $this->limit_count;
                                    $pager->show_page_number_list = true;
                                    $pager->pager_link_range=5;
                                    $pager->render();
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
