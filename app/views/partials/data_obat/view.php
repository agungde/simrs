<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_obat/add");
$can_edit = ACL::is_allowed("data_obat/edit");
$can_view = ACL::is_allowed("data_obat/view");
$can_delete = ACL::is_allowed("data_obat/delete");
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
                    <h4 class="record-title">View  Data Obat</h4>
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
                                    <tr  class="td-kode_obat">
                                        <th class="title"> Kode Obat: </th>
                                        <td class="value"> <?php echo $data['kode_obat']; ?></td>
                                    </tr>
                                    <tr  class="td-penggunaan">
                                        <th class="title"> PENGGUNAAN: </th>
                                        <td class="value"> <?php echo $data['penggunaan']; ?></td>
                                    </tr>
                                    <tr  class="td-nama_obat">
                                        <th class="title"> NAMA OBAT: </th>
                                        <td class="value"> <?php echo $data['nama_obat']; ?></td>
                                    </tr>
                                    <tr  class="td-pbf">
                                        <th class="title"> PBF: </th>
                                        <td class="value"> <?php echo $data['pbf']; ?></td>
                                    </tr>
                                    <tr  class="td-hna">
                                        <th class="title"> HNA: </th>
                                        <td class="value">Rp.<?php echo number_format($data['hna'],0,",","."); ?></td>
                                    </tr>
                                    <tr  class="td-hja">
                                        <th class="title"> HJA: </th>
                                        <td class="value">Rp.<?php echo number_format($data['hja'],0,",","."); ?></td>
                                    </tr>
                                    <tr  class="td-tipe">
                                        <th class="title"> TIPE: </th>
                                        <td class="value"> <?php echo $data['tipe']; ?></td>
                                    </tr>
                                    <tr  class="td-satuan">
                                        <th class="title"> Satuan: </th>
                                        <td class="value"> <?php echo $data['satuan']; ?></td>
                                    </tr>
                                    <tr  class="td-operator">
                                        <th class="title"> Operator: </th>
                                        <td class="value"> <?php echo $data['operator']; ?></td>
                                    </tr>
                                    <tr  class="td-tanggal_dibuat">
                                        <th class="title"> Tanggal Dibuat: </th>
                                        <td class="value"> <?php echo $data['tanggal_dibuat']; ?></td>
                                    </tr>
                                    <tr  class="td-tanggal_diperbarui">
                                        <th class="title"> Tanggal Diperbarui: </th>
                                        <td class="value"> <?php echo $data['tanggal_diperbarui']; ?></td>
                                    </tr>
                                </tbody>
                                <!-- Table Body End -->
                            </table>
                        </div>
                        <div class="p-3 d-flex">
                            <?php if($can_edit){ ?>
                            <a class="btn btn-sm btn-info"  href="<?php print_link("data_obat/edit/$rec_id"); ?>">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <?php } ?>
                            <?php if($can_delete){ ?>
                            <a class="btn btn-sm btn-danger record-delete-btn mx-1"  href="<?php print_link("data_obat/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
                                <i class="fa fa-times"></i> Delete
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
