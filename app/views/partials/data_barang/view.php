<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_barang/add");
$can_edit = ACL::is_allowed("data_barang/edit");
$can_view = ACL::is_allowed("data_barang/view");
$can_delete = ACL::is_allowed("data_barang/delete");
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
    <div  class="bg-white p-1 mb-1">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">View  Data Barang</h4>
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
                        $rec_id = (!empty($data['id_barang']) ? urlencode($data['id_barang']) : null);
                        $counter++;
                        ?>
                        <div id="page-report-body" class="">
                            <table class="table table-hover table-borderless table-striped">
                                <!-- Table Body Start -->
                                <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                    <tr  class="td-id_barang">
                                        <th class="title"> Id Barang: </th>
                                        <td class="value"> <?php echo $data['id_barang']; ?></td>
                                    </tr>
                                    <tr  class="td-kode_barang">
                                        <th class="title"> Kode Barang: </th>
                                        <td class="value"> <?php echo $data['kode_barang']; ?></td>
                                    </tr>
                                    <tr  class="td-nama_barang">
                                        <th class="title"> Nama Barang: </th>
                                        <td class="value"> <?php echo $data['nama_barang']; ?></td>
                                    </tr>
                                    <tr  class="td-satuan">
                                        <th class="title"> Satuan: </th>
                                        <td class="value"> <?php echo $data['satuan']; ?></td>
                                    </tr>
                                    <tr  class="td-category_barang">
                                        <th class="title"> Category Barang: </th>
                                        <td class="value">
                                            <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("category_barang/view/" . urlencode($data['category_barang'])) ?>">
                                                <i class="fa fa-eye"></i> <?php echo $data['category_barang_category'] ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr  class="td-warning_setok">
                                        <th class="title"> Warning Setok: </th>
                                        <td class="value"> <?php echo $data['warning_setok']; ?></td>
                                    </tr>
                                    <tr  class="td-operator">
                                        <th class="title"> Operator: </th>
                                        <td class="value">
                                            <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("user_login/view/" . urlencode($data['operator'])) ?>">
                                                <i class="fa fa-eye"></i> <?php echo $data['user_login_nama'] ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr  class="td-date_created">
                                        <th class="title"> Date Created: </th>
                                        <td class="value"> <?php echo $data['date_created']; ?></td>
                                    </tr>
                                    <tr  class="td-date_updated">
                                        <th class="title"> Date Updated: </th>
                                        <td class="value"> <?php echo $data['date_updated']; ?></td>
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
