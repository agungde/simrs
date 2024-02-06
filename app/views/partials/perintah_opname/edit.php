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
                    <h4 class="record-title">Edit  Perintah Opname</h4>
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
                        <form novalidate  id="" role="form" enctype="multipart/form-data"  class="form page-form form-horizontal needs-validation" action="<?php print_link("perintah_opname/edit/$page_id/?csrf_token=$csrf_token"); ?>" method="post">
                            <div>
                                <input id="ctrl-tanggal"  value="<?php  echo $data['tanggal']; ?>" type="hidden" placeholder="Enter Tanggal"  required="" name="tanggal"  class="form-control " />
                                    <input id="ctrl-no_rekam_medis"  value="<?php  echo $data['no_rekam_medis']; ?>" type="hidden" placeholder="Enter No Rekam Medis"  required="" name="no_rekam_medis"  class="form-control " />
                                        <input id="ctrl-nama_pasien"  value="<?php  echo $data['nama_pasien']; ?>" type="hidden" placeholder="Enter Nama Pasien"  required="" name="nama_pasien"  class="form-control " />
                                            <input id="ctrl-jenis_kelamin"  value="<?php  echo $data['jenis_kelamin']; ?>" type="hidden" placeholder="Enter Jenis Kelamin"  required="" name="jenis_kelamin"  class="form-control " />
                                                <input id="ctrl-alamat"  value="<?php  echo $data['alamat']; ?>" type="hidden" placeholder="Enter Alamat"  required="" name="alamat"  class="form-control " />
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label class="control-label" for="diagnosa">Diagnosa <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <div class="">
                                                                    <select required="" data-endpoint="<?php print_link('api/json/perintah_opname_diagnosa_option_list') ?>" id="ctrl-diagnosa" name="diagnosa"  placeholder="Select a value ..."    class="selectize-ajax" >
                                                                        <option value="">Select a value ...</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label class="control-label" for="therapi">Therapi </label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <div class="">
                                                                    <input id="ctrl-therapi"  value="<?php  echo $data['therapi']; ?>" type="text" placeholder="Enter Therapi"  name="therapi"  class="form-control " />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <input id="ctrl-dokter_pemeriksa"  value="<?php  echo $data['dokter_pemeriksa']; ?>" type="hidden" placeholder="Enter Dokter Pemeriksa"  required="" name="dokter_pemeriksa"  class="form-control " />
                                                            <div class="form-group ">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" for="ttd">Ttd <span class="text-danger">*</span></label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <div class="">
                                                                            <input id="ctrl-ttd"  value="<?php  echo $data['ttd']; ?>" type="text" placeholder="Enter Ttd"  required="" name="ttd"  class="form-control " />
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
