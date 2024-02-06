<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("biodata/add");
$can_edit = ACL::is_allowed("biodata/edit");
$can_view = ACL::is_allowed("biodata/view");
$can_delete = ACL::is_allowed("biodata/delete");
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
                    <h4 class="record-title">Biodata</h4>
                </div>
                <div class="col-sm-3 comp-grid">
                    <div class=""><div>
                        <span><a class="btn btn-sm btn-primary has-tooltip"  href="<?php print_link("rekam_medis/history"); ?>">
                            <i class="fa fa-database"></i> Riwayat Pelayanan
                        </a></span>   
                    </div>
                </div>
            </div>
            <div class="col-sm-3 ">
                <div class="">
                    <?php
                    $id_user = "".USER_ID;
                    $dbhost="".DB_HOST;
                    $dbuser="".DB_USERNAME;
                    $dbpass="".DB_PASSWORD;
                    $dbname="".DB_NAME;
                    //$koneksi=open_connection();
                    $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                    $query = mysqli_query($koneksi, "SELECT * from biodata WHERE id_user='$id_user'")
                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                    $rows = mysqli_num_rows($query);
                    if ($rows <> 0) {
                    $sqlcek = mysqli_query($koneksi,"select * from biodata WHERE id_user='$id_user'");
                    while ($row=mysqli_fetch_array($sqlcek)){
                    $norekammedis=$row['no_rekam_medis'];
                    }     
                    $sqlcek2 = mysqli_query($koneksi,"select * from data_pasien WHERE no_rekam_medis='$norekammedis'");
                    while ($row2=mysqli_fetch_array($sqlcek2)){
                    $id_pasien=$row2['id_pasien'];
                    //echo $id_pasien;
                    }      
                    $key="dermawangroup";
                    $plaintext = "$id_pasien";
                    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                    $iv = openssl_random_pseudo_bytes($ivlen);
                    $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                    $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                    $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );   
                    ?>
                    <span><a class="btn btn-sm btn-primary has-tooltip"  href="<?php print_link("appointment/add?precord=$ciphertext");?>">
                        <i class="fa fa-database"></i>Daftar Appointment
                    </a></span>
                    <?php
                    }else {
                    ?>
                    <span><a class="btn btn-sm btn-primary has-tooltip"  href="<?php print_link("biodata/add?csrf_token=$csrf_token"); ?>">
                        <i class="fa fa-database"></i> Isi Biodata
                    </a></span>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="col-md-12 comp-grid">
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
                    <div id="biodata-list-records">
                        <div id="page-report-body" class="table-responsive">
                            <?php Html::ajaxpage_spinner(); ?>
                            <table class="table  table-sm text-left">
                                <thead class="table-header bg-success text-dark">
                                    <tr>
                                        <th  class="td-no_ktp"> No Ktp</th>
                                        <th  class="td-nama"> Nama</th>
                                        <th  class="td-alamat"> Alamat</th>
                                        <th  class="td-tanggal_lahir"> Tanggal Lahir</th>
                                        <th  class="td-no_hp"> No Hp</th>
                                        <th  class="td-jenis_kelamin"> Jenis Kelamin</th>
                                        <th  class="td-umur"> Umur</th>
                                        <th  class="td-email"> Email</th>
                                        <th  class="td-photo"> Photo</th>
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
                                    $rec_id = (!empty($data['id_biodata']) ? urlencode($data['id_biodata']) : null);
                                    $counter++;
                                    ?>
                                    <tr>
                                        <td class="td-no_ktp"> <?php echo $data['no_ktp']; ?></td>
                                        <td class="td-nama"> <?php echo $data['nama']; ?></td>
                                        <td class="td-alamat"> <?php echo $data['alamat']; ?></td>
                                        <td class="td-tanggal_lahir"> <?php echo $data['tanggal_lahir']; ?></td>
                                        <td class="td-no_hp"> <?php echo $data['no_hp']; ?></td>
                                        <td class="td-jenis_kelamin"> <?php echo $data['jenis_kelamin']; ?></td>
                                        <td class="td-umur"> <?php echo $data['umur']; ?></td>
                                        <td class="td-email"><a href="<?php print_link("mailto:$data[email]") ?>"><?php echo $data['email']; ?></a></td>
                                        <td class="td-photo"> <?php echo $data['photo']; ?></td>
                                        <td class="td-date_created"> <?php echo $data['date_created']; ?></td>
                                        <td class="td-date_updated"> <?php echo $data['date_updated']; ?></td>
                                        <td class="page-list-action td-btn">
                                            <div class="dropdown" >
                                                <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                                                    <i class="fa fa-bars"></i> 
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <?php if($can_view){ ?>
                                                    <a class="dropdown-item page-modal" href="<?php print_link("biodata/view/$rec_id"); ?>">
                                                        <i class="fa fa-eye"></i> View 
                                                    </a>
                                                    <?php } ?>
                                                    <?php if($can_edit){ ?>
                                                    <a class="dropdown-item page-modal" href="<?php print_link("biodata/edit/$rec_id"); ?>">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>
                                                    <?php } ?>
                                                    <?php if($can_delete){ ?>
                                                    <a  class="dropdown-item record-delete-btn" href="<?php print_link("biodata/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
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
                                        <button data-prompt-msg="Are you sure you want to delete these records?" data-display-style="modal" data-url="<?php print_link("biodata/delete/{sel_ids}/?csrf_token=$csrf_token&redirect=$current_page"); ?>" class="btn btn-sm btn-danger btn-delete-selected d-none">
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
