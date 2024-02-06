<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_tagihan_pasien/add");
$can_edit = ACL::is_allowed("data_tagihan_pasien/edit");
$can_view = ACL::is_allowed("data_tagihan_pasien/view");
$can_delete = ACL::is_allowed("data_tagihan_pasien/delete");
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
    <div  class="bg-white p-3 mb-3">
        <div class="container-fluid">
            <div class="row ">
                <div class="col ">
                    <h1 class="record-title">Data Pendapatan </h1>
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
                                    <a class="text-decoration-none" href="<?php print_link('data_tagihan_pasien'); ?>">
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
                                    <a class="text-decoration-none" href="<?php print_link('data_tagihan_pasien'); ?>">
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
                <div class="col-md-4 comp-grid">
                    <form method="get" action="<?php print_link($current_page) ?>" class="form filter-form">
                        <div class="card mb-3">
                            <div class="card-header h4 h4">Filter by Data Tagihan Pasien Tanggal</div>
                            <div class="p-2">
                                <input class="form-control datepicker"  value="<?php echo $this->set_field_value('data_tagihan_pasien_tanggal') ?>" type="datetime"  name="data_tagihan_pasien_tanggal" placeholder="" data-enable-time="" data-date-format="Y-m-d" data-alt-format="M j, Y" data-inline="false" data-no-calendar="false" data-mode="range" />
                                </div>
                            </div>
                            <hr />
                            <div class="form-group text-center">
                                <button class="btn btn-primary">Filter</button>
                            </div>
                        </form>
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
                        <div class="filter-tags mb-2">
                            <?php
                            if(!empty($_GET['data_tagihan_pasien_tanggal'])){
                            ?>
                            <div class="filter-chip card bg-light">
                                <b>Data Tagihan Pasien Tanggal :</b> 
                                <?php
                                $date_val = get_value('data_tagihan_pasien_tanggal');
                                $formated_date = "";
                                if(str_contains('-to-', $date_val)){
                                //if value is a range date
                                $vals = explode('-to-' , str_replace(' ' , '' , $date_val));
                                $startdate = $vals[0];
                                $enddate = $vals[1];
                                $formated_date = format_date($startdate, 'jS F, Y') . ' <span class="text-muted">&#10148;</span> ' . format_date($enddate, 'jS F, Y');
                                }
                                elseif(str_contains(',', $date_val)){
                                //multi date values
                                $vals = explode(',' , str_replace(' ' , '' , $date_val));
                                $formated_arrs = array_map(function($date){return format_date($date, 'jS F, Y');}, $vals);
                                $formated_date = implode(' <span class="text-info">&#11161;</span> ', $formated_arrs);
                                }
                                else{
                                $formated_date = format_date($date_val, 'jS F, Y');
                                }
                                echo  $formated_date;
                                $remove_link = unset_get_value('data_tagihan_pasien_tanggal', $this->route->page_url);
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
                            <div id="data_tagihan_pasien-list-records">
                                <div id="page-report-body" class="table-responsive">
                                    <?php Html::ajaxpage_spinner(); ?>
                                    <table class="table  table-sm text-left">
                                        <thead class="table-header bg-success text-dark">
                                            <tr>
                                                <th  class="td-tanggal"> Tanggal</th>
                                                <th  class="td-no_rekam_medis"> No Rekam Medis</th>
                                                <th  class="td-pasien"> Pasien</th>
                                                <th  class="td-keterangan"> Keterangan</th>
                                                <th  class="td-total_tagihan"> Total </th>
                                                <th  class="td-setatus"> Status</th>
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
                                                <td class="td-pasien"> <?php echo $data['pasien']; ?></td>
                                                <td class="td-keterangan"> <?php echo $data['keterangan']; ?></td>
                                                <td class="td-total_tagihan"> <span><?php echo "Rp ".number_format ( $data['total_tagihan'] ); ?></span> </td>
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
                                                    ?>
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
