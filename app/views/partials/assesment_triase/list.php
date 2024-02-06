<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("assesment_triase/add");
$can_edit = ACL::is_allowed("assesment_triase/edit");
$can_view = ACL::is_allowed("assesment_triase/view");
$can_delete = ACL::is_allowed("assesment_triase/delete");
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
                    <h4 class="record-title">Detile Assesment Triase</h4>
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
                    <?php $this :: display_page_errors(); ?>
                    <div  class=" animated fadeIn page-content">
                        <div id="assesment_triase-list-records">
                            <div id="page-report-body" class="table-responsive">
                                <table class="table  table-sm text-left">
                                    <thead class="table-header bg-success text-dark">
                                        <tr>
                                            <th  class="td-tgl_masuk"> Tgl Masuk</th>
                                            <th  class="td-jam"> Jam</th>
                                            <th  class="td-level"> Level</th>
                                            <th  class="td-response_time"> Response Time</th>
                                            <th  class="td-keadaan_ke_igd"> Keadaan Ke Igd</th>
                                            <th  class="td-rujukan_dari"> Rujukan Dari</th>
                                            <th  class="td-tgl_rujukan"> Tgl Rujukan</th>
                                            <th  class="td-org_yg_bisa_di_hub"> Org Yg Bisa Di Hub</th>
                                            <th  class="td-pasien_dr_poli"> Pasien Dr Poli</th>
                                            <th  class="td-keterangan"> Keterangan</th>
                                            <th  class="td-dokter_pemeriksa"> Dokter Pemeriksa</th>
                                            <th  class="td-ttd_dokter"> Ttd Dokter</th>
                                            <th  class="td-ttd_petugas"> Ttd Petugas</th>
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
                                        $rec_id = (!empty($data['id_triase']) ? urlencode($data['id_triase']) : null);
                                        $counter++;
                                        ?>
                                        <tr>
                                            <td class="td-tgl_masuk"> <?php echo $data['tgl_masuk']; ?></td>
                                            <td class="td-jam"> <?php echo $data['jam']; ?></td>
                                            <td class="td-level"><div><?php echo $data['level']; ?></div>
                                            </td>
                                            <td class="td-response_time"> <?php echo $data['response_time']; ?></td>
                                            <td class="td-keadaan_ke_igd"> <?php echo $data['keadaan_ke_igd']; ?></td>
                                            <td class="td-rujukan_dari"> <?php echo $data['rujukan_dari']; ?></td>
                                            <td class="td-tgl_rujukan"> <?php echo $data['tgl_rujukan']; ?></td>
                                            <td class="td-org_yg_bisa_di_hub"> <?php echo $data['org_yg_bisa_di_hub']; ?></td>
                                            <td class="td-pasien_dr_poli"> <?php echo $data['pasien_dr_poli']; ?></td>
                                            <td class="td-keterangan"><div><?php echo $data['keterangan']; ?></div>
                                            </td>
                                            <td class="td-dokter_pemeriksa"> <?php echo $data['dokter_pemeriksa']; ?></td>
                                            <td class="td-ttd_dokter"><?php Html :: page_img($data['ttd_dokter'],50,50,1); ?></td>
                                            <td class="td-ttd_petugas"><?php Html :: page_img($data['ttd_petugas'],50,50,1); ?></td>
                                            <td class="page-list-action td-btn">
                                                <div class="dropdown" >
                                                    <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                                                        <i class="fa fa-bars"></i> 
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <?php if($can_view){ ?>
                                                        <a class="dropdown-item page-modal" href="<?php print_link("assesment_triase/view/$rec_id"); ?>">
                                                            <i class="fa fa-eye"></i> View 
                                                        </a>
                                                        <?php } ?>
                                                        <?php if($can_edit){ ?>
                                                        <a class="dropdown-item page-modal" href="<?php print_link("assesment_triase/edit/$rec_id"); ?>">
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
