<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_resep/add");
$can_edit = ACL::is_allowed("data_resep/edit");
$can_view = ACL::is_allowed("data_resep/view");
$can_delete = ACL::is_allowed("data_resep/delete");
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
                    <h4 class="record-title">Data Resep</h4>
                </div>
                <div class="col-sm-3 ">
                </div>
                <div class="col-sm-4 ">
                    <form  class="search" action="<?php print_link('data_resep'); ?>" method="get">
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
                                        <a class="text-decoration-none" href="<?php print_link('data_resep'); ?>">
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
                                        <a class="text-decoration-none" href="<?php print_link('data_resep'); ?>">
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
                            <div id="data_resep-list-records">
                                <div id="page-report-body" class="table-responsive">
                                    <table class="table  table-sm text-left">
                                        <thead class="table-header bg-success text-dark">
                                            <tr>
                                                <th  class="td-tanggal"> Tanggal</th>
                                                <th  class="td-no_rekam_medis"> No Rekam Medis</th>
                                                <th  class="td-nama_poli"> Nama Poli</th>
                                                <th  class="td-nama_dokter"> Nama Dokter</th>
                                                <th  class="td-nama_pasien"> Nama Pasien</th>
                                                <th  class="td-alamat"> Alamat</th>
                                                <th  class="td-tanggal_lahir"> Tanggal Lahir</th>
                                                <th  class="td-umur"> Umur</th>
                                                <th  class="td-nama_obat"> Nama Obat</th>
                                                <th  class="td-aturan_minum"> Aturan Minum</th>
                                                <th  class="td-jumlah"> Jumlah</th>
                                                <th  class="td-setatus"> Setatus</th>
                                                <th  class="td-date_created"> Date Created</th>
                                                <th  class="td-action"> Action</th>
                                                <th  class="td-id_resep_obat"> Id Resep Obat</th>
                                                <th  class="td-date_updated"> Date Updated</th>
                                                <th  class="td-racikan"> Racikan</th>
                                                <th  class="td-id_daftar"> Id Daftar</th>
                                                <th  class="td-keterangan"> Keterangan</th>
                                                <th  class="td-resep"> Resep</th>
                                                <th  class="td-id_transaksi"> Id Transaksi</th>
                                                <th  class="td-ket_setok"> Ket Setok</th>
                                                <th  class="td-bagian"> Bagian</th>
                                                <th  class="td-lap"> Lap</th>
                                                <th  class="td-kode_barang"> Kode Barang</th>
                                                <th  class="td-id_data_setok"> Id Data Setok</th>
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
                                            $rec_id = (!empty($data['id_data_resep']) ? urlencode($data['id_data_resep']) : null);
                                            $counter++;
                                            ?>
                                            <tr>
                                                <td class="td-tanggal"> <?php echo $data['tanggal']; ?></td>
                                                <td class="td-no_rekam_medis"> <?php echo $data['no_rekam_medis']; ?></td>
                                                <td class="td-nama_poli">
                                                    <a size="sm" class="btn btn-sm btn-primary page-modal" href="<?php print_link("data_poli/view/" . urlencode($data['nama_poli'])) ?>">
                                                        <i class="fa fa-eye"></i> <?php echo $data['data_poli_nama_poli'] ?>
                                                    </a>
                                                </td>
                                                <td class="td-nama_dokter"> <?php echo $data['nama_dokter']; ?></td>
                                                <td class="td-nama_pasien"> <?php echo $data['nama_pasien']; ?></td>
                                                <td class="td-alamat"> <?php echo $data['alamat']; ?></td>
                                                <td class="td-tanggal_lahir"> <?php echo $data['tanggal_lahir']; ?></td>
                                                <td class="td-umur"> <?php echo $data['umur']; ?></td>
                                                <td class="td-nama_obat"> <?php echo $data['nama_obat']; ?></td>
                                                <td class="td-aturan_minum"> <?php echo $data['aturan_minum']; ?></td>
                                                <td class="td-jumlah"> <?php echo $data['jumlah']; ?></td>
                                                <td class="td-setatus"> <?php echo $data['setatus']; ?></td>
                                                <td class="td-date_created"> <?php echo $data['date_created']; ?></td>
                                                <td class="td-action"> <?php echo $data['action']; ?></td>
                                                <td class="td-id_resep_obat"> <?php echo $data['id_resep_obat']; ?></td>
                                                <td class="td-date_updated"> <?php echo $data['date_updated']; ?></td>
                                                <td class="td-racikan"> <?php echo $data['racikan']; ?></td>
                                                <td class="td-id_daftar"> <?php echo $data['id_daftar']; ?></td>
                                                <td class="td-keterangan"> <?php echo $data['keterangan']; ?></td>
                                                <td class="td-resep"> <?php echo $data['resep']; ?></td>
                                                <td class="td-id_transaksi"> <?php echo $data['id_transaksi']; ?></td>
                                                <td class="td-ket_setok"> <?php echo $data['ket_setok']; ?></td>
                                                <td class="td-bagian"> <?php echo $data['bagian']; ?></td>
                                                <td class="td-lap"> <?php echo $data['lap']; ?></td>
                                                <td class="td-kode_barang"> <?php echo $data['kode_barang']; ?></td>
                                                <td class="td-id_data_setok"> <?php echo $data['id_data_setok']; ?></td>
                                                <td class="page-list-action td-btn">
                                                    <div class="dropdown" >
                                                        <button data-toggle="dropdown" class="dropdown-toggle btn btn-primary btn-sm">
                                                            <i class="fa fa-bars"></i> 
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <?php if($can_view){ ?>
                                                            <a class="dropdown-item page-modal" href="<?php print_link("data_resep/view/$rec_id"); ?>">
                                                                <i class="fa fa-eye"></i> View 
                                                            </a>
                                                            <?php } ?>
                                                            <?php if($can_edit){ ?>
                                                            <a class="dropdown-item page-modal" href="<?php print_link("data_resep/edit/$rec_id"); ?>">
                                                                <i class="fa fa-edit"></i> Edit
                                                            </a>
                                                            <?php } ?>
                                                            <?php if($can_delete){ ?>
                                                            <a  class="dropdown-item record-delete-btn" href="<?php print_link("data_resep/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
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
                                                <button data-prompt-msg="Are you sure you want to delete these records?" data-display-style="modal" data-url="<?php print_link("data_resep/delete/{sel_ids}/?csrf_token=$csrf_token&redirect=$current_page"); ?>" class="btn btn-sm btn-danger btn-delete-selected d-none">
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
