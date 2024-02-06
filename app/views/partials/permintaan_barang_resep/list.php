<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("permintaan_barang_resep/add");
$can_edit = ACL::is_allowed("permintaan_barang_resep/edit");
$can_view = ACL::is_allowed("permintaan_barang_resep/view");
$can_delete = ACL::is_allowed("permintaan_barang_resep/delete");
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
    <div  class=" p-2 mb-2">
        <div class="container-fluid">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Permintaan Barang Resep</h4>
                </div>
                <div class="col-sm-4 ">
                    <form  class="search" action="<?php print_link('permintaan_barang_resep'); ?>" method="get">
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
                                        <a class="text-decoration-none" href="<?php print_link('permintaan_barang_resep'); ?>">
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
                                        <a class="text-decoration-none" href="<?php print_link('permintaan_barang_resep'); ?>">
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
                            if(USER_ROLE==20){
                            $itung=0;
                            $queryb = mysqli_query($koneksi, "select * from permintaan_barang_resep WHERE setatus='Register'")
                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                            // ambil jumlah baris data hasil query
                            $rowsb = mysqli_num_rows($queryb);
                            if ($rowsb <> 0) {
                            while ($rowb=mysqli_fetch_array($queryb)){
                            $itung++;
                            }
                            if($itung > 1){
                            ?>
                            <a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip"  href="#" onclick="kirim()">
                            <i class="fa fa-send"></i> Proses Semua Pengiriman</a>
                            <form name="proses" id="kirimbarang" method="post" action="<?php print_link("data_permintaan_barang/add?csrf_token=$csrf_token") ?>">
                                <input type="hidden" name="kirimall" value="<?php echo $csrf_token; ?>"/>
                                    <input type="hidden" name="token" value="<?php echo $csrf_token; ?>"/>
                                    </form>                               
                                    <script>
                                        function kirim(){ 
                                        var result = confirm("Proses Semua Pengiriman Barang!! ? \n Apakah Semua Barang Sudah Sesuai? \n Proses Kirim Barang Semua Ke Divisi: FARMASI ?");
                                        if (result == true) {
                                        //document.getElementById('autobtn').click();
                                        document.getElementById("kirimbarang").submit();
                                        return true;
                                        }
                                        else {
                                        return false;
                                        }
                                        }
                                    </script> 
                                    <?php } }
                                    }
                                    if(USER_ROLE==5){
                                    $itung=0;
                                    $queryb = mysqli_query($koneksi, "select * from permintaan_barang_resep WHERE setatus='Di Kirim'")
                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                    // ambil jumlah baris data hasil query
                                    $rowsb = mysqli_num_rows($queryb);
                                    if ($rowsb <> 0) {
                                    while ($rowb=mysqli_fetch_array($queryb)){
                                    $itung++;
                                    }
                                    if($itung > 1){
                                    ?>
                                    <a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip"  href="#" onclick="terima()">
                                    <i class="fa fa-send"></i> Proses Semua Terima Barang</a>
                                    <form name="proses" id="terimabarang" method="post" action="<?php print_link("data_permintaan_barang/add?csrf_token=$csrf_token") ?>">
                                        <input type="hidden" name="terimaall" value="<?php echo $csrf_token; ?>"/>
                                            <input type="hidden" name="token" value="<?php echo $csrf_token; ?>"/>
                                            </form>                               
                                            <script>
                                                function terima(){ 
                                                var result = confirm("Proses Semua Terima Barang!! ? \n Apakah Semua Barang Sudah Sesuai? \n Proses Terima Barang Semua Divisi: FARMASI ?");
                                                if (result == true) {
                                                //document.getElementById('autobtn').click();
                                                document.getElementById("terimabarang").submit();
                                                return true;
                                                }
                                                else {
                                                return false;
                                                }
                                                }
                                            </script> 
                                            <?php } }
                                            }    
                                            //echo $data['actiom']; 
                                            ?>   
                                        </div>
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
                                        <div id="permintaan_barang_resep-list-records">
                                            <div id="page-report-body" class="table-responsive">
                                                <table class="table  table-sm text-left">
                                                    <thead class="table-header bg-success">
                                                        <tr>
                                                            <th  class="td-tanggal"> Tanggal</th>
                                                            <th  class="td-actiom"> Actiom</th>
                                                            <th  class="td-kode_barang"> Kode Barang</th>
                                                            <th  class="td-nama_barang"> Nama Barang</th>
                                                            <th  class="td-category_barang"> Category Barang</th>
                                                            <th  class="td-jumlah"> Jumlah</th>
                                                            <th  class="td-divisi"> Divisi</th>
                                                            <th  class="td-bagian"> Bagian</th>
                                                            <th  class="td-setatus"> Status</th>
                                                            <th  class="td-keterangan"> Keterangan</th>
                                                            <th  class="td-date_created"> Date Created</th>
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
                                                            <td class="td-actiom"> <span>
                                                                <?php
                                                                $querya = mysqli_query($koneksi, "select * from setok_barang WHERE kode_barang='".$data['kode_barang']."'")
                                                                or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                // ambil jumlah baris data hasil query
                                                                $rowsa = mysqli_num_rows($querya);
                                                                if ($rowsa <> 0) {
                                                                $rowa   = mysqli_fetch_assoc($querya); 
                                                                $satuan=$rowa['satuan'];
                                                                }
                                                                if(USER_ROLE==5){
                                                                if($data['setatus']=="Di Kirim"){?>
                                                                <a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip"  href="#" onclick="terima<?php echo $rec_id;?>()">
                                                                <i class="fa fa-send"></i> Terima Barang</a>
                                                                <form id="formterimaresep<?php echo $rec_id;?>" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("data_permintaan_barang/add?csrf_token=$csrf_token") ?>" method="post">
                                                                    <input type="hidden" name="terimaresep" value="<?php echo $rec_id; ?>"/>
                                                                        <input type="hidden" name="token" value="<?php echo $csrf_token; ?>"/>
                                                                        </form>                               
                                                                        <script>
                                                                            function terima<?php echo $rec_id;?>(){ 
                                                                            var result = confirm("Terima Barang <?php echo $data['nama_barang']; echo " (".$data['jumlah']." $satuan)"; ?>!! \n Apakah Semua Barang Sudah Sesuai? \n Proses Terima Barang Divisi: FARMASI?");
                                                                            if (result == true) {
                                                                            //document.getElementById('autobtn').click();
                                                                            document.getElementById("formterimaresep<?php echo $rec_id;?>").submit();
                                                                            return true;
                                                                            }
                                                                            else {
                                                                            return false;
                                                                            }
                                                                            }
                                                                        </script>                
                                                                        <?php     
                                                                        }
                                                                        }
                                                                        if(USER_ROLE==20){
                                                                        if($data['setatus']=="Register"){?>
                                                                        <a style="margin-top:2px;" class="btn btn-sm btn-primary has-tooltip"  href="#" onclick="kirim<?php echo $rec_id;?>()">
                                                                        <i class="fa fa-send"></i> Proses kirim</a>
                                                                        <form id="formkirimresep<?php echo $rec_id;?>" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("data_permintaan_barang/add?csrf_token=$csrf_token") ?>" method="post">
                                                                            <input type="hidden" name="kirimresep" value="<?php echo $rec_id; ?>"/>
                                                                                <input type="hidden" name="token" value="<?php echo $csrf_token; ?>"/>
                                                                                </form>                               
                                                                                <script>
                                                                                    function kirim<?php echo $rec_id;?>(){ 
                                                                                    var result = confirm("Kirim Barang <?php echo $data['nama_barang']; echo " (".$data['jumlah']." $satuan)"; ?>!! \n Apakah Semua Barang Sudah Sesuai? \n Proses Kirim Barang Ke Divisi: FARMASI?");
                                                                                    if (result == true) {
                                                                                    //document.getElementById('autobtn').click();
                                                                                    document.getElementById("formkirimresep<?php echo $rec_id;?>").submit();
                                                                                    return true;
                                                                                    }
                                                                                    else {
                                                                                    return false;
                                                                                    }
                                                                                    }
                                                                                </script> 
                                                                                <?php } }
                                                                                //echo $data['actiom']; 
                                                                            ?></span></td>
                                                                            <td class="td-kode_barang"> <?php echo $data['kode_barang']; ?></td>
                                                                            <td class="td-nama_barang"> <span><?php echo $data['nama_barang']; echo " ($satuan)";?></span></td>
                                                                            <td class="td-category_barang">
                                                                                <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("category_barang/view/" . urlencode($data['category_barang'])) ?>">
                                                                                    <i class="fa fa-eye"></i> <?php echo $data['category_barang_category'] ?>
                                                                                </a>
                                                                            </td>
                                                                            <td class="td-jumlah"> <?php echo $data['jumlah']; ?></td>
                                                                            <td class="td-divisi"> <?php echo $data['divisi']; ?></td>
                                                                            <td class="td-bagian"> <?php echo $data['bagian']; ?></td>
                                                                            <td class="td-setatus"> <?php echo $data['setatus']; ?></td>
                                                                            <td class="td-keterangan"> <?php echo $data['keterangan']; ?></td>
                                                                            <td class="td-date_created"> <?php echo $data['date_created']; ?></td>
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
