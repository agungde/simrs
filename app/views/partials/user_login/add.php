<?php
$comp_model = new SharedController;
$page_element_id = "add-page-" . random_str();
$current_page = $this->set_current_page_link();
$csrf_token = Csrf::$token;
$show_header = $this->show_header;
$view_title = $this->view_title;
$redirect_to = $this->redirect_to;
?>
<section class="page" id="<?php echo $page_element_id; ?>" data-page-type="add"  data-display-type="" data-page-url="<?php print_link($current_page); ?>">
    <?php
    if( $show_header == true ){
    ?>
    <div  class="bg-white p-1 mb-1">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <div class=""><div>
                        <?php
                        if(isset($_POST['datid'])){
                        $usrnam  = "".USER_NAME;
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        $idtrace = "$id_user$usrnam";
                        $datid=$_POST['datid'];
                        $nama=$_POST['nama'];
                        $username=$_POST['username'];
                        if (isset($_POST['user_role_id'])) {
                        $roles = $_POST['user_role_id'];
                        }else{
                        $roles = "";
                        }
                        if (isset($_POST['admin_poli'])) {
                        $admin_poli = $_POST['admin_poli'];
                        }else{
                        $admin_poli = "0";
                        }
                        if (isset($_POST['admin_ranap'])) {
                        $admin_ranap = $_POST['admin_ranap'];
                        }else{
                        $admin_ranap = "0";
                        }
                        if (isset($_POST['admin_ranap_anak'])) {
                        $admin_ranap_anak = $_POST['admin_ranap_anak'];
                        }else{
                        $admin_ranap_anak = "0";
                        }
                        if (isset($_POST['admin_ranap_perina'])) {
                        $admin_ranap_perina = $_POST['admin_ranap_perina'];
                        }else{
                        $admin_ranap_perina = "0";
                        }
                        if (isset($_POST['admin_ranap_bersalin'])) {
                        $admin_ranap_bersalin = $_POST['admin_ranap_bersalin'];
                        }else{
                        $admin_ranap_bersalin = "0";
                        }
                        if (isset($_POST['loket'])) {
                        $loket = $_POST['loket'];
                        }else{
                        $loket = "0";
                        }
                        if($roles==""){
                        // $db->rawQuery("UPDATE user_login SET operator='".USER_ID."', date_updated='".date("Y-m-d H:i:s")."' WHERE id_userlogin='$rec_id'");   
                        }else{
                        mysqli_query($koneksi,"UPDATE user_login SET loket='$loket', nama='$nama', username='$username', user_role_id='$roles', admin_poli='$admin_poli',admin_ranap='$admin_ranap', admin_ranap_anak='$admin_ranap_anak', admin_ranap_perina='$admin_ranap_perina', admin_ranap_bersalin='$admin_ranap_bersalin', operator='".USER_ID."', date_updated='".date("Y-m-d H:i:s")."' WHERE id_userlogin='$datid'");     
                        }
                        ?>
                        <script language="JavaScript">
                            alert('Data Login Berhasil Di Update');
                            document.location='<?php print_link("user_login"); ?>';
                        </script>
                        <?php   
                        } 
                        ?>
                    </div>
                </div><h4 class="record-title">Add New User Login</h4>
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
                    <form id="user_login-add-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("user_login/add?csrf_token=$csrf_token") ?>" method="post">
                        <div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="nama">Nama <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="">
                                            <input id="ctrl-nama"  value="<?php  echo $this->set_field_value('nama',""); ?>" type="text" placeholder="Enter Nama"  required="" name="nama"  data-url="api/json/user_login_nama_value_exist/" data-loading-msg="Checking availability ..." data-available-msg="Available" data-unavailable-msg="Not available" class="form-control  ctrl-check-duplicate" />
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
                                                <input id="ctrl-username"  value="<?php  echo $this->set_field_value('username',""); ?>" type="text" placeholder="Enter Username"  required="" name="username"  data-url="api/json/user_login_username_value_exist/" data-loading-msg="Checking availability ..." data-available-msg="Available" data-unavailable-msg="Not available" class="form-control  ctrl-check-duplicate" />
                                                    <div class="check-status"></div> 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="email">Email <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <input id="ctrl-email"  value="<?php  echo $this->set_field_value('email',""); ?>" type="email" placeholder="Enter Email"  required="" name="email"  data-url="api/json/user_login_email_value_exist/" data-loading-msg="Checking availability ..." data-available-msg="Available" data-unavailable-msg="Not available" class="form-control  ctrl-check-duplicate" />
                                                        <div class="check-status"></div> 
                                                    </div>
                                                    <small class="form-text">Email Harus Valid Dan Aktif</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="control-label" for="password">Password <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input id="ctrl-password"  value="<?php  echo $this->set_field_value('password',""); ?>" type="password" placeholder="Enter Password" maxlength="255"  required="" name="password"  class="form-control  password password-strength" />
                                                            <div class="input-group-append cursor-pointer btn-toggle-password">
                                                                <span class="input-group-text"><i class="fa fa-eye"></i></span>
                                                            </div>
                                                        </div>
                                                        <div class="password-strength-msg">
                                                            <small class="font-weight-bold">Should contain</small>
                                                            <small class="length chip">6 Characters minimum</small>
                                                            <small class="caps chip">Capital Letter</small>
                                                            <small class="number chip">Number</small>
                                                            <small class="special chip">Symbol</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label class="control-label" for="confirm_password">Confirm Password <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="input-group">
                                                            <input id="ctrl-password-confirm" data-match="#ctrl-password"  class="form-control password-confirm " type="password" name="confirm_password" required placeholder="Confirm Password" />
                                                            <div class="input-group-append cursor-pointer btn-toggle-password">
                                                                <span class="input-group-text"><i class="fa fa-eye"></i></span>
                                                            </div>
                                                            <div class="invalid-feedback">
                                                                Password does not match
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label class="control-label" for="photo">Photo </label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="">
                                                            <div class="dropzone " input="#ctrl-photo" fieldname="photo"    data-multiple="false" dropmsg="Choose files or drag and drop files to upload"    btntext="Browse" extensions=".jpg,.png,.gif,.jpeg" filesize="40" maximum="1">
                                                                <input name="photo" id="ctrl-photo" class="dropzone-input form-control" value="<?php  echo $this->set_field_value('photo',""); ?>" type="text"  />
                                                                    <!--<div class="invalid-feedback animated bounceIn text-center">Please a choose file</div>-->
                                                                    <div class="dz-file-limit animated bounceIn text-center text-danger"></div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group form-submit-btn-holder text-center mt-3">
                                                <div class="form-ajax-status"></div>
                                                <button class="btn btn-primary" type="submit">
                                                    Submit
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
