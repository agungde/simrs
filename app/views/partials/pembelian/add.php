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
                    <h4 class="record-title">Add New Pembelian</h4>
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
                <div class="col-md-8 comp-grid">
                    <div class=""> <script language="JavaScript">
                        alert('Dilarang Akses Add Langsung');
                        document.location='<?php print_link(""); ?>';
                    </script>
                    <div align="center">
                        <div class="form-group ">
                            <label class="control-label" for="cari">Cari Kode/Nama Barang / (Barcode)</label>
                            <div id="ctrl-nama_barang" class=""> 
                                <input type="text" id="search" placeholder="Cari Barang / (Barcode)" name="nama_barang" class="form-control "/> 
                            </div>
                            <div id="display"></div>
                            <script>
                                function fill(Value) {
                                //Assigning value to "search" div in "search.php" file.
                                $('#search').val(Value);
                                //Hiding "display" div in "search.php" file.
                                $('#display').hide();
                                }
                                $(document).ready(function() {
                                //On pressing a key on "Search box" in "search.php" file. This function will be called.
                                $('#search').val("").focus();
                                $('#search').keyup(function(e){
                                var tex = $(this).val();
                                console.log(tex);
                                if(tex !=="" && e.keyCode===13){
                                }
                                e.preventDefault();
                                //Assigning search box value to javascript variable named as "name".
                                var name = $('#search').val();
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
                                url: "<?php print_link("cari.php") ?>",
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
                                });
                            </script> 
                            <style>
                                a:hover {
                                cursor: pointer;
                                background-color: #F5F5DC;
                                }
                            </style>
                            <b>Harga Jual Isi Di Setok</b>   
                        </div>
                    </div>
                    <?php $this :: display_page_errors(); ?>
                    <div  class="bg-light p-3 animated fadeIn page-content">
                        <form id="pembelian-add-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("pembelian/add?csrf_token=$csrf_token") ?>" method="post">
                            <div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="nama_suplier">Nama Suplier <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="ctrl-nama_suplier"  value="<?php  echo $this->set_field_value('nama_suplier',""); ?>" type="text" placeholder="Enter Nama Suplier"  required="" name="nama_suplier"  class="form-control " />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <input id="ctrl-ppn"  value="<?php $id_user = "".USER_ID; echo"$id_user";?>" type="hidden" placeholder="Enter Ppn"  name="ppn"  class="form-control " />
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="control-label" for="tanggal_pembelian">Tanggal Pembelian <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="input-group">
                                                        <input id="ctrl-tanggal_pembelian" class="form-control datepicker  datepicker"  required="" value="<?php  echo $this->set_field_value('tanggal_pembelian',""); ?>" type="datetime" name="tanggal_pembelian" placeholder="Enter Tanggal Pembelian" data-enable-time="false" data-min-date="" data-max-date="" data-date-format="Y-m-d" data-alt-format="F j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
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
                                                        <label class="control-label" for="alamat">Alamat <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="">
                                                            <input id="ctrl-alamat"  value="<?php  echo $this->set_field_value('alamat',""); ?>" type="text" placeholder="Enter Alamat"  required="" name="alamat"  class="form-control " />
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
                                                                <input id="ctrl-no_hp"  value="<?php  echo $this->set_field_value('no_hp',""); ?>" type="text" placeholder="Enter No Hp"  required="" name="no_hp"  class="form-control " />
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group ">
                                                        <div class="row">
                                                            <div class="col-sm-4">
                                                                <label class="control-label" for="total_jumlah">Total Jumlah <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <div class="">
                                                                    <input id="ctrl-total_jumlah"  value="<?php  echo $this->set_field_value('total_jumlah',""); ?>" type="number" placeholder="Enter Total Jumlah" step="1"  required="" name="total_jumlah"  class="form-control " />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label class="control-label" for="total_harga_beli">Total Harga Beli <span class="text-danger">*</span></label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <div class="">
                                                                        <input id="ctrl-total_harga_beli"  value="<?php  echo $this->set_field_value('total_harga_beli',""); ?>" type="number" placeholder="Enter Total Harga Beli" step="1"  required="" name="total_harga_beli"  class="form-control " />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group ">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" for="total_diskon">Total Diskon <span class="text-danger">*</span></label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <div class="">
                                                                            <input id="ctrl-total_diskon"  value="<?php  echo $this->set_field_value('total_diskon',""); ?>" type="number" placeholder="Enter Total Diskon" step="1"  required="" name="total_diskon"  class="form-control " />
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="form-group ">
                                                                    <div class="row">
                                                                        <div class="col-sm-4">
                                                                            <label class="control-label" for="category_barang">Category Barang <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-sm-8">
                                                                            <div class="">
                                                                                <select required=""  id="ctrl-category_barang" name="category_barang"  placeholder="Select a value ..."    class="custom-select" >
                                                                                    <option value="">Select a value ...</option>
                                                                                    <?php 
                                                                                    $category_barang_options = $comp_model -> pembelian_category_barang_option_list();
                                                                                    if(!empty($category_barang_options)){
                                                                                    foreach($category_barang_options as $option){
                                                                                    $value = (!empty($option['value']) ? $option['value'] : null);
                                                                                    $label = (!empty($option['label']) ? $option['label'] : $value);
                                                                                    $selected = $this->set_field_selected('category_barang',$value, "");
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
                                                                            <label class="control-label" for="divisi">Divisi <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="col-sm-8">
                                                                            <div class="">
                                                                                <input id="ctrl-divisi"  value="<?php  echo $this->set_field_value('divisi',""); ?>" type="text" placeholder="Enter Divisi"  required="" name="divisi"  class="form-control " />
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
