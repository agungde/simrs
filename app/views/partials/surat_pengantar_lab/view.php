<?php 
//check if current user role is allowed access to the pages
$can_add = ACL::is_allowed("surat_pengantar_lab/add");
$can_edit = ACL::is_allowed("surat_pengantar_lab/edit");
$can_view = ACL::is_allowed("surat_pengantar_lab/view");
$can_delete = ACL::is_allowed("surat_pengantar_lab/delete");
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
                    <h4 class="record-title">View  Surat Pengantar Lab</h4>
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
                        $rec_id = (!empty($data['id_surat']) ? urlencode($data['id_surat']) : null);
                        $counter++;
                        ?>
                        <div id="page-report-body" class="">
                            <table class="table table-hover table-borderless table-striped">
                                <!-- Table Body Start -->
                                <tbody class="page-data" id="page-data-<?php echo $page_element_id; ?>">
                                    <tr  class="td-nama_pasien">
                                        <th class="title"> Nama Pasien: </th>
                                        <td class="value"> <?php echo $data['nama_pasien']; ?></td>
                                    </tr>
                                    <tr  class="td-tgl_lahir">
                                        <th class="title"> Tgl Lahir: </th>
                                        <td class="value"> <?php echo $data['tgl_lahir']; ?></td>
                                    </tr>
                                    <tr  class="td-alamat">
                                        <th class="title"> Alamat: </th>
                                        <td class="value"> <?php echo $data['alamat']; ?></td>
                                    </tr>
                                    <tr  class="td-ruangan">
                                        <th class="title"> Ruangan: </th>
                                        <td class="value"> <?php echo $data['ruangan']; ?></td>
                                    </tr>
                                    <tr  class="td-kelas">
                                        <th class="title"> Kelas: </th>
                                        <td class="value"> <?php echo $data['kelas']; ?></td>
                                    </tr>
                                    <tr  class="td-imuniserologi">
                                        <th class="title"> Imuniserologi: </th>
                                        <td class="value"> <?php echo $data['imuniserologi']; ?></td>
                                    </tr>
                                    <tr  class="td-kimia_klinik">
                                        <th class="title"> Kimia Klinik: </th>
                                        <td class="value"> <?php echo $data['kimia_klinik']; ?></td>
                                    </tr>
                                    <tr  class="td-urin_faces">
                                        <th class="title"> Urin Faces: </th>
                                        <td class="value"> <?php echo $data['urin_faces']; ?></td>
                                    </tr>
                                    <tr  class="td-microbiologi">
                                        <th class="title"> Microbiologi: </th>
                                        <td class="value"> <?php echo $data['microbiologi']; ?></td>
                                    </tr>
                                    <tr  class="td-lain_lain">
                                        <th class="title"> Lain Lain: </th>
                                        <td class="value"> <?php echo $data['lain_lain']; ?></td>
                                    </tr>
                                    <tr  class="td-dari_poli">
                                        <th class="title"> Dari Poli: </th>
                                        <td class="value"> <?php echo $data['dari_poli']; ?></td>
                                    </tr>
                                    <tr  class="td-ttd_dokter">
                                        <th class="title"> Ttd Dokter: </th>
                                        <td class="value"><?php Html :: page_img($data['ttd_dokter'],400,400,1); ?></td>
                                    </tr>
                                    <tr  class="td-tanggal">
                                        <th class="title"> Tanggal: </th>
                                        <td class="value"> <?php echo $data['tanggal']; ?></td>
                                    </tr>
                                    <tr  class="td-no_rekam_medis">
                                        <th class="title"> No Rekam Medis: </th>
                                        <td class="value"> <?php echo $data['no_rekam_medis']; ?></td>
                                    </tr>
                                </tbody>
                                <!-- Table Body End -->
                            </table>
                        </div>
                        <div class="p-3 d-flex">
                            <?php if($can_edit){ ?>
                            <a class="btn btn-sm btn-info"  href="<?php print_link("surat_pengantar_lab/edit/$rec_id"); ?>">
                                <i class="fa fa-edit"></i> Edit
                            </a>
                            <?php } ?>
                            <?php if($can_delete){ ?>
                            <a class="btn btn-sm btn-danger record-delete-btn mx-1"  href="<?php print_link("surat_pengantar_lab/delete/$rec_id/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
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
