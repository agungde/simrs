<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("penjualan/add");
$can_edit = ACL::is_allowed("penjualan/edit");
$can_view = ACL::is_allowed("penjualan/view");
$can_delete = ACL::is_allowed("penjualan/delete");
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
                    <h4 class="record-title">Penjualan</h4>
                </div>
                <div class="col-sm-3 ">
                    <?php if($can_add){ ?>
                    <a  class="btn btn btn-primary my-1" href="<?php print_link("transaksi_penjualan/penjualan") ?>">
                        <i class="fa fa-plus"></i>                              
                        Add Penjualan 
                    </a>
                    <?php } ?>
                </div>
                <div class="col-sm-4 ">
                    <form  class="search" action="<?php print_link('penjualan'); ?>" method="get">
                        <div class="input-group">
                            <input value="<?php echo get_value('search'); ?>" class="form-control" type="text" name="search"  placeholder="Search" />
                                <div class="input-group-append">
                                    <button class="btn btn-primary"><i class="fa fa-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-12 comp-grid">
                        <div class="">
                            <!-- Page bread crumbs components-->
                            <?php
                            if(!empty($field_name) || !empty($_GET['search'])){
                            ?>
                            <hr class="sm d-block d-sm-none" />
                            <nav class="page-header-breadcrumbs mt-2" aria-label="breadcrumb">
                                <ul class="breadcrumb m-0 p-1">
                                    <?php
                                    if(!empty($field_name)){
                                    ?>
                                    <li class="breadcrumb-item">
                                        <a class="text-decoration-none" href="<?php print_link('penjualan'); ?>">
                                            <i class="fa fa-angle-left"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <?php echo (get_value("tag") ? get_value("tag")  :  make_readable($field_name)); ?>
                                    </li>
                                    <li  class="breadcrumb-item active text-capitalize font-weight-bold">
                                        <?php echo (get_value("label") ? get_value("label")  :  make_readable(urldecode($field_value))); ?>
                                    </li>
                                    <?php 
                                    }   
                                    ?>
                                    <?php
                                    if(get_value("search")){
                                    ?>
                                    <li class="breadcrumb-item">
                                        <a class="text-decoration-none" href="<?php print_link('penjualan'); ?>">
                                            <i class="fa fa-angle-left"></i>
                                        </a>
                                    </li>
                                    <li class="breadcrumb-item text-capitalize">
                                        Search
                                    </li>
                                    <li  class="breadcrumb-item active text-capitalize font-weight-bold"><?php echo get_value("search"); ?></li>
                                    <?php
                                    }
                                    ?>
                                </ul>
                            </nav>
                            <!--End of Page bread crumbs components-->
                            <?php
                            }
                            ?>
                        </div>
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
                    <div class="col-md-5 comp-grid">
                        <div class=""><div>
                            <form method="get" action="<?php print_link($current_page) ?>" class="form filter-form">
                                <div class="input-group">
                                    <input class="form-control datepicker  datepicker"  value="<?php echo $this->set_field_value('penjualan_tanggal'); ?>" type="datetime"  name="penjualan_tanggal" placeholder="Tanggal" data-enable-time="" data-date-format="Y-m-d" data-alt-format="M j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
                                        <div class="input-group-append">
                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                        </div>
                                        &nbsp;&nbsp;
                                        <select required=""  name="penjualan_name"  placeholder="Select a value ..."    class="custom-select" >
                                            <option  value="Clinik" >Clinik</option>
                                            <option  value="Jual">Resep Luar</option>
                                        </select>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" id="autobtn">Filter</button>
                                        </div>
                                    </div>
                                </form>  
                            </div>
                            <div style="margin-bottom:3px;"></div>
                        </div>
                    </div>
                    <div class="col-md-12 comp-grid">
                        <?php $this :: display_page_errors(); ?>
                        <div  class=" animated fadeIn page-content">
                            <div id="penjualan-list-records">
                                <div id="page-report-body" class="table-responsive">
                                    <?php Html::ajaxpage_spinner(); ?>
                                    <table class="table  table-sm text-left">
                                        <thead class="table-header bg-success text-dark">
                                            <tr>
                                                <th  class="td-tanggal"> Tanggal</th>
                                                <th  class="td-no_invoice"> No Invoice</th>
                                                <th  class="td-nama_pelanggan"> Nama Pelanggan</th>
                                                <th  class="td-alamat"> Alamat</th>
                                                <th  class="td-no_hp"> No Hp</th>
                                                <th  class="td-total_jumlah"> Total Jumlah</th>
                                                <th  class="td-total_harga_beli"> Total Harga Beli</th>
                                                <th  class="td-total_harga_jual"> Total Harga Jual</th>
                                                <th  class="td-total_diskon"> Total Diskon</th>
                                                <th  class="td-trx"> Transaksi</th>
                                                <th  class="td-setatus"> Status</th>
                                                <th  class="td-bayar"> Bayar</th>
                                                <th  class="td-kembalian"> Kembalian</th>
                                                <th  class="td-operator"> Operator</th>
                                                <th  class="td-date_created"> Date Created</th>
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
                                            $rec_id = (!empty($data['id_penjualan']) ? urlencode($data['id_penjualan']) : null);
                                            $counter++;
                                            ?>
                                            <tr>
                                                <td class="td-tanggal"> <?php echo $data['tanggal']; ?></td>
                                                <td class="td-no_invoice"> <span>
                                                    <?php
                                                    $bayar=$data['bayar'];
                                                    $key="dermawangroup";
                                                    $plaintext = "$rec_id";
                                                    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                                                    $iv = openssl_random_pseudo_bytes($ivlen);
                                                    $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                                                    $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                                                    $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
                                                    if($bayar=="" or $bayar=="0"){
                                                    // echo $data['nama_pelanggan']; 
                                                    $print="<i class=\"fa fa-eye\"></i>Lihat";
                                                    $lihat="&view=Detile";
                                                    }else{
                                                    $print="<i class=\"fa fa-print\"></i>Print";
                                                    $lihat="";
                                                    ?> 
                                                    <?php }?>
                                                    <a class="btn btn-sm btn-primary has-tooltip page-modal"  href="<?php  print_link("penjualan/invoice?precord=$ciphertext$lihat");?>">                                           
                                                    <div><?php echo $data['no_invoice']; ?></div><?php echo $print; ?></a>   
                                                </span></td>
                                                <td class="td-nama_pelanggan"> <?php echo $data['nama_pelanggan']; ?></td>
                                                <td class="td-alamat"> <?php echo $data['alamat']; ?></td>
                                                <td class="td-no_hp"> <?php echo $data['no_hp']; ?></td>
                                                <td class="td-total_jumlah"> <?php echo $data['total_jumlah']; ?></td>
                                                <td class="td-total_harga_beli"> <span>Rp.<?php echo number_format($data['total_harga_beli'],0,",",".");
                                                    $satuanbeli=$data['total_harga_beli'] / $data['total_jumlah'];
                                                ?> (@<?php echo number_format($satuanbeli,0,",",".");?>)</span></td>
                                                <td class="td-total_harga_jual"> <span>Rp.<?php echo number_format($data['total_harga_jual'],0,",",".");
                                                    $satuanjual=$data['total_harga_jual'] / $data['total_jumlah'];
                                                ?> (@<?php echo number_format($satuanjual,0,",",".");?>)</span></td>
                                                <td class="td-total_diskon"> <span>Rp.<?php echo number_format($data['total_diskon'],0,",",".");?></span></td>
                                                <td class="td-trx"> <span><?php 
                                                    if($data['trx']=="Jual"){
                                                    echo "Resep Luar";
                                                    }else{
                                                echo $data['trx']; } ?></span></td>
                                                <td class="td-setatus"> <?php echo $data['setatus']; ?></td>
                                                <td class="td-bayar"> <span>Rp.<?php echo number_format($data['bayar'],0,",",".");?></span></td>
                                                <td class="td-kembalian"> <span>Rp.<?php echo number_format($data['kembalian'],0,",",".");?></span></td>
                                                <td class="td-operator"> <span><?php
                                                    $id_user = "".USER_ID;
                                                    $dbhost  = "".DB_HOST;
                                                    $dbuser  = "".DB_USERNAME;
                                                    $dbpass  = "".DB_PASSWORD;
                                                    $dbname  = "".DB_NAME;
                                                    $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                                                    $sql = mysqli_query($koneksi,"select * from user_login WHERE id_userlogin='".$data['operator']."'");
                                                    while ($row=mysqli_fetch_array($sql)){
                                                    $namaop=$row['nama'];
                                                    }
                                                echo $namaop; ?></span></td>
                                                <td class="td-date_created"> <?php echo $data['date_created']; ?></td>
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
