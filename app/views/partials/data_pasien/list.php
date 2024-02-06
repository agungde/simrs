<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_pasien/add");
$can_edit = ACL::is_allowed("data_pasien/edit");
$can_view = ACL::is_allowed("data_pasien/view");
$can_delete = ACL::is_allowed("data_pasien/delete");
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
                    <h4 class="record-title">Data Pasien</h4>
                </div>
                <div class="col-sm-3 ">
                    <?php if($can_add){ ?>
                    <a  class="btn btn btn-primary my-1" href="<?php print_link("data_pasien/add") ?>">
                        <i class="fa fa-plus"></i>                              
                        Add New Data Pasien 
                    </a>
                    <?php } ?>
                </div>
                <div class="col-sm-4 ">
                    <form  class="search" action="<?php print_link('data_pasien'); ?>" method="get">
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
                                        <a class="text-decoration-none" href="<?php print_link('data_pasien'); ?>">
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
                                        <a class="text-decoration-none" href="<?php print_link('data_pasien'); ?>">
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
            <div class="container">
                <div class="row ">
                    <div class="col-sm-4 comp-grid">
                    </div>
                    <div class="col-md-4 comp-grid">
                    </div>
                    <div class="col-md-4 comp-grid">
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
                            <div id="data_pasien-list-records">
                                <div id="page-report-body" class="table-responsive">
                                    <?php Html::ajaxpage_spinner(); ?>
                                    <table class="table  table-sm text-left">
                                        <thead class="table-header bg-success text-dark">
                                            <tr>
                                                <th  class="td-no_rekam_medis"> No Rekam Medis</th>
                                                <th  class="td-no_ktp"> No Ktp</th>
                                                <th  class="td-rm"> NO RM LAMA</th>
                                                <th  class="td-tl"> TL</th>
                                                <th  class="td-nama_pasien"> Nama Pasien</th>
                                                <th  class="td-alamat"> Alamat</th>
                                                <th  class="td-action"> Action</th>
                                                <th  class="td-tanggal_lahir"> Tanggal Lahir</th>
                                                <th  class="td-no_hp"> No Hp</th>
                                                <th  class="td-jenis_kelamin"> Jenis Kelamin</th>
                                                <th  class="td-umur"> Umur</th>
                                                <th  class="td-email"> Email</th>
                                                <th  class="td-photo"> Photo</th>
                                                <th  class="td-nokk"> NOKK</th>
                                                <th  class="td-namaortu"> NAMAORTU</th>
                                                <th  class="td-operator"> Operator</th>
                                                <th  class="td-date_created"> Date Created</th>
                                                <th  class="td-date_updated"> Date Updated</th>
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
                                            $rec_id = (!empty($data['id_pasien']) ? urlencode($data['id_pasien']) : null);
                                            $counter++;
                                            ?>
                                            <tr>
                                                <td class="td-no_rekam_medis"> <span><?php echo $data['no_rekam_medis']; ?></span></td>
                                                <td class="td-no_ktp"> <?php echo $data['no_ktp']; ?></td>
                                                <td class="td-rm"> <?php echo $data['rm']; ?></td>
                                                <td class="td-tl"> <?php echo $data['tl']; ?></td>
                                                <td class="td-nama_pasien"> <?php echo $data['nama_pasien']; ?></td>
                                                <td class="td-alamat"> <?php echo $data['alamat']; ?></td>
                                                <td class="td-action"> <span>
                                                    <?php
                                                    $id_user = "".USER_ID;
                                                    $dbhost="".DB_HOST;
                                                    $dbuser="".DB_USERNAME;
                                                    $dbpass="".DB_PASSWORD;
                                                    $dbname="".DB_NAME;
                                                    //$koneksi=open_connection();
                                                    $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                                                    $sql = mysqli_query($koneksi,"select * from user_login WHERE id_userlogin='$id_user'");
                                                    while ($row=mysqli_fetch_array($sql)){
                                                    $user_role_id=$row['user_role_id'];
                                                    $admin_poli   = $row['admin_poli'];
                                                    }
                                                    $key="dermawangroup";
                                                    $plaintext = "$rec_id";
                                                    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                                                    $iv = openssl_random_pseudo_bytes($ivlen);
                                                    $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                                                    $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                                                    $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
                                                    if(!empty($_GET['appointment'])){
                                                    if($user_role_id=="3"){}else{
                                                    ?>
                                                    <a class="btn btn-sm btn-primary has-tooltip"  href="<?php  print_link("appointment/add?csrf_token=$csrf_token&precord=$ciphertext");?>"
                                                    <i class="fa fa-send"></i>Add appointment</a>
                                                    <?php }
                                                    }else if(!empty($_GET['poli'])){
                                                    if($user_role_id=="3"){}else{
                                                    ?>
                                                    <a class="btn btn-sm btn-primary has-tooltip"  href="<?php  print_link("pendaftaran_poli/add?csrf_token=$csrf_token&precord=$ciphertext");?>"
                                                    <i class="fa fa-send"></i>Daftar Ke Poli</a>
                                                    <?php }  }else{
                                                    if($user_role_id=="3"){}else{
                                                    ?>
                                                    <a class="btn btn-sm btn-primary has-tooltip"  href="<?php  print_link("pendaftaran_poli/add?csrf_token=$csrf_token&precord=$ciphertext");?>"
                                                    <i class="fa fa-send"></i>Daftar Ke Poli</a>
                                                    <a class="btn btn-sm btn-primary has-tooltip"  href="<?php  print_link("appointment/add?csrf_token=$csrf_token&precord=$ciphertext");?>"
                                                    <i class="fa fa-send"></i>Add appointment</a>
                                                    <?php }
                                                    }
                                                    ?>
                                                </span></td>
                                                <td class="td-tanggal_lahir"> <?php echo $data['tanggal_lahir']; ?></td>
                                                <td class="td-no_hp"> <?php echo $data['no_hp']; ?></td>
                                                <td class="td-jenis_kelamin"> <?php echo $data['jenis_kelamin']; ?></td>
                                                <td class="td-umur"> <?php echo $data['umur']; ?></td>
                                                <td class="td-email"><a href="<?php print_link("mailto:$data[email]") ?>"><?php echo $data['email']; ?></a></td>
                                                <td class="td-photo"><?php Html :: page_img($data['photo'],50,50,1); ?></td>
                                                <td class="td-nokk"> <?php echo $data['nokk']; ?></td>
                                                <td class="td-namaortu"> <?php echo $data['namaortu']; ?></td>
                                                <td class="td-operator">
                                                    <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("user_login/view/" . urlencode($data['operator'])) ?>">
                                                        <i class="fa fa-eye"></i> <?php echo $data['user_login_nama'] ?>
                                                    </a>
                                                </td>
                                                <td class="td-date_created"> <?php echo $data['date_created']; ?></td>
                                                <td class="td-date_updated"> <?php echo $data['date_updated']; ?></td>
                                                <td class="page-list-action td-btn">
                                                    <div class="dropdown" >
                                                        <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                                                            <i class="fa fa-bars"></i> 
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <?php if($can_view){ ?>
                                                            <a class="dropdown-item page-modal" href="<?php print_link("data_pasien/view/$rec_id"); ?>">
                                                                <i class="fa fa-eye"></i> View 
                                                            </a>
                                                            <?php } ?>
                                                            <?php if($can_edit){ ?>
                                                            <a class="dropdown-item page-modal" href="<?php print_link("data_pasien/edit/$rec_id"); ?>">
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
                                                <?php Html :: import_form('data_pasien/import_data' , "Import Data", 'CSV'); ?>
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
