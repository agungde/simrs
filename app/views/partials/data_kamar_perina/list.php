<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_kamar_perina/add");
$can_edit = ACL::is_allowed("data_kamar_perina/edit");
$can_view = ACL::is_allowed("data_kamar_perina/view");
$can_delete = ACL::is_allowed("data_kamar_perina/delete");
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
                    <h4 class="record-title">Data Kamar Perina</h4>
                </div>
                <div class="col-sm-3 ">
                    <?php if($can_add){ ?>
                    <a  class="btn btn btn-primary my-1" href="<?php print_link("data_kamar_perina/add") ?>">
                        <i class="fa fa-plus"></i>                              
                        Add New Data Kamar Perina 
                    </a>
                    <?php } ?>
                </div>
                <div class="col-sm-4 ">
                    <form  class="search" action="<?php print_link('data_kamar_perina'); ?>" method="get">
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
                                        <a class="text-decoration-none" href="<?php print_link('data_kamar_perina'); ?>">
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
                                        <a class="text-decoration-none" href="<?php print_link('data_kamar_perina'); ?>">
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
                        <?php $this :: display_page_errors(); ?>
                        <div  class=" animated fadeIn page-content">
                            <div id="data_kamar_perina-list-records">
                                <div id="page-report-body" class="table-responsive">
                                    <table class="table  table-sm text-left">
                                        <thead class="table-header bg-success">
                                            <tr>
                                                <th  class="td-kamar_kelas"> Kamar Kelas</th>
                                                <th  class="td-nama_kamar"> Nama Kamar</th>
                                                <th  class="td-no_kamar"> No Kamar</th>
                                                <th  class="td-jumlah_ranjang"> Jumlah Ranjang</th>
                                                <th  class="td-harga"> Harga</th>
                                                <th  class="td-terisi"> Terisi</th>
                                                <th  class="td-sisa"> Sisa</th>
                                                <th  class="td-date_created"> Date Created</th>
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
                                            $rec_id = (!empty($data['id_data_kamar_perina']) ? urlencode($data['id_data_kamar_perina']) : null);
                                            $counter++;
                                            ?>
                                            <tr>
                                                <td class="td-kamar_kelas">
                                                    <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("data_kelas/view/" . urlencode($data['kamar_kelas'])) ?>">
                                                        <i class="fa fa-eye"></i> <?php echo $data['data_kelas_nama_kelas'] ?>
                                                    </a>
                                                </td>
                                                <td class="td-nama_kamar">
                                                    <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("nama_kamar_ranap_perina/view/" . urlencode($data['nama_kamar'])) ?>">
                                                        <i class="fa fa-eye"></i> <?php echo $data['nama_kamar_ranap_perina_nama_kamar'] ?>
                                                    </a>
                                                </td>
                                                <td class="td-no_kamar"> <?php echo $data['no_kamar']; ?></td>
                                                <td class="td-jumlah_ranjang"><span>
                                                    <?php
                                                    if(!empty($_GET['precord'])){
                                                    $isipre=$_GET['precord'];
                                                    ?>
                                                    <a size="sm" class="btn btn-sm btn-primary " href="<?php print_link("data_kamar_perina/detile?precord=$isipre&fromdata=$rec_id");?>">
                                                        <i class="fa fa-eye"></i>                                                    
                                                    <?php echo $data['jumlah_ranjang']; ?> Pilih</a>
                                                    <?php
                                                    }else{
                                                    ?>
                                                    <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("data_kamar_perina/view/$rec_id");?>"> <i class="fa fa-eye"></i>                                                    
                                                    <?php echo $data['jumlah_ranjang']; ?> View</a>        
                                                    <?php
                                                }?></span></td>
                                                <td class="td-harga"> <?php echo $data['harga']; ?></td>
                                                <td class="td-terisi"> <?php echo $data['terisi']; ?></td>
                                                <td class="td-sisa"> <?php echo $data['sisa']; ?></td>
                                                <td class="td-date_created"> <?php echo $data['date_created']; ?></td>
                                                <td class="page-list-action td-btn">
                                                    <div class="dropdown" >
                                                        <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                                                            <i class="fa fa-bars"></i> 
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <?php if($can_edit){ ?>
                                                            <a class="dropdown-item" href="<?php print_link("data_kamar_perina/edit/$rec_id"); ?>">
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
