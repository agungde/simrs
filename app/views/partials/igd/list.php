<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("igd/add");
$can_edit = ACL::is_allowed("igd/edit");
$can_view = ACL::is_allowed("igd/view");
$can_delete = ACL::is_allowed("igd/delete");
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
    <div  class="bg-white p-1 mb-1">
        <div class="container-fluid">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">IGD</h4>
                    <div class=""><div><?php $usrnam       = "".USER_NAME;
                        $id_user      = "".USER_ID;
                        $dbhost       = "".DB_HOST;
                        $dbuser       = "".DB_USERNAME;
                        $dbpass       = "".DB_PASSWORD;
                        $dbname       = "".DB_NAME;
                        $koneksi      = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                    $idtrace      = "$id_user$usrnam";?></div>
                </div>
            </div>
            <div class="col-sm-3 ">
                <?php if($can_add){ ?>
                <a  class="btn btn btn-primary my-1" href="<?php print_link("igd/add") ?>">
                    <i class="fa fa-plus"></i>                              
                    Add New Igd 
                </a>
                <?php } ?>
            </div>
            <div class="col-sm-4 ">
                <form  class="search" action="<?php print_link('igd'); ?>" method="get">
                    <div class="input-group">
                        <input value="<?php echo get_value('search'); ?>" class="form-control" type="text" name="search"  placeholder="Search" />
                            <div class="input-group-append">
                                <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-12 comp-grid">
                    <div class="">
                        <!-- Page bread crumbs components-->
                        <?php
                        if(!empty($field_name) || !empty($_GET['search'])){
                        ?>
                        <hr class="sm d-block d-sm-none" />
                        <nav class="page-header-breadcrumbs mt-2" aria-label="breadcrumb">
                            <ul class="breadcrumb m-0 p-1">
                                <?php
                                if(!empty($field_name)){
                                ?>
                                <li class="breadcrumb-item">
                                    <a class="text-decoration-none" href="<?php print_link('igd'); ?>">
                                        <i class="fa fa-angle-left"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item">
                                    <?php echo (get_value("tag") ? get_value("tag")  :  make_readable($field_name)); ?>
                                </li>
                                <li  class="breadcrumb-item active text-capitalize font-weight-bold">
                                    <?php echo (get_value("label") ? get_value("label")  :  make_readable(urldecode($field_value))); ?>
                                </li>
                                <?php 
                                }   
                                ?>
                                <?php
                                if(get_value("search")){
                                ?>
                                <li class="breadcrumb-item">
                                    <a class="text-decoration-none" href="<?php print_link('igd'); ?>">
                                        <i class="fa fa-angle-left"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item text-capitalize">
                                    Search
                                </li>
                                <li  class="breadcrumb-item active text-capitalize font-weight-bold"><?php echo get_value("search"); ?></li>
                                <?php
                                }
                                ?>
                            </ul>
                        </nav>
                        <!--End of Page bread crumbs components-->
                        <?php
                        }
                        ?>
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
                <div class="col-md-12 comp-grid">
                    <div class=""><style>
                        #table-wrappera {
                        position:relative;
                        }
                        #table-scrolla {
                        height:100px;
                        overflow:auto;  
                        margin-top:0px;
                        }
                        #table-wrappera table {
                        width:100%;
                        }
                        #table-wrappera table * {
                        color:black;
                        }
                        #table-wrappera table thead th .text {
                        position:absolute;   
                        top:-20px;
                        z-index:2;
                        height:0px;
                        width:35%;
                        border:1px solid red;
                        }       
                    </style>
                    <div>
                        <?php
                        $usrnam  = "".USER_NAME;
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        $idtrace = "$id_user$usrnam";
                        $linksite="".SITE_ADDR;
                        $sekarang = gmdate("Y-m-d", time() + 60 * 60 * 7);
                        $appcek = mysqli_query($koneksi,"select * from igd WHERE setatus='' and DATE(igd.tanggal_masuk)='$sekarang'");
                        $roapp = mysqli_num_rows($appcek );
                        if ($roapp  <> 0) {
                        while ($datapp = MySQLi_fetch_array($appcek)) {
                        $bayar= $datapp['pembayaran'];
                        $datapoli=$datapp['id_igd'];
                        $trxcek = mysqli_query($koneksi,"select * from transaksi WHERE no_rekam_medis='".$datapp['no_rekam_medis']."'");
                        $rotrx = mysqli_num_rows($trxcek);
                        if ($rotrx  <> 0) {
                        $datp=mysqli_fetch_assoc($trxcek);
                        $trxset=$datp['setatus_tagihan'];
                        }else{
                        $trxset="";
                        }
                        if(USER_ROLE==12 or USER_ROLE==1 or USER_ROLE==19){
                        $datrm = mysqli_query($koneksi,"select * from data_rekam_medis WHERE idapp='$datapoli' and no_rekam_medis='".$datapp['no_rekam_medis']."'");
                        $rotrxd = mysqli_num_rows($datrm );
                        if ($rotrxd  <> 0) {
                        ?>
                        <div id="appointment-liveap-records">    
                            <div id="page-report-body" class="table-responsive">
                                <div id="table-wrappera">
                                    <div id="table-scrolla">
                                        <table class="table  table-striped table-sm text-left">
                                            <thead class="table-header bg-success text-dark">
                                                <tr>
                                                    <th  class="td-tanggal"> Tanggal</th>
                                                    <th  class="td-no_rekam_medis">NO RM</th>
                                                    <th  class="td-nama"> Nama</th>
                                                    <th  class="td-alamat"> Alamat</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody class="page-data" id="page-data-list-page-8rt4hbl3u9f5">
                                                <tr>
                                                    <td > <?php echo $datapp['tanggal_masuk'];?></td>
                                                    <td ><?php echo $datapp['no_rekam_medis'];?></td>
                                                    <td > <?php echo $datapp['nama_pasien'];?></td>
                                                    <td > <?php echo $datapp['alamat'];?></td>
                                                    <td ><div class=""> 
                                                        <?php
                                                        if($trxset=="Register"){
                                                        if($bayar=="1"){
                                                        echo "Kasir Proses Closed Dahulu";  
                                                        }else{
                                                        echo "Selesaikan Pembayaran Dahulu"; 
                                                        }
                                                        ?>
                                                        <div>
                                                            <a style="margin-top:2px;margin-bottom:5px;" class="dropdown-item" title="Chekin" href="#">
                                                                <i class="fa fa-sign-in "></i> Chekin
                                                            </a>   </div> </div>  
                                                            <?php
                                                            }else{?>
                                                            <div>
                                                                <a style="margin-top:2px;margin-bottom:5px;" class="dropdown-item" title="Chekin" href="<?php  print_link("igd/chekin/$datapoli?action=Rujukan");?>">
                                                                    <i class="fa fa-sign-in "></i> Chekin
                                                                </a>   </div> </div>   
                                                                <?php }?>
                                                            </td>
                                                        </tr>    
                                                    </tbody>
                                                </table>   
                                            </div></div></div>  </div>
                                            <?php 
                                            }
                                            }
                                            }
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 comp-grid">
                                    <div class=""><div></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div  class="">
                        <div class="container">
                            <div class="row ">
                                <div class="col-md-12 comp-grid">
                                </div>
                                <div class="col-md-6 comp-grid">
                                    <div class=""><div>
                                        <?php if(!empty($_GET['igd_tanggal'])){}else{?> 
                                        <script>
                                            window.onload = function(){
                                            // document.forms['autoform'].submit();
                                            //document.getElementById('autobtn').click();
                                            }   
                                        </script>
                                        <?php }?>
                                        <form method="get" action="<?php print_link($current_page) ?>" class="form filter-form">
                                            <div class="input-group">
                                                <input class="form-control datepicker  datepicker"  value="<?php echo $this->set_field_value('igd_tanggal',''); ?>" type="datetime"  name="igd_tanggal" placeholder="Tanggal" data-enable-time="" data-date-format="Y-m-d" data-alt-format="M j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                    </div>
                                                    &nbsp;&nbsp;
                                                    <select required=""  name="igd_setatus"  placeholder="Select a value ..."    class="custom-select" >
                                                        <option  value="Register" >Register</option>
                                                        <option  value="Closed">Closed</option>
                                                    </select>
                                                    &nbsp;&nbsp;
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary" id="autobtn">Filter</button>
                                                    </div>
                                                </div>
                                            </form>  
                                        </div>
                                        <div style="margin-bottom:3px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div  class="">
                        <div class="container-fluid">
                            <div class="row ">
                                <div class="col-md-12 comp-grid">
                                    <?php $this :: display_page_errors(); ?>
                                    <div  class=" animated fadeIn page-content">
                                        <div id="igd-list-records">
                                            <div id="page-report-body" class="table-responsive">
                                                <?php Html::ajaxpage_spinner(); ?>
                                                <table class="table  table-sm text-left">
                                                    <thead class="table-header bg-success text-dark">
                                                        <tr>
                                                            <th  class="td-tanggal_masuk"> Tanggal Masuk</th>
                                                            <th  class="td-no_rekam_medis"> No Rekam Medis</th>
                                                            <th  class="td-nama_pasien"> Nama Pasien</th>
                                                            <th  class="td-tl"> Title</th>
                                                            <th  class="td-tanggal_lahir"> Tanggal Lahir</th>
                                                            <th  class="td-umur"> Umur</th>
                                                            <th  class="td-jenis_kelamin"> Jenis Kelamin</th>
                                                            <th  class="td-alamat"> Alamat</th>
                                                            <th  class="td-dokter"> Dokter</th>
                                                            <th  class="td-assesment_triase"> Assesment Triase</th>
                                                            <th  class="td-pemeriksaan_fisik"> Pemeriksaan Fisik</th>
                                                            <th  class="td-catatan_medis"> Catatan Medis</th>
                                                            <th  class="td-tindakan"> Tindakan</th>
                                                            <th  class="td-lab"> Laboratorium</th>
                                                            <th  class="td-resep_obat"> Resep Obat</th>
                                                            <th  class="td-rekam_medis"> Rekam Medis</th>
                                                            <th  class="td-assesment_medis"> Assesment Medis</th>
                                                            <th  class="td-action"> Action</th>
                                                            <th  class="td-rawat_inap"> RANAP</th>
                                                            <th  class="td-pembayaran"> Pembayaran</th>
                                                            <th  class="td-setatus_bpjs"> Setatus Bpjs</th>
                                                            <th  class="td-setatus"> Status</th>
                                                            <th  class="td-tanggal_keluar"> Tanggal Keluar</th>
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
                                                        $rec_id = (!empty($data['id_igd']) ? urlencode($data['id_igd']) : null);
                                                        $counter++;
                                                        ?>
                                                        <tr>
                                                            <td class="td-tanggal_masuk"> <?php echo $data['tanggal_masuk']; ?></td>
                                                            <td class="td-no_rekam_medis"> <?php echo $data['no_rekam_medis']; ?></td>
                                                            <td class="td-nama_pasien"> <?php echo $data['nama_pasien']; ?></td>
                                                            <td class="td-tl"> <?php echo $data['tl']; ?></td>
                                                            <td class="td-tanggal_lahir"> <?php echo $data['tanggal_lahir']; ?></td>
                                                            <td class="td-umur"> <?php echo $data['umur']; ?></td>
                                                            <td class="td-jenis_kelamin"> <?php echo $data['jenis_kelamin']; ?></td>
                                                            <td class="td-alamat"> <?php echo $data['alamat']; ?></td>
                                                            <td class="td-dokter">
                                                                <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("data_dokter/view/" . urlencode($data['dokter'])) ?>">
                                                                    <i class="fa fa-eye"></i> <?php echo $data['data_dokter_nama_dokter'] ?>
                                                                </a>
                                                            </td>
                                                            <td class="td-assesment_triase"> <style>
                                                                .dropdown a.dropdown-item:hover {
                                                                cursor: pointer;
                                                                background-color: #F5F5DC;
                                                                }
                                                            </style>
                                                            <span>
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
                                                                        $id_user = "".USER_ID;
                                                                        $dbhost  = "".DB_HOST;
                                                                        $dbuser  = "".DB_USERNAME;
                                                                        $dbpass  = "".DB_PASSWORD;
                                                                        $dbname  = "".DB_NAME;
                                                                        //$koneksi=open_connection();
                                                                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                                                                        $norm=$data['no_rekam_medis'];
                                                                        $qup = mysqli_query($koneksi, "SELECT * from data_pasien WHERE no_rekam_medis='$norm'")
                                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                        $rop = mysqli_num_rows($qup);
                                                                        if ($rop <> 0) {
                                                                        $ctp= mysqli_fetch_assoc($qup);
                                                                        $idpas=$ctp['id_pasien'];
                                                                        }
                                                                        $qutrt = mysqli_query($koneksi, "SELECT * from assesment_triase WHERE no_rekam_medis='$norm'")
                                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                        $rotrt = mysqli_num_rows($qutrt);
                                                                        if ($rotrt <> 0) {
                                                                        $ctrt= mysqli_fetch_assoc($qutrt);
                                                                        //$idtri=$ctrt['id_triase'];
                                                                        ?>
                                                                        <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip page-modal" href="<?php  print_link("assesment_triase?precord=$norm&datprecord=$idpas");?>">
                                                                        <i class="fa fa-eye"></i> Lihat Assesment Triase</a>
                                                                        <?php
                                                                        }   
                                                                        $qutr = mysqli_query($koneksi, "SELECT * from assesment_triase WHERE id_daftar='$rec_id' and no_rekam_medis='$norm'")
                                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                        $rotr = mysqli_num_rows($qutr);
                                                                        if ($rotr <> 0) {
                                                                        $ctr= mysqli_fetch_assoc($qutr);
                                                                        $idtri=$ctr['id_triase'];
                                                                        }else{
                                                                        }
                                                                        if($data['setatus']=="" or $data['setatus']=="Register"){?>
                                                                        <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip" href="<?php  print_link("assesment_triase/add?precord=$ciphertext&datprecord=$rec_id");?>">
                                                                        <i class="fa fa-eye"></i> Add Assesment Triase</a>
                                                                        <?php  
                                                                        }
                                                                        ?>  
                                                                    </ul>
                                                                </div>
                                                            </span>
                                                        </td>
                                                        <td class="td-pemeriksaan_fisik">  <style>
                                                            .dropdown a.dropdown-item:hover {
                                                            cursor: pointer;
                                                            background-color: #F5F5DC;
                                                            }
                                                        </style>
                                                        <span>
                                                            <div class="dropdown" >
                                                                <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                                                                    <i class="fa fa-bars"></i> 
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <?php
                                                                    $norm=$data['no_rekam_medis'];
                                                                    $qutrt = mysqli_query($koneksi, "SELECT * from pemeriksaan_fisik WHERE no_rekam_medis='$norm'")
                                                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                    $rotrt = mysqli_num_rows($qutrt);
                                                                    if ($rotrt <> 0) {
                                                                    $ctrt= mysqli_fetch_assoc($qutrt);
                                                                    //$idtri=$ctrt['id_triase'];
                                                                    $qup = mysqli_query($koneksi, "SELECT * from data_pasien WHERE no_rekam_medis='$norm'")
                                                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                    $rop = mysqli_num_rows($qup);
                                                                    if ($rop <> 0) {
                                                                    $ctp= mysqli_fetch_assoc($qup);
                                                                    $idpas=$ctp['id_pasien'];
                                                                    }
                                                                    ?>
                                                                    <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip page-modal" href="<?php  print_link("pemeriksaan_fisik?precord=$norm&datprecord=$idpas");?>">
                                                                    <i class="fa fa-eye"></i> Lihat Pemeriksaan Fisik</a>
                                                                    <?php
                                                                    }   
                                                                    $qutrif = mysqli_query($koneksi, "SELECT * from pemeriksaan_fisik WHERE id_daftar='$rec_id' and no_rekam_medis='$norm'")
                                                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                    $rotrif = mysqli_num_rows($qutrif);
                                                                    if ($rotrif <> 0) {
                                                                    $ctrif= mysqli_fetch_assoc($qutrif);
                                                                    $idtrif=$ctrif['id_fisik'];
                                                                    ?>
                                                                    <?php
                                                                    }else{
                                                                    }
                                                                    if($data['setatus']=="" or $data['setatus']=="Register"){?>
                                                                    <a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip"  href="<?php  print_link("pemeriksaan_fisik/add?precord=$ciphertext&datprecord=$rec_id");?>">
                                                                    <i class="fa fa-send"></i> Add Pemeriksaan Fisik</a>                      
                                                                    <?php  
                                                                    }
                                                                    ?> 
                                                                </ul>
                                                            </div>
                                                        </span>
                                                    </td>
                                                    <td class="td-catatan_medis">
                                                        <span>
                                                            <div class="dropdown" >
                                                                <button data-toggle="dropdown" class="dropdown-toggle btn btn-danger btn-sm">
                                                                    <i class="fa fa-bars"></i> 
                                                                    </button><ul class="dropdown-menu">
                                                                    <?php
                                                                    //  if(USER_ROLE==3){
                                                                    $norekam=$data['no_rekam_medis'];
                                                                    $quep = mysqli_query($koneksi, "SELECT * from data_pasien WHERE no_rekam_medis='$norekam'")
                                                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                    $rowp = mysqli_num_rows($quep);
                                                                    if ($rowp <> 0) {
                                                                    $ckrmp= mysqli_fetch_assoc($quep);
                                                                    $ipas=$ckrmp['id_pasien'];
                                                                    }          
                                                                    $querydt = mysqli_query($koneksi, "SELECT * from catatan_medis WHERE no_rekam_medis='$norekam'")
                                                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                    $rowsdt = mysqli_num_rows($querydt);
                                                                    if ($rowsdt <> 0) { 
                                                                    ?>
                                                                    <a class="btn btn-sm btn-danger has-tooltip page-modal"  href="<?php  print_link("catatan_medis?detile_precord=$norekam&datprecord=$ipas");?>">
                                                                    <i class="fa fa-eye"></i> Lihat Catatan Medis</a>
                                                                    <?php
                                                                    }
                                                                    //}
                                                                    if($data['setatus']=="Closed"){}else{
                                                                    ?>
                                                                    <a class="btn btn-sm btn-danger has-tooltip"  href="<?php  print_link("catatan_medis/add?precord=$ciphertext&pasien=IGD&datprecord=$ipas");?>">
                                                                    <i class="fa fa-plus"></i> Add Catatan Medis</a>
                                                                    <?php }?>
                                                                </ul>
                                                            </div>
                                                        </span></td>
                                                        <td class="td-tindakan"> <style>
                                                            .dropdown a.dropdown-item:hover {
                                                            cursor: pointer;
                                                            background-color: #F5F5DC;
                                                            }
                                                        </style>
                                                        <span>
                                                            <div class="dropdown" >
                                                                <button data-toggle="dropdown" class="dropdown-toggle btn btn-warning btn-sm">
                                                                    <i class="fa fa-bars"></i> 
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <?php
                                                                    $dtrekam=$data['no_rekam_medis'];
                                                                    $query = mysqli_query($koneksi, "SELECT * from data_tindakan WHERE no_rekam_medis='$dtrekam'")
                                                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                    // ambil jumlah baris data hasil query
                                                                    $rows = mysqli_num_rows($query);
                                                                    // cek hasil query
                                                                    // jika "no_antrian" sudah ada
                                                                    if ($rows <> 0) {
                                                                    // $datacek= mysqli_fetch_assoc($query);
                                                                    $queryrm = mysqli_query($koneksi, "SELECT * from rekam_medis WHERE no_rekam_medis='$dtrekam'")
                                                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                    // ambil jumlah baris data hasil query
                                                                    $rowsrm = mysqli_num_rows($queryrm);
                                                                    // cek hasil query
                                                                    // jika "no_antrian" sudah ada
                                                                    if ($rowsrm <> 0) {
                                                                    $datrm= mysqli_fetch_assoc($queryrm);
                                                                    $iddatrm=$datrm['id_rekam_medis'];
                                                                    }
                                                                    ?>
                                                                    <a style="margin-top:2px;" class="btn btn-sm btn-warning has-tooltip page-modal"  href="<?php  print_link("rekam_medis/tindakan/$iddatrm?detile_precord=$dtrekam");?>">
                                                                    <i class="fa fa-user "></i> Lihat Tindakan</a> 
                                                                    <?php
                                                                    }
                                                                    if($data['setatus']=="" or $data['setatus']=="Register"){?>
                                                                    <a style="margin-top:2px;" class="btn btn-sm btn-warning has-tooltip"  href="<?php print_link("data_tindakan/add?precord=$ciphertext&pasien=IGD") ?>">
                                                                        <i class="fa fa-user-md "></i> Add Tindakan
                                                                    </a>
                                                                    <?php }?>   
                                                                </ul>
                                                            </div>
                                                        </span>
                                                    </td>
                                                    <td class="td-lab"> <style>
                                                        .dropdown a.dropdown-item:hover {
                                                        cursor: pointer;
                                                        background-color: #F5F5DC;
                                                        }
                                                    </style>
                                                    <span>
                                                        <div class="dropdown" >
                                                            <button data-toggle="dropdown" class="dropdown-toggle btn btn-success btn-sm">
                                                                <i class="fa fa-bars"></i> 
                                                            </button>
                                                            <ul class="dropdown-menu">
                                                                <?php
                                                                $cekdaf=0;
                                                                $query = mysqli_query($koneksi, "SELECT * from pendaftaran_lab WHERE id_daftar='$rec_id'")
                                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                // ambil jumlah baris data hasil query
                                                                $rows = mysqli_num_rows($query);
                                                                if ($rows <> 0) {
                                                                while ($datacek=mysqli_fetch_array($query)){
                                                                $nodaf=$cekdaf;
                                                                if($nodaf=="0"){
                                                                $labke="Lab";
                                                                }else{
                                                                $nodaf=$nodaf + 1; 
                                                                $labke="Lab Ke $nodaf";
                                                                }
                                                                // $datacek= mysqli_fetch_assoc($query);
                                                                $iddaftarlab=$datacek['id'];
                                                                if($datacek['setatus']=="Closed"){
                                                                $queryh = mysqli_query($koneksi, "SELECT * from hasil_lab WHERE id_daftar_lab='$iddaftarlab'")
                                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                // ambil jumlah baris data hasil query
                                                                $rowsh = mysqli_num_rows($queryh);
                                                                // cek hasil query
                                                                // jika "no_antrian" sudah ada
                                                                if ($rowsh <> 0) {
                                                                $datacekh= mysqli_fetch_assoc($queryh);
                                                                $id_hasil_lab= $datacekh['id_hasil_lab']; 
                                                                $key="dermawangroup";
                                                                $plaintext = "$id_hasil_lab";
                                                                $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                                                                $iv = openssl_random_pseudo_bytes($ivlen);
                                                                $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                                                                $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                                                                $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
                                                                }
                                                                ?>
                                                                <a style="margin-top:2px;" class="btn btn-sm btn-success has-tooltip page-modal"  href="<?php  print_link("hasil_lab/hasil?csrf_token=$csrf_token&precord=$ciphertext");?>">
                                                                <i class="fa fa-send"></i>Lihat <?php echo $labke;?></a> 
                                                                <?php 
                                                                }else{
                                                                ?>
                                                                <a style="margin-top:2px;" class="btn btn-sm btn-success has-tooltip" href="#"> 
                                                                <i class="fa fa-users"></i><?php echo $labke;?> Masih Proses</a> 
                                                                <?php
                                                            // echo "<i class=\"fa fa-users \"></i> Masih Proses $labke</a>";
                                                            $norekam=$data['no_rekam_medis'];
                                                            }
                                                            $cekdaf++;
                                                            }
                                                            }
                                                            if($data['setatus']=="" or $data['setatus']=="Register"){
                                                            $key="dermawangroup";
                                                            $plaintext = "$rec_id";
                                                            $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                                                            $iv = openssl_random_pseudo_bytes($ivlen);
                                                            $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                                                            $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                                                            $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
                                                            ?>
                                                            <a style="margin-top:2px;margin-bottom:5px;" class="btn btn-sm btn-success"    href="<?php print_link("pendaftaran_lab/lab?precord=$ciphertext&pasien=IGD&datprecord=$idpas") ?>">
                                                                <i class="fa fa-file-archive-o "></i> Daftar Ke Lab
                                                            </a>  
                                                            <?php }
                                                            $no_rekam_medis=$data['no_rekam_medis'];
                                                            $quespl= mysqli_query($koneksi, "select * from hasil_lab_luar WHERE no_rekam_medis='$no_rekam_medis' and id_daftar='$rec_id'")
                                                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                            // ambil jumlah baris data hasil query
                                                            $rospl = mysqli_num_rows($quespl);
                                                            if ($rospl <> 0) {
                                                            $daspl= mysqli_fetch_assoc($quespl);
                                                            $idlbl=$daspl['id'];
                                                            ?>
                                                            <a style="margin-top:2px;" class="btn btn-sm btn-secondary has-tooltip page-modal"  href="<?php  print_link("hasil_lab_luar/view/$idlbl?csrf_token=$csrf_toke");?>">
                                                            <i class="fa fa-send"></i>Lihat Hasil Lab Luar</a>       
                                                            <?php
                                                            }
                                                            ?>
                                                            <a style="margin-top:2px;" class="btn btn-sm btn-secondary has-tooltip"  href="<?php  print_link("hasil_lab_luar/add?csrf_token=$csrf_toke&pasien=IGD&datrecord=$rec_id");?>">
                                                            <i class="fa fa-send"></i>Uploads Hasil Lab Luar</a>       
                                                            <?php   
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </span></td>
                                                <td class="td-resep_obat"> <style>
                                                    .dropdown a.dropdown-item:hover {
                                                    cursor: pointer;
                                                    background-color: #F5F5DC;
                                                    }
                                                </style>
                                                <span>
                                                    <div class="dropdown" >
                                                        <button data-toggle="dropdown" class="dropdown-toggle btn btn-secondary btn-sm">
                                                            <i class="fa fa-bars"></i> 
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <?php
                                                            $normmed=$data['no_rekam_medis'];
                                                            $qupas = mysqli_query($koneksi, "SELECT * from data_pasien WHERE no_rekam_medis='$normmed'")
                                                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                            $ropas = mysqli_num_rows($qupas);
                                                            if ($ropas <> 0) {
                                                            $dapas= mysqli_fetch_assoc($qupas);
                                                            $idpas=$dapas['id_pasien'];
                                                            }
                                                            $querydt = mysqli_query($koneksi, "SELECT * from resep_obat WHERE setatus='Register' or setatus='Closed' and no_rekam_medis='$normmed'")
                                                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                            $rowsdt = mysqli_num_rows($querydt);
                                                            if ($rowsdt <> 0) {
                                                            $datr= mysqli_fetch_assoc($querydt);
                                                            $idresp=$datr['id_resep_obat'];
                                                            ?>
                                                            <a style="margin-top:1px;" class="btn btn-sm btn-secondary has-tooltip page-modal"  href="<?php  print_link("data_resep/obat?detile_precord=$normmed&datprecord=$idpas");?>">
                                                            <i class="fa fa-eye"></i> Lihat Resep</a> 
                                                            <?php 
                                                            }
                                                            if($data['setatus']=="" or $data['setatus']=="Register"){  
                                                            $key="dermawangroup";
                                                            $plaintext = "$rec_id";
                                                            $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                                                            $iv = openssl_random_pseudo_bytes($ivlen);
                                                            $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                                                            $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                                                            $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
                                                            ?>
                                                            <a style="margin-top:1px;" class="btn btn-sm btn-secondary has-tooltip"  href="<?php print_link("igd/resep?precord=$ciphertext") ?>">
                                                                <i class="fa fa-file-archive-o "></i> Add Resep Obat
                                                            </a>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                </span></td>
                                                <td class="td-rekam_medis"> <span>
                                                    <div class="dropdown" >
                                                        <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                                                            <i class="fa fa-bars"></i> 
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <?php
                                                            $dtrm=$data['no_rekam_medis'];
                                                            $queryrm = mysqli_query($koneksi, "SELECT * from rekam_medis WHERE no_rekam_medis='$dtrm'")
                                                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                            $rowsrm = mysqli_num_rows($queryrm);
                                                            if ($rowsrm <> 0) {
                                                            $ckrm= mysqli_fetch_assoc($queryrm);
                                                            $idrm=$ckrm['id_rekam_medis'];
                                                            $queryb = mysqli_query($koneksi, "select * from data_rekam_medis WHERE no_rekam_medis='$dtrm'")
                                                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                            // ambil jumlah baris data hasil query
                                                            $rowsb = mysqli_num_rows($queryb);
                                                            // cek hasil query
                                                            // jika "no_antrian" sudah ada
                                                            if ($rowsb <> 0) {
                                                            ?>
                                                            <a class="btn btn-sm btn-primary has-tooltip"  href="<?php  print_link("rekam_medis/detile/$idrm?detile_precord=$dtrm");?>">
                                                            <i class="fa fa-eye"></i>Lihat Detil</a>
                                                            <?php }
                                                            }
                                                            if($data['setatus']=="" or $data['setatus']=="Register" ){
                                                            ?>
                                                            <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip" href="<?php  print_link("data_rekam_medis/add?precord=$ciphertext&pasien=IGD");?>">
                                                            <i class="fa fa-file-archive-o "></i> Isi Rekam Medis</a>       
                                                            <?php 
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </span></td>
                                                <td class="td-assesment_medis"> <style>
                                                    .dropdown a.dropdown-item:hover {
                                                    cursor: pointer;
                                                    background-color: #F5F5DC;
                                                    }
                                                </style>
                                                <span>
                                                    <div class="dropdown" >
                                                        <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                                                            <i class="fa fa-bars"></i> 
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <?php
                                                            $norm=$data['no_rekam_medis'];
                                                            $qup = mysqli_query($koneksi, "SELECT * from data_pasien WHERE no_rekam_medis='$norm'")
                                                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                            $rop = mysqli_num_rows($qup);
                                                            if ($rop <> 0) {
                                                            $ctp= mysqli_fetch_assoc($qup);
                                                            $idpas=$ctp['id_pasien'];
                                                            }
                                                            $qutrt = mysqli_query($koneksi, "SELECT * from assesment_medis WHERE no_rekam_medis='$norm'")
                                                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                            $rotrt = mysqli_num_rows($qutrt);
                                                            if ($rotrt <> 0) {
                                                            $ctrt= mysqli_fetch_assoc($qutrt);
                                                            //$idtri=$ctrt['id_triase'];
                                                            ?>
                                                            <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip page-modal" href="<?php  print_link("assesment_medis?precord=$norm&datprecord=$idpas");?>">
                                                            <i class="fa fa-eye"></i> Lihat Assesment Medis</a>
                                                            <?php
                                                            }   
                                                            $qutr = mysqli_query($koneksi, "SELECT * from assesment_medis WHERE id_daftar='$rec_id' and no_rekam_medis='$norm'")
                                                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                            $rotr = mysqli_num_rows($qutr);
                                                            if ($rotr <> 0) {
                                                            $ctr= mysqli_fetch_assoc($qutr);
                                                            $idtri=$ctr['id_triase'];
                                                            }else{
                                                            }
                                                            if($data['setatus']=="" or $data['setatus']=="Register"){?>
                                                            <a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip"  href="<?php  print_link("assesment_medis/add?precord=$ciphertext&datprecord=$idpas&datfrom=IGD");?>">
                                                            <i class="fa fa-send"></i>  Add Assesment Medis</a>                               
                                                            <?php  
                                                            }
                                                            ?>  
                                                        </ul>
                                                    </div>
                                                </span>
                                            </td>
                                            <td class="td-action"> <style>
                                                .dropdown a.dropdown-item:hover {
                                                cursor: pointer;
                                                background-color: #F5F5DC;
                                                }
                                            </style>
                                            <span>
                                                <?php 
                                                $id_user = "".USER_ID;
                                                $dbhost  = "".DB_HOST;
                                                $dbuser  = "".DB_USERNAME;
                                                $dbpass  = "".DB_PASSWORD;
                                                $dbname  = "".DB_NAME;
                                                //$koneksi=open_connection();
                                                $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
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
                                                        //assesment_triase/add
                                                        $norm=$data['no_rekam_medis'];
                                                        $qudt = mysqli_query($koneksi, "SELECT * from penjualan WHERE id_jual='$rec_id' and id_pelanggan='$norm'  ORDER BY `id_penjualan` DESC")
                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                        $rodt = mysqli_num_rows($qudt);
                                                        if ($rodt <> 0) {
                                                        $cdt= mysqli_fetch_assoc($qudt);
                                                        $idpnj=$cdt['id_penjualan']; 
                                                        $totbeli=$cdt['total_harga_beli']; 
                                                        $totjual=$cdt['total_harga_jual'];
                                                        $totuntung=$totjual - $totbeli;
                                                        // total_untung
                                                        mysqli_query($koneksi,"UPDATE penjualan SET total_untung='$totuntung'  WHERE id_penjualan='$idpnj'");
                                                        } 
                                                        $idtransaksi=$data['id_transaksi'];
                                                        $dokter=$data['dokter'];
                                                        $querydt = mysqli_query($koneksi, "SELECT * from data_rekam_medis WHERE id_daftar='$rec_id'")
                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                        // ambil jumlah baris data hasil query
                                                        $rowsdt = mysqli_num_rows($querydt);
                                                        // cek hasil query
                                                        // jika "no_antrian" sudah ada
                                                        if ($rowsdt <> 0) {
                                                        $ckdtr= mysqli_fetch_assoc($querydt);
                                                        $idrmr=$ckdtr['id'];
                                                        $ceksuhu=$ckdtr['suhu_badan'];
                                                        if($ceksuhu==""){
                                                        ?>
                                                        <?php
                                                        }
                                                        }else{
                                                        }
                                                        if($data['setatus']=="" or $data['setatus']=="Register" ){
                                                        ?>
                                                        <?php 
                                                        }
                                                        $dtrm=$data['no_rekam_medis'];
                                                        $queryrm = mysqli_query($koneksi, "SELECT * from rekam_medis WHERE no_rekam_medis='$dtrm'")
                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                        $rowsrm = mysqli_num_rows($queryrm);
                                                        if ($rowsrm <> 0) {
                                                        $ckrm= mysqli_fetch_assoc($queryrm);
                                                        $idrm=$ckrm['id_rekam_medis'];
                                                        ?>
                                                        <?php
                                                        }
                                                        ////////////////////////////////////////////////////////////////$dokter 
                                                        $no_rekam_medis=$data['no_rekam_medis'];
                                                        $queijin = mysqli_query($koneksi, "select * from ijin_pulang WHERE id_daftar='$rec_id' and no_rekam_medis='$no_rekam_medis'")
                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                        // ambil jumlah baris data hasil query
                                                        $roijin = mysqli_num_rows($queijin);
                                                        if ($roijin <> 0) {
                                                        $datijin    = mysqli_fetch_assoc($queijin);
                                                        $idijin=$datijin['id'];
                                                        ?>
                                                        <a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip page-modal"  href="<?php  print_link("ijin_pulang/view/$idijin?precord=$ciphertext");?>">
                                                        <i class="fa fa-send"></i> Lihat Ijin Pulang</a>  
                                                        <?php  }else{ 
                                                        $quep = mysqli_query($koneksi, "SELECT * from data_pasien WHERE no_rekam_medis='$no_rekam_medis'")
                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                        $rowp = mysqli_num_rows($quep);
                                                        if ($rowp <> 0) {
                                                        $ckrmp= mysqli_fetch_assoc($quep);
                                                        $ipas=$ckrmp['id_pasien'];
                                                        }
                                                        if($data['setatus']=="Closed"){}else{
                                                        ?>
                                                        <a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip"  href="<?php  print_link("ijin_pulang/pulang?precord=$ciphertext&datprecord=$ipas&darecord=igd");?>">
                                                        <i class="fa fa-send"></i> Add Ijin Pulang</a>     
                                                        <?php }
                                                        }
                                                        $qud= mysqli_query($koneksi, "select * from data_dokter WHERE id_dokter='$dokter'")
                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                        // ambil jumlah baris data hasil query
                                                        $rotd = mysqli_num_rows($qud);
                                                        if ($rotd <> 0) {
                                                        $datd   = mysqli_fetch_assoc($qud);
                                                        // $idtrx      = $datd['specialist '];  
                                                        $jasaigd=$dattrxb['jasa_igd'];
                                                        $tagigd=$dattrxb['tagihan_jasa_igd'];
                                                        } 
                                                        $quetrxb= mysqli_query($koneksi, "select * from transaksi WHERE id='$idtransaksi' and setatus_tagihan='Register'")
                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                        // ambil jumlah baris data hasil query
                                                        $rotrxb = mysqli_num_rows($quetrxb);
                                                        if ($rotrxb <> 0) {
                                                        $dattrxb    = mysqli_fetch_assoc($quetrxb);
                                                        $idtrx      = $dattrxb['id'];  
                                                        $totaltagih=$dattrxb['total_tagihan'];
                                                        }
                                                        $quetag = mysqli_query($koneksi, "select * from data_tagihan_pasien WHERE id_transaksi='$idtransaksi' and nama_tagihan='Jasa Dokter'")
                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                        // ambil jumlah baris data hasil query
                                                        $rotag = mysqli_num_rows($quetag);
                                                        if ($rotag <> 0) {
                                                        $datag    = mysqli_fetch_assoc($quetag);
                                                        $notag=$datag['no_tag'];
                                                        }else{ 
                                                        if($tagigd=="Tidak" or $tagigd==""){ }else{
                                                        $jumlahatag= $jasaigd + $totaltagih;
                                                        mysqli_query($koneksi,"UPDATE transaksi SET total_tagihan='$jumlahatag'  WHERE id='$idtrx'");
                                                        mysqli_query($koneksi,"INSERT INTO `data_tagihan_pasien` (`id_transaksi`,`id_data`,`nama_tagihan`,`tanggal`,`no_rekam_medis`,`total_tagihan`,`setatus`,`pasien`,`keterangan`) VALUES ('$idtrx','$rec_id','Jasa Dokter','".date("Y-m-d H:i:s")."','$no_rekam_medis','$jasaigd','Register','IGD','Jasa Dokter IGD')");
                                                        }
                                                        }
                                                        if($data['setatus']=="Closed"){}else{
                                                        ?>
                                                        <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip"    href="<?php print_link("pendaftaran_operasi/add?precord=$ciphertext&pasien=IGD&csrf_token=$csrf_token") ?>">
                                                            <i class="fa fa-file-archive-o "></i> Add Operasi
                                                        </a>         
                                                        <?php }?>
                                                    </ul>
                                                </div>
                                            </span></td>
                                            <td class="td-rawat_inap"> <span>
                                                <div class="dropdown" >
                                                    <button data-toggle="dropdown" class="dropdown-toggle btn btn-dark btn-sm">
                                                        <i class="fa fa-bars"></i> 
                                                        </button><ul class="dropdown-menu">
                                                        <?php
                                                        $norm=$data['no_rekam_medis'];
                                                        $qutrip = mysqli_query($koneksi, "SELECT * from perintah_opname WHERE id_daftar='$rec_id' and no_rekam_medis='$norm'")
                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                        $rotrip = mysqli_num_rows($qutrip);
                                                        if ($rotrip <> 0) {
                                                        $ctrip= mysqli_fetch_assoc($qutrip);
                                                        $idop=$ctrip['id'];
                                                        ?>
                                                        <a style="margin-top:2px;" class="btn btn-sm btn-dark has-tooltip page-modal"  href="<?php  print_link("perintah_opname/opname/$idop?precord=$norm&datprecord=$rec_id");?>">
                                                        <i class="fa fa-send"></i> Lihat Perintah Opname</a>  
                                                        <?php
                                                        }else{
                                                        ?>
                                                        <a style="margin-top:2px;" class="btn btn-sm btn-dark has-tooltip"  href="<?php  print_link("perintah_opname/add?precord=$ciphertext&datprecord=$rec_id&dat");?>">
                                                        <i class="fa fa-send"></i> Add Perintah Opname</a>  
                                                        <?php
                                                        //Perintah Opname
                                                        }
                                                        if($data['setatus']=="Closed"){}else{
                                                        //  if(USER_ROLE==15){
                                                        $key="dermawangroup";
                                                        $plaintext = "$rec_id";
                                                        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                                                        $iv = openssl_random_pseudo_bytes($ivlen);
                                                        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                                                        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                                                        $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
                                                        $querydtb = mysqli_query($koneksi, "SELECT * FROM `perintah_opname`  WHERE id_daftar='$rec_id' and no_rekam_medis='$norm'")
                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                        $rowsdtb = mysqli_num_rows($querydtb);
                                                        if ($rowsdtb <> 0) {      
                                                        //  $datidb= mysqli_fetch_assoc($querydtb);
                                                        // $idrekam=$datidb['id_rekam_medis'];
                                                        $quei = mysqli_query($koneksi, "SELECT * FROM `rawat_inap`  WHERE id_igd='$rec_id' and no_rekam_medis='$norm'")
                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                        $rowi= mysqli_num_rows($quei);
                                                        if ($rowi <> 0) {
                                                        $opname1="";
                                                        }else{
                                                        $opname1="Ya";
                                                        }
                                                        $queia = mysqli_query($koneksi, "SELECT * FROM `ranap_anak`  WHERE id_igd='$rec_id' and no_rekam_medis='$norm'")
                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                        $rowia= mysqli_num_rows($queia);
                                                        if ($rowia <> 0) {
                                                        $opname2="";
                                                        }else{
                                                        $opname2="Ya";
                                                        } 
                                                        $queib = mysqli_query($koneksi, "SELECT * FROM `ranap_bersalin`  WHERE id_igd='$rec_id' and no_rekam_medis='$norm'")
                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                        $rowib= mysqli_num_rows($queib);
                                                        if ($rowib <> 0) {
                                                        $opname3="";
                                                        }else{
                                                        $opname3="Ya";
                                                        } 
                                                        if($opname1==""){
                                                        $opname="";
                                                        }else   if($opname2==""){
                                                        $opname="";
                                                        }else   if($opname3==""){
                                                        $opname="";
                                                        }else{
                                                        $opname="Ya";
                                                        }
                                                        if($opname=="Ya"){
                                                        $cekumur = explode(' ', $data['umur']);
                                                        $int_var = (int)filter_var($cekumur[0], FILTER_SANITIZE_NUMBER_INT); 
                                                        if($int_var < 14) {}else{
                                                        ?>
                                                        <a style="margin-top:1px;" class="btn btn-sm btn-dark has-tooltip" href="<?php print_link("rawat_inap/add?precord=$ciphertext&pasien=IGD") ?>">
                                                            <i class="fa fa-bed "></i> Add Rawat inap
                                                        </a>
                                                        <?php }
                                                        if($data['jenis_kelamin']=="Perempuan" and $int_var >15){?>
                                                        <a style="margin-top:1px;" class="btn btn-sm btn-dark has-tooltip" href="<?php print_link("ranap_bersalin/add?precord=$ciphertext&pasien=IGD") ?>">
                                                            <i class="fa fa-bed "></i> Add Ruang Bersalin
                                                        </a>   
                                                        <?php }
                                                        if($int_var < 18){
                                                        ?>    
                                                        <a style="margin-top:1px;" class="btn btn-sm btn-dark has-tooltip" href="<?php print_link("ranap_anak/add?precord=$ciphertext&pasien=IGD") ?>">
                                                            <i class="fa fa-bed "></i> Add Rawat inap Anak
                                                        </a>
                                                        <?php
                                                        }
                                                        }
                                                        }
                                                        //}
                                                        ?>
                                                        <a style="margin-top:1px;" class="btn btn-sm btn-dark has-tooltip" href="<?php print_link("rawat_inap_anak/add?precord=$ciphertext&pasien=IGD") ?>">
                                                            <i class="fa fa-bed "></i> Add Operasi
                                                        </a>
                                                        <?php
                                                        }?>
                                                    </ul>
                                                </div>
                                            </span></td>
                                            <td class="td-pembayaran">
                                                <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("data_bank/view/" . urlencode($data['pembayaran'])) ?>">
                                                    <i class="fa fa-eye"></i> <?php echo $data['data_bank_nama_bank'] ?>
                                                </a>
                                            </td>
                                            <td class="td-setatus_bpjs"> <?php echo $data['setatus_bpjs']; ?></td>
                                            <td class="td-setatus"> <?php
                                                if($data['setatus']=="Closed"){
                                                ?>
                                                <span style="border-radius: 8px; background-color:     #DC143C; color: white; padding:5px; font-weight: bold;"><?php echo $data['setatus']; ?></span>
                                                <?php
                                                }else if($data['setatus']=="Register"){
                                                ?>
                                                <span style="border-radius: 8px; background-color: #1E90FF; color: white; padding:5px; font-weight: bold;"><?php echo $data['setatus']; ?></span>
                                                <?php
                                                }else{
                                                ?>
                                                <span ><?php echo $data['setatus']; ?></span>
                                                <?php
                                                }
                                            ?></td>
                                            <td class="td-tanggal_keluar"> <?php echo $data['tanggal_keluar']; ?></td>
                                            <td class="page-list-action td-btn">
                                                <div class="dropdown" >
                                                    <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                                                        <i class="fa fa-bars"></i> 
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <?php if($can_view){ ?>
                                                        <a class="dropdown-item page-modal" href="<?php print_link("igd/view/$rec_id"); ?>">
                                                            <i class="fa fa-eye"></i> View 
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
