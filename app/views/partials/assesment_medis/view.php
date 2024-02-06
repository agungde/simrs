<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("assesment_medis/add");
$can_edit = ACL::is_allowed("assesment_medis/edit");
$can_view = ACL::is_allowed("assesment_medis/view");
$can_delete = ACL::is_allowed("assesment_medis/delete");
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
    <div  class=" p-1 mb-1">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">View  Assesment Medis</h4>
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
                                    <tr  class="td-tgl_masuk">
                                        <th class="title"> Tgl Masuk: </th>
                                        <td class="value"> <?php echo $data['tgl_masuk']; ?></td>
                                    </tr>
                                    <tr  class="td-no_rekam_medis">
                                        <th class="title"> No Rekam Medis: </th>
                                        <td class="value"> <?php echo $data['no_rekam_medis']; ?></td>
                                    </tr>
                                    <tr  class="td-nama_pasien">
                                        <th class="title"> Nama Pasien: </th>
                                        <td class="value"> <?php echo $data['nama_pasien']; ?></td>
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
                                    <tr  class="td-tgl_keluar">
                                        <th class="title"> Tgl Keluar: </th>
                                        <td class="value"> <?php echo $data['tgl_keluar']; ?></td>
                                    </tr>
                                    <tr  class="td-scor_gcs">
                                        <th class="title"> SCOR/GCS: </th>
                                        <td class="value"> <?php echo $data['scor_gcs']; ?></td>
                                    </tr>
                                    <tr  class="td-td">
                                        <th class="title"> TD: </th>
                                        <td class="value"> <?php echo $data['td']; ?></td>
                                    </tr>
                                    <tr  class="td-dj">
                                        <th class="title"> DJ: </th>
                                        <td class="value"> <?php echo $data['dj']; ?></td>
                                    </tr>
                                    <tr  class="td-djj">
                                        <th class="title"> DJJ: </th>
                                        <td class="value"> <?php echo $data['djj']; ?></td>
                                    </tr>
                                    <tr  class="td-sh">
                                        <th class="title"> SH: </th>
                                        <td class="value"> <?php echo $data['sh']; ?></td>
                                    </tr>
                                    <tr  class="td-spo">
                                        <th class="title"> SPO2: </th>
                                        <td class="value"> <?php echo $data['spo']; ?></td>
                                    </tr>
                                    <tr  class="td-nd">
                                        <th class="title"> ND: </th>
                                        <td class="value"> <?php echo $data['nd']; ?></td>
                                    </tr>
                                    <tr  class="td-kondisi_umum">
                                        <th class="title"> Kondisi Umum: </th>
                                        <td class="value"> <?php echo $data['kondisi_umum']; ?></td>
                                    </tr>
                                    <tr  class="td-pemeriksaan_penunjang">
                                        <th class="title"> Pemeriksaan Penunjang: </th>
                                        <td class="value"> <?php echo $data['pemeriksaan_penunjang']; ?></td>
                                    </tr>
                                    <tr  class="td-diagnosa_kerja">
                                        <th class="title"> Diagnosa Kerja: </th>
                                        <td class="value"> <?php echo $data['diagnosa_kerja']; ?></td>
                                    </tr>
                                    <tr  class="td-diagnosa_banding">
                                        <th class="title"> Diagnosa Banding: </th>
                                        <td class="value"> <?php echo $data['diagnosa_banding']; ?></td>
                                    </tr>
                                    <tr  class="td-tindakan_pengobatan">
                                        <th class="title"> Tindakan Pengobatan: </th>
                                        <td class="value"> <?php echo $data['tindakan_pengobatan']; ?></td>
                                    </tr>
                                    <tr  class="td-instruksi_selanjutnya">
                                        <th class="title"> Instruksi Selanjutnya: </th>
                                        <td class="value"> <?php echo $data['instruksi_selanjutnya']; ?></td>
                                    </tr>
                                    <tr  class="td-diteruskan_dokter">
                                        <th class="title"> Diteruskan Dokter: </th>
                                        <td class="value"> <?php echo $data['diteruskan_dokter']; ?></td>
                                    </tr>
                                    <tr  class="td-keadaan_keluar_igd">
                                        <th class="title"> Keadaan Keluar Igd: </th>
                                        <td class="value"> <?php echo $data['keadaan_keluar_igd']; ?></td>
                                    </tr>
                                    <tr  class="td-ttd_dokter">
                                        <th class="title"> Ttd Dokter: </th>
                                        <td class="value"><?php Html :: page_img($data['ttd_dokter'],400,400,1); ?></td>
                                    </tr>
                                    <tr  class="td-pasien">
                                        <th class="title"> Pasien: </th>
                                        <td class="value"> <?php echo $data['pasien']; ?></td>
                                    </tr>
                                </tbody>
                                <!-- Table Body End -->
                            </table>
                        </div>
                        <div class="p-3 d-flex">
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
