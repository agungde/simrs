<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_pembelian/add");
$can_edit = ACL::is_allowed("data_pembelian/edit");
$can_view = ACL::is_allowed("data_pembelian/view");
$can_delete = ACL::is_allowed("data_pembelian/delete");
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
                    <h4 class="record-title"> <?php
                        $usrnam  = "".USER_NAME;
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        $idtrace = "$id_user$usrnam";
                        if(!empty($_GET['noinvoice'])){
                        $noinvoice= $_GET['noinvoice'];
                        $queryin = mysqli_query($koneksi, "SELECT * from pembelian WHERE no_invoice='$noinvoice'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsin = mysqli_num_rows($queryin);
                        if ($rowsin <> 0) {
                        $dataa= mysqli_fetch_assoc($queryin);
                        }else{
                        }
                        }
                        $cate=$dataa['category_barang'];
                        $querycat = mysqli_query($koneksi, "SELECT * FROM `category_barang` WHERE id='$cate'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rocat = mysqli_num_rows($querycat);
                        if ($rocat <> 0) {
                        $datcat= mysqli_fetch_assoc($querycat);
                        $namacat= $datcat['category'];
                        }
                        ?>
                    Detile Pembelian <?php echo $namacat;?> </h4>
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
                    <div class="">
                        <div id="page-report-body" class="">
                            <table class="table  table-sm text-left">
                                <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                    <tr><td>
                                        <table class="table  table-sm text-left">
                                            <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                                <tr  class="td-tanggal_pembelian">
                                                    <th class="title"> Tanggal Pembelian: </th>
                                                    <td class="value"> <?php echo $dataa['tanggal_pembelian']; ?></td>
                                                </tr>
                                                <tr  class="td-category_barang">
                                                    <th class="title"> Category Barang: </th>
                                                    <td class="value">
                                                        <?php echo $namacat;?> 
                                                    </td>
                                                </tr>           
                                                <tr  class="td-no_invoice">
                                                    <th class="title"> No Invoice: </th>
                                                    <td class="value"> <?php echo $dataa['no_invoice']; ?></td>
                                                </tr>
                                                <tr  class="td-nama_suplier">
                                                    <th class="title"> Nama Suplier: </th>
                                                    <td class="value"> <?php echo $dataa['nama_suplier']; ?></td>
                                                </tr>
                                                <tr  class="td-alamat">
                                                    <th class="title"> Alamat: </th>
                                                    <td class="value"> <?php echo $dataa['alamat']; ?></td>
                                                </tr>
                                            </table>
                                            </td><td>
                                            <table class="table  table-sm text-left">
                                                <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">       
                                                    <tr  class="td-total_jumlah">
                                                        <th class="title"> Total Jumlah: </th>
                                                        <td class="value"> <?php echo $dataa['total_jumlah']; ?></td>
                                                    </tr>
                                                    <tr  class="td-total_harga_beli">
                                                        <th class="title"> Total Harga Beli: </th>
                                                        <td class="value"> <?php echo $dataa['total_harga_beli']; ?></td>
                                                    </tr>
                                                    <tr  class="td-total_diskon">
                                                        <th class="title"> Total Diskon: </th>
                                                        <td class="value"> <?php echo $dataa['total_diskon']; ?></td>
                                                    </tr>
                                                    <tr  class="td-ppn">
                                                        <th class="title"> Ppn: </th>
                                                        <td class="value"> <?php echo $dataa['ppn']; ?></td>
                                                    </tr>
                                                    <tr  class="td-divisi">
                                                        <th class="title"> Divisi: </th>
                                                        <td class="value"> <?php echo $dataa['divisi']; ?></td>
                                                    </tr>
                                                </tbody>
                                                <!-- Table Body End -->
                                            </table>
                                        </td> </tr>  </tbody>
                                    </table>
                                </div>
                            </div>
                            <?php $this :: display_page_errors(); ?>
                            <div  class=" animated fadeIn page-content">
                                <div id="data_pembelian-list-records">
                                    <div id="page-report-body" class="table-responsive">
                                        <?php Html::ajaxpage_spinner(); ?>
                                        <table class="table  table-sm text-left">
                                            <thead class="table-header bg-success text-dark">
                                                <tr>
                                                    <th  class="td-kode_barang"> Kode Barang</th>
                                                    <th  class="td-nama_barang"> Nama Barang</th>
                                                    <th  class="td-jumlah"> Jumlah</th>
                                                    <th  class="td-harga_beli"> Harga Beli</th>
                                                    <th  class="td-ppn"> Ppn</th>
                                                    <th  class="td-total_harga"> Total Harga</th>
                                                    <th  class="td-tanggal_expired"> Tanggal Expired</th>
                                                    <th  class="td-diskon"> Diskon</th>
                                                    <th  class="td-total_diskon"> Total Diskon</th>
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
                                                $rec_id = (!empty($data['id_data_pembelian']) ? urlencode($data['id_data_pembelian']) : null);
                                                $counter++;
                                                ?>
                                                <tr>
                                                    <td class="td-kode_barang"> <?php echo $data['kode_barang']; ?></td>
                                                    <td class="td-nama_barang"> <?php echo $data['nama_barang']; ?></td>
                                                    <td class="td-jumlah"> <?php echo $data['jumlah']; ?></td>
                                                    <td class="td-harga_beli"> <?php echo $data['harga_beli']; ?></td>
                                                    <td class="td-ppn"> <?php echo $data['ppn']; ?></td>
                                                    <td class="td-total_harga"> <?php echo $data['total_harga']; ?></td>
                                                    <td class="td-tanggal_expired"> <?php echo $data['tanggal_expired']; ?></td>
                                                    <td class="td-diskon"> <?php echo $data['diskon']; ?></td>
                                                    <td class="td-total_diskon"> <?php echo $data['total_diskon']; ?></td>
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
                                                <?php
                                                if($show_pagination == true){
                                                $pager = new Pagination($total_records, $record_count);
                                                $pager->route = $this->route;
                                                $pager->show_page_count = true;
                                                $pager->show_record_count = true;
                                                $pager->show_page_limit =true;
                                                $pager->limit_count = $this->limit_count;
                                                $pager->show_page_number_list = true;
                                                $pager->pager_link_range=5;
                                                $pager->ajax_page = true;
                                                $pager->render();
                                                }
                                                ?>
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
