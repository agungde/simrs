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
                    <h4 class="record-title">Edit  User Login
                        <script>
                            $('#ctrl-user_role_id').on('change', function(){ 
                            var role = document.getElementById("ctrl-user_role_id").value;
                            var ctrlVal = $(this).val();
                            if(role==3){
                            alert('Tidak Boleh Pilih Dokter');
                            $(this).val('');
                            }
                            if(role==6){
                            document.getElementById("ctrl-admin_poli").focus();
                            //document.user_login-add-form..value =role;
                            document.getElementById("ctrl-admin_poli").disabled=false;
                            document.getElementById("ctrl-admin_poli").riquired=true;
                            alert('Harus Pilih Nama Poli');
                            }else{
                            document.getElementById("ctrl-admin_poli").disabled=true;
                            document.getElementById("ctrl-admin_poli").riquired=false;
                            }
                            if(role==13){
                            document.getElementById("ctrl-admin_ranap").focus();
                            //document.user_login-add-form..value =role;
                            document.getElementById("ctrl-admin_ranap").disabled=false;
                            document.getElementById("ctrl-admin_ranap").riquired=true;
                            alert('Harus Pilih Nama Kamar');
                            }else{
                            document.getElementById("ctrl-admin_ranap").disabled=true;
                            document.getElementById("ctrl-admin_ranap").riquired=false;
                            }   
                            if(role==21){
                            document.getElementById("ctrl-admin_ranap_perina").focus();
                            //document.user_login-add-form..value =role;
                            document.getElementById("ctrl-admin_ranap_perina").disabled=false;
                            document.getElementById("ctrl-admin_ranap_perina").riquired=true;
                            alert('Harus Pilih Nama Kamar');
                            }else{
                            document.getElementById("ctrl-admin_ranap_perina").disabled=true;
                            document.getElementById("ctrl-admin_ranap_perina").riquired=false;
                            }
                            if(role==22){
                            document.getElementById("ctrl-admin_ranap_anak").focus();
                            //document.user_login-add-form..value =role;
                            document.getElementById("ctrl-admin_ranap_anak").disabled=false;
                            document.getElementById("ctrl-admin_ranap_anak").riquired=true;
                            alert('Harus Pilih Nama Kamar');
                            }else{
                            document.getElementById("ctrl-admin_ranap_anak").disabled=true;
                            document.getElementById("ctrl-admin_ranap_anak").riquired=false;
                            }
                            if(role==23){
                            document.getElementById("ctrl-admin_ranap_bersalin").focus();
                            //document.user_login-add-form..value =role;
                            document.getElementById("ctrl-admin_ranap_bersalin").disabled=false;
                            document.getElementById("ctrl-admin_ranap_bersalin").riquired=true;
                            alert('Harus Pilih Nama Kamar');
                            }else{
                            document.getElementById("ctrl-admin_ranap_bersalin").disabled=true;
                            document.getElementById("ctrl-admin_ranap_bersalin").riquired=false;
                            }
                            if(role==19 || role==12){
                            document.getElementById("ctrl-loket").focus();
                            //document.user_login-add-form..value =role;
                            document.getElementById("ctrl-loket").disabled=false;
                            document.getElementById("ctrl-loket").riquired=true;
                            alert('Harus Pilih Loket');
                            }else{
                            document.getElementById("ctrl-loket").disabled=true;
                            document.getElementById("ctrl-loket").riquired=false;
                            }
                            //do something like 
                            //$(this).hide(); 
                            //$(#anotherfieldid).show();
                            //var ctrlVal = $(this).val();
                            //$(#anotherfieldname).val(ctrlVal)
                            });
                        </script></h4>
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
                            <form novalidate  id="" role="form" enctype="multipart/form-data"  class="form page-form form-horizontal needs-validation" action="<?php print_link("user_login/add?csrf_token=$csrf_token"); ?>" method="post"><input type="hidden" name="datid" value="<?php echo $page_id;?>">
                                <div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="nama">Nama <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <input id="ctrl-nama"  value="<?php  echo $data['nama']; ?>" type="text" placeholder="Enter Nama"  required="" name="nama"  data-url="api/json/user_login_nama_value_exist/" data-loading-msg="Checking availability ..." data-available-msg="Available" data-unavailable-msg="Not available" class="form-control  ctrl-check-duplicate" />
                                                        <div class="check-status"></div> 
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="control-label" for="username">Username <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="">
                                                        <input id="ctrl-username"  value="<?php  echo $data['username']; ?>" type="text" placeholder="Enter Username"  required="" name="username"  data-url="api/json/user_login_username_value_exist/" data-loading-msg="Checking availability ..." data-available-msg="Available" data-unavailable-msg="Not available" class="form-control  ctrl-check-duplicate" />
                                                            <div class="check-status"></div> 
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php /////////////////////////////////// 
                                            if(USER_ROLE==1){
                                            ?>
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label class="control-label" for="user_role_id">User Role Id <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="">
                                                            <select required=""  id="ctrl-user_role_id" name="user_role_id"  placeholder="Select a value ..."    class="custom-select" >
                                                                <option value="">Select a value ...</option>
                                                                <?php 
                                                                $user_role_id_options = $comp_model -> user_login_user_role_id_option_list();
                                                                if(!empty($user_role_id_options)){
                                                                foreach($user_role_id_options as $option){
                                                                $value = (!empty($option['value']) ? $option['value'] : null);
                                                                $label = (!empty($option['label']) ? $option['label'] : $value);
                                                                $selected = $this->set_field_selected('user_role_id',$value, "");
                                                                ?>
                                                                <option <?php echo $selected; ?> value="<?php echo $value; ?>">
                                                                    <?php echo $label; ?>
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
                                                        <label class="control-label" for="admin_poli">Admin Poli </label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="">
                                                            <select  id="ctrl-admin_poli" name="admin_poli"  placeholder="Select a value ..."    class="custom-select" >
                                                                <option value="">Select a value ...</option>
                                                                <?php 
                                                                $admin_poli_options = $comp_model -> user_login_admin_poli_option_list();
                                                                if(!empty($admin_poli_options)){
                                                                foreach($admin_poli_options as $option){
                                                                $value = (!empty($option['value']) ? $option['value'] : null);
                                                                $label = (!empty($option['label']) ? $option['label'] : $value);
                                                                $selected = $this->set_field_selected('admin_poli',$value, "");
                                                                ?>
                                                                <option <?php echo $selected; ?> value="<?php echo $value; ?>">
                                                                    <?php echo $label; ?>
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
                                                        <label class="control-label" for="admin_ranap">Admin Ranap </label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="">
                                                            <select  id="ctrl-admin_ranap" name="admin_ranap"  placeholder="Select a value ..."    class="custom-select" >
                                                                <option value="">Select a value ...</option>
                                                                <?php 
                                                                $admin_ranap_options = $comp_model -> user_login_admin_ranap_option_list();
                                                                if(!empty($admin_ranap_options)){
                                                                foreach($admin_ranap_options as $option){
                                                                $value = (!empty($option['value']) ? $option['value'] : null);
                                                                $label = (!empty($option['label']) ? $option['label'] : $value);
                                                                $selected = $this->set_field_selected('admin_ranap',$value, "");
                                                                ?>
                                                                <option <?php echo $selected; ?> value="<?php echo $value; ?>">
                                                                    <?php echo $label; ?>
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
                                                        <label class="control-label" for="admin_ranap_perina">Admin Ranap Perina </label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="">
                                                            <select  id="ctrl-admin_ranap_perina" name="admin_ranap_perina"  placeholder="Select a value ..."    class="custom-select" >
                                                                <option value="">Select a value ...</option>
                                                                <?php 
                                                                $admin_ranap_perina_options = $comp_model -> user_login_admin_ranap_perina_option_list();
                                                                if(!empty($admin_ranap_perina_options)){
                                                                foreach($admin_ranap_perina_options as $option){
                                                                $value = (!empty($option['value']) ? $option['value'] : null);
                                                                $label = (!empty($option['label']) ? $option['label'] : $value);
                                                                $selected = $this->set_field_selected('admin_ranap_perina',$value, "");
                                                                ?>
                                                                <option <?php echo $selected; ?> value="<?php echo $value; ?>">
                                                                    <?php echo $label; ?>
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
                                                        <label class="control-label" for="admin_ranap_anak">Admin Ranap Anak </label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="">
                                                            <select  id="ctrl-admin_ranap_anak" name="admin_ranap_anak"  placeholder="Select a value ..."    class="custom-select" >
                                                                <option value="">Select a value ...</option>
                                                                <?php 
                                                                $admin_ranap_anak_options = $comp_model -> user_login_admin_ranap_anak_option_list();
                                                                if(!empty($admin_ranap_anak_options)){
                                                                foreach($admin_ranap_anak_options as $option){
                                                                $value = (!empty($option['value']) ? $option['value'] : null);
                                                                $label = (!empty($option['label']) ? $option['label'] : $value);
                                                                $selected = $this->set_field_selected('admin_ranap_anak',$value, "");
                                                                ?>
                                                                <option <?php echo $selected; ?> value="<?php echo $value; ?>">
                                                                    <?php echo $label; ?>
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
                                                        <label class="control-label" for="admin_ranap_bersalin">Admin Ranap Bersalin </label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="">
                                                            <select  id="ctrl-admin_ranap_bersalin" name="admin_ranap_bersalin"  placeholder="Select a value ..."    class="custom-select" >
                                                                <option value="">Select a value ...</option>
                                                                <?php 
                                                                $admin_ranap_bersalin_options = $comp_model -> user_login_admin_ranap_bersalin_option_list();
                                                                if(!empty($admin_ranap_bersalin_options)){
                                                                foreach($admin_ranap_bersalin_options as $option){
                                                                $value = (!empty($option['value']) ? $option['value'] : null);
                                                                $label = (!empty($option['label']) ? $option['label'] : $value);
                                                                $selected = $this->set_field_selected('admin_ranap_bersalin',$value, "");
                                                                ?>
                                                                <option <?php echo $selected; ?> value="<?php echo $value; ?>">
                                                                    <?php echo $label; ?>
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
                                                        <label class="control-label" for="loket">Loket </label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="">
                                                            <select  id="ctrl-loket" name="loket"  placeholder="Select a value ..."    class="custom-select" >
                                                                <option value="">Select a value ...</option>
                                                                <?php 
                                                                $loket_options = $comp_model -> user_login_loket_option_list();
                                                                if(!empty($loket_options)){
                                                                foreach($loket_options as $option){
                                                                $value = (!empty($option['value']) ? $option['value'] : null);
                                                                $label = (!empty($option['label']) ? $option['label'] : $value);
                                                                $selected = $this->set_field_selected('loket',$value, "");
                                                                ?>
                                                                <option <?php echo $selected; ?> value="<?php echo $value; ?>">
                                                                    <?php echo $label; ?>
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
                                            <?php
                                            }
                                            /////////////////////////////////////////////////
                                            ?>
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label class="control-label" for="photo">Photo </label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="">
                                                            <div class="dropzone " input="#ctrl-photo" fieldname="photo"    data-multiple="false" dropmsg="Choose files or drag and drop files to upload"    btntext="Browse" extensions=".jpg,.png,.gif,.jpeg" filesize="4" maximum="1">
                                                                <input name="photo" id="ctrl-photo" class="dropzone-input form-control" value="<?php  echo $data['photo']; ?>" type="text"  />
                                                                    <!--<div class="invalid-feedback animated bounceIn text-center">Please a choose file</div>-->
                                                                    <div class="dz-file-limit animated bounceIn text-center text-danger"></div>
                                                                </div>
                                                            </div>
                                                            <?php Html :: uploaded_files_list($data['photo'], '#ctrl-photo', 'true'); ?>
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
