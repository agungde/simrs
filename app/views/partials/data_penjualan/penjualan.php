<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_penjualan/add");
$can_edit = ACL::is_allowed("data_penjualan/edit");
$can_view = ACL::is_allowed("data_penjualan/view");
$can_delete = ACL::is_allowed("data_penjualan/delete");
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
                    <h4 class="record-title">Transaksi Penjualan</h4>
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
                    <div class=""><div>
                        <div id="page-report-body" class="table-responsive">
                            <table class="table  table-striped table-sm text-left">
                                <tbody class="page-data" id="page-data-list-page-o9mrs73gfq5v">
                                    <!--record-->
                                    <tr>
                                        <td class="td-kode_barang">
                                            <span>
                                                DTO100102 
                                            </span>
                                        </td>
                                        <td class="td-nama_barang">
                                            <span>
                                                ambroxol 
                                            </span>
                                        </td>
                                        <td class="td-jumlah">
                                            <span>
                                                1 
                                            </span>
                                        </td>
                                        <td class="td-harga">
                                            <span>
                                                12000 
                                            </span>
                                        </td>
                                        <td class="td-total_harga">
                                            <span>
                                                12000 
                                            </span>
                                        </td>
                                        <td class="td-ppn">
                                            <span>
                                            </span>
                                        </td>
                                    </tr>
                                    <!--endrecord-->
                                </tbody>
                                <tbody class="search-data" id="search-data-list-page-o9mrs73gfq5v"></tbody>
                            </table>
                        </div> 
                    </div>
                </div>
                <?php $this :: display_page_errors(); ?>
                <div  class=" animated fadeIn page-content">
                    <div id="data_penjualan-penjualan-records">
                        <div id="page-report-body" class="table-responsive">
                            <?php Html::ajaxpage_spinner(); ?>
                            <table class="table  table-sm text-left">
                                <thead class="table-header bg-success text-dark">
                                    <tr>
                                        <th  class="td-kode_barang"> Kode Barang</th>
                                        <th  class="td-nama_barang"> Nama Barang</th>
                                        <th  class="td-jumlah"> Jumlah</th>
                                        <th  class="td-harga"> Harga</th>
                                        <th  class="td-diskon"> Diskon</th>
                                        <th  class="td-ppn"> Ppn</th>
                                        <th  class="td-total_harga"> Total Harga</th>
                                        <th  class="td-no_invoice"> No Invoice</th>
                                        <th  class="td-id_transaksi"> Id Transaksi</th>
                                        <th  class="td-divisi"> Divisi</th>
                                        <th  class="td-bagian"> Bagian</th>
                                        <th  class="td-lap"> Lap</th>
                                        <th  class="td-id_data_setok"> Id Data Setok</th>
                                        <th  class="td-trx"> Trx</th>
                                        <th  class="td-setatus"> Setatus</th>
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
                                    $rec_id = (!empty($data['id_data_penjualan']) ? urlencode($data['id_data_penjualan']) : null);
                                    $counter++;
                                    ?>
                                    <tr>
                                        <td class="td-kode_barang"> <?php echo $data['kode_barang']; ?></td>
                                        <td class="td-nama_barang"> <?php echo $data['nama_barang']; ?></td>
                                        <td class="td-jumlah"> <?php echo $data['jumlah']; ?></td>
                                        <td class="td-harga"> <?php echo $data['harga']; ?></td>
                                        <td class="td-diskon"> <?php echo $data['diskon']; ?></td>
                                        <td class="td-ppn"> <?php echo $data['ppn']; ?></td>
                                        <td class="td-total_harga"> <?php echo $data['total_harga']; ?></td>
                                        <td class="td-no_invoice"> <?php echo $data['no_invoice']; ?></td>
                                        <td class="td-id_transaksi"> <?php echo $data['id_transaksi']; ?></td>
                                        <td class="td-divisi"> <?php echo $data['divisi']; ?></td>
                                        <td class="td-bagian"> <?php echo $data['bagian']; ?></td>
                                        <td class="td-lap"> <?php echo $data['lap']; ?></td>
                                        <td class="td-id_data_setok"> <?php echo $data['id_data_setok']; ?></td>
                                        <td class="td-trx"> <?php echo $data['trx']; ?></td>
                                        <td class="td-setatus"> <?php echo $data['setatus']; ?></td>
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
                <div class=""><div></div>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
