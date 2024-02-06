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
    <div  class=" p-1 mb-1">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Edit  Assesment Medis</h4>
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
                        <form novalidate  id="" role="form" enctype="multipart/form-data"  class="form page-form form-horizontal needs-validation" action="<?php print_link("assesment_medis/edit/$page_id/?csrf_token=$csrf_token"); ?>" method="post">
                            <div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="scor_gcs">Scor GCS </label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <?php
                                                $scor_gcs_options = Menu :: $scor_gcs;
                                                $field_value = $data['scor_gcs'];
                                                if(!empty($scor_gcs_options)){
                                                foreach($scor_gcs_options as $option){
                                                $value = $option['value'];
                                                $label = $option['label'];
                                                //check if value is among checked options
                                                $checked = $this->check_form_field_checked($field_value, $value);
                                                ?>
                                                <label class="custom-control custom-checkbox custom-control-inline option-btn">
                                                    <input id="ctrl-scor_gcs" class="custom-control-input" value="<?php echo $value ?>" <?php echo $checked ?> type="checkbox"  name="scor_gcs[]" />
                                                        <span class="custom-control-label"><?php echo $label ?></span>
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
                                                <label class="control-label" for="td">TD <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <input id="ctrl-td"  value="<?php  echo $data['td']; ?>" type="text" placeholder="Enter TD"  required="" name="td"  class="form-control " />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="control-label" for="dj">DJ </label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="">
                                                        <input id="ctrl-dj"  value="<?php  echo $data['dj']; ?>" type="text" placeholder="Enter DJ"  name="dj"  class="form-control " />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label class="control-label" for="djj">DJJ </label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="">
                                                            <input id="ctrl-djj"  value="<?php  echo $data['djj']; ?>" type="text" placeholder="Enter DJJ"  name="djj"  class="form-control " />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label class="control-label" for="sh">SH <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="">
                                                                <input id="ctrl-sh"  value="<?php  echo $data['sh']; ?>" type="text" placeholder="Enter SH"  required="" name="sh"  class="form-control " />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label class="control-label" for="spo">SPO </label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <div class="">
                                                                    <input id="ctrl-spo"  value="<?php  echo $data['spo']; ?>" type="text" placeholder="Enter SPO"  name="spo"  class="form-control " />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label class="control-label" for="nd">ND </label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <div class="">
                                                                        <input id="ctrl-nd"  value="<?php  echo $data['nd']; ?>" type="text" placeholder="Enter ND"  name="nd"  class="form-control " />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group ">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" for="kondisi_umum">Kondisi Umum <span class="text-danger">*</span></label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <div class="">
                                                                            <?php
                                                                            $kondisi_umum_options = Menu :: $kondisi_umum;
                                                                            $field_value = $data['kondisi_umum'];
                                                                            if(!empty($kondisi_umum_options)){
                                                                            foreach($kondisi_umum_options as $option){
                                                                            $value = $option['value'];
                                                                            $label = $option['label'];
                                                                            //check if value is among checked options
                                                                            $checked = $this->check_form_field_checked($field_value, $value);
                                                                            ?>
                                                                            <label class="custom-control custom-checkbox custom-control-inline option-btn">
                                                                                <input id="ctrl-kondisi_umum" class="custom-control-input" value="<?php echo $value ?>" <?php echo $checked ?> type="checkbox" required=""  name="kondisi_umum[]" />
                                                                                    <span class="custom-control-label"><?php echo $label ?></span>
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
                                                                            <label class="control-label" for="pemeriksaan_penunjang">Pemeriksaan Penunjang </label>
                                                                        </div>
                                                                        <div class="col-sm-8">
                                                                            <div class="">
                                                                                <input id="ctrl-pemeriksaan_penunjang"  value="<?php  echo $data['pemeriksaan_penunjang']; ?>" type="text" placeholder="Enter Pemeriksaan Penunjang"  name="pemeriksaan_penunjang"  class="form-control " />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group ">
                                                                        <div class="row">
                                                                            <div class="col-sm-4">
                                                                                <label class="control-label" for="diagnosa_kerja">Diagnosa Kerja </label>
                                                                            </div>
                                                                            <div class="col-sm-8">
                                                                                <div class="">
                                                                                    <select  id="ctrl-diagnosa_kerja" name="diagnosa_kerja"  placeholder="Select a value ..."    class="custom-select" >
                                                                                        <option value="">Select a value ...</option>
                                                                                        <?php
                                                                                        $rec = $data['diagnosa_kerja'];
                                                                                        $diagnosa_kerja_options = $comp_model -> assesment_medis_diagnosa_kerja_option_list();
                                                                                        if(!empty($diagnosa_kerja_options)){
                                                                                        foreach($diagnosa_kerja_options as $option){
                                                                                        $value = (!empty($option['value']) ? $option['value'] : null);
                                                                                        $label = (!empty($option['label']) ? $option['label'] : $value);
                                                                                        $selected = ( $value == $rec ? 'selected' : null );
                                                                                        ?>
                                                                                        <option 
                                                                                            <?php echo $selected; ?> value="<?php echo $value; ?>"><?php echo $label; ?>
                                                                                        </option>
                                                                                        <?php
                                                                                        }
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group ">
                                                                        <div class="row">
                                                                            <div class="col-sm-4">
                                                                                <label class="control-label" for="diagnosa_banding">Diagnosa Banding </label>
                                                                            </div>
                                                                            <div class="col-sm-8">
                                                                                <div class="">
                                                                                    <select  id="ctrl-diagnosa_banding" name="diagnosa_banding"  placeholder="Select a value ..."    class="custom-select" >
                                                                                        <option value="">Select a value ...</option>
                                                                                        <?php
                                                                                        $rec = $data['diagnosa_banding'];
                                                                                        $diagnosa_banding_options = $comp_model -> assesment_medis_diagnosa_banding_option_list();
                                                                                        if(!empty($diagnosa_banding_options)){
                                                                                        foreach($diagnosa_banding_options as $option){
                                                                                        $value = (!empty($option['value']) ? $option['value'] : null);
                                                                                        $label = (!empty($option['label']) ? $option['label'] : $value);
                                                                                        $selected = ( $value == $rec ? 'selected' : null );
                                                                                        ?>
                                                                                        <option 
                                                                                            <?php echo $selected; ?> value="<?php echo $value; ?>"><?php echo $label; ?>
                                                                                        </option>
                                                                                        <?php
                                                                                        }
                                                                                        }
                                                                                        ?>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group ">
                                                                        <div class="row">
                                                                            <div class="col-sm-4">
                                                                                <label class="control-label" for="tindakan_pengobatan">Tindakan Pengobatan </label>
                                                                            </div>
                                                                            <div class="col-sm-8">
                                                                                <div class="">
                                                                                    <input id="ctrl-tindakan_pengobatan"  value="<?php  echo $data['tindakan_pengobatan']; ?>" type="text" placeholder="Enter Tindakan Pengobatan"  name="tindakan_pengobatan"  class="form-control " />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group ">
                                                                            <div class="row">
                                                                                <div class="col-sm-4">
                                                                                    <label class="control-label" for="instruksi_selanjutnya">Instruksi Selanjutnya <span class="text-danger">*</span></label>
                                                                                </div>
                                                                                <div class="col-sm-8">
                                                                                    <div class="">
                                                                                        <?php
                                                                                        $instruksi_selanjutnya_options = Menu :: $instruksi_selanjutnya;
                                                                                        $field_value = $data['instruksi_selanjutnya'];
                                                                                        if(!empty($instruksi_selanjutnya_options)){
                                                                                        foreach($instruksi_selanjutnya_options as $option){
                                                                                        $value = $option['value'];
                                                                                        $label = $option['label'];
                                                                                        //check if value is among checked options
                                                                                        $checked = $this->check_form_field_checked($field_value, $value);
                                                                                        ?>
                                                                                        <label class="custom-control custom-checkbox custom-control-inline option-btn">
                                                                                            <input id="ctrl-instruksi_selanjutnya" class="custom-control-input" value="<?php echo $value ?>" <?php echo $checked ?> type="checkbox" required=""  name="instruksi_selanjutnya[]" />
                                                                                                <span class="custom-control-label"><?php echo $label ?></span>
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
                                                                                        <label class="control-label" for="diteruskan_dokter">Diteruskan Dokter </label>
                                                                                    </div>
                                                                                    <div class="col-sm-8">
                                                                                        <div class="">
                                                                                            <select  id="ctrl-diteruskan_dokter" name="diteruskan_dokter"  placeholder="Select a value ..."    class="custom-select" >
                                                                                                <option value="">Select a value ...</option>
                                                                                                <?php
                                                                                                $rec = $data['diteruskan_dokter'];
                                                                                                $diteruskan_dokter_options = $comp_model -> assesment_medis_diteruskan_dokter_option_list();
                                                                                                if(!empty($diteruskan_dokter_options)){
                                                                                                foreach($diteruskan_dokter_options as $option){
                                                                                                $value = (!empty($option['value']) ? $option['value'] : null);
                                                                                                $label = (!empty($option['label']) ? $option['label'] : $value);
                                                                                                $selected = ( $value == $rec ? 'selected' : null );
                                                                                                ?>
                                                                                                <option 
                                                                                                    <?php echo $selected; ?> value="<?php echo $value; ?>"><?php echo $label; ?>
                                                                                                </option>
                                                                                                <?php
                                                                                                }
                                                                                                }
                                                                                                ?>
                                                                                            </select>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group ">
                                                                                <div class="row">
                                                                                    <div class="col-sm-4">
                                                                                        <label class="control-label" for="tgl_keluar">Tgl Keluar </label>
                                                                                    </div>
                                                                                    <div class="col-sm-8">
                                                                                        <div class="input-group">
                                                                                            <input id="ctrl-tgl_keluar" class="form-control datepicker  datepicker" value="<?php  echo $data['tgl_keluar']; ?>" type="datetime"  name="tgl_keluar" placeholder="Enter Tgl Keluar" data-enable-time="true" data-min-date="" data-max-date="" data-date-format="Y-m-d H:i:S" data-alt-format="F j, Y - H:i" data-inline="false" data-no-calendar="false" data-mode="single" /> 
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
                                                                                            <label class="control-label" for="keadaan_keluar_igd">Keadaan Keluar Igd </label>
                                                                                        </div>
                                                                                        <div class="col-sm-8">
                                                                                            <div class="">
                                                                                                <input id="ctrl-keadaan_keluar_igd"  value="<?php  echo $data['keadaan_keluar_igd']; ?>" type="text" placeholder="Enter Keadaan Keluar Igd"  name="keadaan_keluar_igd"  class="form-control " />
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
