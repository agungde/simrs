<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("ranap_anak/add");
$can_edit = ACL::is_allowed("ranap_anak/edit");
$can_view = ACL::is_allowed("ranap_anak/view");
$can_delete = ACL::is_allowed("ranap_anak/delete");
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
                    <h4 class="record-title">Ranap Anak</h4>
                </div>
                <div class="col-sm-3 ">
                    <?php if($can_add){ ?>
                    <a  class="btn btn btn-primary my-1" href="<?php print_link("ranap_anak/add") ?>">
                        <i class="fa fa-plus"></i>                              
                        Add New Ranap Anak 
                    </a>
                    <?php } ?>
                </div>
                <div class="col-sm-4 ">
                    <form  class="search" action="<?php print_link('ranap_anak'); ?>" method="get">
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
                                        <a class="text-decoration-none" href="<?php print_link('ranap_anak'); ?>">
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
                                        <a class="text-decoration-none" href="<?php print_link('ranap_anak'); ?>">
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
                            <div id="ranap_anak-list-records">
                                <div id="page-report-body" class="table-responsive">
                                    <table class="table  table-striped table-sm text-left">
                                        <thead class="table-header bg-light">
                                            <tr>
                                                <?php if($can_delete){ ?>
                                                <th class="td-checkbox">
                                                    <label class="custom-control custom-checkbox custom-control-inline">
                                                        <input class="toggle-check-all custom-control-input" type="checkbox" />
                                                        <span class="custom-control-label"></span>
                                                    </label>
                                                </th>
                                                <?php } ?>
                                                <th class="td-sno">#</th>
                                                <th  class="td-id"> Id</th>
                                                <th  class="td-id_transaksi"> Id Transaksi</th>
                                                <th  class="td-id_igd"> Id Igd</th>
                                                <th  class="td-tanggal_masuk"> Tanggal Masuk</th>
                                                <th  class="td-no_rekam_medis"> No Rekam Medis</th>
                                                <th  class="td-no_ktp"> No Ktp</th>
                                                <th  class="td-tl"> Tl</th>
                                                <th  class="td-nama_pasien"> Nama Pasien</th>
                                                <th  class="td-alamat"> Alamat</th>
                                                <th  class="td-tanggal_lahir"> Tanggal Lahir</th>
                                                <th  class="td-jenis_kelamin"> Jenis Kelamin</th>
                                                <th  class="td-umur"> Umur</th>
                                                <th  class="td-no_hp"> No Hp</th>
                                                <th  class="td-email"> Email</th>
                                                <th  class="td-nama_orang_tua"> Nama Orang Tua</th>
                                                <th  class="td-pembayaran"> Pembayaran</th>
                                                <th  class="td-setatus_bpjs"> Setatus Bpjs</th>
                                                <th  class="td-penanggung_jawab"> Penanggung Jawab</th>
                                                <th  class="td-id_penanggung_jawab"> Id Penanggung Jawab</th>
                                                <th  class="td-alamat_penanggung_jawab"> Alamat Penanggung Jawab</th>
                                                <th  class="td-no_hp_penanggung_jawab"> No Hp Penanggung Jawab</th>
                                                <th  class="td-hubungan"> Hubungan</th>
                                                <th  class="td-ranap_anak"> Ranap Anak</th>
                                                <th  class="td-action"> Action</th>
                                                <th  class="td-setatus"> Setatus</th>
                                                <th  class="td-dokter_pengirim"> Dokter Pengirim</th>
                                                <th  class="td-tindakan"> Tindakan</th>
                                                <th  class="td-resep_obat"> Resep Obat</th>
                                                <th  class="td-pasien"> Pasien</th>
                                                <th  class="td-kamar_kelas"> Kamar Kelas</th>
                                                <th  class="td-nama_kamar"> Nama Kamar</th>
                                                <th  class="td-no_kamar"> No Kamar</th>
                                                <th  class="td-no_ranjang"> No Ranjang</th>
                                                <th  class="td-dokter_ranap_anak"> Dokter Ranap Anak</th>
                                                <th  class="td-poli"> Poli</th>
                                                <th  class="td-lab"> Lab</th>
                                                <th  class="td-catatan_medis"> Catatan Medis</th>
                                                <th  class="td-assesment_medis"> Assesment Medis</th>
                                                <th  class="td-pemeriksaan_fisik"> Pemeriksaan Fisik</th>
                                                <th  class="td-rekam_medis"> Rekam Medis</th>
                                                <th  class="td-tanggal_keluar"> Tanggal Keluar</th>
                                                <th  class="td-back_link"> Back Link</th>
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
                                            $rec_id = (!empty($data['id']) ? urlencode($data['id']) : null);
                                            $counter++;
                                            ?>
                                            <tr>
                                                <?php if($can_delete){ ?>
                                                <th class=" td-checkbox">
                                                    <label class="custom-control custom-checkbox custom-control-inline">
                                                        <input class="optioncheck custom-control-input" name="optioncheck[]" value="<?php echo $data['id'] ?>" type="checkbox" />
                                                            <span class="custom-control-label"></span>
                                                        </label>
                                                    </th>
                                                    <?php } ?>
                                                    <th class="td-sno"><?php echo $counter; ?></th>
                                                    <td class="td-id"><a href="<?php print_link("ranap_anak/view/$data[id]") ?>"><?php echo $data['id']; ?></a></td>
                                                    <td class="td-id_transaksi">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['id_transaksi']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="id_transaksi" 
                                                            data-title="Enter Id Transaksi" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="number" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['id_transaksi']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-id_igd">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['id_igd']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="id_igd" 
                                                            data-title="Enter Id Igd" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="number" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['id_igd']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-tanggal_masuk">
                                                        <span <?php if($can_edit){ ?> data-flatpickr="{ minDate: '', maxDate: ''}" 
                                                            data-value="<?php echo $data['tanggal_masuk']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="tanggal_masuk" 
                                                            data-title="Enter Tanggal Masuk" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="flatdatetimepicker" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['tanggal_masuk']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-no_rekam_medis">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['no_rekam_medis']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="no_rekam_medis" 
                                                            data-title="Enter No Rekam Medis" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['no_rekam_medis']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-no_ktp">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['no_ktp']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="no_ktp" 
                                                            data-title="Enter No Ktp" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="number" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['no_ktp']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-tl">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['tl']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="tl" 
                                                            data-title="Enter Tl" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['tl']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-nama_pasien">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['nama_pasien']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="nama_pasien" 
                                                            data-title="Enter Nama Pasien" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['nama_pasien']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-alamat">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['alamat']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="alamat" 
                                                            data-title="Enter Alamat" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['alamat']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-tanggal_lahir">
                                                        <span <?php if($can_edit){ ?> data-flatpickr="{ enableTime: false, minDate: '', maxDate: ''}" 
                                                            data-value="<?php echo $data['tanggal_lahir']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="tanggal_lahir" 
                                                            data-title="Enter Tanggal Lahir" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="flatdatetimepicker" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['tanggal_lahir']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-jenis_kelamin">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['jenis_kelamin']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="jenis_kelamin" 
                                                            data-title="Enter Jenis Kelamin" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['jenis_kelamin']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-umur">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['umur']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="umur" 
                                                            data-title="Enter Umur" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['umur']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-no_hp">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['no_hp']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="no_hp" 
                                                            data-title="Enter No Hp" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['no_hp']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-email"><a href="<?php print_link("mailto:$data[email]") ?>"><?php echo $data['email']; ?></a></td>
                                                    <td class="td-nama_orang_tua">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['nama_orang_tua']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="nama_orang_tua" 
                                                            data-title="Enter Nama Orang Tua" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['nama_orang_tua']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-pembayaran">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['pembayaran']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="pembayaran" 
                                                            data-title="Enter Pembayaran" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="number" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['pembayaran']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-setatus_bpjs">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['setatus_bpjs']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="setatus_bpjs" 
                                                            data-title="Enter Setatus Bpjs" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['setatus_bpjs']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-penanggung_jawab">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['penanggung_jawab']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="penanggung_jawab" 
                                                            data-title="Enter Penanggung Jawab" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['penanggung_jawab']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-id_penanggung_jawab">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['id_penanggung_jawab']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="id_penanggung_jawab" 
                                                            data-title="Enter Id Penanggung Jawab" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['id_penanggung_jawab']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-alamat_penanggung_jawab">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['alamat_penanggung_jawab']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="alamat_penanggung_jawab" 
                                                            data-title="Enter Alamat Penanggung Jawab" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['alamat_penanggung_jawab']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-no_hp_penanggung_jawab">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['no_hp_penanggung_jawab']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="no_hp_penanggung_jawab" 
                                                            data-title="Enter No Hp Penanggung Jawab" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['no_hp_penanggung_jawab']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-hubungan">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['hubungan']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="hubungan" 
                                                            data-title="Enter Hubungan" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['hubungan']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-ranap_anak">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['ranap_anak']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="ranap_anak" 
                                                            data-title="Enter Ranap Anak" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['ranap_anak']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-action">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['action']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="action" 
                                                            data-title="Enter Action" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['action']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-setatus">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['setatus']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="setatus" 
                                                            data-title="Enter Setatus" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['setatus']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-dokter_pengirim">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['dokter_pengirim']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="dokter_pengirim" 
                                                            data-title="Enter Dokter Pengirim" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="number" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['dokter_pengirim']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-tindakan">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['tindakan']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="tindakan" 
                                                            data-title="Enter Tindakan" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['tindakan']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-resep_obat">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['resep_obat']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="resep_obat" 
                                                            data-title="Enter Resep Obat" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['resep_obat']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-pasien">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['pasien']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="pasien" 
                                                            data-title="Enter Pasien" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['pasien']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-kamar_kelas">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['kamar_kelas']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="kamar_kelas" 
                                                            data-title="Enter Kamar Kelas" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="number" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['kamar_kelas']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-nama_kamar">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['nama_kamar']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="nama_kamar" 
                                                            data-title="Enter Nama Kamar" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['nama_kamar']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-no_kamar">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['no_kamar']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="no_kamar" 
                                                            data-title="Enter No Kamar" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['no_kamar']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-no_ranjang">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['no_ranjang']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="no_ranjang" 
                                                            data-title="Enter No Ranjang" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['no_ranjang']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-dokter_ranap_anak">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['dokter_ranap_anak']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="dokter_ranap_anak" 
                                                            data-title="Enter Dokter Ranap Anak" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="number" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['dokter_ranap_anak']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-poli">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['poli']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="poli" 
                                                            data-title="Enter Poli" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="number" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['poli']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-lab">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['lab']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="lab" 
                                                            data-title="Enter Lab" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['lab']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-catatan_medis">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['catatan_medis']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="catatan_medis" 
                                                            data-title="Enter Catatan Medis" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['catatan_medis']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-assesment_medis">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['assesment_medis']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="assesment_medis" 
                                                            data-title="Enter Assesment Medis" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['assesment_medis']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-pemeriksaan_fisik">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['pemeriksaan_fisik']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="pemeriksaan_fisik" 
                                                            data-title="Enter Pemeriksaan Fisik" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['pemeriksaan_fisik']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-rekam_medis">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['rekam_medis']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="rekam_medis" 
                                                            data-title="Enter Rekam Medis" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['rekam_medis']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-tanggal_keluar">
                                                        <span <?php if($can_edit){ ?> data-flatpickr="{ minDate: '', maxDate: ''}" 
                                                            data-value="<?php echo $data['tanggal_keluar']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="tanggal_keluar" 
                                                            data-title="Enter Tanggal Keluar" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="flatdatetimepicker" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['tanggal_keluar']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-back_link">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['back_link']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="back_link" 
                                                            data-title="Enter Back Link" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['back_link']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-operator">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['operator']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="operator" 
                                                            data-title="Enter Operator" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="number" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['operator']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-date_created"> <?php echo $data['date_created']; ?></td>
                                                    <td class="td-date_updated">
                                                        <span <?php if($can_edit){ ?> data-flatpickr="{ minDate: '', maxDate: ''}" 
                                                            data-value="<?php echo $data['date_updated']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("ranap_anak/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="date_updated" 
                                                            data-title="Enter Date Updated" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="flatdatetimepicker" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['date_updated']; ?> 
                                                        </span>
                                                    </td>
                                                    <th class="td-btn">
                                                        <?php if($can_view){ ?>
                                                        <a class="btn btn-sm btn-success has-tooltip" title="View Record" href="<?php print_link("ranap_anak/view/$rec_id"); ?>">
                                                            <i class="fa fa-eye"></i> View
                                                        </a>
                                                        <?php } ?>
                                                        <?php if($can_edit){ ?>
                                                        <a class="btn btn-sm btn-info has-tooltip" title="Edit This Record" href="<?php print_link("ranap_anak/edit/$rec_id"); ?>">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a>
                                                        <?php } ?>
                                                        <?php if($can_delete){ ?>
                                                        <a class="btn btn-sm btn-danger has-tooltip record-delete-btn" title="Delete this record" href="<?php print_link("ranap_anak/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
                                                            <i class="fa fa-times"></i>
                                                            Delete
                                                        </a>
                                                        <?php } ?>
                                                    </th>
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
                                                    <button data-prompt-msg="Are you sure you want to delete these records?" data-display-style="modal" data-url="<?php print_link("ranap_anak/delete/{sel_ids}/?csrf_token=$csrf_token&redirect=$current_page"); ?>" class="btn btn-sm btn-danger btn-delete-selected d-none">
                                                        <i class="fa fa-times"></i> Delete Selected
                                                    </button>
                                                    <?php } ?>
                                                    <div class="dropup export-btn-holder mx-1">
                                                        <button class="btn btn-sm btn-primary dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                            <i class="fa fa-save"></i> Export
                                                        </button>
                                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                            <?php $export_print_link = $this->set_current_page_link(array('format' => 'print')); ?>
                                                            <a class="dropdown-item export-link-btn" data-format="print" href="<?php print_link($export_print_link); ?>" target="_blank">
                                                                <img src="<?php print_link('assets/images/print.png') ?>" class="mr-2" /> PRINT
                                                                </a>
                                                                <?php $export_pdf_link = $this->set_current_page_link(array('format' => 'pdf')); ?>
                                                                <a class="dropdown-item export-link-btn" data-format="pdf" href="<?php print_link($export_pdf_link); ?>" target="_blank">
                                                                    <img src="<?php print_link('assets/images/pdf.png') ?>" class="mr-2" /> PDF
                                                                    </a>
                                                                    <?php $export_word_link = $this->set_current_page_link(array('format' => 'word')); ?>
                                                                    <a class="dropdown-item export-link-btn" data-format="word" href="<?php print_link($export_word_link); ?>" target="_blank">
                                                                        <img src="<?php print_link('assets/images/doc.png') ?>" class="mr-2" /> WORD
                                                                        </a>
                                                                        <?php $export_csv_link = $this->set_current_page_link(array('format' => 'csv')); ?>
                                                                        <a class="dropdown-item export-link-btn" data-format="csv" href="<?php print_link($export_csv_link); ?>" target="_blank">
                                                                            <img src="<?php print_link('assets/images/csv.png') ?>" class="mr-2" /> CSV
                                                                            </a>
                                                                            <?php $export_excel_link = $this->set_current_page_link(array('format' => 'excel')); ?>
                                                                            <a class="dropdown-item export-link-btn" data-format="excel" href="<?php print_link($export_excel_link); ?>" target="_blank">
                                                                                <img src="<?php print_link('assets/images/xsl.png') ?>" class="mr-2" /> EXCEL
                                                                                </a>
                                                                            </div>
                                                                        </div>
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
