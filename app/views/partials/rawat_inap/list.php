<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("rawat_inap/add");
$can_edit = ACL::is_allowed("rawat_inap/edit");
$can_view = ACL::is_allowed("rawat_inap/view");
$can_delete = ACL::is_allowed("rawat_inap/delete");
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
    <div  class="bg-white p-1 mb-1">
        <div class="container-fluid">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Rawat Inap</h4>
                </div>
                <div class="col-sm-4 ">
                    <form  class="search" action="<?php print_link('rawat_inap'); ?>" method="get">
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
                                        <a class="text-decoration-none" href="<?php print_link('rawat_inap'); ?>">
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
                                        <a class="text-decoration-none" href="<?php print_link('rawat_inap'); ?>">
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
            <div class="container-fluid">
                <div class="row ">
                    <div class="col-md-12 comp-grid">
                        <div class="card mb-3 sticky-top">
                            <?php $menu_id = "menu-" . random_str(); ?>
                            <nav class="navbar navbar-expand-lg navbar-light">
                                <div class="h4">Filter by Nama Kamar</div>
                                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#<?php echo $menu_id ?>" aria-expanded="false">
                                    <span class="navbar-toggler-icon"></span>
                                </button>
                            </nav>
                            <div class="collapse collapse-lg " id="<?php echo $menu_id ?>">
                                <ul class="nav nav-pills">
                                    <?php 
                                    $option_list = $comp_model->rawat_inap_rawat_inapnama_kamar_option_list();
                                    if(!empty($option_list)){
                                    foreach($option_list as $option){
                                    $value = (!empty($option['value']) ? $option['value'] : null);
                                    $label = (!empty($option['label']) ? $option['label'] : $value);
                                    $nav_link = $this->set_current_page_link(array('rawat_inap_nama_kamar' => $value , 'rawat_inap_nama_kamarlabel' => $label) , false);
                                    ?>
                                    <li class="nav-item">
                                        <a class="nav-link <?php echo is_active_link('rawat_inap_nama_kamar', $value); ?>" href="<?php print_link($nav_link) ?>">
                                            <?php echo $label; ?>
                                        </a>
                                    </li>
                                    <?php
                                    }
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>
                        <?php $this :: display_page_errors(); ?>
                        <div class="filter-tags mb-2">
                            <?php
                            if(!empty(get_value('rawat_inap_nama_kamar'))){
                            ?>
                            <div class="filter-chip card bg-light">
                                <b>Nama Kamar :</b> 
                                <?php 
                                if(get_value('rawat_inap_nama_kamarlabel')){
                                echo get_value('rawat_inap_nama_kamarlabel');
                                }
                                else{
                                echo get_value('rawat_inap_nama_kamar');
                                }
                                $remove_link = unset_get_value('rawat_inap_nama_kamar', $this->route->page_url);
                                ?>
                                <a href="<?php print_link($remove_link); ?>" class="close-btn">
                                    &times;
                                </a>
                            </div>
                            <?php
                            }
                            ?>
                        </div>
                        <div  class=" animated fadeIn page-content">
                            <div id="rawat_inap-list-records">
                                <div id="page-report-body" class="table-responsive">
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
                                                <th  class="td-poli"> Specialist</th>
                                                <th  class="td-dokter_pengirim"> Dokter Pengirim</th>
                                                <th  class="td-dokter_rawat_inap"> Dokter Rawat Inap</th>
                                                <th  class="td-action"> Action</th>
                                                <th  class="td-pemeriksaan_fisik"> Pemeriksaan Fisik</th>
                                                <th  class="td-catatan_medis"> Catatan Medis</th>
                                                <th  class="td-tindakan"> Tindakan</th>
                                                <th  class="td-resep_obat"> Resep Obat</th>
                                                <th  class="td-lab"> Lab</th>
                                                <th  class="td-assesment_medis"> Assesment Medis</th>
                                                <th  class="td-rekam_medis"> Rekam Medis</th>
                                                <th  class="td-pembayaran"> Pembayaran</th>
                                                <th  class="td-setatus_bpjs"> Setatus Bpjs</th>
                                                <th  class="td-kamar_kelas"> Kamar Kelas</th>
                                                <th  class="td-nama_kamar"> Nama Kamar</th>
                                                <th  class="td-no_kamar"> No Kamar</th>
                                                <th  class="td-no_ranjang"> No Ranjang</th>
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
                                            $rec_id = (!empty($data['id']) ? urlencode($data['id']) : null);
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
                                                <td class="td-poli">
                                                    <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("data_poli/view/" . urlencode($data['poli'])) ?>">
                                                        <i class="fa fa-eye"></i> <?php echo $data['data_poli_nama_poli'] ?>
                                                    </a>
                                                </td>
                                                <td class="td-dokter_pengirim"> <span><?php
                                                    $key="dermawangroup";
                                                    $plaintext = "$rec_id";
                                                    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                                                    $iv = openssl_random_pseudo_bytes($ivlen);
                                                    $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                                                    $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                                                    $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
                                                    $usrnam  = "".USER_NAME;
                                                    $id_user = "".USER_ID;
                                                    $dbhost  = "".DB_HOST;
                                                    $dbuser  = "".DB_USERNAME;
                                                    $dbpass  = "".DB_PASSWORD;
                                                    $dbname  = "".DB_NAME;
                                                    $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                                                    $idtrace = "$id_user$usrnam";
                                                    $Queryp = "SELECT * FROM data_dokter WHERE id_dokter='".$data['dokter_pengirim']."'";
                                                    $ExecQueryp = MySQLi_query($koneksi, $Queryp);
                                                    $rowsc = mysqli_num_rows($ExecQueryp);
                                                    if ($rowsc <> 0) {
                                                    $Resultp = mysqli_fetch_assoc($ExecQueryp);
                                                    $namdok=$Resultp['nama_dokter'];
                                                    }else{
                                                    $namdok=$data['dokter_pengirim'];
                                                    }
                                                echo $namdok; ?></span></td>
                                                <td class="td-dokter_rawat_inap">
                                                    <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("data_dokter/view/" . urlencode($data['dokter_rawat_inap'])) ?>">
                                                        <i class="fa fa-eye"></i> <?php echo $data['data_dokter_nama_dokter'] ?>
                                                    </a>
                                                </td>
                                                <td class="td-action"><style>
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
                                                    $idtransaksi=$data['id_transaksi'];
                                                    if($data['setatus']=="Closed"){ echo $data['setatus']; }else{?>
                                                    <div class="dropdown" >
                                                        <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                                                            <i class="fa fa-bars"></i> 
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <?php 
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
                                                            $key="dermawangroup";
                                                            $plaintext = "$rec_id";
                                                            $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                                                            $iv = openssl_random_pseudo_bytes($ivlen);
                                                            $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                                                            $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                                                            $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
                                                            ?>
                                                            <?php if($data['setatus']=="Chekin"){
                                                            $no_rekam_medis=$data['no_rekam_medis'];
                                                            $dtkelas= mysqli_query($koneksi, "select * from data_kelas WHERE id_kelas='".$data['kamar_kelas']."' ")
                                                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                            // ambil jumlah baris data hasil query
                                                            $rodtk = mysqli_num_rows($dtkelas);
                                                            if ($rodtk <> 0) {
                                                            $datkl    = mysqli_fetch_assoc($dtkelas);
                                                            $hargakamar      = $datkl['harga'];  
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
                                                            $quetag = mysqli_query($koneksi, "select * from data_tagihan_pasien WHERE id_transaksi='$idtransaksi' and nama_tagihan='Tagihan Kamar'")
                                                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                            // ambil jumlah baris data hasil query
                                                            $rotag = mysqli_num_rows($quetag);
                                                            if ($rotag <> 0) {
                                                            $datag    = mysqli_fetch_assoc($quetag);
                                                            $notag=$datag['no_tag'];
                                                            }else{ 
                                                            $jumlahatag= $hargakamar + $totaltagih;
                                                            mysqli_query($koneksi,"UPDATE transaksi SET total_tagihan='$jumlahatag'  WHERE id='$idtrx'");
                                                            mysqli_query($koneksi,"INSERT INTO `data_tagihan_pasien` (`id_transaksi`,`id_data`,`nama_tagihan`,`tanggal`,`no_rekam_medis`,`total_tagihan`,`setatus`,`pasien`,`keterangan`) VALUES ('$idtrx','$rec_id','Tagihan Kamar','".date("Y-m-d H:i:s")."','$no_rekam_medis','$hargakamar','Register','RAWAT INAP','Tagihan Kamar Rawat inap')");
                                                            }
                                                            $tglmsk=$data['tanggal_masuk']; 
                                                            $awal  = new DateTime($tglmsk);
                                                            $akhir = new DateTime(); // Waktu sekarang
                                                            $diff  = $awal->diff($akhir);
                                                            //echo 'Selisih waktu: ';
                                                            //echo $diff->y . ' tahun, ';
                                                            //echo $diff->m . ' bulan, ';
                                                            //echo $diff->d . ' hari, ';
                                                            //echo $diff->h . ' jam, ';
                                                            //echo $diff->i . ' menit, ';
                                                            //echo $diff->s . ' detik, ';
                                                            //$thun=$diff->y . ' Tahun, ';
                                                            //$buln=$diff->m . ' Bulan, ';
                                                            //$hri=$diff->d . ' Hari';
                                                            //$jam=$diff->h . ' jam, ';
                                                            $thun=$diff->y . '';
                                                            $buln=$diff->m . '';
                                                            $hri=$diff->d . '';
                                                            $jam=$diff->h . '';
                                                            $umrskrng="$thun$buln$hri$jam";
                                                            if($hri > 0){
                                                            for ($x = 0; $x <= $hri; $x++) {
                                                            // echo "The number is $hri: $x <br>";
                                                                $quetagno = mysqli_query($koneksi, "select * from data_tagihan_pasien WHERE id_transaksi='$idtrx' and nama_tagihan='Tagihan Kamar' and no_tag='$x'")
                                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                // ambil jumlah baris data hasil query
                                                                $rotagno = mysqli_num_rows($quetagno);
                                                                if ($rotagno <> 0) {
                                                                }else{
                                                                $quetrxbk= mysqli_query($koneksi, "select * from transaksi WHERE id='$idtransaksi' and setatus_tagihan='Register'")
                                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                // ambil jumlah baris data hasil query
                                                                $rotrxbk = mysqli_num_rows($quetrxbk);
                                                                if ($rotrxbk <> 0) {
                                                                $dattrxbk    = mysqli_fetch_assoc($quetrxbk);
                                                                $totatag=$dattrxbk['total_tagihan'];
                                                                }  
                                                                $jumlahatag= $hargakamar + $totatag;
                                                                mysqli_query($koneksi,"UPDATE transaksi SET total_tagihan='$jumlahatag'  WHERE id='$idtransaksi'");
                                                                $hn=$x + 1; 
                                                                mysqli_query($koneksi,"INSERT INTO `data_tagihan_pasien` (`no_tag`,`id_transaksi`,`id_data`,`nama_tagihan`,`tanggal`,`no_rekam_medis`,`total_tagihan`,`setatus`,`pasien`,`keterangan`) VALUES ('$x','$idtransaksi','$rec_id','Tagihan Kamar','".date("Y-m-d H:i:s")."','$no_rekam_medis','$hargakamar','Register','RAWAT INAP','Tagihan Kamar Rawat inap Hari Ke $hn')");
                                                                }
                                                                } 
                                                                //$notag
                                                                }
                                                                $queijin = mysqli_query($koneksi, "select * from kunjungan_dokter WHERE id_daftar='$rec_id' and no_rekam_medis='$no_rekam_medis'")
                                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                // ambil jumlah baris data hasil query
                                                                $roijin = mysqli_num_rows($queijin);
                                                                if ($roijin <> 0) {
                                                                ?>
                                                                <a style="margin-top:2px;"  class="btn btn-sm btn-primary has-tooltip page-modal"    href="<?php print_link("kunjungan_dokter?precord=$ciphertext&darecord=rawat_inap") ?>">
                                                                    <i class="fa fa-user-md "></i> Lihat Kunjungan Dokter
                                                                </a> 
                                                                <?php   
                                                                }
                                                                ?>
                                                                <a style="margin-top:2px;"  class="btn btn-sm btn-primary has-tooltip"    href="<?php print_link("kunjungan_dokter/add?precord=$ciphertext&datprecord=$rec_id&darecord=rawat_inap") ?>">
                                                                    <i class="fa fa-user-md "></i> Add Kunjungan Dokter
                                                                </a> 
                                                                <?php 
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
                                                                <?php  }else{ ?>
                                                                <a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip"  href="<?php  print_link("ijin_pulang/add?precord=$ciphertext&datprecord=$rec_id&darecord=rawat_inap");?>">
                                                                <i class="fa fa-send"></i> Add Ijin Pulang</a>     
                                                                <?php } }else{?>
                                                                <?php
                                                                if($data['no_ranjang']==""){?>
                                                                <a style="margin-top:2px;" class="dropdown-item "   href="<?php print_link("data_kamar?precord=$ciphertext") ?>">
                                                                    <i class="fa fa-file-archive-o "></i> Pilih kamar
                                                                </a>
                                                                <?php }else{?>
                                                                <a style="margin-top:2px;" class="dropdown-item "   href="<?php print_link("rawat_inap/chekin?precord=$ciphertext") ?>">
                                                                    <i class="fa fa-bed "></i> Chekin Pasien
                                                                </a>      
                                                                <?php } }  ?>  
                                                            </ul>
                                                        </div>
                                                        <?php
                                                        ////////////////////////////////////////////////////
                                                        ?>
                                                        <?php }  
                                                        ///////////////////////////////////////////////////   
                                                        ?>  
                                                    </span></td>
                                                    <td class="td-pemeriksaan_fisik">   <style>
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
                                                                if($data['setatus']=="Chekin"){?>
                                                                <a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip"  href="<?php  print_link("pemeriksaan_fisik/inap?precord=$ciphertext&datprecord=$rec_id&datfrom=RANAP");?>">
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
                                                                if($data['setatus']=="Chekin"){
                                                                ?>
                                                                <a class="btn btn-sm btn-danger has-tooltip"  href="<?php  print_link("catatan_medis/add?precord=$ciphertext&pasien=RAWAT INAP&datprecord=$ipas");?>">
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
                                                                <a style="margin-top:2px;" class="dropdown-item page-modal"  href="<?php  print_link("rekam_medis/tindakan/$iddatrm?detile_precord=$dtrekam");?>">
                                                                <i class="fa fa-user "></i> Lihat Tindakan</a> 
                                                                <?php
                                                                }
                                                                if($data['setatus']=="Chekin"){
                                                                $key="dermawangroup";
                                                                $plaintext = "$rec_id";
                                                                $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                                                                $iv = openssl_random_pseudo_bytes($ivlen);
                                                                $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                                                                $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                                                                $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
                                                                ?>
                                                                <a style="margin-top:2px;" class="dropdown-item"  href="<?php print_link("data_tindakan/add?precord=$ciphertext&pasien=RAWAT INAP") ?>">
                                                                    <i class="fa fa-user-md "></i> Add Tindakan
                                                                </a>
                                                                <?php }?>   
                                                            </ul>
                                                        </div>
                                                    </span>
                                                </td>
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
                                                            if($data['setatus']=="Chekin"){  
                                                            $key="dermawangroup";
                                                            $plaintext = "$rec_id";
                                                            $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                                                            $iv = openssl_random_pseudo_bytes($ivlen);
                                                            $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                                                            $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                                                            $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
                                                            ?>
                                                            <a style="margin-top:1px;" class="btn btn-sm btn-secondary has-tooltip"  href="<?php print_link("rawat_inap/resep?precord=$ciphertext") ?>">
                                                                <i class="fa fa-file-archive-o "></i> Add Resep Obat
                                                            </a>
                                                            <?php } ?>
                                                        </ul>
                                                    </div>
                                                </span></td>
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
                                                        if($data['setatus']=="Chekin"){
                                                        $key="dermawangroup";
                                                        $plaintext = "$rec_id";
                                                        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                                                        $iv = openssl_random_pseudo_bytes($ivlen);
                                                        $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                                                        $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                                                        $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
                                                        ?>
                                                        <a style="margin-top:2px;margin-bottom:5px;" class="btn btn-sm btn-success"    href="<?php print_link("pendaftaran_lab/lab?precord=$ciphertext&pasien=RANAP&datprecord=$idpas") ?>">
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
                                                        <a style="margin-top:2px;" class="btn btn-sm btn-secondary has-tooltip"  href="<?php  print_link("hasil_lab_luar/add?csrf_token=$csrf_toke&pasien=RAWAT INAP&datrecord=$rec_id");?>">
                                                        <i class="fa fa-send"></i>Uploads Hasil Lab Luar</a>       
                                                        <?php   
                                                        ?>
                                                    </ul>
                                                </div>
                                            </span>
                                        </td>
                                        <td class="td-assesment_medis">  <style>
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
                                                    $qutripm = mysqli_query($koneksi, "SELECT * from assesment_medis WHERE id_daftar='$rec_id' and no_rekam_medis='$norm'")
                                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                    $rotripm = mysqli_num_rows($qutripm);
                                                    if ($rotripm <> 0) {
                                                    $ctripm= mysqli_fetch_assoc($qutripm);
                                                    $idopm=$ctripm['id'];
                                                    ?>
                                                    <?php }else{  
                                                    }
                                                    if($data['setatus']=="Chekin"){?>
                                                    <a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip"  href="<?php  print_link("assesment_medis/add?precord=$ciphertext&datprecord=$idpas&datfrom=RANAP");?>">
                                                    <i class="fa fa-send"></i>  Add Assesment Medis</a>  
                                                    <?php
                                                    }
                                                    ?> 
                                                </ul>
                                            </div>
                                        </span>
                                    </td>
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
                                                if($data['setatus']=="Chekin"){
                                                ?>
                                                <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip" href="<?php  print_link("data_rekam_medis/add?precord=$ciphertext&pasien=RANAP");?>">
                                                <i class="fa fa-file-archive-o "></i> Isi Rekam Medis</a>       
                                                <?php 
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </span></td>
                                    <td class="td-pembayaran">
                                        <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("data_bank/view/" . urlencode($data['pembayaran'])) ?>">
                                            <i class="fa fa-eye"></i> <?php echo $data['data_bank_nama_bank'] ?>
                                        </a>
                                    </td>
                                    <td class="td-setatus_bpjs"> <?php echo $data['setatus_bpjs']; ?></td>
                                    <td class="td-kamar_kelas"> <span>
                                        <?php
                                        if($data['kamar_kelas']=="" or $data['kamar_kelas']=="0"){ }else{
                                        $Queryk = "SELECT * FROM data_kelas WHERE id_kelas='".$data['kamar_kelas']."'";
                                        $ExecQueryk = MySQLi_query($koneksi, $Queryk);
                                        while ($Resultk = MySQLi_fetch_array($ExecQueryk)) {
                                        $namkel=$Resultk['nama_kelas'];
                                        }
                                        echo $namkel; }?>   
                                    <?php //echo $data['kamar_kelas']; ?></span></td>
                                    <td class="td-nama_kamar"> <span><?php
                                        if($data['nama_kamar']=="" or $data['nama_kamar']=="0"){ }else{
                                        $Queryk = "SELECT * FROM nama_kamar_ranap WHERE id='".$data['nama_kamar']."'";
                                        $ExecQueryk = MySQLi_query($koneksi, $Queryk);
                                        while ($Resultk = MySQLi_fetch_array($ExecQueryk)) {
                                        $namkel=$Resultk['nama_kamar'];
                                        }
                                        echo $namkel; }
                                        // echo $data['nama_kamar'];
                                    ?></span></td>
                                    <td class="td-no_kamar"> <?php echo $data['no_kamar']; ?></td>
                                    <td class="td-no_ranjang"> <?php echo $data['no_ranjang']; ?></td>
                                    <td class="td-setatus"><?php
                                        if($data['setatus']=="Closed"){
                                        ?>
                                        <span style="border-radius: 8px; background-color: #DC143C; color: white; padding:5px; font-weight: bold;"><?php echo $data['setatus']; ?></span>
                                        <?php
                                        }else if($data['setatus']=="Register"){
                                        ?>
                                        <span style="border-radius: 8px; background-color:  #1E90FF; color: white; padding:5px; font-weight: bold;"><?php echo $data['setatus']; ?></span>
                                        <?php
                                        }else{
                                        ?>
                                        <span style="border-radius: 8px; background-color: #228B22; color: white; padding:5px; font-weight: bold;"><?php echo $data['setatus']; ?></span>
                                        <?php
                                        }
                                        ?>
                                    </td>
                                    <td class="td-tanggal_keluar"> <?php echo $data['tanggal_keluar']; ?></td>
                                    <td class="page-list-action td-btn">
                                        <div class="dropdown" >
                                            <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                                                <i class="fa fa-bars"></i> 
                                            </button>
                                            <ul class="dropdown-menu">
                                                <?php if($can_view){ ?>
                                                <a class="dropdown-item page-modal" href="<?php print_link("rawat_inap/view/$rec_id"); ?>">
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
