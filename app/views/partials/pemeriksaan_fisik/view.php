<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("pemeriksaan_fisik/add");
$can_edit = ACL::is_allowed("pemeriksaan_fisik/edit");
$can_view = ACL::is_allowed("pemeriksaan_fisik/view");
$can_delete = ACL::is_allowed("pemeriksaan_fisik/delete");
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
    <div  class="bg-white p-1 mb-1">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">View  Pemeriksaan Fisik</h4>
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
                        $rec_id = (!empty($data['id_fisik']) ? urlencode($data['id_fisik']) : null);
                        $counter++;
                        ?>
                        <div id="page-report-body" class="">
                            <table class="table table-hover table-borderless table-striped">
                                <!-- Table Body Start -->
                                <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                    <tr  class="td-tanggal">
                                        <th class="title"> Tanggal: </th>
                                        <td class="value"> <?php echo $data['tanggal']; ?></td>
                                    </tr>
                                    <tr  class="td-no_rekam_medis">
                                        <th class="title"> No Rekam Medis: </th>
                                        <td class="value"> <?php echo $data['no_rekam_medis']; ?></td>
                                    </tr>
                                    <tr  class="td-nama_pasien">
                                        <th class="title"> Nama Pasien: </th>
                                        <td class="value"> <?php echo $data['nama_pasien']; ?></td>
                                    </tr>
                                    <tr  class="td-jenis_kelamin">
                                        <th class="title"> Jenis Kelamin: </th>
                                        <td class="value"> <?php echo $data['jenis_kelamin']; ?></td>
                                    </tr>
                                    <tr  class="td-tanggal_lahir">
                                        <th class="title"> Tanggal Lahir: </th>
                                        <td class="value"> <?php echo $data['tanggal_lahir']; ?></td>
                                    </tr>
                                    <tr  class="td-alamat">
                                        <th class="title"> Alamat: </th>
                                        <td class="value"> <?php echo $data['alamat']; ?></td>
                                    </tr>
                                    <tr  class="td-pasien">
                                        <th class="title"> Pasien: </th>
                                        <td class="value"> <?php echo $data['pasien']; ?></td>
                                    </tr>
                                    <tr  class="td-TB">
                                        <th class="title"> Tb: </th>
                                        <td class="value"> <?php echo $data['TB']; ?></td>
                                    </tr>
                                    <tr  class="td-BB">
                                        <th class="title"> Bb: </th>
                                        <td class="value"> <?php echo $data['BB']; ?></td>
                                    </tr>
                                    <tr  class="td-RR">
                                        <th class="title"> Rr: </th>
                                        <td class="value"> <?php echo $data['RR']; ?></td>
                                    </tr>
                                    <tr  class="td-SH">
                                        <th class="title"> Sh: </th>
                                        <td class="value"> <?php echo $data['SH']; ?></td>
                                    </tr>
                                    <tr  class="td-TFU">
                                        <th class="title"> Tfu: </th>
                                        <td class="value"> <?php echo $data['TFU']; ?></td>
                                    </tr>
                                    <tr  class="td-LILA">
                                        <th class="title"> Lila: </th>
                                        <td class="value"> <?php echo $data['LILA']; ?></td>
                                    </tr>
                                    <tr  class="td-HPHT">
                                        <th class="title"> Hpht: </th>
                                        <td class="value"> <?php echo $data['HPHT']; ?></td>
                                    </tr>
                                    <tr  class="td-riwayat_batuk">
                                        <th class="title"> Riwayat Batuk: </th>
                                        <td class="value"> <?php echo $data['riwayat_batuk']; ?></td>
                                    </tr>
                                    <tr  class="td-riwayat_alergi">
                                        <th class="title"> Riwayat Alergi: </th>
                                        <td class="value"> <?php echo $data['riwayat_alergi']; ?></td>
                                    </tr>
                                    <tr  class="td-riwayat_SCOP">
                                        <th class="title"> Riwayat Scop: </th>
                                        <td class="value"> <?php echo $data['riwayat_SCOP']; ?></td>
                                    </tr>
                                    <tr  class="td-riwayat_penyakit">
                                        <th class="title"> Riwayat Penyakit: </th>
                                        <td class="value"> <?php echo $data['riwayat_penyakit']; ?></td>
                                    </tr>
                                    <tr  class="td-keluhan">
                                        <th class="title"> Keluhan: </th>
                                        <td class="value"> <?php echo $data['keluhan']; ?></td>
                                    </tr>
                                    <tr  class="td-EKG">
                                        <th class="title"> Ekg: </th>
                                        <td class="value"><?php Html :: page_img($data['EKG'],400,400,5); ?></td>
                                    </tr>
                                    <tr  class="td-CTG">
                                        <th class="title"> Ctg: </th>
                                        <td class="value"><?php Html :: page_img($data['CTG'],400,400,5); ?></td>
                                    </tr>
                                    <tr  class="td-ND">
                                        <th class="title"> Nd: </th>
                                        <td class="value"> <?php echo $data['ND']; ?></td>
                                    </tr>
                                    <tr  class="td-SPO">
                                        <th class="title"> Spo: </th>
                                        <td class="value"> <?php echo $data['SPO']; ?></td>
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
