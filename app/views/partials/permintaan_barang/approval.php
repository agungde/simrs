<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("permintaan_barang/add");
$can_edit = ACL::is_allowed("permintaan_barang/edit");
$can_view = ACL::is_allowed("permintaan_barang/view");
$can_delete = ACL::is_allowed("permintaan_barang/delete");
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
    <div  class="bg-light p-3 mb-3">
        <div class="container-fluid">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Permintaan Barang</h4>
                </div>
                <div class="col-sm-3 ">
                    <?php if($can_add){ ?>
                    <a  class="btn btn btn-primary my-1" href="<?php print_link("permintaan_barang/add") ?>">
                        <i class="fa fa-plus"></i>                              
                        Add New Permintaan Barang 
                    </a>
                    <?php } ?>
                </div>
                <div class="col-sm-4 ">
                    <form  class="search" action="<?php print_link('permintaan_barang/'); ?>" method="get">
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
                                        <a class="text-decoration-none" href="<?php print_link('permintaan_barang'); ?>">
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
                                        <a class="text-decoration-none" href="<?php print_link('permintaan_barang'); ?>">
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
                    <div class="col-md-12 comp-grid">
                        <?php $this :: display_page_errors(); ?>
                        <div  class=" animated fadeIn page-content">
                            <div id="permintaan_barang-approval-records">
                                <div id="page-report-body" class="table-responsive">
                                    <table class="table  table-sm text-left">
                                        <thead class="table-header bg-success">
                                            <tr>
                                                <th  class="td-tanggal"> Tanggal</th>
                                                <th  class="td-no_request"> No Request</th>
                                                <th  class="td-action"> Action</th>
                                                <th  class="td-category_barang"> Category Barang</th>
                                                <th  class="td-divisi"> Divisi</th>
                                                <th  class="td-bagian"> Bagian</th>
                                                <th  class="td-approval"> Approval</th>
                                                <th  class="td-setatus"> Status</th>
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
                                                <td class="td-no_request"> <?php echo $data['no_request']; ?></td>
                                                <td class="td-action"> <span>
                                                    <?php 
                                                    $usrnam  = "".USER_NAME;
                                                    $id_user = "".USER_ID;
                                                    $dbhost  = "".DB_HOST;
                                                    $dbuser  = "".DB_USERNAME;
                                                    $dbpass  = "".DB_PASSWORD;
                                                    $dbname  = "".DB_NAME;
                                                    $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                                                    $idtrace = "$id_user$usrnam";    
                                                    $key="dermawangroup";
                                                    $plaintext = $data['no_request'];
                                                    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                                                    $iv = openssl_random_pseudo_bytes($ivlen);
                                                    $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                                                    $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                                                    $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
                                                    //if($data['setatus']=="Register"){
                                                    ?>
                                                    <div class="dropup export-btn-holder mx-1">
                                                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa fa-edit"></i>Action
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <a class="btn btn-sm btn-primary has-tooltip" style="margin-top:3px;" href="<?php  print_link("data_permintaan_barang/detile?csrf_token=$csrf_token&detile_request=".$data['no_request']);?>">
                                                            <i class="fa fa-eye "></i>Detile Permintaan Barang</a>
                                                        </div>
                                                    </div> 
                                                </span></td>
                                                <td class="td-category_barang">
                                                    <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("category_barang/view/" . urlencode($data['category_barang'])) ?>">
                                                        <i class="fa fa-eye"></i> <?php echo $data['category_barang_category'] ?>
                                                    </a>
                                                </td>
                                                <td class="td-divisi"> <?php echo $data['divisi']; ?></td>
                                                <td class="td-bagian"> <span><?php 
                                                    if($data['divisi']=="RANAP"){
                                                    $queryb = mysqli_query($koneksi, "select * from nama_kamar_ranap WHERE id='".$data['bagian']."'")
                                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                    // ambil jumlah baris data hasil query
                                                    $rowsb = mysqli_num_rows($queryb);
                                                    if ($rowsb <> 0) {
                                                    $row   = mysqli_fetch_assoc($queryb); 
                                                    echo $row['nama_kamar'];
                                                    }
                                                    }else{
                                                    echo $data['bagian']; 
                                                }?></span></td>
                                                <td class="td-approval"><?php Html :: page_img($data['approval'],50,50,1); ?></td>
                                                <td class="td-setatus"> <?php
                                                    if($data['setatus']=="Di Terima Dan Closed"){
                                                    ?>
                                                    <span style="border-radius: 8px; background-color: #1eff8d; color: dark; padding:5px; font-weight: bold;"><?php echo $data['setatus']; ?></span>
                                                    <?php
                                                    }else if($data['setatus']=="Register"){
                                                    ?>
                                                    <span style="border-radius: 8px; background-color: #000000; color: white; padding:5px; font-weight: bold;"><?php echo $data['setatus']; ?></span>
                                                    <?php
                                                    }else{
                                                    ?>
                                                    <span ><?php echo $data['setatus']; ?></span>
                                                    <?php
                                                    }
                                                ?></td>
                                                <td class="td-date_created"> <?php echo $data['date_created']; ?></td>
                                                <td class="page-list-action td-btn">
                                                    <div class="dropdown" >
                                                        <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                                                            <i class="fa fa-bars"></i> 
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <?php if($can_view){ ?>
                                                            <a class="dropdown-item page-modal" href="<?php print_link("permintaan_barang/view/$rec_id"); ?>">
                                                                <i class="fa fa-eye"></i> View 
                                                            </a>
                                                            <?php } ?>
                                                            <?php if($can_edit){ ?>
                                                            <a class="dropdown-item page-modal" href="<?php print_link("permintaan_barang/edit/$rec_id"); ?>">
                                                                <i class="fa fa-edit"></i> Edit
                                                            </a>
                                                            <?php } ?>
                                                            <?php if($can_delete){ ?>
                                                            <a  class="dropdown-item record-delete-btn" href="<?php print_link("permintaan_barang/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
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
                                                <button data-prompt-msg="Are you sure you want to delete these records?" data-display-style="modal" data-url="<?php print_link("permintaan_barang/delete/{sel_ids}/?csrf_token=$csrf_token&redirect=$current_page"); ?>" class="btn btn-sm btn-danger btn-delete-selected d-none">
                                                    <i class="fa fa-times"></i> Delete Selected
                                                </button>
                                                <?php } ?>
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
