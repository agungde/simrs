<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("assesment_triase/add");
$can_edit = ACL::is_allowed("assesment_triase/edit");
$can_view = ACL::is_allowed("assesment_triase/view");
$can_delete = ACL::is_allowed("assesment_triase/delete");
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
                    <h4 class="record-title">View  Assesment Triase</h4>
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
                        $rec_id = (!empty($data['id_triase']) ? urlencode($data['id_triase']) : null);
                        $counter++;
                        ?>
                        <div id="page-report-body" class="">
                            <table class="table table-hover table-borderless table-striped">
                                <!-- Table Body Start -->
                                <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                    <div><?php echo $data['level']; ?></div>
                                    <tr  class="td-response_time">
                                        <th class="title"> Response Time: </th>
                                        <td class="value"> <?php echo $data['response_time']; ?></td>
                                    </tr>
                                    <tr  class="td-nama_pasien">
                                        <th class="title"> Nama Pasien: </th>
                                        <td class="value"> <?php echo $data['nama_pasien']; ?></td>
                                    </tr>
                                    <tr  class="td-no_rekam_medis">
                                        <th class="title"> No Rekam Medis: </th>
                                        <td class="value"> <?php echo $data['no_rekam_medis']; ?></td>
                                    </tr>
                                    <tr  class="td-tgl_lahir">
                                        <th class="title"> Tgl Lahir: </th>
                                        <td class="value"> <?php echo $data['tgl_lahir']; ?></td>
                                    </tr>
                                    <tr  class="td-umur">
                                        <th class="title"> Umur: </th>
                                        <td class="value"> <?php echo $data['umur']; ?></td>
                                    </tr>
                                    <tr  class="td-jenis_kelamin">
                                        <th class="title"> Jenis Kelamin: </th>
                                        <td class="value"> <?php echo $data['jenis_kelamin']; ?></td>
                                    </tr>
                                    <tr  class="td-alamat">
                                        <th class="title"> Alamat: </th>
                                        <td class="value"> <?php echo $data['alamat']; ?></td>
                                    </tr>
                                    <tr  class="td-keadaan_ke_igd">
                                        <th class="title"> Keadaan Ke Igd: </th>
                                        <td class="value"> <?php echo $data['keadaan_ke_igd']; ?></td>
                                    </tr>
                                    <tr  class="td-rujukan_dari">
                                        <th class="title"> Rujukan Dari: </th>
                                        <td class="value"> <?php echo $data['rujukan_dari']; ?></td>
                                    </tr>
                                    <tr  class="td-tgl_rujukan">
                                        <th class="title"> Tgl Rujukan: </th>
                                        <td class="value"> <?php echo $data['tgl_rujukan']; ?></td>
                                    </tr>
                                    <tr  class="td-org_yg_bisa_di_hub">
                                        <th class="title"> Org Yg Bisa Di Hub: </th>
                                        <td class="value"> <?php echo $data['org_yg_bisa_di_hub']; ?></td>
                                    </tr>
                                    <tr  class="td-tgl_masuk">
                                        <th class="title"> Tgl Masuk: </th>
                                        <td class="value"> <?php echo $data['tgl_masuk']; ?></td>
                                    </tr>
                                    <tr  class="td-pasien_dr_poli">
                                        <th class="title"> Pasien Dr Poli: </th>
                                        <td class="value"> <?php echo $data['pasien_dr_poli']; ?></td>
                                    </tr>
                                    <div><?php echo $data['keterangan']; ?></div>
                                    <tr  class="td-jam">
                                        <th class="title"> Jam: </th>
                                        <td class="value"> <?php echo $data['jam']; ?></td>
                                    </tr>
                                    <tr  class="td-dokter_pemeriksa">
                                        <th class="title"> Dokter Pemeriksa: </th>
                                        <td class="value"> <?php echo $data['dokter_pemeriksa']; ?></td>
                                    </tr>
                                    <tr  class="td-ttd_dokter">
                                        <th class="title"> Ttd Dokter: </th>
                                        <td class="value"><?php Html :: page_img($data['ttd_dokter'],400,400,1); ?></td>
                                    </tr>
                                    <tr  class="td-ttd_petugas">
                                        <th class="title"> Ttd Petugas: </th>
                                        <td class="value"><?php Html :: page_img($data['ttd_petugas'],400,400,1); ?></td>
                                    </tr>
                                </tbody>
                                <!-- Table Body End -->
                            </table>
                        </div>
                        <div class="p-3 d-flex">
                            <?php if($can_edit){ ?>
                            <a class="btn btn-sm btn-info"  href="<?php print_link("assesment_triase/edit/$rec_id"); ?>">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <?php } ?>
                            <?php if($can_delete){ ?>
                            <a class="btn btn-sm btn-danger record-delete-btn mx-1"  href="<?php print_link("assesment_triase/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
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
