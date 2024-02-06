<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("rm_lama/add");
$can_edit = ACL::is_allowed("rm_lama/edit");
$can_view = ACL::is_allowed("rm_lama/view");
$can_delete = ACL::is_allowed("rm_lama/delete");
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
    <div  class="p-1 mb-1">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">View  Rm Lama</h4>
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
                                    <tr  class="td-tanggal_rm">
                                        <th class="title"> Tanggal Rm: </th>
                                        <td class="value"> <?php echo $data['tanggal_rm']; ?></td>
                                    </tr>
                                    <tr  class="td-pemeriksaan_fisik">
                                        <th class="title"> Pemeriksaan Fisik: </th>
                                        <td class="value"><?php Html :: page_img($data['pemeriksaan_fisik'],400,400,1); ?></td>
                                    </tr>
                                    <tr  class="td-assesment_triase">
                                        <th class="title"> Assesment Triase: </th>
                                        <td class="value"><?php Html :: page_img($data['assesment_triase'],400,400,1); ?></td>
                                    </tr>
                                    <tr  class="td-assesment_medis">
                                        <th class="title"> Assesment Medis: </th>
                                        <td class="value"><?php Html :: page_img($data['assesment_medis'],400,400,1); ?></td>
                                    </tr>
                                    <tr  class="td-catatan_medis">
                                        <th class="title"> Catatan Medis: </th>
                                        <td class="value"><?php Html :: page_img($data['catatan_medis'],400,400,1); ?></td>
                                    </tr>
                                    <tr  class="td-resep_obat">
                                        <th class="title"> Resep Obat: </th>
                                        <td class="value"><?php Html :: page_img($data['resep_obat'],400,400,1); ?></td>
                                    </tr>
                                    <tr  class="td-tindakan">
                                        <th class="title"> Tindakan: </th>
                                        <td class="value"><?php Html :: page_img($data['tindakan'],400,400,1); ?></td>
                                    </tr>
                                </tbody>
                                <!-- Table Body End -->
                            </table>
                        </div>
                        <div class="p-3 d-flex">
                            <?php if($can_edit){ ?>
                            <a class="btn btn-sm btn-info"  href="<?php print_link("rm_lama/edit/$rec_id"); ?>">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <?php } ?>
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
