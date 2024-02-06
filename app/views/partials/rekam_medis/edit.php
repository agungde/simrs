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
                    <h4 class="record-title">Edit  Rekam Medis</h4>
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
                        <form novalidate  id="" role="form" enctype="multipart/form-data"  class="form page-form form-horizontal needs-validation" action="<?php print_link("rekam_medis/edit/$page_id/?csrf_token=$csrf_token"); ?>" method="post">
                            <div>
                                <input id="ctrl-no_rekam_medis"  value="<?php  echo $data['no_rekam_medis']; ?>" type="hidden" placeholder="Enter No Rekam Medis"  readonly required="" name="no_rekam_medis"  class="form-control " />
                                    <input id="ctrl-nama_pasien"  value="<?php  echo $data['nama_pasien']; ?>" type="hidden" placeholder="Enter Nama Pasien"  readonly required="" name="nama_pasien"  class="form-control " />
                                        <input id="ctrl-alamat"  value="<?php  echo $data['alamat']; ?>" type="hidden" placeholder="Enter Alamat"  readonly required="" name="alamat"  class="form-control " />
                                            <input id="ctrl-no_hp"  value="<?php  echo $data['no_hp']; ?>" type="hidden" placeholder="Enter No Hp"  readonly required="" name="no_hp"  class="form-control " />
                                                <input id="ctrl-email"  value="<?php  echo $data['email']; ?>" type="hidden" placeholder="Enter Email"  readonly required="" name="email"  class="form-control " />
                                                    <input id="ctrl-jenis_kelamin"  value="<?php  echo $data['jenis_kelamin']; ?>" type="hidden" placeholder="Enter Jenis Kelamin"  readonly required="" name="jenis_kelamin"  class="form-control " />
                                                        <input id="ctrl-tanggal_lahir"  value="<?php  echo $data['tanggal_lahir']; ?>" type="hidden" placeholder="Enter Tanggal Lahir"  readonly required="" name="tanggal_lahir"  class="form-control " />
                                                            <input id="ctrl-umur"  value="<?php  echo $data['umur']; ?>" type="hidden" placeholder="Enter Umur"  readonly required="" name="umur"  class="form-control " />
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
