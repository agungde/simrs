<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("kunjungan_doktek_ranap_anak/add");
$can_edit = ACL::is_allowed("kunjungan_doktek_ranap_anak/edit");
$can_view = ACL::is_allowed("kunjungan_doktek_ranap_anak/view");
$can_delete = ACL::is_allowed("kunjungan_doktek_ranap_anak/delete");
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
                    <div class=" ">
                        <?php  
                        $this->render_page("rawat_inap/fisik/$_GET[datprecord]"); 
                        ?>
                    </div>
                    <?php $this :: display_page_errors(); ?>
                    <div  class=" animated fadeIn page-content">
                        <div id="kunjungan_doktek_ranap_anak-list-records">
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
                                                        <a class="dropdown-item" href="<?php print_link("kunjungan_doktek_ranap_anak/view/$rec_id"); ?>">
                                                            <i class="fa fa-eye"></i> View 
                                                        </a>
                                                        <?php } ?>
                                                        <?php if($can_edit){ ?>
                                                        <a class="dropdown-item" href="<?php print_link("kunjungan_doktek_ranap_anak/edit/$rec_id"); ?>">
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
