<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("pemeriksaan_fisik/add");
$can_edit = ACL::is_allowed("pemeriksaan_fisik/edit");
$can_view = ACL::is_allowed("pemeriksaan_fisik/view");
$can_delete = ACL::is_allowed("pemeriksaan_fisik/delete");
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
                    <h4 class="record-title">Detile Pemeriksaan Fisik</h4>
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
                        <div id="pemeriksaan_fisik-list-records">
                            <div id="page-report-body" class="table-responsive">
                                <table class="table table-hover table-sm text-left">
                                    <thead class="table-header bg-success text-dark">
                                        <tr>
                                            <th  class="td-tanggal"> Tanggal</th>
                                            <th  class="td-no_rekam_medis"> No Rekam Medis</th>
                                            <th  class="td-pasien"> Pasien</th>
                                            <th  class="td-ND"> Nd</th>
                                            <th  class="td-TB"> Tb</th>
                                            <th  class="td-BB"> Bb</th>
                                            <th  class="td-RR"> Rr</th>
                                            <th  class="td-SH"> Sh</th>
                                            <th  class="td-TFU"> Tfu</th>
                                            <th  class="td-LILA"> Lila</th>
                                            <th  class="td-HPHT"> Hpht</th>
                                            <th  class="td-riwayat_batuk"> Riwayat Batuk</th>
                                            <th  class="td-riwayat_alergi"> Riwayat Alergi</th>
                                            <th  class="td-riwayat_SCOP"> Riwayat Scop</th>
                                            <th  class="td-riwayat_penyakit"> Riwayat Penyakit</th>
                                            <th  class="td-keluhan"> Keluhan</th>
                                            <th  <?php echo (get_value('orderby')=='EKG' ? 'class="sortedby td-EKG"' : null); ?>>
                                                <?php Html :: get_field_order_link('EKG', "EKG"); ?>
                                            </th>
                                            <th  class="td-CTG"> CTG</th>
                                            <th  class="td-SPO"> Spo</th>
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
                                        $rec_id = (!empty($data['id_fisik']) ? urlencode($data['id_fisik']) : null);
                                        $counter++;
                                        ?>
                                        <tr>
                                            <td class="td-tanggal"> <?php echo $data['tanggal']; ?></td>
                                            <td class="td-no_rekam_medis"> <?php echo $data['no_rekam_medis']; ?></td>
                                            <td class="td-pasien"> <?php echo $data['pasien']; ?></td>
                                            <td class="td-ND"> <?php echo $data['ND']; ?></td>
                                            <td class="td-TB"> <?php echo $data['TB']; ?></td>
                                            <td class="td-BB"> <?php echo $data['BB']; ?></td>
                                            <td class="td-RR"> <?php echo $data['RR']; ?></td>
                                            <td class="td-SH"> <?php echo $data['SH']; ?></td>
                                            <td class="td-TFU"> <?php echo $data['TFU']; ?></td>
                                            <td class="td-LILA"> <?php echo $data['LILA']; ?></td>
                                            <td class="td-HPHT"> <?php echo $data['HPHT']; ?></td>
                                            <td class="td-riwayat_batuk"> <?php echo $data['riwayat_batuk']; ?></td>
                                            <td class="td-riwayat_alergi"> <?php echo $data['riwayat_alergi']; ?></td>
                                            <td class="td-riwayat_SCOP"> <?php echo $data['riwayat_SCOP']; ?></td>
                                            <td class="td-riwayat_penyakit"> <?php echo $data['riwayat_penyakit']; ?></td>
                                            <td class="td-keluhan"> <?php echo $data['keluhan']; ?></td>
                                            <td class="td-EKG"><?php Html :: page_img($data['EKG'],50,50,5); ?></td>
                                            <td class="td-CTG"><?php Html :: page_img($data['CTG'],50,50,5); ?></td>
                                            <td class="td-SPO"> <?php echo $data['SPO']; ?></td>
                                            <td class="page-list-action td-btn">
                                                <div class="dropdown" >
                                                    <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                                                        <i class="fa fa-bars"></i> 
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <?php if($can_view){ ?>
                                                        <a class="dropdown-item page-modal" href="<?php print_link("pemeriksaan_fisik/view/$rec_id"); ?>">
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
