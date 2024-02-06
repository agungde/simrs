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
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="list"  data-display-type="table" data-page-url="<?php print_link($current_page); ?>">
    <div  class="">
        <div class="container-fluid">
            <div class="row ">
                <div class="col-md-12 comp-grid">
                    <?php $this :: display_page_errors(); ?>
                    <div  class=" animated fadeIn page-content">
                        <div id="rm_lama-rmlama-records">
                            <div id="page-report-body" class="table-responsive">
                                <table class="table  table-sm text-left">
                                    <thead class="table-header bg-success text-dark">
                                        <tr>
                                            <th  class="td-tanggal_rm"> Tanggal Rm</th>
                                            <th  class="td-pemeriksaan_fisik"> Pemeriksaan Fisik</th>
                                            <th  class="td-tindakan"> Tindakan</th>
                                            <th  class="td-catatan_medis"> Catatan Medis</th>
                                            <th  class="td-resep_obat"> Resep Obat</th>
                                            <th  class="td-assesment_medis"> Assesment Medis</th>
                                            <th  class="td-assesment_triase"> Assesment Triase</th>
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
                                            <td class="td-pemeriksaan_fisik"><?php Html :: page_img($data['pemeriksaan_fisik'],50,50,1); ?></td>
                                            <td class="td-tindakan"><?php Html :: page_img($data['tindakan'],50,50,1); ?></td>
                                            <td class="td-catatan_medis"><?php Html :: page_img($data['catatan_medis'],50,50,1); ?></td>
                                            <td class="td-resep_obat"><?php Html :: page_img($data['resep_obat'],50,50,1); ?></td>
                                            <td class="td-assesment_medis"><?php Html :: page_img($data['assesment_medis'],50,50,1); ?></td>
                                            <td class="td-assesment_triase"><?php Html :: page_img($data['assesment_triase'],50,50,1); ?></td>
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
