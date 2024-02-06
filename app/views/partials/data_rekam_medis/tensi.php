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
    <div  class="">
        <div class="container">
            <div class="row ">
                <div class="col-md-7 comp-grid">
                    <div class=" ">
                        <?php  
                        $this->render_page("data_rekam_medis/tensiview/$page_id"); 
                        ?>
                    </div>
                    <?php $this :: display_page_errors(); ?>
                    <div  class="bg-light p-3 animated fadeIn page-content">
                        <form novalidate  id="" role="form" enctype="multipart/form-data"  class="form page-form form-horizontal needs-validation" action="<?php print_link("data_rekam_medis/tensi/$page_id/?csrf_token=$csrf_token"); ?>" method="post">
                            <div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="tensi">Tensi <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="ctrl-tensi"  value="<?php  echo $data['tensi']; ?>" type="text" placeholder="Enter Tensi"  required="" name="tensi"  class="form-control " />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="suhu_badan">Suhu Badan <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <input id="ctrl-suhu_badan"  value="<?php  echo $data['suhu_badan']; ?>" type="text" placeholder="Enter Suhu Badan"  required="" name="suhu_badan"  class="form-control " />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="control-label" for="tinggi">Tinggi </label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="">
                                                        <input id="ctrl-tinggi"  value="<?php  echo $data['tinggi']; ?>" type="text" placeholder="Enter Tinggi"  name="tinggi"  class="form-control " />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label class="control-label" for="berat_badan">Berat Badan </label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="">
                                                            <input id="ctrl-berat_badan"  value="<?php  echo $data['berat_badan']; ?>" type="text" placeholder="Enter Berat Badan"  name="berat_badan"  class="form-control " />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>                        
                                                <input id="ctrl-date_updated"  value="<?php  echo $data['date_updated']; ?>" type="hidden" placeholder="Enter Date Updated"  name="date_updated"  class="form-control " />
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
