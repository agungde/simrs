<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("assesment_kaji_keperawatan/add");
$can_edit = ACL::is_allowed("assesment_kaji_keperawatan/edit");
$can_view = ACL::is_allowed("assesment_kaji_keperawatan/view");
$can_delete = ACL::is_allowed("assesment_kaji_keperawatan/delete");
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
                    <h4 class="record-title">Assesment Kaji Keperawatan</h4>
                </div>
                <div class="col-sm-3 ">
                    <?php if($can_add){ ?>
                    <a  class="btn btn btn-primary my-1" href="<?php print_link("assesment_kaji_keperawatan/add") ?>">
                        <i class="fa fa-plus"></i>                              
                        Add New Assesment Kaji Keperawatan 
                    </a>
                    <?php } ?>
                </div>
                <div class="col-sm-4 ">
                    <form  class="search" action="<?php print_link('assesment_kaji_keperawatan'); ?>" method="get">
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
                                        <a class="text-decoration-none" href="<?php print_link('assesment_kaji_keperawatan'); ?>">
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
                                        <a class="text-decoration-none" href="<?php print_link('assesment_kaji_keperawatan'); ?>">
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
                            <div id="assesment_kaji_keperawatan-list-records">
                                <div id="page-report-body" class="table-responsive">
                                    <table class="table  table-sm text-left">
                                        <thead class="table-header bg-success text-dark">
                                            <tr>
                                                <th  class="td-id_kaji"> Id Kaji</th>
                                                <th  class="td-nama_pasien"> Nama Pasien</th>
                                                <th  class="td-no_rekam_medis"> No Rekam Medis</th>
                                                <th  class="td-tgl_lahir"> Tgl Lahir</th>
                                                <th  class="td-jenis_kelamin"> Jenis Kelamin</th>
                                                <th  class="td-tgl_masuk"> Tgl Masuk</th>
                                                <th  class="td-perawat_pemeriksa"> Perawat Pemeriksa</th>
                                                <th  class="td-daftar_alergi"> Daftar Alergi</th>
                                                <th  class="td-tanda_vital_kondisi_umum"> Tanda Vital Kondisi Umum</th>
                                                <th  class="td-BB"> Bb</th>
                                                <th  class="td-TD"> Td</th>
                                                <th  class="td-RR"> Rr</th>
                                                <th  class="td-HG"> Hg</th>
                                                <th  class="td-TB"> Tb</th>
                                                <th  class="td-suhu"> Suhu</th>
                                                <th  class="td-scrining_nutrisi"> Scrining Nutrisi</th>
                                                <th  class="td-perubahan_ukuran_pakaian"> Perubahan Ukuran Pakaian</th>
                                                <th  class="td-terlihat_kurus"> Terlihat Kurus</th>
                                                <th  class="td-makan_dlm_dua_minggu"> Makan Dlm Dua Minggu</th>
                                                <th  class="td-mual_muntah"> Mual Muntah</th>
                                                <th  class="td-diare"> Diare</th>
                                                <th  class="td-anokresia"> Anokresia</th>
                                                <th  class="td-factor_pemberat"> Factor Pemberat</th>
                                                <th  class="td-penurunan_fungsi"> Penurunan Fungsi</th>
                                                <th  class="td-status_gizi"> Status Gizi</th>
                                                <th  class="td-catatan_gizi"> Catatan Gizi</th>
                                                <th  class="td-lokasi_nyeri"> Lokasi Nyeri</th>
                                                <th  class="td-waktu_nyer"> Waktu Nyer</th>
                                                <th  class="td-pencetus_saat_nyeri"> Pencetus Saat Nyeri</th>
                                                <th  class="td-type_nyeri"> Type Nyeri</th>
                                                <th  class="td-nyeri"> Nyeri</th>
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
                                            $rec_id = (!empty($data['id_kaji']) ? urlencode($data['id_kaji']) : null);
                                            $counter++;
                                            ?>
                                            <tr>
                                                <td class="td-id_kaji"><a href="<?php print_link("assesment_kaji_keperawatan/view/$data[id_kaji]") ?>"><?php echo $data['id_kaji']; ?></a></td>
                                                <td class="td-nama_pasien"> <?php echo $data['nama_pasien']; ?></td>
                                                <td class="td-no_rekam_medis"> <?php echo $data['no_rekam_medis']; ?></td>
                                                <td class="td-tgl_lahir"> <?php echo $data['tgl_lahir']; ?></td>
                                                <td class="td-jenis_kelamin"> <?php echo $data['jenis_kelamin']; ?></td>
                                                <td class="td-tgl_masuk"> <?php echo $data['tgl_masuk']; ?></td>
                                                <td class="td-perawat_pemeriksa"> <?php echo $data['perawat_pemeriksa']; ?></td>
                                                <td class="td-daftar_alergi"> <?php echo $data['daftar_alergi']; ?></td>
                                                <td class="td-tanda_vital_kondisi_umum"> <?php echo $data['tanda_vital_kondisi_umum']; ?></td>
                                                <td class="td-BB"> <?php echo $data['BB']; ?></td>
                                                <td class="td-TD"> <?php echo $data['TD']; ?></td>
                                                <td class="td-RR"> <?php echo $data['RR']; ?></td>
                                                <td class="td-HG"> <?php echo $data['HG']; ?></td>
                                                <td class="td-TB"> <?php echo $data['TB']; ?></td>
                                                <td class="td-suhu"> <?php echo $data['suhu']; ?></td>
                                                <td class="td-scrining_nutrisi"> <?php echo $data['scrining_nutrisi']; ?></td>
                                                <td class="td-perubahan_ukuran_pakaian"> <?php echo $data['perubahan_ukuran_pakaian']; ?></td>
                                                <td class="td-terlihat_kurus"> <?php echo $data['terlihat_kurus']; ?></td>
                                                <td class="td-makan_dlm_dua_minggu"> <?php echo $data['makan_dlm_dua_minggu']; ?></td>
                                                <td class="td-mual_muntah"> <?php echo $data['mual_muntah']; ?></td>
                                                <td class="td-diare"> <?php echo $data['diare']; ?></td>
                                                <td class="td-anokresia"> <?php echo $data['anokresia']; ?></td>
                                                <td class="td-factor_pemberat"> <?php echo $data['factor_pemberat']; ?></td>
                                                <td class="td-penurunan_fungsi"> <?php echo $data['penurunan_fungsi']; ?></td>
                                                <td class="td-status_gizi"> <?php echo $data['status_gizi']; ?></td>
                                                <td class="td-catatan_gizi"> <?php echo $data['catatan_gizi']; ?></td>
                                                <td class="td-lokasi_nyeri"> <?php echo $data['lokasi_nyeri']; ?></td>
                                                <td class="td-waktu_nyer"> <?php echo $data['waktu_nyer']; ?></td>
                                                <td class="td-pencetus_saat_nyeri"> <?php echo $data['pencetus_saat_nyeri']; ?></td>
                                                <td class="td-type_nyeri"> <?php echo $data['type_nyeri']; ?></td>
                                                <td class="td-nyeri"> <?php echo $data['nyeri']; ?></td>
                                                <td class="page-list-action td-btn">
                                                    <div class="dropdown" >
                                                        <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                                                            <i class="fa fa-bars"></i> 
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <?php if($can_view){ ?>
                                                            <a class="dropdown-item page-modal" href="<?php print_link("assesment_kaji_keperawatan/view/$rec_id"); ?>">
                                                                <i class="fa fa-eye"></i> View 
                                                            </a>
                                                            <?php } ?>
                                                            <?php if($can_edit){ ?>
                                                            <a class="dropdown-item page-modal" href="<?php print_link("assesment_kaji_keperawatan/edit/$rec_id"); ?>">
                                                                <i class="fa fa-edit"></i> Edit
                                                            </a>
                                                            <?php } ?>
                                                            <?php if($can_delete){ ?>
                                                            <a  class="dropdown-item record-delete-btn" href="<?php print_link("assesment_kaji_keperawatan/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
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
                                                <button data-prompt-msg="Are you sure you want to delete these records?" data-display-style="modal" data-url="<?php print_link("assesment_kaji_keperawatan/delete/{sel_ids}/?csrf_token=$csrf_token&redirect=$current_page"); ?>" class="btn btn-sm btn-danger btn-delete-selected d-none">
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
