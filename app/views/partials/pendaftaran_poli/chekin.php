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
                    <h4 class="record-title"><?php
                        if(!empty($_GET['action'])){
                        echo "Rujukan Chekin";
                        }else{
                        echo "Appointment Chekin";
                    }?></h4>
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
                    <div class=""><div>
                        <script>
                            $(document).ready(function() {
                            $('#ctrl-pembayaran').on('change', function(){ 
                            //do something like 
                            //$(this).hide(); 
                            //$(#anotherfieldid).show();
                            //var pem = document.getElementById("ctrl-pembayaran").value;
                            var pem =  $('#ctrl-pembayaran').val();
                            //  alert('Tes' +pem);
                            if(pem==1){
                            //$('#ctrl-setatus_bpjs')..disabled=false;  
                            document.getElementById("ctrl-setatus_bpjs").disabled=false;
                            document.getElementById("ctrl-setatus_bpjs").selectedIndex = 0;
                            BPJSopenTab();
                            }else{
                            document.getElementById("ctrl-setatus_bpjs").selectedIndex = 1;
                            }
                            });  
                            });
                        </script> 
                    </div>
                </div>
                <?php $this :: display_page_errors(); ?>
                <div  class="bg-light p-3 animated fadeIn page-content">
                    <form novalidate  id="" role="form" enctype="multipart/form-data"  class="form page-form form-horizontal needs-validation" action="<?php print_link("pendaftaran_poli/chekin/$page_id/?csrf_token=$csrf_token"); ?>" method="post">
                        <div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="pembayaran">Pembayaran <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="">
                                            <select required=""  id="ctrl-pembayaran" name="pembayaran"  placeholder="Select a value ..."    class="custom-select" >
                                                <option value="">Select a value ...</option>
                                                <?php
                                                $rec = $data['pembayaran'];
                                                $pembayaran_options = $comp_model -> pendaftaran_poli_pembayaran_option_list();
                                                if(!empty($pembayaran_options)){
                                                foreach($pembayaran_options as $option){
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
                                        <label class="control-label" for="setatus_bpjs">Setatus Bpjs <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="">
                                            <select required=""  id="ctrl-setatus_bpjs" name="setatus_bpjs"  placeholder="Select a value ..."    class="custom-select" >
                                                <option value="">Select a value ...</option>
                                                <?php
                                                $setatus_bpjs_options = Menu :: $setatus_bpjs;
                                                $field_value = $data['setatus_bpjs'];
                                                if(!empty($setatus_bpjs_options)){
                                                foreach($setatus_bpjs_options as $option){
                                                $value = $option['value'];
                                                $label = $option['label'];
                                                $selected = ( $value == $field_value ? 'selected' : null );
                                                ?>
                                                <option <?php echo $selected ?> value="<?php echo $value ?>">
                                                    <?php echo $label ?>
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
                                        <label class="control-label" for="nama_poli">Nama Poli <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="">
                                            <select required=""  id="ctrl-nama_poli" data-load-select-options="dokter" name="nama_poli"  placeholder="Select a value ..."    class="custom-select" >
                                                <option value="">Select a value ...</option>
                                                <?php
                                                $rec = $data['nama_poli'];
                                                $nama_poli_options = $comp_model -> pendaftaran_poli_nama_poli_option_list_2();
                                                if(!empty($nama_poli_options)){
                                                foreach($nama_poli_options as $option){
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
                                        <label class="control-label" for="dokter">Dokter <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="">
                                            <select required=""  id="ctrl-dokter" data-load-path="<?php print_link('api/json/pendaftaran_poli_dokter_option_list') ?>" name="dokter"  placeholder="Select a value ..."    class="custom-select" >
                                                <?php
                                                $rec = $data['dokter'];
                                                $dokter_options = $comp_model -> pendaftaran_poli_dokter_option_list($data['nama_poli']);
                                                if(!empty($dokter_options)){
                                                foreach($dokter_options as $option){
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
                                        <label class="control-label" for="nama_pasien">Nama Pasien <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="">
                                            <input id="ctrl-nama_pasien"  value="<?php  echo $data['nama_pasien']; ?>" type="text" placeholder="Enter Nama Pasien"  required="" name="nama_pasien"  class="form-control " />
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
                                                <input id="ctrl-no_rekam_medis"  value="<?php  echo $data['no_rekam_medis']; ?>" type="text" placeholder="Enter No Rekam Medis"  required="" name="no_rekam_medis"  class="form-control " />
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
                                                    <input id="ctrl-alamat"  value="<?php  echo $data['alamat']; ?>" type="text" placeholder="Enter Alamat"  required="" name="alamat"  class="form-control " />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="control-label" for="jenis_kelamin">Jenis Kelamin <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="">
                                                        <input id="ctrl-jenis_kelamin"  value="<?php  echo $data['jenis_kelamin']; ?>" type="text" placeholder="Enter Jenis Kelamin"  required="" name="jenis_kelamin"  class="form-control " />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label class="control-label" for="setatus">Setatus <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="">
                                                            <select required=""  id="ctrl-setatus" name="setatus"  placeholder="Select a value ..."    class="custom-select" >
                                                                <option value="">Select a value ...</option>
                                                                <?php
                                                                $setatus_options = Menu :: $setatus;
                                                                $field_value = $data['setatus'];
                                                                if(!empty($setatus_options)){
                                                                foreach($setatus_options as $option){
                                                                $value = $option['value'];
                                                                $label = $option['label'];
                                                                $selected = ( $value == $field_value ? 'selected' : null );
                                                                ?>
                                                                <option <?php echo $selected ?> value="<?php echo $value ?>">
                                                                    <?php echo $label ?>
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
