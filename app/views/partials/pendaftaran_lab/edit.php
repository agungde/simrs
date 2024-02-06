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
                    <h4 class="record-title">Edit  Pendaftaran Lab</h4>
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
                        <form novalidate  id="" role="form" enctype="multipart/form-data"  class="form page-form form-horizontal needs-validation" action="<?php print_link("pendaftaran_lab/edit/$page_id/?csrf_token=$csrf_token"); ?>" method="post">
                            <div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="jenis_pemeriksaan">Jenis Pemeriksaan <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <select required=""  id="ctrl-jenis_pemeriksaan" data-load-check-options="nama_pemeriksaan" name="jenis_pemeriksaan"  placeholder="Select a value ..."    class="custom-select" >
                                                    <option value="">Select a value ...</option>
                                                    <?php
                                                    $rec = $data['jenis_pemeriksaan'];
                                                    $jenis_pemeriksaan_options = $comp_model -> pendaftaran_lab_jenis_pemeriksaan_option_list();
                                                    if(!empty($jenis_pemeriksaan_options)){
                                                    foreach($jenis_pemeriksaan_options as $option){
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
                                            <label class="control-label" for="nama_pemeriksaan">Nama Pemeriksaan </label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <template id="nama_pemeriksaan-option-template">
                                                    <label class="custom-control custom-checkbox custom-control-inline">
                                                        <input class="custom-control-input" id="ctrl-nama_pemeriksaan" value="true" type="checkbox"  name="nama_pemeriksaan[]"  />
                                                        <span class="custom-control-label input-label-text"></span>
                                                    </label>
                                                </template>
                                                <div id="nama_pemeriksaan-options-holder" data-load-path="<?php print_link('api/json/pendaftaran_lab_nama_pemeriksaan_option_list') ?>">
                                                    <?php 
                                                    $nama_pemeriksaan_options = $comp_model -> pendaftaran_lab_nama_pemeriksaan_option_list($data['jenis_pemeriksaan']);
                                                    $arrRec = explode(',', $data['nama_pemeriksaan']);
                                                    if(!empty($nama_pemeriksaan_options)){
                                                    foreach($nama_pemeriksaan_options as $option){
                                                    $value = (!empty($option['value']) ? $option['value'] : null);
                                                    $label = (!empty($option['label']) ? $option['label'] : $value);
                                                    $checked = (in_array($value , $arrRec) ? 'checked' : null);
                                                    ?>
                                                    <label class="custom-control custom-checkbox custom-control-inline option-btn">
                                                        <input id="ctrl-nama_pemeriksaan" class="custom-control-input" <?php echo $checked ?>  value="<?php echo $value; ?>" type="checkbox"  name="nama_pemeriksaan[]" />
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
