<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_kelahiran/add");
$can_edit = ACL::is_allowed("data_kelahiran/edit");
$can_view = ACL::is_allowed("data_kelahiran/view");
$can_delete = ACL::is_allowed("data_kelahiran/delete");
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
                    <h4 class="record-title">Data Kelahiran</h4>
                </div>
                <div class="col-sm-3 ">
                    <?php if($can_add){ ?>
                    <a  class="btn btn btn-primary my-1" href="<?php print_link("data_kelahiran/add") ?>">
                        <i class="fa fa-plus"></i>                              
                        Add New Data Kelahiran 
                    </a>
                    <?php } ?>
                </div>
                <div class="col-sm-4 ">
                    <form  class="search" action="<?php print_link('data_kelahiran'); ?>" method="get">
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
                                        <a class="text-decoration-none" href="<?php print_link('data_kelahiran'); ?>">
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
                                        <a class="text-decoration-none" href="<?php print_link('data_kelahiran'); ?>">
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
                            <div id="data_kelahiran-list-records">
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
                                                <th  class="td-id_ranap_bersalin"> Id Ranap Bersalin</th>
                                                <th  class="td-no_rekam_medis"> No Rekam Medis</th>
                                                <th  class="td-tanggal"> Tanggal</th>
                                                <th  class="td-jam"> Jam</th>
                                                <th  class="td-jenis_kelamin"> Jenis Kelamin</th>
                                                <th  class="td-Jenis_kelahiran"> Jenis Kelahiran</th>
                                                <th  class="td-kelahiran_ke"> Kelahiran Ke</th>
                                                <th  class="td-Berat_lahir"> Berat Lahir</th>
                                                <th  class="td-panjang_badan"> Panjang Badan</th>
                                                <th  class="td-nama_bayi"> Nama Bayi</th>
                                                <th  class="td-nama_ibu"> Nama Ibu</th>
                                                <th  class="td-umur_ibu"> Umur Ibu</th>
                                                <th  class="td-pekerjaan_ibu"> Pekerjaan Ibu</th>
                                                <th  class="td-nik_ibu"> Nik Ibu</th>
                                                <th  class="td-alamat_ibu"> Alamat Ibu</th>
                                                <th  class="td-nama_ayah"> Nama Ayah</th>
                                                <th  class="td-umur_ayah"> Umur Ayah</th>
                                                <th  class="td-pekerjaan_ayah"> Pekerjaan Ayah</th>
                                                <th  class="td-nik_ayah"> Nik Ayah</th>
                                                <th  class="td-alamat_ayah"> Alamat Ayah</th>
                                                <th  class="td-setatus"> Setatus</th>
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
                                                    <td class="td-id"><a href="<?php print_link("data_kelahiran/view/$data[id]") ?>"><?php echo $data['id']; ?></a></td>
                                                    <td class="td-id_ranap_bersalin">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['id_ranap_bersalin']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("data_kelahiran/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="id_ranap_bersalin" 
                                                            data-title="Enter Id Ranap Bersalin" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="number" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['id_ranap_bersalin']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-no_rekam_medis">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['no_rekam_medis']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("data_kelahiran/editfield/" . urlencode($data['id'])); ?>" 
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
                                                    <td class="td-tanggal">
                                                        <span <?php if($can_edit){ ?> data-flatpickr="{ enableTime: false, minDate: '', maxDate: ''}" 
                                                            data-value="<?php echo $data['tanggal']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("data_kelahiran/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="tanggal" 
                                                            data-title="Enter Tanggal" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="flatdatetimepicker" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['tanggal']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-jam">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['jam']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("data_kelahiran/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="jam" 
                                                            data-title="Enter Jam" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="time" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['jam']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-jenis_kelamin">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['jenis_kelamin']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("data_kelahiran/editfield/" . urlencode($data['id'])); ?>" 
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
                                                    <td class="td-Jenis_kelahiran">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['Jenis_kelahiran']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("data_kelahiran/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="Jenis_kelahiran" 
                                                            data-title="Enter Jenis Kelahiran" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['Jenis_kelahiran']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-kelahiran_ke">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['kelahiran_ke']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("data_kelahiran/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="kelahiran_ke" 
                                                            data-title="Enter Kelahiran Ke" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['kelahiran_ke']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-Berat_lahir">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['Berat_lahir']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("data_kelahiran/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="Berat_lahir" 
                                                            data-title="Enter Berat Lahir" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="number" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['Berat_lahir']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-panjang_badan">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['panjang_badan']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("data_kelahiran/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="panjang_badan" 
                                                            data-title="Enter Panjang Badan" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="number" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['panjang_badan']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-nama_bayi">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['nama_bayi']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("data_kelahiran/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="nama_bayi" 
                                                            data-title="Enter Nama Bayi" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['nama_bayi']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-nama_ibu">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['nama_ibu']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("data_kelahiran/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="nama_ibu" 
                                                            data-title="Enter Nama Ibu" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['nama_ibu']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-umur_ibu">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['umur_ibu']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("data_kelahiran/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="umur_ibu" 
                                                            data-title="Enter Umur Ibu" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="number" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['umur_ibu']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-pekerjaan_ibu">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['pekerjaan_ibu']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("data_kelahiran/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="pekerjaan_ibu" 
                                                            data-title="Enter Pekerjaan Ibu" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['pekerjaan_ibu']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-nik_ibu">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['nik_ibu']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("data_kelahiran/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="nik_ibu" 
                                                            data-title="Enter Nik Ibu" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="number" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['nik_ibu']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-alamat_ibu">
                                                        <span <?php if($can_edit){ ?> data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("data_kelahiran/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="alamat_ibu" 
                                                            data-title="Enter Alamat Ibu" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="textarea" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['alamat_ibu']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-nama_ayah">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['nama_ayah']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("data_kelahiran/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="nama_ayah" 
                                                            data-title="Enter Nama Ayah" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['nama_ayah']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-umur_ayah">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['umur_ayah']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("data_kelahiran/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="umur_ayah" 
                                                            data-title="Enter Umur Ayah" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="number" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['umur_ayah']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-pekerjaan_ayah">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['pekerjaan_ayah']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("data_kelahiran/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="pekerjaan_ayah" 
                                                            data-title="Enter Pekerjaan Ayah" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="text" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['pekerjaan_ayah']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-nik_ayah">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['nik_ayah']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("data_kelahiran/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="nik_ayah" 
                                                            data-title="Enter Nik Ayah" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="number" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['nik_ayah']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-alamat_ayah">
                                                        <span <?php if($can_edit){ ?> data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("data_kelahiran/editfield/" . urlencode($data['id'])); ?>" 
                                                            data-name="alamat_ayah" 
                                                            data-title="Enter Alamat Ayah" 
                                                            data-placement="left" 
                                                            data-toggle="click" 
                                                            data-type="textarea" 
                                                            data-mode="popover" 
                                                            data-showbuttons="left" 
                                                            class="is-editable" <?php } ?>>
                                                            <?php echo $data['alamat_ayah']; ?> 
                                                        </span>
                                                    </td>
                                                    <td class="td-setatus">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['setatus']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("data_kelahiran/editfield/" . urlencode($data['id'])); ?>" 
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
                                                    <td class="td-operator">
                                                        <span <?php if($can_edit){ ?> data-value="<?php echo $data['operator']; ?>" 
                                                            data-pk="<?php echo $data['id'] ?>" 
                                                            data-url="<?php print_link("data_kelahiran/editfield/" . urlencode($data['id'])); ?>" 
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
                                                    <th class="td-btn">
                                                        <?php if($can_view){ ?>
                                                        <a class="btn btn-sm btn-success has-tooltip" title="View Record" href="<?php print_link("data_kelahiran/view/$rec_id"); ?>">
                                                            <i class="fa fa-eye"></i> View
                                                        </a>
                                                        <?php } ?>
                                                        <?php if($can_edit){ ?>
                                                        <a class="btn btn-sm btn-info has-tooltip" title="Edit This Record" href="<?php print_link("data_kelahiran/edit/$rec_id"); ?>">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a>
                                                        <?php } ?>
                                                        <?php if($can_delete){ ?>
                                                        <a class="btn btn-sm btn-danger has-tooltip record-delete-btn" title="Delete this record" href="<?php print_link("data_kelahiran/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
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
                                                    <button data-prompt-msg="Are you sure you want to delete these records?" data-display-style="modal" data-url="<?php print_link("data_kelahiran/delete/{sel_ids}/?csrf_token=$csrf_token&redirect=$current_page"); ?>" class="btn btn-sm btn-danger btn-delete-selected d-none">
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
