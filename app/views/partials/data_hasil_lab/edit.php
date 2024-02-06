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
                    <h4 class="record-title">Edit  Data Hasil Lab</h4>
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
                        <form novalidate  id="" role="form" enctype="multipart/form-data"  class="form page-form form-horizontal needs-validation" action="<?php print_link("data_hasil_lab/edit/$page_id/?csrf_token=$csrf_token"); ?>" method="post">
                            <div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="nama_pemeriksaan">Nama Pemeriksaan <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <select required=""  id="ctrl-nama_pemeriksaan" data-load-select-options="nilai_rujukan" name="nama_pemeriksaan"  placeholder="Select a value ..."    class="custom-select" >
                                                    <option value="">Select a value ...</option>
                                                    <?php
                                                    $rec = $data['nama_pemeriksaan'];
                                                    $nama_pemeriksaan_options = $comp_model -> data_hasil_lab_nama_pemeriksaan_option_list();
                                                    if(!empty($nama_pemeriksaan_options)){
                                                    foreach($nama_pemeriksaan_options as $option){
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
                                            <label class="control-label" for="hasil_pemeriksaan">Hasil Pemeriksaan <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="ctrl-hasil_pemeriksaan"  value="<?php  echo $data['hasil_pemeriksaan']; ?>" type="text" placeholder="Enter Hasil Pemeriksaan"  required="" name="hasil_pemeriksaan"  class="form-control " />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="nilai_rujukan">Nilai Rujukan <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <select required=""  id="ctrl-nilai_rujukan" data-load-path="<?php print_link('api/json/data_hasil_lab_nilai_rujukan_option_list') ?>" name="nilai_rujukan"  placeholder="Select a value ..."    class="custom-select" >
                                                        <?php
                                                        $rec = $data['nilai_rujukan'];
                                                        $nilai_rujukan_options = $comp_model -> data_hasil_lab_nilai_rujukan_option_list($data['nama_pemeriksaan']);
                                                        if(!empty($nilai_rujukan_options)){
                                                        foreach($nilai_rujukan_options as $option){
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
                                    <input id="ctrl-id_daftar_lab"  value="<?php  echo $data['id_daftar_lab']; ?>" type="hidden" placeholder="Enter Id Daftar Lab"  required="" name="id_daftar_lab"  class="form-control " />
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="control-label" for="diagnosa">Diagnosa <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="">
                                                        <select required="" data-endpoint="<?php print_link('api/json/data_hasil_lab_diagnosa_option_list') ?>" id="ctrl-diagnosa" name="diagnosa"  placeholder="Select a value ..."    class="selectize-ajax" >
                                                            <option value="">Select a value ...</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="control-label" for="jenis_pemeriksaan">Jenis Pemeriksaan <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="">
                                                        <input id="ctrl-jenis_pemeriksaan"  value="<?php  echo $data['jenis_pemeriksaan']; ?>" type="text" placeholder="Enter Jenis Pemeriksaan"  required="" name="jenis_pemeriksaan"  class="form-control " />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label class="control-label" for="harga">Harga <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="">
                                                            <input id="ctrl-harga"  value="<?php  echo $data['harga']; ?>" type="number" placeholder="Enter Harga" step="1"  required="" name="harga"  class="form-control " />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label class="control-label" for="id_transaksi">Id Transaksi <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="">
                                                                <input id="ctrl-id_transaksi"  value="<?php  echo $data['id_transaksi']; ?>" type="number" placeholder="Enter Id Transaksi" step="1"  required="" name="id_transaksi"  class="form-control " />
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
