<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("rawat_inap_anak/add");
$can_edit = ACL::is_allowed("rawat_inap_anak/edit");
$can_view = ACL::is_allowed("rawat_inap_anak/view");
$can_delete = ACL::is_allowed("rawat_inap_anak/delete");
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
                    <h4 class="record-title">View  Rawat Inap Anak</h4>
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
                                    <tr  class="td-id_igd">
                                        <th class="title"> Id Igd: </th>
                                        <td class="value"> <?php echo $data['id_igd']; ?></td>
                                    </tr>
                                    <tr  class="td-id_transaksi">
                                        <th class="title"> Id Transaksi: </th>
                                        <td class="value"> <?php echo $data['id_transaksi']; ?></td>
                                    </tr>
                                    <tr  class="td-tanggal_masuk">
                                        <th class="title"> Tanggal Masuk: </th>
                                        <td class="value"> <?php echo $data['tanggal_masuk']; ?></td>
                                    </tr>
                                    <tr  class="td-nama_pasien">
                                        <th class="title"> Nama Pasien: </th>
                                        <td class="value"> <?php echo $data['nama_pasien']; ?></td>
                                    </tr>
                                    <tr  class="td-no_rekam_medis">
                                        <th class="title"> No Rekam Medis: </th>
                                        <td class="value"> <?php echo $data['no_rekam_medis']; ?></td>
                                    </tr>
                                    <tr  class="td-alamat">
                                        <th class="title"> Alamat: </th>
                                        <td class="value"> <?php echo $data['alamat']; ?></td>
                                    </tr>
                                    <tr  class="td-tanggal_lahir">
                                        <th class="title"> Tanggal Lahir: </th>
                                        <td class="value"> <?php echo $data['tanggal_lahir']; ?></td>
                                    </tr>
                                    <tr  class="td-umur">
                                        <th class="title"> Umur: </th>
                                        <td class="value"> <?php echo $data['umur']; ?></td>
                                    </tr>
                                    <tr  class="td-jenis_kelamin">
                                        <th class="title"> Jenis Kelamin: </th>
                                        <td class="value"> <?php echo $data['jenis_kelamin']; ?></td>
                                    </tr>
                                    <tr  class="td-nama_orang_tua">
                                        <th class="title"> Nama Orang Tua: </th>
                                        <td class="value"> <?php echo $data['nama_orang_tua']; ?></td>
                                    </tr>
                                    <tr  class="td-action">
                                        <th class="title"> Action: </th>
                                        <td class="value"> <?php echo $data['action']; ?></td>
                                    </tr>
                                    <tr  class="td-pemeriksaan_fisik">
                                        <th class="title"> Pemeriksaan Fisik: </th>
                                        <td class="value"> <?php echo $data['pemeriksaan_fisik']; ?></td>
                                    </tr>
                                    <tr  class="td-catatan_medis">
                                        <th class="title"> Catatan Medis: </th>
                                        <td class="value"> <?php echo $data['catatan_medis']; ?></td>
                                    </tr>
                                    <tr  class="td-tindakan">
                                        <th class="title"> Tindakan: </th>
                                        <td class="value"> <?php echo $data['tindakan']; ?></td>
                                    </tr>
                                    <tr  class="td-rekam_medis">
                                        <th class="title"> Rekam Medis: </th>
                                        <td class="value"> <?php echo $data['rekam_medis']; ?></td>
                                    </tr>
                                    <tr  class="td-resep_obat">
                                        <th class="title"> Resep Obat: </th>
                                        <td class="value"> <?php echo $data['resep_obat']; ?></td>
                                    </tr>
                                    <tr  class="td-lab">
                                        <th class="title"> Lab: </th>
                                        <td class="value"> <?php echo $data['lab']; ?></td>
                                    </tr>
                                    <tr  class="td-status">
                                        <th class="title"> Status: </th>
                                        <td class="value"> <?php echo $data['status']; ?></td>
                                    </tr>
                                    <tr  class="td-assesment_medis">
                                        <th class="title"> Assesment Medis: </th>
                                        <td class="value"> <?php echo $data['assesment_medis']; ?></td>
                                    </tr>
                                    <tr  class="td-assesment_triase">
                                        <th class="title"> Assesment Triase: </th>
                                        <td class="value"> <?php echo $data['assesment_triase']; ?></td>
                                    </tr>
                                    <tr  class="td-tanggal_keluar">
                                        <th class="title"> Tanggal Keluar: </th>
                                        <td class="value"> <?php echo $data['tanggal_keluar']; ?></td>
                                    </tr>
                                    <tr  class="td-operator">
                                        <th class="title"> Operator: </th>
                                        <td class="value"> <?php echo $data['operator']; ?></td>
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
                            <?php if($can_edit){ ?>
                            <a class="btn btn-sm btn-info"  href="<?php print_link("rawat_inap_anak/edit/$rec_id"); ?>">
                                <i class="fa fa-edit"></i> Edit
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
