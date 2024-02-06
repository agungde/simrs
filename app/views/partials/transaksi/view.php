<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("transaksi/add");
$can_edit = ACL::is_allowed("transaksi/edit");
$can_view = ACL::is_allowed("transaksi/view");
$can_delete = ACL::is_allowed("transaksi/delete");
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
                    <h4 class="record-title">View  Transaksi</h4>
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
                                    <tr  class="td-no_invoice">
                                        <th class="title"> No Invoice: </th>
                                        <td class="value"> <?php echo $data['no_invoice']; ?></td>
                                    </tr>
                                    <tr  class="td-tanggal">
                                        <th class="title"> Tanggal: </th>
                                        <td class="value"> <?php echo $data['tanggal']; ?></td>
                                    </tr>
                                    <tr  class="td-no_rekam_medis">
                                        <th class="title"> No Rekam Medis: </th>
                                        <td class="value"> <?php echo $data['no_rekam_medis']; ?></td>
                                    </tr>
                                    <tr  class="td-nama_pasien">
                                        <th class="title"> Nama Pasien: </th>
                                        <td class="value"> <?php echo $data['nama_pasien']; ?></td>
                                    </tr>
                                    <tr  class="td-alamat">
                                        <th class="title"> Alamat: </th>
                                        <td class="value"> <?php echo $data['alamat']; ?></td>
                                    </tr>
                                    <tr  class="td-no_hp">
                                        <th class="title"> No Hp: </th>
                                        <td class="value"> <?php echo $data['no_hp']; ?></td>
                                    </tr>
                                    <tr  class="td-pasien">
                                        <th class="title"> Pasien: </th>
                                        <td class="value"> <?php echo $data['pasien']; ?></td>
                                    </tr>
                                    <tr  class="td-poli">
                                        <th class="title"> Poli: </th>
                                        <td class="value"> <?php echo $data['poli']; ?></td>
                                    </tr>
                                    <tr  class="td-total_tagihan">
                                        <th class="title"> Total Tagihan: </th>
                                        <td class="value"> <?php echo $data['total_tagihan']; ?></td>
                                    </tr>
                                    <tr  class="td-pembayaran">
                                        <th class="title"> Pembayaran: </th>
                                        <td class="value">
                                            <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("data_bank/view/" . urlencode($data['pembayaran'])) ?>">
                                                <i class="fa fa-eye"></i> <?php echo $data['data_bank_nama_bank'] ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <tr  class="td-setatus_bpjs">
                                        <th class="title"> Setatus Bpjs: </th>
                                        <td class="value"> <?php echo $data['setatus_bpjs']; ?></td>
                                    </tr>
                                    <tr  class="td-deposit">
                                        <th class="title"> Deposit: </th>
                                        <td class="value"> <?php echo $data['deposit']; ?></td>
                                    </tr>
                                    <tr  class="td-sisa_tagihan">
                                        <th class="title"> Sisa Tagihan: </th>
                                        <td class="value"> <?php echo $data['sisa_tagihan']; ?></td>
                                    </tr>
                                    <tr  class="td-bayar">
                                        <th class="title"> Bayar: </th>
                                        <td class="value"> <?php echo $data['bayar']; ?></td>
                                    </tr>
                                    <tr  class="td-kembalian">
                                        <th class="title"> Kembalian: </th>
                                        <td class="value"> <?php echo $data['kembalian']; ?></td>
                                    </tr>
                                    <tr  class="td-setatus_tagihan">
                                        <th class="title"> Setatus Tagihan: </th>
                                        <td class="value"> <?php echo $data['setatus_tagihan']; ?></td>
                                    </tr>
                                    <tr  class="td-transaksi">
                                        <th class="title"> Transaksi: </th>
                                        <td class="value"> <?php echo $data['transaksi']; ?></td>
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
                                    <tr  class="td-action">
                                        <th class="title"> Action: </th>
                                        <td class="value"> <?php echo $data['action']; ?></td>
                                    </tr>
                                    <tr  class="td-kas_awal">
                                        <th class="title"> Kas Awal: </th>
                                        <td class="value"> <?php echo $data['kas_awal']; ?></td>
                                    </tr>
                                    <tr  class="td-kas_akhir">
                                        <th class="title"> Kas Akhir: </th>
                                        <td class="value"> <?php echo $data['kas_akhir']; ?></td>
                                    </tr>
                                </tbody>
                                <!-- Table Body End -->
                            </table>
                        </div>
                        <div class="p-3 d-flex">
                            <?php if($can_edit){ ?>
                            <a class="btn btn-sm btn-info"  href="<?php print_link("transaksi/edit/$rec_id"); ?>">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <?php } ?>
                            <?php if($can_delete){ ?>
                            <a class="btn btn-sm btn-danger record-delete-btn mx-1"  href="<?php print_link("transaksi/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
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
