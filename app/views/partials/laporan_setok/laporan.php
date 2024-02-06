<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("laporan_setok/add");
$can_edit = ACL::is_allowed("laporan_setok/edit");
$can_view = ACL::is_allowed("laporan_setok/view");
$can_delete = ACL::is_allowed("laporan_setok/delete");
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
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="list"  data-display-type="table" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class=" p-2 mb-2">
        <div class="container-fluid">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Laporan Setok</h4>
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
                    <div class=""><div>
                        <?php
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        //$koneksi=open_connection();
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        if(USER_ROLE==8){
                        $divisi = "IGD";
                        $bagian    = "IGD";    
                        }else if(USER_ROLE==6){
                        $divisi = "POLI";
                        $bagian    = $_SESSION[APP_ID.'user_data']['admin_poli'];
                        }else  if(USER_ROLE==13){
                        $divisi = "RANAP";
                        $bagian    = $_SESSION[APP_ID.'user_data']['admin_ranap'];   
                        }else  if(USER_ROLE==5){
                        $divisi = "FARMASI";
                        $bagian    = "FARMASI";     
                        }
                        $sqlcek1 = mysqli_query($koneksi, "SELECT * from laporan_setok WHERE setatus='' and divisi='$divisi' and bagian='$bagian'");
                        $rows1 = mysqli_num_rows($sqlcek1);
                        if ($rows1 <> 0) { 
                        ?>
                        <button class="btn btn-primary" type="button" onclick="simpanlaporan()">
                            Simpan Laporan
                            <i class="fa fa-send"></i>
                        </button> 
                        <form name="laporan" id="laporan" enctype="multipart/form-data"  method="post" action="<?php print_link("laporan_setok/add?csrf_token=$csrf_token") ?>">
                            <input type="hidden" name="proseslaporan" value="<?php echo $divisi;?>"/>
                                <?php
                                while ($row4=mysqli_fetch_array($sqlcek1)){
                                ?>
                                <input type="hidden" name="idlap[]" value="<?php echo $row4['id'];?>"/>
                                    <?php } ?>
                                </form>                                            
                                <script>   
                                    function simpanlaporan() { 
                                    var result = confirm("Anda Yakin Senua Data Sudah Benar? \n Pilih OK Data Di Simpan Dan Tidak Bisa di Rubah Lagi!!");
                                    if (result == true) {
                                    //document.getElementById('autobtn').click();
                                    document.getElementById("laporan").submit();
                                    return true;
                                    }
                                    else {
                                    return false;
                                    }      
                                    }
                                </script>
                                <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div  class="">
            <div class="container-fluid">
                <div class="row ">
                    <div class="col-md-12 comp-grid">
                        <?php $this :: display_page_errors(); ?>
                        <div  class=" animated fadeIn page-content">
                            <div id="laporan_setok-laporan-records">
                                <div id="page-report-body" class="table-responsive">
                                    <table class="table  table-sm text-left">
                                        <thead class="table-header bg-success">
                                            <tr>
                                                <th  class="td-tanggal"> Tanggal</th>
                                                <th  class="td-kode_barang"> Kode Barang</th>
                                                <th  class="td-nama_barang"> Nama Barang</th>
                                                <th  class="td-category_barang"> Category Barang</th>
                                                <th  class="td-setok"> Stok Actual</th>
                                                <th  class="td-divisi"> Divisi</th>
                                                <th  class="td-bagian"> Bagian</th>
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
                                            $rec_id = (!empty($data['id']) ? urlencode($data['id']) : null);
                                            $counter++;
                                            ?>
                                            <tr>
                                                <td class="td-tanggal"> <?php echo $data['tanggal']; ?></td>
                                                <td class="td-kode_barang"> <?php echo $data['kode_barang']; ?></td>
                                                <td class="td-nama_barang"> <?php echo $data['nama_barang']; ?></td>
                                                <td class="td-category_barang">
                                                    <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("category_barang/view/" . urlencode($data['category_barang'])) ?>">
                                                        <i class="fa fa-eye"></i> <?php echo $data['category_barang_category'] ?>
                                                    </a>
                                                </td>
                                                <td class="td-setok"> <?php echo $data['setok']; ?></td>
                                                <td class="td-divisi"> <?php echo $data['divisi']; ?></td>
                                                <td class="td-bagian"> <?php echo $data['bagian']; ?></td>
                                                <td class="td-date_created"> <?php echo $data['date_created']; ?></td>
                                                <td class="page-list-action td-btn">
                                                    <div class="dropdown" >
                                                        <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                                                            <i class="fa fa-bars"></i> 
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <?php if($can_edit){ ?>
                                                            <a class="dropdown-item page-modal" href="<?php print_link("laporan_setok/edit/$rec_id"); ?>">
                                                                <i class="fa fa-edit"></i> Edit
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
