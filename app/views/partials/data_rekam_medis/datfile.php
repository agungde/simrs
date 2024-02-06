<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_rekam_medis/add");
$can_edit = ACL::is_allowed("data_rekam_medis/edit");
$can_view = ACL::is_allowed("data_rekam_medis/view");
$can_delete = ACL::is_allowed("data_rekam_medis/delete");
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
                    <div class=""><div><?php
                        if(!empty($_GET['dari'])){
                        $dari=$_GET['dari'];
                        if($dari=="Pemtem"){
                        $dari="Pemeriksaan Tambahan";
                        }else{
                        $dari="Keterangan Tambahan";
                        }
                        }else{
                        $dari="";
                    } ?></div>
                </div><h4 class="record-title">Data Upload <?php echo $dari;?></h4>
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
                    <div id="data_rekam_medis-datfile-records">
                        <div id="page-report-body" class="table-responsive">
                            <?php
                            if(!empty($_GET['datfile'])){
                            $urlimg= $_GET['datfile'];
                            ?><center>
                                <img  src="<?php print_link($urlimg); ?>" />
                                </center>
                                <?php }?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
