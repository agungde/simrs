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
                    <h4 class="record-title">Edit  Data Key</h4>
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
                        <form novalidate  id="" role="form" enctype="multipart/form-data"  class="form page-form form-horizontal needs-validation" action="<?php print_link("data_key/edit/$page_id/?csrf_token=$csrf_token"); ?>" method="post">
                            <div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="jabatan">Jabatan <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="ctrl-jabatan"  value="<?php  echo $data['jabatan']; ?>" type="text" placeholder="Enter Jabatan"  required="" name="jabatan"  class="form-control " />
                                                </div>
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
                                                    <input id="ctrl-password"  value="<?php  echo $data['password']; ?>" type="password" placeholder="Enter Password" minlength="6"  required="" name="password"  class="form-control  password password-strength" />
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
                                                    <small class="form-text">Password Minimal 6</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="control-label" for="pin">Pin <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input id="ctrl-pin"  value="<?php  echo $data['pin']; ?>" type="password" placeholder="Enter Pin" minlength="6"  required="" name="pin"  class="form-control  password password-strength" />
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
                                                        <small class="form-text">Pin Minimal 6</small>
                                                    </div>
                                                </div>
                                            </div>
                                            <input id="ctrl-user_role_id"  value="<?php  echo $data['user_role_id']; ?>" type="hidden" placeholder="Enter User Role Id"  required="" name="user_role_id"  class="form-control " />
                                            </div>
                                            <div class="form-ajax-status"></div>
                                            <div class="form-group text-center">
                                                <button class="btn btn-primary" type="submit">
                                                    Update
                                                    <i class="fa fa-send"></i>
                                                </button>
                                            </div>
                                        </form>
                                        <script>
                                            $(document).ready(function(){ 
                                            document.getElementById("ctrl-password").value="";
                                            document.getElementById("ctrl-pin").value="";
                                            });
                                        </script>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
