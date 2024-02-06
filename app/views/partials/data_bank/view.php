<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_bank/add");
$can_edit = ACL::is_allowed("data_bank/edit");
$can_view = ACL::is_allowed("data_bank/view");
$can_delete = ACL::is_allowed("data_bank/delete");
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
                    <h4 class="record-title">View  Data Bank</h4>
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
                        $rec_id = (!empty($data['id_databank']) ? urlencode($data['id_databank']) : null);
                        $counter++;
                        ?>
                        <div id="page-report-body" class="">
                            <table class="table table-hover table-borderless table-striped">
                                <!-- Table Body Start -->
                                <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                    <tr  class="td-kode">
                                        <th class="title"> Kode: </th>
                                        <td class="value"> <?php echo $data['kode']; ?></td>
                                    </tr>
                                    <tr  class="td-nama_bank">
                                        <th class="title"> Nama Bank: </th>
                                        <td class="value"> <?php echo $data['nama_bank']; ?></td>
                                    </tr>
                                    <tr  class="td-no_rek">
                                        <th class="title"> No Rek: </th>
                                        <td class="value"> <?php echo $data['no_rek']; ?></td>
                                    </tr>
                                    <tr  class="td-cabang">
                                        <th class="title"> Cabang: </th>
                                        <td class="value"> <?php echo $data['cabang']; ?></td>
                                    </tr>
                                    <tr  class="td-alamat">
                                        <th class="title"> Alamat: </th>
                                        <td class="value"> <?php echo $data['alamat']; ?></td>
                                    </tr>
                                    <tr  class="td-nama_pemilik">
                                        <th class="title"> Nama Pemilik: </th>
                                        <td class="value"> <?php echo $data['nama_pemilik']; ?></td>
                                    </tr>
                                    <tr  class="td-active">
                                        <th class="title"> Active: </th>
                                        <td class="value"> <?php echo $data['active']; ?></td>
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
