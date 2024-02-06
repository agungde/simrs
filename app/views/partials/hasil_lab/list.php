<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("hasil_lab/add");
$can_edit = ACL::is_allowed("hasil_lab/edit");
$can_view = ACL::is_allowed("hasil_lab/view");
$can_delete = ACL::is_allowed("hasil_lab/delete");
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
    <div  class="bg-white p-1 mb-1">
        <div class="container-fluid">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Hasil Lab</h4>
                </div>
                <div class="col-sm-4 ">
                    <form  class="search" action="<?php print_link('hasil_lab'); ?>" method="get">
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
                                        <a class="text-decoration-none" href="<?php print_link('hasil_lab'); ?>">
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
                                        <a class="text-decoration-none" href="<?php print_link('hasil_lab'); ?>">
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
                            <div id="hasil_lab-list-records">
                                <div id="page-report-body" class="table-responsive">
                                    <table class="table  table-sm text-left">
                                        <thead class="table-header bg-success text-dark">
                                            <tr>
                                                <th  class="td-tanggal"> Tanggal</th>
                                                <th  class="td-nama_pasien"> Nama Pasien</th>
                                                <th  class="td-no_rekam_medis"> No Rekam Medis</th>
                                                <th  class="td-alamat"> Alamat</th>
                                                <th  class="td-no_hp"> No Hp</th>
                                                <th  class="td-keluhan"> Keluhan</th>
                                                <th  class="td-nama_poli"> Nama Poli</th>
                                                <th  class="td-dokter_pengirim"> Dokter Pengirim</th>
                                                <th  class="td-action"> Action</th>
                                                <th  class="td-setatus"> Setatus</th>
                                                <th  class="td-jenis_pemeriksaan"> Jenis Pemeriksaan</th>
                                                <th  class="td-pasien"> Pasien</th>
                                                <th  class="td-total_harga"> Total Harga</th>
                                                <th  class="td-date_created"> Date Created</th>
                                                <th  class="td-id_transaksi"> Id Transaksi</th>
                                                <th  class="td-nama_pemeriksaan"> Nama Pemeriksaan</th>
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
                                            $rec_id = (!empty($data['id_hasil_lab']) ? urlencode($data['id_hasil_lab']) : null);
                                            $counter++;
                                            ?>
                                            <tr>
                                                <td class="td-tanggal"> <?php echo $data['tanggal']; ?></td>
                                                <td class="td-nama_pasien"> <?php echo $data['nama_pasien']; ?></td>
                                                <td class="td-no_rekam_medis"> <?php echo $data['no_rekam_medis']; ?></td>
                                                <td class="td-alamat"> <?php echo $data['alamat']; ?></td>
                                                <td class="td-no_hp"> <?php echo $data['no_hp']; ?></td>
                                                <td class="td-keluhan"> <?php echo $data['keluhan']; ?></td>
                                                <td class="td-nama_poli"> <?php echo $data['nama_poli']; ?></td>
                                                <td class="td-dokter_pengirim"> <?php echo $data['dokter_pengirim']; ?></td>
                                                <td class="td-action"> <span>
                                                    <?php 
                                                    if($data['setatus']=="Closed"){
                                                    $key="dermawangroup";
                                                    $plaintext = "$rec_id"; 
                                                    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                                                    $iv = openssl_random_pseudo_bytes($ivlen);
                                                    $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                                                    $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                                                    $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
                                                    ?>
                                                    <a class="btn btn-sm btn-primary has-tooltip"  href="<?php  print_link("hasil_lab/hasil?csrf_token=$csrf_token&precord=$ciphertext");?>" target="_blank">
                                                    <i class="fa fa-send"></i>Lihat Hasil Lab</a>
                                                    <?php
                                                    }else{
                                                    if($data['setatus']==""){echo "Dalam Proses";}else{
                                                    $id_daftar_lab=$data['id_daftar_lab'];
                                                    $plaintext = "$id_daftar_lab";   
                                                    $key="dermawangroup";
                                                    //$plaintext = "$rec_id"; 
                                                    $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                                                    $iv = openssl_random_pseudo_bytes($ivlen);
                                                    $ciphertext_raw = openssl_encrypt($plaintext, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                                                    $hmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                                                    $ciphertext = base64_encode( $iv.$hmac.$ciphertext_raw );
                                                    ?>
                                                    <a class="btn btn-sm btn-primary has-tooltip"  href="<?php print_link("hasil_lab/proses_lab?csrf_token=$csrf_token&precord=$ciphertext&backcomplit=$ciphertext"); ?>">
                                                    <i class="fa fa-send"></i>Isi Diagnosa</a>
                                                    <?php
                                                    }
                                                    }
                                                    ?>
                                                </span>
                                            </td>
                                            <td class="td-setatus"> <span><?php 
                                                if($data['setatus']==""){
                                                echo "Dalam Proses";
                                                }else{
                                            echo $data['setatus']; }?></span></td>
                                            <td class="td-jenis_pemeriksaan"> <?php echo $data['jenis_pemeriksaan']; ?></td>
                                            <td class="td-pasien"> <?php echo $data['pasien']; ?></td>
                                            <td class="td-total_harga"> <?php echo $data['total_harga']; ?></td>
                                            <td class="td-date_created"> <?php echo $data['date_created']; ?></td>
                                            <td class="td-id_transaksi"> <?php echo $data['id_transaksi']; ?></td>
                                            <td class="td-nama_pemeriksaan"> <?php echo $data['nama_pemeriksaan']; ?></td>
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
