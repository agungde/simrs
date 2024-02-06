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
                    <h4 class="record-title">Edit  Assesment Triase</h4>
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
                        <form novalidate  id="" role="form" enctype="multipart/form-data"  class="form page-form form-horizontal needs-validation" action="<?php print_link("assesment_triase/edit/$page_id/?csrf_token=$csrf_token"); ?>" method="post">
                            <div>
                                <input id="ctrl-no_rekam_medis"  value="<?php  echo $data['no_rekam_medis']; ?>" type="hidden" placeholder="Enter No Rekam Medis"  required="" name="no_rekam_medis"  class="form-control " />
                                    <input id="ctrl-nama_pasien"  value="<?php  echo $data['nama_pasien']; ?>" type="hidden" placeholder="Enter Nama Pasien"  required="" name="nama_pasien"  class="form-control " />
                                        <input id="ctrl-alamat"  value="<?php  echo $data['alamat']; ?>" type="hidden" placeholder="Enter Alamat"  required="" name="alamat"  class="form-control " />
                                            <input id="ctrl-jenis_kelamin"  value="<?php  echo $data['jenis_kelamin']; ?>" type="hidden" placeholder="Enter Jenis Kelamin"  required="" name="jenis_kelamin"  class="form-control " />
                                                <input id="ctrl-tgl_lahir"  value="<?php  echo $data['tgl_lahir']; ?>" type="hidden" placeholder="Enter Tgl Lahir"  required="" name="tgl_lahir"  class="form-control " />
                                                    <input id="ctrl-umur"  value="<?php  echo $data['umur']; ?>" type="hidden" placeholder="Enter Umur"  required="" name="umur"  class="form-control " />
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label class="control-label" for="keadaan_ke_igd">Keadaan Ke Igd <span class="text-danger">*</span></label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <div class="">
                                                                        <input id="ctrl-keadaan_ke_igd"  value="<?php  echo $data['keadaan_ke_igd']; ?>" type="text" placeholder="Enter Keadaan Ke Igd"  required="" name="keadaan_ke_igd"  class="form-control " />
                                                                        </div>
                                                                        <small class="form-text">Sendiri/ Keluarga / Polisi / Lainnya</small>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group ">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" for="rujukan_dari">Rujukan Dari </label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <div class="">
                                                                            <input id="ctrl-rujukan_dari"  value="<?php  echo $data['rujukan_dari']; ?>" type="text" placeholder="Enter Rujukan Dari"  name="rujukan_dari"  class="form-control " />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group ">
                                                                    <div class="row">
                                                                        <div class="col-sm-4">
                                                                            <label class="control-label" for="tgl_rujukan">Tgl Rujukan </label>
                                                                        </div>
                                                                        <div class="col-sm-8">
                                                                            <div class="input-group">
                                                                                <input id="ctrl-tgl_rujukan" class="form-control datepicker  datepicker"  value="<?php  echo $data['tgl_rujukan']; ?>" type="datetime" name="tgl_rujukan" placeholder="Enter Tgl Rujukan" data-enable-time="false" data-min-date="" data-max-date="" data-date-format="Y-m-d" data-alt-format="F j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
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
                                                                                <label class="control-label" for="org_yg_bisa_di_hub">Org Yg Bisa Di Hub <span class="text-danger">*</span></label>
                                                                            </div>
                                                                            <div class="col-sm-8">
                                                                                <div class="">
                                                                                    <input id="ctrl-org_yg_bisa_di_hub"  value="<?php  echo $data['org_yg_bisa_di_hub']; ?>" type="text" placeholder="Enter Org Yg Bisa Di Hub"  required="" name="org_yg_bisa_di_hub"  class="form-control " />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group ">
                                                                            <div class="row">
                                                                                <div class="col-sm-4">
                                                                                    <label class="control-label" for="tgl_masuk">Tgl Masuk IGD <span class="text-danger">*</span></label>
                                                                                </div>
                                                                                <div class="col-sm-8">
                                                                                    <div class="input-group">
                                                                                        <input id="ctrl-tgl_masuk" class="form-control datepicker  datepicker"  required="" value="<?php  echo $data['tgl_masuk']; ?>" type="datetime" name="tgl_masuk" placeholder="Enter Tgl Masuk IGD" data-enable-time="false" data-min-date="" data-max-date="" data-date-format="Y-m-d" data-alt-format="F j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
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
                                                                                        <label class="control-label" for="jam">Jam <span class="text-danger">*</span></label>
                                                                                    </div>
                                                                                    <div class="col-sm-8">
                                                                                        <div class="input-group">
                                                                                            <input id="ctrl-jam" class="form-control datepicker  datepicker"  required="" value="<?php  echo $data['jam']; ?>" type="time" name="jam" placeholder="Enter Jam" data-enable-time="true" data-min-date="" data-max-date=""  data-alt-format="H:i" data-date-format="H:i:S" data-inline="false" data-no-calendar="true" data-mode="single" /> 
                                                                                                <div class="input-group-append">
                                                                                                    <span class="input-group-text"><i class="fa fa-clock"></i></span>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group ">
                                                                                    <div class="row">
                                                                                        <div class="col-sm-4">
                                                                                            <label class="control-label" for="dokter_pemeriksa">Dokter Pemeriksa <span class="text-danger">*</span></label>
                                                                                        </div>
                                                                                        <div class="col-sm-8">
                                                                                            <div class="">
                                                                                                <input id="ctrl-dokter_pemeriksa"  value="<?php  echo $data['dokter_pemeriksa']; ?>" type="text" placeholder="Enter Dokter Pemeriksa"  required="" name="dokter_pemeriksa"  class="form-control " />
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group ">
                                                                                        <div class="row">
                                                                                            <div class="col-sm-4">
                                                                                                <label class="control-label" for="ttd_dokter">Ttd Dokter <span class="text-danger">*</span></label>
                                                                                            </div>
                                                                                            <div class="col-sm-8">
                                                                                                <div class="">
                                                                                                    <input id="ctrl-ttd_dokter"  value="<?php  echo $data['ttd_dokter']; ?>" type="text" placeholder="Enter Ttd Dokter"  required="" name="ttd_dokter"  class="form-control " />
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group ">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-4">
                                                                                                    <label class="control-label" for="level">Level <span class="text-danger">*</span></label>
                                                                                                </div>
                                                                                                <div class="col-sm-8">
                                                                                                    <div class="">
                                                                                                        <?php
                                                                                                        $level_options = Menu :: $level;
                                                                                                        $field_value = $data['level'];
                                                                                                        if(!empty($level_options)){
                                                                                                        foreach($level_options as $option){
                                                                                                        $value = $option['value'];
                                                                                                        $label = $option['label'];
                                                                                                        //check if value is among checked options
                                                                                                        $checked = $this->check_form_field_checked($field_value, $value);
                                                                                                        ?>
                                                                                                        <label class="form-check form-check-inline option-btn">
                                                                                                            <input id="ctrl-level" class="form-check-input" value="<?php echo $value ?>" <?php echo $checked ?> type="checkbox" required=""  name="level[]" />
                                                                                                                <span class="form-check-label"><?php echo $label ?></span>
                                                                                                            </label>
                                                                                                            <?php
                                                                                                            }
                                                                                                            }
                                                                                                            ?>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group ">
                                                                                                <div class="row">
                                                                                                    <div class="col-sm-4">
                                                                                                        <label class="control-label" for="ttd_petugas">Ttd Petugas <span class="text-danger">*</span></label>
                                                                                                    </div>
                                                                                                    <div class="col-sm-8">
                                                                                                        <div class="">
                                                                                                            <input id="ctrl-ttd_petugas"  value="<?php  echo $data['ttd_petugas']; ?>" type="text" placeholder="Enter Ttd Petugas"  required="" name="ttd_petugas"  class="form-control " />
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <input id="ctrl-id_daftar"  value="<?php  echo $data['id_daftar']; ?>" type="hidden" placeholder="Enter Id Daftar"  required="" name="id_daftar"  class="form-control " />
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
