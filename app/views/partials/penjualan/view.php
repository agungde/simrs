<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("penjualan/add");
$can_edit = ACL::is_allowed("penjualan/edit");
$can_view = ACL::is_allowed("penjualan/view");
$can_delete = ACL::is_allowed("penjualan/delete");
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
                    <h4 class="record-title">View  Penjualan</h4>
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
                        $rec_id = (!empty($data['id_penjualan']) ? urlencode($data['id_penjualan']) : null);
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
                                    <tr  class="td-nama_pelanggan">
                                        <th class="title"> Nama Pelanggan: </th>
                                        <td class="value"> <?php echo $data['nama_pelanggan']; ?></td>
                                    </tr>
                                    <tr  class="td-alamat">
                                        <th class="title"> Alamat: </th>
                                        <td class="value"> <?php echo $data['alamat']; ?></td>
                                    </tr>
                                    <tr  class="td-no_hp">
                                        <th class="title"> No Hp: </th>
                                        <td class="value"> <?php echo $data['no_hp']; ?></td>
                                    </tr>
                                    <tr  class="td-total_jumlah">
                                        <th class="title"> Total Jumlah: </th>
                                        <td class="value"> <?php echo $data['total_jumlah']; ?></td>
                                    </tr>
                                    <tr  class="td-total_harga_beli">
                                        <th class="title"> Total Harga Beli: </th>
                                        <td class="value">Rp.<?php echo number_format($data['total_harga_beli'],0,",",".");?></td>
                                    </tr>
                                    <tr  class="td-total_harga_jual">
                                        <th class="title"> Total Harga Jual: </th>
                                        <td class="value">Rp.<?php echo number_format($data['total_harga_jual'],0,",",".");?></td>
                                    </tr>
                                    <tr  class="td-total_diskon">
                                        <th class="title"> Total Diskon: </th>
                                        <td class="value">Rp.<?php echo number_format($data['total_diskon'],0,",",".");?></td>
                                    </tr>
                                    <tr  class="td-no_invoice">
                                        <th class="title"> No Invoice: </th>
                                        <td class="value"> <?php echo $data['no_invoice']; ?></td>
                                    </tr>
                                    <tr  class="td-bayar">
                                        <th class="title"> Bayar: </th>
                                        <td class="value">Rp.<?php echo number_format($data['bayar'],0,",",".");?></td>
                                    </tr>
                                    <tr  class="td-kembalian">
                                        <th class="title"> Kembalian: </th>
                                        <td class="value">Rp.<?php echo number_format($data['kembalian'],0,",",".");?></td>
                                    </tr>
                                    <tr  class="td-trx">
                                        <th class="title"> Trx: </th>
                                        <td class="value"> <?php echo $data['trx']; ?></td>
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
                    <div class=""><div></div>
                    </div>
                    <div class=" ">
                        <?php  
                        $this->render_page("data_penjualan/detail?limit_count=20"); 
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
