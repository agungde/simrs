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
                    <h4 class="record-title">Add New Data Hasil Lab</h4>
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
                <div class="col-md-12 comp-grid">
                    <?php $this :: display_page_errors(); ?>
                    <div  class="bg-light p-3 animated fadeIn page-content">
                        <form id="data_hasil_lab-add-form"  novalidate role="form" enctype="multipart/form-data" class="form multi-form page-form" action="<?php print_link("data_hasil_lab/add?csrf_token=$csrf_token") ?>" method="post" >
                            <div>
                                <table class="table table-striped table-sm" data-maxrow="10" data-minrow="1">
                                    <thead>
                                        <tr>
                                            <th class="bg-light"><label for="nama_pemeriksaan">Nama Pemeriksaan</label></th>
                                            <th class="bg-light"><label for="hasil_pemeriksaan">Hasil Pemeriksaan</label></th>
                                            <th class="bg-light"><label for="nilai_rujukan">Nilai Rujukan</label></th>
                                            <th class="bg-light"><label for="diagnosa">Diagnosa</label></th>
                                            <th class="bg-light"><label for="jenis_pemeriksaan">Jenis Pemeriksaan</label></th>
                                            <th class="bg-light"><label for="harga">Harga</label></th>
                                            <th class="bg-light"><label for="id_transaksi">Id Transaksi</label></th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php 
                                        for( $row = 1; $row <= 1; $row++ ){
                                        ?>
                                        <tr class="input-row">
                                            <td>
                                                <div id="ctrl-nama_pemeriksaan-row<?php echo $row; ?>-holder" class="">
                                                    <select required=""  id="ctrl-nama_pemeriksaan-row<?php echo $row; ?>" data-load-select-options="nilai_rujukan" name="row<?php echo $row ?>[nama_pemeriksaan]"  placeholder="Select a value ..."    class="custom-select" >
                                                        <option value="">Select a value ...</option>
                                                        <?php 
                                                        $nama_pemeriksaan_options = $comp_model -> data_hasil_lab_nama_pemeriksaan_option_list();
                                                        if(!empty($nama_pemeriksaan_options)){
                                                        foreach($nama_pemeriksaan_options as $option){
                                                        $value = (!empty($option['value']) ? $option['value'] : null);
                                                        $label = (!empty($option['label']) ? $option['label'] : $value);
                                                        $selected = $this->set_field_selected('nama_pemeriksaan',$value, "");
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
                                            </td>
                                            <td>
                                                <div id="ctrl-hasil_pemeriksaan-row<?php echo $row; ?>-holder" class="">
                                                    <input id="ctrl-hasil_pemeriksaan-row<?php echo $row; ?>"  value="<?php  echo $this->set_field_value('hasil_pemeriksaan',"", $row); ?>" type="text" placeholder="Enter Hasil Pemeriksaan"  required="" name="row<?php echo $row ?>[hasil_pemeriksaan]"  class="form-control " />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div id="ctrl-nilai_rujukan-row<?php echo $row; ?>-holder" class="">
                                                        <select required=""  id="ctrl-nilai_rujukan-row<?php echo $row; ?>" data-load-path="<?php print_link('api/json/data_hasil_lab_nilai_rujukan_option_list') ?>" name="row<?php echo $row ?>[nilai_rujukan]"  placeholder="Select a value ..."    class="custom-select" >
                                                            <option value="">Select a value ...</option>
                                                        </select>
                                                    </div>
                                                </td>
                                                <input id="ctrl-id_daftar_lab-row<?php echo $row; ?>"  value="<?php echo $original_plaintext;?>" type="hidden" placeholder="Enter Id Daftar Lab"  required="" name="row<?php echo $row ?>[id_daftar_lab]"  class="form-control " />
                                                    <td>
                                                        <div id="ctrl-diagnosa-row<?php echo $row; ?>-holder" class="">
                                                            <select required="" data-endpoint="<?php print_link('api/json/data_hasil_lab_diagnosa_option_list') ?>" id="ctrl-diagnosa-row<?php echo $row; ?>" name="row<?php echo $row ?>[diagnosa]"  placeholder="Select a value ..."    class="selectize-ajax" >
                                                                <option value="">Select a value ...</option>
                                                            </select>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div id="ctrl-jenis_pemeriksaan-row<?php echo $row; ?>-holder" class="">
                                                            <input id="ctrl-jenis_pemeriksaan-row<?php echo $row; ?>"  value="<?php  echo $this->set_field_value('jenis_pemeriksaan',"", $row); ?>" type="text" placeholder="Enter Jenis Pemeriksaan"  required="" name="row<?php echo $row ?>[jenis_pemeriksaan]"  class="form-control " />
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div id="ctrl-harga-row<?php echo $row; ?>-holder" class="">
                                                                <input id="ctrl-harga-row<?php echo $row; ?>"  value="<?php  echo $this->set_field_value('harga',"", $row); ?>" type="number" placeholder="Enter Harga" step="1"  required="" name="row<?php echo $row ?>[harga]"  class="form-control " />
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div id="ctrl-id_transaksi-row<?php echo $row; ?>-holder" class="">
                                                                    <input id="ctrl-id_transaksi-row<?php echo $row; ?>"  value="<?php  echo $this->set_field_value('id_transaksi',"", $row); ?>" type="number" placeholder="Enter Id Transaksi" step="1"  required="" name="row<?php echo $row ?>[id_transaksi]"  class="form-control " />
                                                                    </div>
                                                                </td>
                                                                <th class="text-center">
                                                                    <button type="button" class="close btn-remove-table-row">&times;</button>
                                                                </th>
                                                            </tr>
                                                            <?php 
                                                            }
                                                            ?>
                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th colspan="100" class="text-right">
                                                                    <?php $template_id = "table-row-" . random_str(); ?>
                                                                    <button type="button" data-template="#<?php echo $template_id ?>" class="btn btn-sm btn-light btn-add-table-row"><i class="fa fa-plus"></i></button>
                                                                </th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>
                                                </div>
                                                <div class="form-group form-submit-btn-holder text-center mt-3">
                                                    <div class="form-ajax-status"></div>
                                                    <button class="btn btn-primary" type="submit">
                                                        Submit
                                                        <i class="fa fa-send"></i>
                                                    </button>
                                                </div>
                                            </form>
                                            <!--[table row template]-->
                                            <template id="<?php echo $template_id ?>">
                                                <tr class="input-row">
                                                    <?php $row = 1; ?>
                                                    <td>
                                                        <div id="ctrl-nama_pemeriksaan-row<?php echo $row; ?>-holder" class="">
                                                            <select required=""  id="ctrl-nama_pemeriksaan-row<?php echo $row; ?>" data-load-select-options="nilai_rujukan" name="row<?php echo $row ?>[nama_pemeriksaan]"  placeholder="Select a value ..."    class="custom-select" >
                                                                <option value="">Select a value ...</option>
                                                                <?php 
                                                                $nama_pemeriksaan_options = $comp_model -> data_hasil_lab_nama_pemeriksaan_option_list();
                                                                if(!empty($nama_pemeriksaan_options)){
                                                                foreach($nama_pemeriksaan_options as $option){
                                                                $value = (!empty($option['value']) ? $option['value'] : null);
                                                                $label = (!empty($option['label']) ? $option['label'] : $value);
                                                                $selected = $this->set_field_selected('nama_pemeriksaan',$value, "");
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
                                                    </td>
                                                    <td>
                                                        <div id="ctrl-hasil_pemeriksaan-row<?php echo $row; ?>-holder" class="">
                                                            <input id="ctrl-hasil_pemeriksaan-row<?php echo $row; ?>"  value="<?php  echo $this->set_field_value('hasil_pemeriksaan',"", $row); ?>" type="text" placeholder="Enter Hasil Pemeriksaan"  required="" name="row<?php echo $row ?>[hasil_pemeriksaan]"  class="form-control " />
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div id="ctrl-nilai_rujukan-row<?php echo $row; ?>-holder" class="">
                                                                <select required=""  id="ctrl-nilai_rujukan-row<?php echo $row; ?>" data-load-path="<?php print_link('api/json/data_hasil_lab_nilai_rujukan_option_list') ?>" name="row<?php echo $row ?>[nilai_rujukan]"  placeholder="Select a value ..."    class="custom-select" >
                                                                    <option value="">Select a value ...</option>
                                                                </select>
                                                            </div>
                                                        </td>
                                                        <input id="ctrl-id_daftar_lab-row<?php echo $row; ?>"  value="<?php echo $original_plaintext;?>" type="hidden" placeholder="Enter Id Daftar Lab"  required="" name="row<?php echo $row ?>[id_daftar_lab]"  class="form-control " />
                                                            <td>
                                                                <div id="ctrl-diagnosa-row<?php echo $row; ?>-holder" class="">
                                                                    <select required="" data-endpoint="<?php print_link('api/json/data_hasil_lab_diagnosa_option_list') ?>" id="ctrl-diagnosa-row<?php echo $row; ?>" name="row<?php echo $row ?>[diagnosa]"  placeholder="Select a value ..."    class="selectize-ajax" >
                                                                        <option value="">Select a value ...</option>
                                                                    </select>
                                                                </div>
                                                            </td>
                                                            <td>
                                                                <div id="ctrl-jenis_pemeriksaan-row<?php echo $row; ?>-holder" class="">
                                                                    <input id="ctrl-jenis_pemeriksaan-row<?php echo $row; ?>"  value="<?php  echo $this->set_field_value('jenis_pemeriksaan',"", $row); ?>" type="text" placeholder="Enter Jenis Pemeriksaan"  required="" name="row<?php echo $row ?>[jenis_pemeriksaan]"  class="form-control " />
                                                                    </div>
                                                                </td>
                                                                <td>
                                                                    <div id="ctrl-harga-row<?php echo $row; ?>-holder" class="">
                                                                        <input id="ctrl-harga-row<?php echo $row; ?>"  value="<?php  echo $this->set_field_value('harga',"", $row); ?>" type="number" placeholder="Enter Harga" step="1"  required="" name="row<?php echo $row ?>[harga]"  class="form-control " />
                                                                        </div>
                                                                    </td>
                                                                    <td>
                                                                        <div id="ctrl-id_transaksi-row<?php echo $row; ?>-holder" class="">
                                                                            <input id="ctrl-id_transaksi-row<?php echo $row; ?>"  value="<?php  echo $this->set_field_value('id_transaksi',"", $row); ?>" type="number" placeholder="Enter Id Transaksi" step="1"  required="" name="row<?php echo $row ?>[id_transaksi]"  class="form-control " />
                                                                            </div>
                                                                        </td>
                                                                        <th class="text-center">
                                                                            <button type="button" class="close btn-remove-table-row">&times;</button>
                                                                        </th>
                                                                    </tr>
                                                                </template>
                                                                <!--[/table row template]-->
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
