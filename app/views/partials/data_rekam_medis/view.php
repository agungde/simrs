<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_rekam_medis/add");
$can_edit = ACL::is_allowed("data_rekam_medis/edit");
$can_view = ACL::is_allowed("data_rekam_medis/view");
$can_delete = ACL::is_allowed("data_rekam_medis/delete");
?>
<?php
$comp_model = new SharedController;
$page_element_id = "view-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
//Page Data Information from Controller
$data = $this->view_data;
//$rec_id = $data['__tableprimarykey'];
$page_id = $this->route->page_id; //Page id from url
$view_title = $this->view_title;
$show_header = $this->show_header;
$show_edit_btn = $this->show_edit_btn;
$show_delete_btn = $this->show_delete_btn;
$show_export_btn = $this->show_export_btn;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="view"  data-display-type="table" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-light p-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">View  Data Rekam Medis</h4>
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
                    <div  class="card animated fadeIn page-content">
                        <?php
                        $counter = 0;
                        if(!empty($data)){
                        $rec_id = (!empty($data['id']) ? urlencode($data['id']) : null);
                        $counter++;
                        ?>
                        <div id="page-report-body" class="">
                            <table class="table table-hover table-borderless table-striped">
                                <!-- Table Body Start -->
                                <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                    <tr  class="td-tanggal">
                                        <th class="title"> Tanggal: </th>
                                        <td class="value"> <?php echo $data['tanggal']; ?></td>
                                    </tr>
                                    <tr  class="td-keluhan">
                                        <th class="title"> Keluhan: </th>
                                        <td class="value"> <?php echo $data['keluhan']; ?></td>
                                    </tr>
                                    <tr  class="td-resep_obat">
                                        <th class="title"> Resep Obat: </th>
                                        <td class="value"> <?php echo $data['resep_obat']; ?></td>
                                    </tr>
                                    <tr  class="td-dokter_pemeriksa">
                                        <th class="title"> Dokter Pemeriksa: </th>
                                        <td class="value"> <?php echo $data['dokter_pemeriksa']; ?></td>
                                    </tr>
                                    <tr  class="td-rujukan">
                                        <th class="title"> Rujukan: </th>
                                        <td class="value"><?php Html :: page_img($data['rujukan'],400,400,1); ?></td>
                                    </tr>
                                    <tr  class="td-alergi_obat">
                                        <th class="title"> Alergi Obat: </th>
                                        <td class="value"> <?php echo $data['alergi_obat']; ?></td>
                                    </tr>
                                    <tr  class="td-perintah_opname">
                                        <th class="title"> Perintah Opname: </th>
                                        <td class="value"> <?php echo $data['perintah_opname']; ?></td>
                                    </tr>
                                </tbody>
                                <!-- Table Body End -->
                            </table>
                        </div>
                        <div class="p-3 d-flex">
                        </div>
                        <?php
                        }
                        else{
                        ?>
                        <!-- Empty Record Message -->
                        <div class="text-muted p-3">
                            <i class="fa fa-ban"></i> No Record Found
                        </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
