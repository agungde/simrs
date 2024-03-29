<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_permintaan_barang/add");
$can_edit = ACL::is_allowed("data_permintaan_barang/edit");
$can_view = ACL::is_allowed("data_permintaan_barang/view");
$can_delete = ACL::is_allowed("data_permintaan_barang/delete");
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
    <div  class="bg-white p-1 mb-1">
        <div class="container-fluid">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Detile Permintaan Barang Divisi</h4>
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
                        <div id="data_permintaan_barang-list-records">
                            <div id="page-report-body" class="table-responsive">
                                <?php Html::ajaxpage_spinner(); ?>
                                <table class="table  table-sm text-left">
                                    <thead class="table-header bg-success text-dark">
                                        <tr>
                                            <th  class="td-kode_barang"> Kode Barang</th>
                                            <th  class="td-nama_barang"> Nama Barang</th>
                                            <th  class="td-jumlah"> Jumlah</th>
                                            <th  class="td-idtrace"> Idtrace</th>
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
                                            <td class="td-kode_barang"> <?php echo $data['kode_barang']; ?></td>
                                            <td class="td-nama_barang"> <?php echo $data['nama_barang']; ?></td>
                                            <td class="td-jumlah"> <?php echo $data['jumlah']; ?></td>
                                            <td class="td-idtrace"> <?php echo $data['idtrace']; ?></td>
                                            <td class="page-list-action td-btn">
                                                <div class="dropdown" >
                                                    <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                                                        <i class="fa fa-bars"></i> 
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <?php if($can_edit){ ?>
                                                        <a class="dropdown-item page-modal" href="<?php print_link("data_permintaan_barang/edit/$rec_id"); ?>">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a>
                                                        <?php } ?>
                                                        <?php if($can_delete){ ?>
                                                        <a  class="dropdown-item record-delete-btn" href="<?php print_link("data_permintaan_barang/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
                                                            <i class="fa fa-times"></i> Delete 
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
                                            <?php if($can_delete){ ?>
                                            <button data-prompt-msg="Are you sure you want to delete these records?" data-display-style="modal" data-url="<?php print_link("data_permintaan_barang/delete/{sel_ids}/?csrf_token=$csrf_token&redirect=$current_page"); ?>" class="btn btn-sm btn-danger btn-delete-selected d-none">
                                                <i class="fa fa-times"></i> Delete Selected
                                            </button>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <div class="col">   
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
