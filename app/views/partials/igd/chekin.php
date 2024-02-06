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
    <div  class="bg-light p-3 mb-3">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <h4 class="record-title">Chekin Paien IGD
                        <div id="display" ></div>
                        <script>
                            function fill(Value) {
                            // $('#search').val(Value);
                            document.location='<?php print_link("igd/add?precord="); ?>'+Value;
                            }
                            $(document).ready(function() {
                            <?php if(!empty($_GET['precord'])){}else{?>
                            setTimeout(function(){
                            // window.location.reload();
                            $('#slideshow').hide();
                            $('#slideshow1').hide();
                            }, 30000);
                            <?php }?>
                            <?php if($jenis_kelamin==""){}else{
                            if($jenis_kelamin=="Laki-Laki"){
                            $indexval="1";
                            }else{
                            $indexval="2";
                            }
                            ?>
                            document.getElementById("ctrl-jenis_kelamin").selectedIndex = "<?php echo $indexval;?>";
                            <?php }?>
                            <?php if($tl==""){}else{
                            if($tl=="TN"){
                            $indexvalt="1";
                            }else if($tl=="NY"){
                            $indexvalt="2";
                            }else if($tl=="AN"){
                            $indexvalt="3";
                            }else if($tl=="BY"){
                            $indexvalt="4";
                            }
                            ?>
                            document.getElementById("ctrl-tl").selectedIndex = "<?php echo $indexvalt;?>";
                            <?php }?>
                            //On pressing a key on "Search box" in "search.php" file. This function will be called.
                            // $('#ctrl-nama_pasien').val("").focus();
                            $('#ctrl-nama_pasien').keyup(function(e){
                            var tex = $(this).val();
                            console.log(tex);
                            if(tex !=="" && e.keyCode===13){
                            }
                            e.preventDefault();
                            //Assigning search box value to javascript variable named as "name".
                            var name = $('#ctrl-nama_pasien').val();
                            //Validating, if "name" is empty.
                            if (name == "") {
                            //Assigning empty value to "display" div in "search.php" file.
                            $("#display").html("");
                            }
                            //If name is not empty.
                            else {
                            //AJAX is called.
                            $.ajax({
                            //AJAX type is "Post".
                            type: "POST",
                            //Data will be sent to "ajax.php".
                            url: "<?php print_link("caripasien.php") ?>",
                            //Data, that will be sent to "ajax.php".
                            data: {
                            //Assigning value of "name" into "search" variable.
                            search: name
                            },
                            //If result found, this funtion will be called.
                            success: function(html) {
                            //Assigning result to "display" div in "search.php" file.
                            $("#display").html(html).show();
                            }
                            });
                            }
                            });
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
                            <form novalidate  id="" role="form" enctype="multipart/form-data"  class="form page-form form-horizontal needs-validation" action="<?php print_link("igd/chekin/$page_id/?csrf_token=$csrf_token"); ?>" method="post">
                                <div>
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
                                                        <label class="control-label" for="tanggal_lahir">Tanggal Lahir <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="input-group">
                                                            <input id="ctrl-tanggal_lahir" class="form-control datepicker  datepicker"  required="" value="<?php  echo $data['tanggal_lahir']; ?>" type="datetime" name="tanggal_lahir" placeholder="Enter Tanggal Lahir" data-enable-time="false" data-min-date="" data-max-date="" data-date-format="Y-m-d" data-alt-format="F j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
                                                                <div class="input-group-append">
                                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label class="control-label" for="umur">Umur <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="">
                                                                <input id="ctrl-umur"  value="<?php  echo $data['umur']; ?>" type="text" placeholder="Enter Umur"  readonly required="" name="umur"  class="form-control " />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label class="control-label" for="no_hp">No Hp <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <div class="">
                                                                    <input id="ctrl-no_hp"  value="<?php  echo $data['no_hp']; ?>" type="text" placeholder="Enter No Hp"  required="" name="no_hp"  class="form-control " />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label class="control-label" for="penanggung_jawab">Penanggung Jawab <span class="text-danger">*</span></label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <div class="">
                                                                        <input id="ctrl-penanggung_jawab"  value="<?php  echo $data['penanggung_jawab']; ?>" type="text" placeholder="Enter Penanggung Jawab"  required="" name="penanggung_jawab"  class="form-control " />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group ">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" for="id_penanggung_jawab">Id Penanggung Jawab <span class="text-danger">*</span></label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <div class="">
                                                                            <input id="ctrl-id_penanggung_jawab"  value="<?php  echo $data['id_penanggung_jawab']; ?>" type="text" placeholder="Enter Id Penanggung Jawab"  required="" name="id_penanggung_jawab"  class="form-control " />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group ">
                                                                    <div class="row">
                                                                        <div class="col-sm-4">
                                                                            <label class="control-label" for="alamat_penanggung_jawab">Alamat Penanggung Jawab <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-sm-8">
                                                                            <div class="">
                                                                                <input id="ctrl-alamat_penanggung_jawab"  value="<?php  echo $data['alamat_penanggung_jawab']; ?>" type="text" placeholder="Enter Alamat Penanggung Jawab"  required="" name="alamat_penanggung_jawab"  class="form-control " />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group ">
                                                                        <div class="row">
                                                                            <div class="col-sm-4">
                                                                                <label class="control-label" for="no_hp_penanggung_jawab">No Hp Penanggung Jawab <span class="text-danger">*</span></label>
                                                                            </div>
                                                                            <div class="col-sm-8">
                                                                                <div class="">
                                                                                    <input id="ctrl-no_hp_penanggung_jawab"  value="<?php  echo $data['no_hp_penanggung_jawab']; ?>" type="text" placeholder="Enter No Hp Penanggung Jawab"  required="" name="no_hp_penanggung_jawab"  class="form-control " />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group ">
                                                                            <div class="row">
                                                                                <div class="col-sm-4">
                                                                                    <label class="control-label" for="hubungan">Hubungan <span class="text-danger">*</span></label>
                                                                                </div>
                                                                                <div class="col-sm-8">
                                                                                    <div class="">
                                                                                        <input id="ctrl-hubungan"  value="<?php  echo $data['hubungan']; ?>" type="text" placeholder="Enter Hubungan"  required="" name="hubungan"  class="form-control " />
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
                                                                                            <label class="control-label" for="email">Email <span class="text-danger">*</span></label>
                                                                                        </div>
                                                                                        <div class="col-sm-8">
                                                                                            <div class="">
                                                                                                <input id="ctrl-email"  value="<?php  echo $data['email']; ?>" type="email" placeholder="Enter Email"  required="" name="email"  class="form-control " />
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
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
                                                                                                        $pembayaran_options = $comp_model -> igd_pembayaran_option_list();
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
                                                                                                <label class="control-label" for="tanggal_masuk">Tanggal Masuk <span class="text-danger">*</span></label>
                                                                                            </div>
                                                                                            <div class="col-sm-8">
                                                                                                <div class="input-group">
                                                                                                    <input id="ctrl-tanggal_masuk" class="form-control datepicker  datepicker" required="" value="<?php  echo $data['tanggal_masuk']; ?>" type="datetime"  name="tanggal_masuk" placeholder="Enter Tanggal Masuk" data-enable-time="true" data-min-date="" data-max-date="" data-date-format="Y-m-d H:i:S" data-alt-format="F j, Y - H:i" data-inline="false" data-no-calendar="false" data-mode="single" /> 
                                                                                                        <div class="input-group-append">
                                                                                                            <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                                                        </div>
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
                                                                                                        <input id="ctrl-no_rekam_medis"  value="<?php  echo $data['no_rekam_medis']; ?>" type="text" placeholder="Enter No Rekam Medis"  readonly required="" name="no_rekam_medis"  class="form-control " />
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
                                                                                                            <select required=""  id="ctrl-dokter" name="dokter"  placeholder="Select a value ..."    class="custom-select" >
                                                                                                                <option value="">Select a value ...</option>
                                                                                                                <?php
                                                                                                                $rec = $data['dokter'];
                                                                                                                $dokter_options = $comp_model -> igd_dokter_option_list();
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
                                                                                                        <label class="control-label" for="no_ktp">No Ktp <span class="text-danger">*</span></label>
                                                                                                    </div>
                                                                                                    <div class="col-sm-8">
                                                                                                        <div class="">
                                                                                                            <input id="ctrl-no_ktp"  value="<?php  echo $data['no_ktp']; ?>" type="number" placeholder="Enter No Ktp" step="1"  required="" name="no_ktp"  class="form-control " />
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="form-group ">
                                                                                                    <div class="row">
                                                                                                        <div class="col-sm-4">
                                                                                                            <label class="control-label" for="tl">TL <span class="text-danger">*</span></label>
                                                                                                        </div>
                                                                                                        <div class="col-sm-8">
                                                                                                            <div class="">
                                                                                                                <select required=""  id="ctrl-tl" name="tl"  placeholder="Select a value ..."    class="custom-select" >
                                                                                                                    <option value="">Select a value ...</option>
                                                                                                                    <?php
                                                                                                                    $tl_options = Menu :: $tl;
                                                                                                                    $field_value = $data['tl'];
                                                                                                                    if(!empty($tl_options)){
                                                                                                                    foreach($tl_options as $option){
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
