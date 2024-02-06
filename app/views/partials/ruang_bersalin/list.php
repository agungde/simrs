<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("ruang_bersalin/add");
$can_edit = ACL::is_allowed("ruang_bersalin/edit");
$can_view = ACL::is_allowed("ruang_bersalin/view");
$can_delete = ACL::is_allowed("ruang_bersalin/delete");
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
                    <h4 class="record-title">Ruang Bersalin</h4>
                </div>
                <div class="col-sm-3 ">
                    <?php if($can_add){ ?>
                    <a  class="btn btn btn-primary my-1" href="<?php print_link("ruang_bersalin/add") ?>">
                        <i class="fa fa-plus"></i>                              
                        Add New Ruang Bersalin 
                    </a>
                    <?php } ?>
                </div>
                <div class="col-sm-4 ">
                    <form  class="search" action="<?php print_link('ruang_bersalin'); ?>" method="get">
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
                                        <a class="text-decoration-none" href="<?php print_link('ruang_bersalin'); ?>">
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
                                        <a class="text-decoration-none" href="<?php print_link('ruang_bersalin'); ?>">
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
                            <div id="ruang_bersalin-list-records">
                                <div id="page-report-body" class="table-responsive">
                                    <table class="table  table-sm text-left">
                                        <thead class="table-header bg-success text-dark">
                                            <tr>
                                                <th  class="td-tanggal_masuk"> Tanggal Masuk</th>
                                                <th  class="td-no_rekam_medis"> No Rekam Medis</th>
                                                <th  class="td-nama_pasien"> Nama Pasien</th>
                                                <th  class="td-tgl_lahir"> Tgl Lahir</th>
                                                <th  class="td-umur"> Umur</th>
                                                <th  class="td-jenis_kelamin"> Jenis Kelamin</th>
                                                <th  class="td-action"> Action</th>
                                                <th  class="td-pemeriksaan_fisik"> Pemeriksaan Fisik</th>
                                                <th  class="td-catatan_medis"> Catatan Medis</th>
                                                <th  class="td-tindakan"> Tindakan</th>
                                                <th  class="td-rekam_medis"> Rekam Medis</th>
                                                <th  class="td-resep_obat"> Resep Obat</th>
                                                <th  class="td-lab"> Lab</th>
                                                <th  class="td-assesment_medis"> Assesment Medis</th>
                                                <th  class="td-tanggal_keluar"> Tanggal Keluar</th>
                                                <th  class="td-status"> Status</th>
                                                <th  class="td-assesment_triase"> Assesment Triase</th>
                                                <th  class="td-id_igd"> Id Igd</th>
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
                                                <td class="td-tgl_lahir"> <?php echo $data['tgl_lahir']; ?></td>
                                                <td class="td-umur"> <?php echo $data['umur']; ?></td>
                                                <td class="td-jenis_kelamin"> <?php echo $data['jenis_kelamin']; ?></td>
                                                <td class="td-action"> <?php echo $data['action']; ?></td>
                                                <td class="td-pemeriksaan_fisik"> <?php echo $data['pemeriksaan_fisik']; ?></td>
                                                <td class="td-catatan_medis"> <?php echo $data['catatan_medis']; ?></td>
                                                <td class="td-tindakan"> <?php echo $data['tindakan']; ?></td>
                                                <td class="td-rekam_medis"> <?php echo $data['rekam_medis']; ?></td>
                                                <td class="td-resep_obat"> <?php echo $data['resep_obat']; ?></td>
                                                <td class="td-lab"> <?php echo $data['lab']; ?></td>
                                                <td class="td-assesment_medis"> <?php echo $data['assesment_medis']; ?></td>
                                                <td class="td-tanggal_keluar"> <?php echo $data['tanggal_keluar']; ?></td>
                                                <td class="td-status"> <?php echo $data['status']; ?></td>
                                                <td class="td-assesment_triase"> <?php echo $data['assesment_triase']; ?></td>
                                                <td class="td-id_igd"> <?php echo $data['id_igd']; ?></td>
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
