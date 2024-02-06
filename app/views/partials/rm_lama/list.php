<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("rm_lama/add");
$can_edit = ACL::is_allowed("rm_lama/edit");
$can_view = ACL::is_allowed("rm_lama/view");
$can_delete = ACL::is_allowed("rm_lama/delete");
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
<section class="page ajax-page" id="<?php echo $page_element_id; ?>" data-page-type="list"  data-display-type="table" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="p-1 mb-1">
        <div class="container-fluid">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Rm Lama</h4>
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
                    <div class=" ">
                        <?php  
                        $this->render_page("data_pasien/pasien/$_GET[datprecord]"); 
                        ?>
                    </div>
                    <div class=""><div>
                        <?php
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        if(!empty($_GET['datprecord'])){
                        $_SESSION['sesid'] ="$id_user";
                        $idpas=$_GET['datprecord'];
                        $queryb = mysqli_query($koneksi, "select * from data_pasien WHERE id_pasien='$idpas'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi)); 
                        // ambil jumlah baris data hasil query
                        $rowsb = mysqli_num_rows($queryb);
                        if ($rowsb <> 0) {
                        $row   = mysqli_fetch_assoc($queryb); 
                        $no_rekam_medis=$row['no_rekam_medis'];
                        $nama_pasien=$row['nama_pasien'];
                        $alamat=$row['alamat'];
                        $no_rm_lama=$row['rm'];
                        $idpas=$row['id_pasien'];
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses URL Tidak Valid');
                            document.location='<?php print_link(""); ?>';
                        </script>
                        <?php }
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses URL Tidak Valid');
                            document.location='<?php print_link(""); ?>';
                        </script>
                        <?php } ?>
                    </div>
                    <div  class="p-1 mb-1">
                        <div class="container-fluid">
                            <div class="row ">
                                <div class="col ">
                                    <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip page-modal" href="<?php  print_link("rm_lama/rm_lama?precord=$csrf_token&datprecord=$idpas");?>">
                                    <i class="fa fa-plus "></i>Add RM Lama</a> 
                                </div>
                                <div class="col-sm-4 ">
                                    <form  class="search" action="<?php print_link("rm_lama") ?>" method="get">
                                        <div class="input-group">
                                            <input value="<?php echo $csrf_token;?>" type="hidden" name="precord"  placeholder="Search" />
                                                <input value="<?php echo $idpas;?>" type="hidden" name="datprecord"  placeholder="Search" />
                                                    <input value="" class="form-control" type="text" name="search"  placeholder="Search" />
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" onclick="caridata();"><i class="fa fa-search"></i></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div></div>
                            <?php $this :: display_page_errors(); ?>
                            <div  class=" animated fadeIn page-content">
                                <div id="rm_lama-list-records">
                                    <div id="page-report-body" class="table-responsive">
                                        <?php Html::ajaxpage_spinner(); ?>
                                        <table class="table  table-sm text-left">
                                            <thead class="table-header bg-success text-dark">
                                                <tr>
                                                    <th  class="td-tanggal_rm"> Tanggal Rm</th>
                                                    <th  class="td-no_rekam_medis"> No Rekam Medis</th>
                                                    <th  class="td-pemeriksaan_fisik"> Pemeriksaan Fisik</th>
                                                    <th  class="td-assesment_triase"> Assesment Triase</th>
                                                    <th  class="td-assesment_medis"> Assesment Medis</th>
                                                    <th  class="td-catatan_medis"> Catatan Medis</th>
                                                    <th  class="td-resep_obat"> Resep Obat</th>
                                                    <th  class="td-tindakan"> Tindakan</th>
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
                                                    <td class="td-tanggal_rm"> <?php echo $data['tanggal_rm']; ?></td>
                                                    <td class="td-no_rekam_medis"> <?php echo $data['no_rekam_medis']; ?></td>
                                                    <td class="td-pemeriksaan_fisik"> <span>
                                                        <?php
                                                        $sekarang = gmdate("Y-m-d", time() + 60 * 60 * 7);
                                                        $id_user = "".USER_ID;
                                                        $dbhost="".DB_HOST;
                                                        $dbuser="".DB_USERNAME;
                                                        $dbpass="".DB_PASSWORD;
                                                        $dbname="".DB_NAME;
                                                        //$koneksi=open_connection();
                                                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                                                        $norm=$data['no_rekam_medis'];
                                                        $qutr = mysqli_query($koneksi, "SELECT * from data_pasien WHERE no_rekam_medis='$norm'")
                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                        $rotr = mysqli_num_rows($qutr);
                                                        if ($rotr <> 0) {
                                                        $ctr= mysqli_fetch_assoc($qutr);
                                                        $rm=$ctr['rm']; 
                                                        $idpas=$ctr['id_pasien']; 
                                                        }
                                                        ?>
                                                        <div class="dropdown" >
                                                            <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                                                                <i class="fa fa-bars"></i> 
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <?php
                                                                $key="dermawangroup";
                                                                $plaintext = "$rec_id";
                                                                $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                                                                $iv = openssl_random_pseudo_bytes($ivlen);
                                                                $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                                                                $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                                                                $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );   
                                                                $cnrm=$data['no_rekam_medis'];
                                                                $ctgl=$data['tanggal_rm'];
                                                                //$frm  = "uploads/rmlama/$postnrm";
                                                                $ckfldr = "rmlama/$cnrm/$ctgl/fisik";
                                                                //mkdir("$frm", 0770, true); 
                                                                //mkdir("$ftgl", 0770, true); 
                                                                if(is_dir($ckfldr)) {
                                                                //echo ("$file is a directory");
                                                                ?>
                                                                <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip" href="<?php  print_link("rm_lama/detile/$rec_id?precord=$ciphertext&datprecord=$idpas&rmlama=fisik");?>">
                                                                <i class="fa fa-plus "></i>Lihat Pemeriksaan Fisik RM Lama</a>                         
                                                                <?php
                                                                } else {
                                                                // mkdir("$ftgl", 0770, true); 
                                                                // echo ("$file is not a directory");
                                                                }   
                                                                ?>
                                                                <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip" href="<?php  print_link("uploadsrm.php?precord=$ciphertext&datprecord=$idpas&rmlama=fisik");?>">
                                                                <i class="fa fa-plus "></i>Uploads Pemeriksaan Fisik RM Lama</a>
                                                                <?php?>
                                                            </ul>
                                                        </div>
                                                    </span></td>
                                                    <td class="td-assesment_triase"> <span><?php //echo $data['assesment_triase']; ?>
                                                        <div class="dropdown" >
                                                            <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                                                                <i class="fa fa-bars"></i> 
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <?php
                                                                $key="dermawangroup";
                                                                $plaintext = "$rec_id";
                                                                $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                                                                $iv = openssl_random_pseudo_bytes($ivlen);
                                                                $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                                                                $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                                                                $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );   
                                                                $cnrm=$data['no_rekam_medis'];
                                                                $ctgl=$data['tanggal_rm'];
                                                                //$frm  = "uploads/rmlama/$postnrm";
                                                                $ckfldr = "rmlama/$cnrm/$ctgl/triase";
                                                                //mkdir("$frm", 0770, true); 
                                                                //mkdir("$ftgl", 0770, true); 
                                                                if(is_dir($ckfldr)) {
                                                                //echo ("$file is a directory");
                                                                ?>
                                                                <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip" href="<?php  print_link("rm_lama/detile/$rec_id?precord=$ciphertext&datprecord=$idpas&rmlama=triase");?>">
                                                                <i class="fa fa-plus "></i>Lihat Pemeriksaan Triase RM Lama</a>                         
                                                                <?php
                                                                } else {
                                                                // mkdir("$ftgl", 0770, true); 
                                                                // echo ("$file is not a directory");
                                                                }   
                                                                ?>
                                                                <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip" href="<?php  print_link("uploadsrm.php?precord=$ciphertext&datprecord=$idpas&rmlama=triase");?>">
                                                                <i class="fa fa-plus "></i>Uploads Pemeriksaan Triase RM Lama</a>
                                                                <?php?>
                                                            </ul>
                                                        </div>
                                                    </span></td>
                                                    <td class="td-assesment_medis"> <span><?php //echo $data['assesment_medis']; ?>
                                                        <div class="dropdown" >
                                                            <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                                                                <i class="fa fa-bars"></i> 
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <?php
                                                                $key="dermawangroup";
                                                                $plaintext = "$rec_id";
                                                                $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                                                                $iv = openssl_random_pseudo_bytes($ivlen);
                                                                $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                                                                $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                                                                $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );   
                                                                $cnrm=$data['no_rekam_medis'];
                                                                $ctgl=$data['tanggal_rm'];
                                                                //$frm  = "uploads/rmlama/$postnrm";
                                                                $ckfldr = "rmlama/$cnrm/$ctgl/medis";
                                                                //mkdir("$frm", 0770, true); 
                                                                //mkdir("$ftgl", 0770, true); 
                                                                if(is_dir($ckfldr)) {
                                                                //echo ("$file is a directory");
                                                                ?>
                                                                <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip" href="<?php  print_link("rm_lama/detile/$rec_id?precord=$ciphertext&datprecord=$idpas&rmlama=medis");?>">
                                                                <i class="fa fa-plus "></i>Lihat Assesment Medis RM Lama</a>                         
                                                                <?php
                                                                } else {
                                                                // mkdir("$ftgl", 0770, true); 
                                                                // echo ("$file is not a directory");
                                                                }   
                                                                ?>
                                                                <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip" href="<?php  print_link("uploadsrm.php?precord=$ciphertext&datprecord=$idpas&rmlama=medis");?>">
                                                                <i class="fa fa-plus "></i>Uploads Assesment Medis RM Lama</a>
                                                                <?php?>
                                                            </ul>
                                                        </div>
                                                    </span></td>
                                                    <td class="td-catatan_medis"> <span><?php //echo $data['catatan_medis']; ?>
                                                        <div class="dropdown" >
                                                            <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                                                                <i class="fa fa-bars"></i> 
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <?php
                                                                $key="dermawangroup";
                                                                $plaintext = "$rec_id";
                                                                $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                                                                $iv = openssl_random_pseudo_bytes($ivlen);
                                                                $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                                                                $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                                                                $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );   
                                                                $cnrm=$data['no_rekam_medis'];
                                                                $ctgl=$data['tanggal_rm'];
                                                                //$frm  = "uploads/rmlama/$postnrm";
                                                                $ckfldr = "rmlama/$cnrm/$ctgl/catat";
                                                                //mkdir("$frm", 0770, true); 
                                                                //mkdir("$ftgl", 0770, true); 
                                                                if(is_dir($ckfldr)) {
                                                                //echo ("$file is a directory");
                                                                ?>
                                                                <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip" href="<?php  print_link("rm_lama/detile/$rec_id?precord=$ciphertext&datprecord=$idpas&rmlama=catat");?>">
                                                                <i class="fa fa-plus "></i>Lihat Catatan Medis RM Lama</a>                         
                                                                <?php
                                                                } else {
                                                                // mkdir("$ftgl", 0770, true); 
                                                                // echo ("$file is not a directory");
                                                                }   
                                                                ?>
                                                                <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip" href="<?php  print_link("uploadsrm.php?precord=$ciphertext&datprecord=$idpas&rmlama=catat");?>">
                                                                <i class="fa fa-plus "></i>Uploads Catatan Medis RM Lama</a>
                                                                <?php?>
                                                            </ul>
                                                        </div>
                                                    </span></td>
                                                    <td class="td-resep_obat"> <span><?php //echo $data['resep_obat']; ?>
                                                        <div class="dropdown" >
                                                            <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                                                                <i class="fa fa-bars"></i> 
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <?php
                                                                $key="dermawangroup";
                                                                $plaintext = "$rec_id";
                                                                $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                                                                $iv = openssl_random_pseudo_bytes($ivlen);
                                                                $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                                                                $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                                                                $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );   
                                                                $cnrm=$data['no_rekam_medis'];
                                                                $ctgl=$data['tanggal_rm'];
                                                                //$frm  = "uploads/rmlama/$postnrm";
                                                                $ckfldr = "rmlama/$cnrm/$ctgl/resep";
                                                                //mkdir("$frm", 0770, true); 
                                                                //mkdir("$ftgl", 0770, true); 
                                                                if(is_dir($ckfldr)) {
                                                                //echo ("$file is a directory");
                                                                ?>
                                                                <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip" href="<?php  print_link("rm_lama/detile/$rec_id?precord=$ciphertext&datprecord=$idpas&rmlama=resep");?>">
                                                                <i class="fa fa-plus "></i>Lihat Resep Obat RM Lama</a>                         
                                                                <?php
                                                                } else {
                                                                // mkdir("$ftgl", 0770, true); 
                                                                // echo ("$file is not a directory");
                                                                }   
                                                                ?>
                                                                <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip" href="<?php  print_link("uploadsrm.php?precord=$ciphertext&datprecord=$idpas&rmlama=resep");?>">
                                                                <i class="fa fa-plus "></i>Uploads Resep Obat RM Lama</a>
                                                                <?php?>
                                                            </ul>
                                                        </div>
                                                    </span></td>
                                                    <td class="td-tindakan"> <span><?php //echo $data['tindakan']; ?>
                                                        <div class="dropdown" >
                                                            <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                                                                <i class="fa fa-bars"></i> 
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <?php
                                                                $key="dermawangroup";
                                                                $plaintext = "$rec_id";
                                                                $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                                                                $iv = openssl_random_pseudo_bytes($ivlen);
                                                                $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                                                                $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                                                                $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );   
                                                                $cnrm=$data['no_rekam_medis'];
                                                                $ctgl=$data['tanggal_rm'];
                                                                //$frm  = "uploads/rmlama/$postnrm";
                                                                $ckfldr = "rmlama/$cnrm/$ctgl/tindakan";
                                                                //mkdir("$frm", 0770, true); 
                                                                //mkdir("$ftgl", 0770, true); 
                                                                if(is_dir($ckfldr)) {
                                                                //echo ("$file is a directory");
                                                                ?>
                                                                <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip" href="<?php  print_link("rm_lama/detile/$rec_id?precord=$ciphertext&datprecord=$idpas&rmlama=tindakan");?>">
                                                                <i class="fa fa-plus "></i>Lihat Tindakan RM Lama</a>                         
                                                                <?php
                                                                } else {
                                                                // mkdir("$ftgl", 0770, true); 
                                                                // echo ("$file is not a directory");
                                                                }   
                                                                ?>
                                                                <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip" href="<?php  print_link("uploadsrm.php?precord=$ciphertext&datprecord=$idpas&rmlama=tindakan");?>">
                                                                <i class="fa fa-plus "></i>Uploads Tindakan RM Lama</a>
                                                                <?php?>
                                                            </ul>
                                                        </div>
                                                    </span></td>
                                                    <td class="page-list-action td-btn">
                                                        <div class="dropdown" >
                                                            <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                                                                <i class="fa fa-bars"></i> 
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <?php if($can_edit){ ?>
                                                                <a class="dropdown-item page-modal" href="<?php print_link("rm_lama/edit/$rec_id"); ?>">
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
                                                $pager->ajax_page = true;
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
