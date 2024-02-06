<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("ranap_perina/add");
$can_edit = ACL::is_allowed("ranap_perina/edit");
$can_view = ACL::is_allowed("ranap_perina/view");
$can_delete = ACL::is_allowed("ranap_perina/delete");
?>
<?php
$comp_model = new SharedController;
$page_element_id = "view-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
//Page Data Information from Controller
$data = $this->view_data;
//$rec_id = $data['__tableprimarykey'];
$page_id = $this->route->page_id; //Page id from url
$view_title = $this->view_title;
$show_header = $this->show_header;
$show_edit_btn = $this->show_edit_btn;
$show_delete_btn = $this->show_delete_btn;
$show_export_btn = $this->show_export_btn;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="view"  data-display-type="table" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-light p-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">View  Ranap Perina</h4>
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
                    <?php $this :: display_page_errors(); ?>
                    <div  class="card animated fadeIn page-content">
                        <?php
                        $counter = 0;
                        if(!empty($data)){
                        $rec_id = (!empty($data['id']) ? urlencode($data['id']) : null);
                        $counter++;
                        ?>
                        <div id="page-report-body" class="">
                            <table class="table table-hover table-borderless table-striped">
                                <!-- Table Body Start -->
                                <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                    <tr  class="td-id">
                                        <th class="title"> Id: </th>
                                        <td class="value"> <?php echo $data['id']; ?></td>
                                    </tr>
                                    <tr  class="td-id_transaksi">
                                        <th class="title"> Id Transaksi: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['id_transaksi']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-id_igd">
                                        <th class="title"> Id Igd: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['id_igd']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-tanggal_masuk">
                                        <th class="title"> Tanggal Masuk: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-flatpickr="{ minDate: '', maxDate: ''}" 
                                                data-value="<?php echo $data['tanggal_masuk']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-no_rekam_medis">
                                        <th class="title"> No Rekam Medis: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['no_rekam_medis']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-no_ktp">
                                        <th class="title"> No Ktp: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['no_ktp']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-tl">
                                        <th class="title"> Tl: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['tl']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-nama_pasien">
                                        <th class="title"> Nama Pasien: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['nama_pasien']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-nama_ibu">
                                        <th class="title"> Nama Ibu: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['nama_ibu']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-nama_ayah">
                                        <th class="title"> Nama Ayah: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['nama_ayah']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-alamat">
                                        <th class="title"> Alamat: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['alamat']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-tanggal_lahir">
                                        <th class="title"> Tanggal Lahir: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-flatpickr="{ enableTime: false, minDate: '', maxDate: ''}" 
                                                data-value="<?php echo $data['tanggal_lahir']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-jenis_kelamin">
                                        <th class="title"> Jenis Kelamin: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['jenis_kelamin']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-umur">
                                        <th class="title"> Umur: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['umur']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-no_hp">
                                        <th class="title"> No Hp: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['no_hp']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-email">
                                        <th class="title"> Email: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['email']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
                                                data-name="email" 
                                                data-title="Enter Email" 
                                                data-placement="left" 
                                                data-toggle="click" 
                                                data-type="email" 
                                                data-mode="popover" 
                                                data-showbuttons="left" 
                                                class="is-editable" <?php } ?>>
                                                <?php echo $data['email']; ?> 
                                            </span>
                                        </td>
                                    </tr>
                                    <tr  class="td-dokter_pengirim">
                                        <th class="title"> Dokter Pengirim: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['dokter_pengirim']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-dokter_ranap_perina">
                                        <th class="title"> Dokter Ranap Perina: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['dokter_ranap_perina']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
                                                data-name="dokter_ranap_perina" 
                                                data-title="Enter Dokter Ranap Perina" 
                                                data-placement="left" 
                                                data-toggle="click" 
                                                data-type="number" 
                                                data-mode="popover" 
                                                data-showbuttons="left" 
                                                class="is-editable" <?php } ?>>
                                                <?php echo $data['dokter_ranap_perina']; ?> 
                                            </span>
                                        </td>
                                    </tr>
                                    <tr  class="td-poli">
                                        <th class="title"> Poli: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['poli']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-action">
                                        <th class="title"> Action: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['action']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-tindakan">
                                        <th class="title"> Tindakan: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['tindakan']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-resep_obat">
                                        <th class="title"> Resep Obat: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['resep_obat']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-lab">
                                        <th class="title"> Lab: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['lab']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-catatan_medis">
                                        <th class="title"> Catatan Medis: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['catatan_medis']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-assesment_medis">
                                        <th class="title"> Assesment Medis: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['assesment_medis']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-pemeriksaan_fisik">
                                        <th class="title"> Pemeriksaan Fisik: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['pemeriksaan_fisik']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-rekam_medis">
                                        <th class="title"> Rekam Medis: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['rekam_medis']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-kamar_kelas">
                                        <th class="title"> Kamar Kelas: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['kamar_kelas']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-nama_kamar">
                                        <th class="title"> Nama Kamar: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['nama_kamar']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-no_kamar">
                                        <th class="title"> No Kamar: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['no_kamar']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-no_ranjang">
                                        <th class="title"> No Ranjang: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['no_ranjang']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-setatus">
                                        <th class="title"> Setatus: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['setatus']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-pembayaran">
                                        <th class="title"> Pembayaran: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['pembayaran']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-setatus_bpjs">
                                        <th class="title"> Setatus Bpjs: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['setatus_bpjs']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-penanggung_jawab">
                                        <th class="title"> Penanggung Jawab: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['penanggung_jawab']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-id_penanggung_jawab">
                                        <th class="title"> Id Penanggung Jawab: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['id_penanggung_jawab']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-alamat_penanggung_jawab">
                                        <th class="title"> Alamat Penanggung Jawab: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['alamat_penanggung_jawab']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-no_hp_penanggung_jawab">
                                        <th class="title"> No Hp Penanggung Jawab: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['no_hp_penanggung_jawab']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-hubungan">
                                        <th class="title"> Hubungan: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['hubungan']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-pasien">
                                        <th class="title"> Pasien: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['pasien']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-ranap_perina">
                                        <th class="title"> Ranap Perina: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['ranap_perina']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
                                                data-name="ranap_perina" 
                                                data-title="Enter Ranap Perina" 
                                                data-placement="left" 
                                                data-toggle="click" 
                                                data-type="text" 
                                                data-mode="popover" 
                                                data-showbuttons="left" 
                                                class="is-editable" <?php } ?>>
                                                <?php echo $data['ranap_perina']; ?> 
                                            </span>
                                        </td>
                                    </tr>
                                    <tr  class="td-tanggal_keluar">
                                        <th class="title"> Tanggal Keluar: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-flatpickr="{ minDate: '', maxDate: ''}" 
                                                data-value="<?php echo $data['tanggal_keluar']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-back_link">
                                        <th class="title"> Back Link: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['back_link']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-operator">
                                        <th class="title"> Operator: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-value="<?php echo $data['operator']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                    <tr  class="td-date_created">
                                        <th class="title"> Date Created: </th>
                                        <td class="value"> <?php echo $data['date_created']; ?></td>
                                    </tr>
                                    <tr  class="td-date_updated">
                                        <th class="title"> Date Updated: </th>
                                        <td class="value">
                                            <span <?php if($can_edit){ ?> data-flatpickr="{ minDate: '', maxDate: ''}" 
                                                data-value="<?php echo $data['date_updated']; ?>" 
                                                data-pk="<?php echo $data['id'] ?>" 
                                                data-url="<?php print_link("ranap_perina/editfield/" . urlencode($data['id'])); ?>" 
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
                                    </tr>
                                </tbody>
                                <!-- Table Body End -->
                            </table>
                        </div>
                        <div class="p-3 d-flex">
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
                                                <?php if($can_edit){ ?>
                                                <a class="btn btn-sm btn-info"  href="<?php print_link("ranap_perina/edit/$rec_id"); ?>">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                <?php } ?>
                                                <?php if($can_delete){ ?>
                                                <a class="btn btn-sm btn-danger record-delete-btn mx-1"  href="<?php print_link("ranap_perina/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
                                                    <i class="fa fa-times"></i> Delete
                                                </a>
                                                <?php } ?>
                                            </div>
                                            <?php
                                            }
                                            else{
                                            ?>
                                            <!-- Empty Record Message -->
                                            <div class="text-muted p-3">
                                                <i class="fa fa-ban"></i> No Record Found
                                            </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
