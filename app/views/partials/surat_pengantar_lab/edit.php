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
                    <h4 class="record-title">Edit  Surat Pengantar Lab</h4>
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
                        <form novalidate  id="" role="form" enctype="multipart/form-data"  class="form page-form form-horizontal needs-validation" action="<?php print_link("surat_pengantar_lab/edit/$page_id/?csrf_token=$csrf_token"); ?>" method="post">
                            <div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="tanggal">Tanggal <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="input-group">
                                                <input id="ctrl-tanggal" class="form-control datepicker  datepicker"  required="" value="<?php  echo $data['tanggal']; ?>" type="datetime" name="tanggal" placeholder="Enter Tanggal" data-enable-time="false" data-min-date="" data-max-date="" data-date-format="Y-m-d" data-alt-format="F j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
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
                                                <label class="control-label" for="dari_poli">Dari Poli <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <input id="ctrl-dari_poli"  value="<?php  echo $data['dari_poli']; ?>" type="text" placeholder="Enter Dari Poli"  readonly required="" name="dari_poli"  class="form-control " />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
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
                                                        <label class="control-label" for="nama_pasien">Nama Pasien <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="">
                                                            <input id="ctrl-nama_pasien"  value="<?php  echo $data['nama_pasien']; ?>" type="text" placeholder="Enter Nama Pasien"  readonly required="" name="nama_pasien"  class="form-control " />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label class="control-label" for="tgl_lahir">Tgl Lahir <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="input-group">
                                                                <input id="ctrl-tgl_lahir"  value="<?php  echo $data['tgl_lahir']; ?>" type="text" placeholder="Enter Tgl Lahir"  readonly required="" name="tgl_lahir"  class="form-control " />
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
                                                                <label class="control-label" for="alamat">Alamat <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <div class="">
                                                                    <input id="ctrl-alamat"  value="<?php  echo $data['alamat']; ?>" type="text" placeholder="Enter Alamat"  readonly required="" name="alamat"  class="form-control " />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label class="control-label" for="ruangan">Ruangan </label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <div class="">
                                                                        <input id="ctrl-ruangan"  value="<?php  echo $data['ruangan']; ?>" type="text" placeholder="Enter Ruangan"  name="ruangan"  class="form-control " />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group ">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" for="kelas">Kelas </label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <div class="">
                                                                            <input id="ctrl-kelas"  value="<?php  echo $data['kelas']; ?>" type="text" placeholder="Enter Kelas"  name="kelas"  class="form-control " />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group ">
                                                                    <div class="row">
                                                                        <div class="col-sm-4">
                                                                            <label class="control-label" for="hematologi">Hematologi </label>
                                                                        </div>
                                                                        <div class="col-sm-8">
                                                                            <div class="">
                                                                                <?php 
                                                                                $hematologi_options = $comp_model -> surat_pengantar_lab_hematologi_option_list();
                                                                                $arrRec = explode(',', $data['hematologi']);
                                                                                if(!empty($hematologi_options)){
                                                                                foreach($hematologi_options as $option){
                                                                                $value = (!empty($option['value']) ? $option['value'] : null);
                                                                                $label = (!empty($option['label']) ? $option['label'] : $value);
                                                                                $checked = (in_array($value , $arrRec) ? 'checked' : null);
                                                                                ?>
                                                                                <label class="custom-control custom-checkbox custom-control-inline option-btn">
                                                                                    <input id="ctrl-hematologi" class="custom-control-input" <?php echo $checked ?>  value="<?php echo $value; ?>" type="checkbox"  name="hematologi[]" />
                                                                                        <span class="custom-control-label"><?php echo $label; ?></span>
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
                                                                                <label class="control-label" for="imuniserologi">Imuniserologi </label>
                                                                            </div>
                                                                            <div class="col-sm-8">
                                                                                <div class="">
                                                                                    <?php 
                                                                                    $imuniserologi_options = $comp_model -> surat_pengantar_lab_imuniserologi_option_list();
                                                                                    $arrRec = explode(',', $data['imuniserologi']);
                                                                                    if(!empty($imuniserologi_options)){
                                                                                    foreach($imuniserologi_options as $option){
                                                                                    $value = (!empty($option['value']) ? $option['value'] : null);
                                                                                    $label = (!empty($option['label']) ? $option['label'] : $value);
                                                                                    $checked = (in_array($value , $arrRec) ? 'checked' : null);
                                                                                    ?>
                                                                                    <label class="custom-control custom-checkbox custom-control-inline option-btn">
                                                                                        <input id="ctrl-imuniserologi" class="custom-control-input" <?php echo $checked ?>  value="<?php echo $value; ?>" type="checkbox"  name="imuniserologi[]" />
                                                                                            <span class="custom-control-label"><?php echo $label; ?></span>
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
                                                                                    <label class="control-label" for="kimia_klinik">Kimia Klinik </label>
                                                                                </div>
                                                                                <div class="col-sm-8">
                                                                                    <div class="">
                                                                                        <?php 
                                                                                        $kimia_klinik_options = $comp_model -> surat_pengantar_lab_kimia_klinik_option_list();
                                                                                        $arrRec = explode(',', $data['kimia_klinik']);
                                                                                        if(!empty($kimia_klinik_options)){
                                                                                        foreach($kimia_klinik_options as $option){
                                                                                        $value = (!empty($option['value']) ? $option['value'] : null);
                                                                                        $label = (!empty($option['label']) ? $option['label'] : $value);
                                                                                        $checked = (in_array($value , $arrRec) ? 'checked' : null);
                                                                                        ?>
                                                                                        <label class="custom-control custom-checkbox custom-control-inline option-btn">
                                                                                            <input id="ctrl-kimia_klinik" class="custom-control-input" <?php echo $checked ?>  value="<?php echo $value; ?>" type="checkbox"  name="kimia_klinik[]" />
                                                                                                <span class="custom-control-label"><?php echo $label; ?></span>
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
                                                                                        <label class="control-label" for="urin_faces">Urin Faces </label>
                                                                                    </div>
                                                                                    <div class="col-sm-8">
                                                                                        <div class="">
                                                                                            <?php 
                                                                                            $urin_faces_options = $comp_model -> surat_pengantar_lab_urin_faces_option_list();
                                                                                            $arrRec = explode(',', $data['urin_faces']);
                                                                                            if(!empty($urin_faces_options)){
                                                                                            foreach($urin_faces_options as $option){
                                                                                            $value = (!empty($option['value']) ? $option['value'] : null);
                                                                                            $label = (!empty($option['label']) ? $option['label'] : $value);
                                                                                            $checked = (in_array($value , $arrRec) ? 'checked' : null);
                                                                                            ?>
                                                                                            <label class="custom-control custom-checkbox custom-control-inline option-btn">
                                                                                                <input id="ctrl-urin_faces" class="custom-control-input" <?php echo $checked ?>  value="<?php echo $value; ?>" type="checkbox"  name="urin_faces[]" />
                                                                                                    <span class="custom-control-label"><?php echo $label; ?></span>
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
                                                                                            <label class="control-label" for="microbiologi">Microbiologi </label>
                                                                                        </div>
                                                                                        <div class="col-sm-8">
                                                                                            <div class="">
                                                                                                <?php 
                                                                                                $microbiologi_options = $comp_model -> surat_pengantar_lab_microbiologi_option_list();
                                                                                                $arrRec = explode(',', $data['microbiologi']);
                                                                                                if(!empty($microbiologi_options)){
                                                                                                foreach($microbiologi_options as $option){
                                                                                                $value = (!empty($option['value']) ? $option['value'] : null);
                                                                                                $label = (!empty($option['label']) ? $option['label'] : $value);
                                                                                                $checked = (in_array($value , $arrRec) ? 'checked' : null);
                                                                                                ?>
                                                                                                <label class="custom-control custom-checkbox custom-control-inline option-btn">
                                                                                                    <input id="ctrl-microbiologi" class="custom-control-input" <?php echo $checked ?>  value="<?php echo $value; ?>" type="checkbox"  name="microbiologi[]" />
                                                                                                        <span class="custom-control-label"><?php echo $label; ?></span>
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
                                                                                                <label class="control-label" for="lain_lain">Lain Lain </label>
                                                                                            </div>
                                                                                            <div class="col-sm-8">
                                                                                                <div class="">
                                                                                                    <input id="ctrl-lain_lain"  value="<?php  echo $data['lain_lain']; ?>" type="text" placeholder="Enter Lain Lain"  name="lain_lain"  class="form-control " />
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
