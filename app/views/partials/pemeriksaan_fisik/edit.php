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
    <div  class="bg-white p-1 mb-1">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Edit  Pemeriksaan Fisik</h4>
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
                        <form novalidate  id="" role="form" enctype="multipart/form-data"  class="form page-form form-horizontal needs-validation" action="<?php print_link("pemeriksaan_fisik/edit/$page_id/?csrf_token=$csrf_token"); ?>" method="post">
                            <div>
                                <input id="ctrl-tanggal"  value="<?php  echo $data['tanggal']; ?>" type="hidden" placeholder="Enter Tanggal"  required="" name="tanggal"  class="form-control " />
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="keluhan">Keluhan <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <input id="ctrl-keluhan"  value="<?php  echo $data['keluhan']; ?>" type="text" placeholder="Enter Keluhan"  required="" name="keluhan"  class="form-control " />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="control-label" for="TD">TD <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="">
                                                        <input id="ctrl-TD"  value="<?php  echo $data['TD']; ?>" type="text" placeholder="Enter TD"  required="" name="TD"  class="form-control " />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label class="control-label" for="ND">Nd <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="">
                                                            <input id="ctrl-ND"  value="<?php  echo $data['ND']; ?>" type="text" placeholder="Enter Nd"  required="" name="ND"  class="form-control " />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label class="control-label" for="SH">SH <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="">
                                                                <input id="ctrl-SH"  value="<?php  echo $data['SH']; ?>" type="text" placeholder="Enter SH"  required="" name="SH"  class="form-control " />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label class="control-label" for="TB">TB </label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <div class="">
                                                                    <input id="ctrl-TB"  value="<?php  echo $data['TB']; ?>" type="text" placeholder="Enter TB"  name="TB"  class="form-control " />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label class="control-label" for="BB">BB </label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <div class="">
                                                                        <input id="ctrl-BB"  value="<?php  echo $data['BB']; ?>" type="text" placeholder="Enter BB"  name="BB"  class="form-control " />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group ">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" for="RR">RR </label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <div class="">
                                                                            <input id="ctrl-RR"  value="<?php  echo $data['RR']; ?>" type="text" placeholder="Enter RR"  name="RR"  class="form-control " />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group ">
                                                                    <div class="row">
                                                                        <div class="col-sm-4">
                                                                            <label class="control-label" for="TFU">TFU </label>
                                                                        </div>
                                                                        <div class="col-sm-8">
                                                                            <div class="">
                                                                                <input id="ctrl-TFU"  value="<?php  echo $data['TFU']; ?>" type="text" placeholder="Enter TFU"  name="TFU"  class="form-control " />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group ">
                                                                        <div class="row">
                                                                            <div class="col-sm-4">
                                                                                <label class="control-label" for="LILA">LILA </label>
                                                                            </div>
                                                                            <div class="col-sm-8">
                                                                                <div class="">
                                                                                    <input id="ctrl-LILA"  value="<?php  echo $data['LILA']; ?>" type="text" placeholder="Enter LILA"  name="LILA"  class="form-control " />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group ">
                                                                            <div class="row">
                                                                                <div class="col-sm-4">
                                                                                    <label class="control-label" for="HPHT">HPHT </label>
                                                                                </div>
                                                                                <div class="col-sm-8">
                                                                                    <div class="">
                                                                                        <input id="ctrl-HPHT"  value="<?php  echo $data['HPHT']; ?>" type="text" placeholder="Enter HPHT"  name="HPHT"  class="form-control " />
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group ">
                                                                                <div class="row">
                                                                                    <div class="col-sm-4">
                                                                                        <label class="control-label" for="SPO">SPO2 </label>
                                                                                    </div>
                                                                                    <div class="col-sm-8">
                                                                                        <div class="">
                                                                                            <input id="ctrl-SPO"  value="<?php  echo $data['SPO']; ?>" type="text" placeholder="Enter SPO2"  name="SPO"  class="form-control " />
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group ">
                                                                                    <div class="row">
                                                                                        <div class="col-sm-4">
                                                                                            <label class="control-label" for="riwayat_batuk">Riwayat Batuk </label>
                                                                                        </div>
                                                                                        <div class="col-sm-8">
                                                                                            <div class="">
                                                                                                <input id="ctrl-riwayat_batuk"  value="<?php  echo $data['riwayat_batuk']; ?>" type="text" placeholder="Enter Riwayat Batuk"  name="riwayat_batuk"  class="form-control " />
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group ">
                                                                                        <div class="row">
                                                                                            <div class="col-sm-4">
                                                                                                <label class="control-label" for="riwayat_alergi">Riwayat Alergi </label>
                                                                                            </div>
                                                                                            <div class="col-sm-8">
                                                                                                <div class="">
                                                                                                    <input id="ctrl-riwayat_alergi"  value="<?php  echo $data['riwayat_alergi']; ?>" type="text" placeholder="Enter Riwayat Alergi"  name="riwayat_alergi"  class="form-control " />
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group ">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-4">
                                                                                                    <label class="control-label" for="riwayat_SCOP">Riwayat SCOP </label>
                                                                                                </div>
                                                                                                <div class="col-sm-8">
                                                                                                    <div class="">
                                                                                                        <input id="ctrl-riwayat_SCOP"  value="<?php  echo $data['riwayat_SCOP']; ?>" type="text" placeholder="Enter Riwayat SCOP"  name="riwayat_SCOP"  class="form-control " />
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group ">
                                                                                                <div class="row">
                                                                                                    <div class="col-sm-4">
                                                                                                        <label class="control-label" for="riwayat_penyakit">Riwayat Penyakit <span class="text-danger">*</span></label>
                                                                                                    </div>
                                                                                                    <div class="col-sm-8">
                                                                                                        <div class="">
                                                                                                            <input id="ctrl-riwayat_penyakit"  value="<?php  echo $data['riwayat_penyakit']; ?>" type="text" placeholder="Enter Riwayat Penyakit"  required="" name="riwayat_penyakit"  class="form-control " />
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group ">
                                                                                                    <div class="row">
                                                                                                        <div class="col-sm-4">
                                                                                                            <label class="control-label" for="EKG">Ekg </label>
                                                                                                        </div>
                                                                                                        <div class="col-sm-8">
                                                                                                            <div class="">
                                                                                                                <div class="dropzone " input="#ctrl-EKG" fieldname="EKG"    data-multiple="true" dropmsg="Choose files or drag and drop files to upload"    btntext="Browse" extensions=".jpg,.png,.gif,.jpeg" filesize="10" maximum="5">
                                                                                                                    <input name="EKG" id="ctrl-EKG" class="dropzone-input form-control" value="<?php  echo $data['EKG']; ?>" type="text"  />
                                                                                                                        <!--<div class="invalid-feedback animated bounceIn text-center">Please a choose file</div>-->
                                                                                                                        <div class="dz-file-limit animated bounceIn text-center text-danger"></div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <?php Html :: uploaded_files_list($data['EKG'], '#ctrl-EKG', 'true'); ?>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <div class="form-group ">
                                                                                                        <div class="row">
                                                                                                            <div class="col-sm-4">
                                                                                                                <label class="control-label" for="CTG">Ctg </label>
                                                                                                            </div>
                                                                                                            <div class="col-sm-8">
                                                                                                                <div class="">
                                                                                                                    <div class="dropzone " input="#ctrl-CTG" fieldname="CTG"    data-multiple="true" dropmsg="Choose files or drag and drop files to upload"    btntext="Browse" extensions=".jpg,.png,.gif,.jpeg" filesize="10" maximum="5">
                                                                                                                        <input name="CTG" id="ctrl-CTG" class="dropzone-input form-control" value="<?php  echo $data['CTG']; ?>" type="text"  />
                                                                                                                            <!--<div class="invalid-feedback animated bounceIn text-center">Please a choose file</div>-->
                                                                                                                            <div class="dz-file-limit animated bounceIn text-center text-danger"></div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                    <?php Html :: uploaded_files_list($data['CTG'], '#ctrl-CTG', 'true'); ?>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                        </div>
                                                                                                        <input id="ctrl-nama_pasien"  value="<?php  echo $data['nama_pasien']; ?>" type="hidden" placeholder="Enter Nama Pasien"  required="" name="nama_pasien"  class="form-control " />
                                                                                                            <input id="ctrl-no_rekam_medis"  value="<?php  echo $data['no_rekam_medis']; ?>" type="hidden" placeholder="Enter No Rekam Medis"  required="" name="no_rekam_medis"  class="form-control " />
                                                                                                                <input id="ctrl-jenis_kelamin"  value="<?php  echo $data['jenis_kelamin']; ?>" type="hidden" placeholder="Enter Jenis Kelamin"  required="" name="jenis_kelamin"  class="form-control " />
                                                                                                                    <input id="ctrl-alamat"  value="<?php  echo $data['alamat']; ?>" type="hidden" placeholder="Enter Alamat"  required="" name="alamat"  class="form-control " />
                                                                                                                        <input id="ctrl-tanggal_lahir"  value="<?php  echo $data['tanggal_lahir']; ?>" type="hidden" placeholder="Enter Tanggal Lahir"  required="" name="tanggal_lahir"  class="form-control " />
                                                                                                                            <input id="ctrl-id_daftar"  value="<?php  echo $data['id_daftar']; ?>" type="hidden" placeholder="Enter Id Daftar"  required="" name="id_daftar"  class="form-control " />
                                                                                                                                <input id="ctrl-pasien"  value="<?php  echo $data['pasien']; ?>" type="hidden" placeholder="Enter Pasien"  required="" name="pasien"  class="form-control " />
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
