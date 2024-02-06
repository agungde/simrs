<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_pembelian/add");
$can_edit = ACL::is_allowed("data_pembelian/edit");
$can_view = ACL::is_allowed("data_pembelian/view");
$can_delete = ACL::is_allowed("data_pembelian/delete");
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
                    <h4 class="record-title">View  Data Pembelian</h4>
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
                        $rec_id = (!empty($data['id_data_pembelian']) ? urlencode($data['id_data_pembelian']) : null);
                        $counter++;
                        ?>
                        <div id="page-report-body" class="">
                            <table class="table table-hover table-borderless table-striped">
                                <!-- Table Body Start -->
                                <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                    <tr  class="td-id_data_pembelian">
                                        <th class="title"> Id Data Pembelian: </th>
                                        <td class="value"> <?php echo $data['id_data_pembelian']; ?></td>
                                    </tr>
                                    <tr  class="td-id_suplier">
                                        <th class="title"> Id Suplier: </th>
                                        <td class="value"> <?php echo $data['id_suplier']; ?></td>
                                    </tr>
                                    <tr  class="td-nama_suplier">
                                        <th class="title"> Nama Suplier: </th>
                                        <td class="value"> <?php echo $data['nama_suplier']; ?></td>
                                    </tr>
                                    <tr  class="td-kode_barang">
                                        <th class="title"> Kode Barang: </th>
                                        <td class="value"> <?php echo $data['kode_barang']; ?></td>
                                    </tr>
                                    <tr  class="td-nama_barang">
                                        <th class="title"> Nama Barang: </th>
                                        <td class="value"> <?php echo $data['nama_barang']; ?></td>
                                    </tr>
                                    <tr  class="td-jumlah">
                                        <th class="title"> Jumlah: </th>
                                        <td class="value"> <?php echo $data['jumlah']; ?></td>
                                    </tr>
                                    <tr  class="td-harga_beli">
                                        <th class="title"> Harga Beli: </th>
                                        <td class="value"> <?php echo $data['harga_beli']; ?></td>
                                    </tr>
                                    <tr  class="td-ppn">
                                        <th class="title"> Ppn: </th>
                                        <td class="value"> <?php echo $data['ppn']; ?></td>
                                    </tr>
                                    <tr  class="td-total_harga">
                                        <th class="title"> Total Harga: </th>
                                        <td class="value"> <?php echo $data['total_harga']; ?></td>
                                    </tr>
                                    <tr  class="td-tanggal_expired">
                                        <th class="title"> Tanggal Expired: </th>
                                        <td class="value"> <?php echo $data['tanggal_expired']; ?></td>
                                    </tr>
                                    <tr  class="td-operator">
                                        <th class="title"> Operator: </th>
                                        <td class="value"> <?php echo $data['operator']; ?></td>
                                    </tr>
                                    <tr  class="td-date_created">
                                        <th class="title"> Date Created: </th>
                                        <td class="value"> <?php echo $data['date_created']; ?></td>
                                    </tr>
                                    <tr  class="td-date_updated">
                                        <th class="title"> Date Updated: </th>
                                        <td class="value"> <?php echo $data['date_updated']; ?></td>
                                    </tr>
                                    <tr  class="td-id_pembelian">
                                        <th class="title"> Id Pembelian: </th>
                                        <td class="value"> <?php echo $data['id_pembelian']; ?></td>
                                    </tr>
                                    <tr  class="td-type_pembelian">
                                        <th class="title"> Type Pembelian: </th>
                                        <td class="value"> <?php echo $data['type_pembelian']; ?></td>
                                    </tr>
                                    <tr  class="td-diskon">
                                        <th class="title"> Diskon: </th>
                                        <td class="value"> <?php echo $data['diskon']; ?></td>
                                    </tr>
                                    <tr  class="td-idtrace">
                                        <th class="title"> Idtrace: </th>
                                        <td class="value"> <?php echo $data['idtrace']; ?></td>
                                    </tr>
                                    <tr  class="td-setatus">
                                        <th class="title"> Setatus: </th>
                                        <td class="value"> <?php echo $data['setatus']; ?></td>
                                    </tr>
                                    <tr  class="td-tanggal_pembelian">
                                        <th class="title"> Tanggal Pembelian: </th>
                                        <td class="value"> <?php echo $data['tanggal_pembelian']; ?></td>
                                    </tr>
                                    <tr  class="td-total_diskon">
                                        <th class="title"> Total Diskon: </th>
                                        <td class="value"> <?php echo $data['total_diskon']; ?></td>
                                    </tr>
                                </tbody>
                                <!-- Table Body End -->
                            </table>
                        </div>
                        <div class="p-3 d-flex">
                            <div class="dropup export-btn-holder mx-1">
                                <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-save"></i> Export
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <?php $export_print_link = $this->set_current_page_link(array('format' => 'print')); ?>
                                    <a class="dropdown-item export-link-btn" data-format="print" href="<?php print_link($export_print_link); ?>" target="_blank">
                                        <img src="<?php print_link('assets/images/print.png') ?>" class="mr-2" /> PRINT
                                        </a>
                                        <?php $export_pdf_link = $this->set_current_page_link(array('format' => 'pdf')); ?>
                                        <a class="dropdown-item export-link-btn" data-format="pdf" href="<?php print_link($export_pdf_link); ?>" target="_blank">
                                            <img src="<?php print_link('assets/images/pdf.png') ?>" class="mr-2" /> PDF
                                            </a>
                                            <?php $export_word_link = $this->set_current_page_link(array('format' => 'word')); ?>
                                            <a class="dropdown-item export-link-btn" data-format="word" href="<?php print_link($export_word_link); ?>" target="_blank">
                                                <img src="<?php print_link('assets/images/doc.png') ?>" class="mr-2" /> WORD
                                                </a>
                                                <?php $export_csv_link = $this->set_current_page_link(array('format' => 'csv')); ?>
                                                <a class="dropdown-item export-link-btn" data-format="csv" href="<?php print_link($export_csv_link); ?>" target="_blank">
                                                    <img src="<?php print_link('assets/images/csv.png') ?>" class="mr-2" /> CSV
                                                    </a>
                                                    <?php $export_excel_link = $this->set_current_page_link(array('format' => 'excel')); ?>
                                                    <a class="dropdown-item export-link-btn" data-format="excel" href="<?php print_link($export_excel_link); ?>" target="_blank">
                                                        <img src="<?php print_link('assets/images/xsl.png') ?>" class="mr-2" /> EXCEL
                                                        </a>
                                                    </div>
                                                </div>
                                                <?php if($can_edit){ ?>
                                                <a class="btn btn-sm btn-info"  href="<?php print_link("data_pembelian/edit/$rec_id"); ?>">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                <?php } ?>
                                                <?php if($can_delete){ ?>
                                                <a class="btn btn-sm btn-danger record-delete-btn mx-1"  href="<?php print_link("data_pembelian/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
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
