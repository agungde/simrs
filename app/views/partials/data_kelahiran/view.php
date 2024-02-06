<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("data_kelahiran/add");
$can_edit = ACL::is_allowed("data_kelahiran/edit");
$can_view = ACL::is_allowed("data_kelahiran/view");
$can_delete = ACL::is_allowed("data_kelahiran/delete");
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
                    <h4 class="record-title">View  Data Kelahiran</h4>
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
                                    <tr  class="td-id_ranap_bersalin">
                                        <th class="title"> Id Ranap Bersalin: </th>
                                        <td class="value">
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
                                    </tr>
                                    <tr  class="td-no_rekam_medis">
                                        <th class="title"> No Rekam Medis: </th>
                                        <td class="value">
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
                                    </tr>
                                    <tr  class="td-tanggal">
                                        <th class="title"> Tanggal: </th>
                                        <td class="value">
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
                                    </tr>
                                    <tr  class="td-jam">
                                        <th class="title"> Jam: </th>
                                        <td class="value">
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
                                    </tr>
                                    <tr  class="td-jenis_kelamin">
                                        <th class="title"> Jenis Kelamin: </th>
                                        <td class="value">
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
                                    </tr>
                                    <tr  class="td-Jenis_kelahiran">
                                        <th class="title"> Jenis Kelahiran: </th>
                                        <td class="value">
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
                                    </tr>
                                    <tr  class="td-kelahiran_ke">
                                        <th class="title"> Kelahiran Ke: </th>
                                        <td class="value">
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
                                    </tr>
                                    <tr  class="td-Berat_lahir">
                                        <th class="title"> Berat Lahir: </th>
                                        <td class="value">
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
                                    </tr>
                                    <tr  class="td-panjang_badan">
                                        <th class="title"> Panjang Badan: </th>
                                        <td class="value">
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
                                    </tr>
                                    <tr  class="td-nama_bayi">
                                        <th class="title"> Nama Bayi: </th>
                                        <td class="value">
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
                                    </tr>
                                    <tr  class="td-nama_ibu">
                                        <th class="title"> Nama Ibu: </th>
                                        <td class="value">
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
                                    </tr>
                                    <tr  class="td-umur_ibu">
                                        <th class="title"> Umur Ibu: </th>
                                        <td class="value">
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
                                    </tr>
                                    <tr  class="td-pekerjaan_ibu">
                                        <th class="title"> Pekerjaan Ibu: </th>
                                        <td class="value">
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
                                    </tr>
                                    <tr  class="td-nik_ibu">
                                        <th class="title"> Nik Ibu: </th>
                                        <td class="value">
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
                                    </tr>
                                    <tr  class="td-alamat_ibu">
                                        <th class="title"> Alamat Ibu: </th>
                                        <td class="value">
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
                                    </tr>
                                    <tr  class="td-nama_ayah">
                                        <th class="title"> Nama Ayah: </th>
                                        <td class="value">
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
                                    </tr>
                                    <tr  class="td-umur_ayah">
                                        <th class="title"> Umur Ayah: </th>
                                        <td class="value">
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
                                    </tr>
                                    <tr  class="td-pekerjaan_ayah">
                                        <th class="title"> Pekerjaan Ayah: </th>
                                        <td class="value">
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
                                    </tr>
                                    <tr  class="td-nik_ayah">
                                        <th class="title"> Nik Ayah: </th>
                                        <td class="value">
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
                                    </tr>
                                    <tr  class="td-alamat_ayah">
                                        <th class="title"> Alamat Ayah: </th>
                                        <td class="value">
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
                                    </tr>
                                    <tr  class="td-setatus">
                                        <th class="title"> Setatus: </th>
                                        <td class="value">
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
                                    </tr>
                                    <tr  class="td-operator">
                                        <th class="title"> Operator: </th>
                                        <td class="value">
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
                                    </tr>
                                    <tr  class="td-date_created">
                                        <th class="title"> Date Created: </th>
                                        <td class="value"> <?php echo $data['date_created']; ?></td>
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
                                                <a class="btn btn-sm btn-info"  href="<?php print_link("data_kelahiran/edit/$rec_id"); ?>">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a>
                                                <?php } ?>
                                                <?php if($can_delete){ ?>
                                                <a class="btn btn-sm btn-danger record-delete-btn mx-1"  href="<?php print_link("data_kelahiran/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
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
