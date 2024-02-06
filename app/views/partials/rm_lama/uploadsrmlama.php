<?php
$comp_model = new SharedController;
$page_element_id = "edit-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
$data = $this->view_data;
//$rec_id = $data['__tableprimarykey'];
$page_id = $this->route->page_id;
$show_header = $this->show_header;
$view_title = $this->view_title;
$redirect_to = $this->redirect_to;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="edit"  data-display-type="" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-light p-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Edit  Rm Lama</h4>
                    <div class=""><div>
                        <?php
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        if(!empty($_GET['datdari'])){
                        $idrm=$_GET['datdari'];
                        $queryb = mysqli_query($koneksi, "select * from rm_lama WHERE id='$idrm'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi)); 
                        // ambil jumlah baris data hasil query
                        $rowsb = mysqli_num_rows($queryb);
                        if ($rowsb <> 0) {
                        $row   = mysqli_fetch_assoc($queryb); 
                        $norekam=$row['no_rekam_medis'];
                        $tglrm=$row['tanggal_rm'];
                        }
                        }
                        ?>
                    </div>
                </div>
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
            <div class="col-md-7 comp-grid">
                <?php $this :: display_page_errors(); ?>
                <div  class="bg-light p-3 animated fadeIn page-content">
                    <form novalidate  id="" role="form" enctype="multipart/form-data"  class="form page-form form-horizontal needs-validation" action="<?php print_link("rm_lama/uploadsrmlama/$page_id/?csrf_token=$csrf_token"); ?>" method="post">
                        <div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="no_rekam_medis">No Rekam Medis <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="">
                                            <input id="ctrl-no_rekam_medis"  value="<?php  echo $data['no_rekam_medis']; ?>" type="text" placeholder="Enter No Rekam Medis"  readonly required="" name="no_rekam_medis"  class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="tanggal_rm">Tanggal Rm <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input id="ctrl-tanggal_rm"  value="<?php  echo $data['tanggal_rm']; ?>" type="text" placeholder="Enter Tanggal Rm"  readonly required="" name="tanggal_rm"  class="form-control " />
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="pemeriksaan_fisik">Pemeriksaan Fisik <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <div class="dropzone required" input="#ctrl-pemeriksaan_fisik" fieldname="pemeriksaan_fisik"    data-multiple="true" dropmsg="Choose files or drag and drop files to upload"    btntext="Browse" extensions=".jpg,.png,.gif,.jpeg" filesize="30" maximum="10">
                                                        <input name="pemeriksaan_fisik" id="ctrl-pemeriksaan_fisik" required="" class="dropzone-input form-control" value="<?php  echo $data['pemeriksaan_fisik']; ?>" type="text"  />
                                                            <!--<div class="invalid-feedback animated bounceIn text-center">Please a choose file</div>-->
                                                            <div class="dz-file-limit animated bounceIn text-center text-danger"></div>
                                                        </div>
                                                    </div>
                                                    <?php Html :: uploaded_files_list($data['pemeriksaan_fisik'], '#ctrl-pemeriksaan_fisik', 'true'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="control-label" for="assesment_triase">Assesment Triase </label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="">
                                                        <div class="dropzone " input="#ctrl-assesment_triase" fieldname="assesment_triase"    data-multiple="true" dropmsg="Choose files or drag and drop files to upload"    btntext="Browse" extensions=".jpg,.png,.gif,.jpeg" filesize="30" maximum="10">
                                                            <input name="assesment_triase" id="ctrl-assesment_triase" class="dropzone-input form-control" value="<?php  echo $data['assesment_triase']; ?>" type="text"  />
                                                                <!--<div class="invalid-feedback animated bounceIn text-center">Please a choose file</div>-->
                                                                <div class="dz-file-limit animated bounceIn text-center text-danger"></div>
                                                            </div>
                                                        </div>
                                                        <?php Html :: uploaded_files_list($data['assesment_triase'], '#ctrl-assesment_triase', 'true'); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label class="control-label" for="assesment_medis">Assesment Medis </label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="">
                                                            <div class="dropzone " input="#ctrl-assesment_medis" fieldname="assesment_medis"    data-multiple="true" dropmsg="Choose files or drag and drop files to upload"    btntext="Browse" extensions=".jpg,.png,.gif,.jpeg" filesize="30" maximum="10">
                                                                <input name="assesment_medis" id="ctrl-assesment_medis" class="dropzone-input form-control" value="<?php  echo $data['assesment_medis']; ?>" type="text"  />
                                                                    <!--<div class="invalid-feedback animated bounceIn text-center">Please a choose file</div>-->
                                                                    <div class="dz-file-limit animated bounceIn text-center text-danger"></div>
                                                                </div>
                                                            </div>
                                                            <?php Html :: uploaded_files_list($data['assesment_medis'], '#ctrl-assesment_medis', 'true'); ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label class="control-label" for="catatan_medis">Catatan Medis </label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="">
                                                                <div class="dropzone " input="#ctrl-catatan_medis" fieldname="catatan_medis"    data-multiple="true" dropmsg="Choose files or drag and drop files to upload"    btntext="Browse" extensions=".jpg,.png,.gif,.jpeg" filesize="30" maximum="10">
                                                                    <input name="catatan_medis" id="ctrl-catatan_medis" class="dropzone-input form-control" value="<?php  echo $data['catatan_medis']; ?>" type="text"  />
                                                                        <!--<div class="invalid-feedback animated bounceIn text-center">Please a choose file</div>-->
                                                                        <div class="dz-file-limit animated bounceIn text-center text-danger"></div>
                                                                    </div>
                                                                </div>
                                                                <?php Html :: uploaded_files_list($data['catatan_medis'], '#ctrl-catatan_medis', 'true'); ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label class="control-label" for="resep_obat">Resep Obat <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <div class="">
                                                                    <div class="dropzone required" input="#ctrl-resep_obat" fieldname="resep_obat"    data-multiple="true" dropmsg="Choose files or drag and drop files to upload"    btntext="Browse" extensions=".jpg,.png,.gif,.jpeg" filesize="30" maximum="10">
                                                                        <input name="resep_obat" id="ctrl-resep_obat" required="" class="dropzone-input form-control" value="<?php  echo $data['resep_obat']; ?>" type="text"  />
                                                                            <!--<div class="invalid-feedback animated bounceIn text-center">Please a choose file</div>-->
                                                                            <div class="dz-file-limit animated bounceIn text-center text-danger"></div>
                                                                        </div>
                                                                    </div>
                                                                    <?php Html :: uploaded_files_list($data['resep_obat'], '#ctrl-resep_obat', 'true'); ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label class="control-label" for="tindakan">Tindakan </label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <div class="">
                                                                        <div class="dropzone " input="#ctrl-tindakan" fieldname="tindakan"    data-multiple="true" dropmsg="Choose files or drag and drop files to upload"    btntext="Browse" extensions=".jpg,.png,.gif,.jpeg" filesize="30" maximum="10">
                                                                            <input name="tindakan" id="ctrl-tindakan" class="dropzone-input form-control" value="<?php  echo $data['tindakan']; ?>" type="text"  />
                                                                                <!--<div class="invalid-feedback animated bounceIn text-center">Please a choose file</div>-->
                                                                                <div class="dz-file-limit animated bounceIn text-center text-danger"></div>
                                                                            </div>
                                                                        </div>
                                                                        <?php Html :: uploaded_files_list($data['tindakan'], '#ctrl-tindakan', 'true'); ?>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group ">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" for="no_rm_lama">No Rm Lama <span class="text-danger">*</span></label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <div class="">
                                                                            <input id="ctrl-no_rm_lama"  value="<?php  echo $data['no_rm_lama']; ?>" type="text" placeholder="Enter No Rm Lama"  readonly required="" name="no_rm_lama"  class="form-control " />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-ajax-status"></div>
                                                            <div class="form-group text-center">
                                                                <button class="btn btn-primary" type="submit">
                                                                    Update
                                                                    <i class="fa fa-send"></i>
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
