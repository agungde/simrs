<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("rekam_medis/add");
$can_edit = ACL::is_allowed("rekam_medis/edit");
$can_view = ACL::is_allowed("rekam_medis/view");
$can_delete = ACL::is_allowed("rekam_medis/delete");
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
        <div class="container">
            <div class="row ">
                <div class="col-md-12 ">
                    <h4 class="record-title">Rekam Medis</h4>
                </div>
                <div class="col-sm-4 ">
                    <form  class="search" action="<?php print_link('rekam_medis'); ?>" method="get">
                        <div class="input-group">
                            <input value="<?php echo get_value('search'); ?>" class="form-control" type="text" name="search"  placeholder="Search" />
                                <div class="input-group-append">
                                    <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12 ">
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
                                        <a class="text-decoration-none" href="<?php print_link('rekam_medis'); ?>">
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
                                        <a class="text-decoration-none" href="<?php print_link('rekam_medis'); ?>">
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
                        <?php $this :: display_page_errors(); ?>
                        <div  class=" animated fadeIn page-content">
                            <div id="rekam_medis-list-records">
                                <div id="page-report-body" class="table-responsive">
                                    <table class="table  table-sm text-left">
                                        <thead class="table-header bg-success text-dark">
                                            <tr>
                                                <th  class="td-no_rekam_medis"> No Rekam Medis</th>
                                                <th  class="td-nama_pasien"> Nama Pasien</th>
                                                <th  class="td-alamat"> Alamat</th>
                                                <th  class="td-action"> Action</th>
                                                <th  class="td-rm_lama"> RM LAMA</th>
                                                <th  class="td-jenis_kelamin"> Jenis Kelamin</th>
                                                <th  class="td-tanggal_lahir"> Tanggal Lahir</th>
                                                <th  class="td-umur"> Umur</th>
                                                <th  class="td-no_hp"> No Hp</th>
                                                <th  class="td-email"> Email</th>
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
                                            $rec_id = (!empty($data['id_rekam_medis']) ? urlencode($data['id_rekam_medis']) : null);
                                            $counter++;
                                            ?>
                                            <tr>
                                                <td class="td-no_rekam_medis"> <?php echo $data['no_rekam_medis']; ?></td>
                                                <td class="td-nama_pasien"> <?php echo $data['nama_pasien']; ?></td>
                                                <td class="td-alamat"> <?php echo $data['alamat']; ?></td>
                                                <td class="td-action"> <span><?php 
                                                    $id_user = "".USER_ID;
                                                    $dbhost  = "".DB_HOST;
                                                    $dbuser  = "".DB_USERNAME;
                                                    $dbpass  = "".DB_PASSWORD;
                                                    $dbname  = "".DB_NAME;
                                                    //$koneksi=open_connection();
                                                    $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                                                    $norekam= $data['no_rekam_medis'];
                                                    $queryb = mysqli_query($koneksi, "select * from data_rekam_medis WHERE no_rekam_medis='$norekam'")
                                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                    // ambil jumlah baris data hasil query
                                                    $rowsb = mysqli_num_rows($queryb);
                                                    // cek hasil query
                                                    // jika "no_antrian" sudah ada
                                                    if ($rowsb <> 0) {
                                                    ?>
                                                    <a class="btn btn-sm btn-primary has-tooltip"  href="<?php  print_link("rekam_medis/detile/$rec_id?detile_precord=$norekam");?>">
                                                    <i class="fa fa-eye"></i>Lihat Detil</a>
                                                    <?php }?>                                
                                                </span></td>
                                                <td class="td-rm_lama">  <style>
                                                    .dropdown a.dropdown-item:hover {
                                                    cursor: pointer;
                                                    background-color: #F5F5DC;
                                                    }
                                                </style>
                                                <span>
                                                    <?php
                                                    $norm=$data['no_rekam_medis'];
                                                    $qutr = mysqli_query($koneksi, "SELECT * from data_pasien WHERE no_rekam_medis='$norm'")
                                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                    $rotr = mysqli_num_rows($qutr);
                                                    if ($rotr <> 0) {
                                                    $ctr= mysqli_fetch_assoc($qutr);
                                                    $rm=$ctr['rm']; 
                                                    $idpas=$ctr['id_pasien'];
                                                    if($rm==""){
                                                    }else{
                                                    echo $rm;
                                                    ?>
                                                    <div class="dropdown" >
                                                        <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                                                            <i class="fa fa-bars"></i> 
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <?php
                                                            $qutrm = mysqli_query($koneksi, "SELECT * from rm_lama WHERE no_rekam_medis='$norm'")
                                                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                            $rotrm = mysqli_num_rows($qutrm);
                                                            if ($rotrm <> 0) {
                                                            ?>
                                                            <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip" href="<?php  print_link("rm_lama?precord=$csrf_token&datprecord=$idpas");?>">
                                                            <i class="fa fa-eye"></i>Lihat/Uploads RM Lama</a>
                                                            <?php
                                                            }else{
                                                            ?>
                                                            <a style="margin-top:1px;" class="btn btn-sm btn-primary has-tooltip" href="<?php  print_link("rm_lama/add?precord=$csrf_token&datprecord=$idpas");?>">
                                                            <i class="fa fa-eye"></i> Upload RM Lama</a>
                                                            <?php }?>
                                                        </ul>
                                                    </div>
                                                    <?php }}?>
                                                </span>
                                            </td>
                                            <td class="td-jenis_kelamin"> <?php echo $data['jenis_kelamin']; ?></td>
                                            <td class="td-tanggal_lahir"> <?php echo $data['tanggal_lahir']; ?></td>
                                            <td class="td-umur"> <?php echo $data['umur']; ?></td>
                                            <td class="td-no_hp"> <?php echo $data['no_hp']; ?></td>
                                            <td class="td-email"><a href="<?php print_link("mailto:$data[email]") ?>"><?php echo $data['email']; ?></a></td>
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
