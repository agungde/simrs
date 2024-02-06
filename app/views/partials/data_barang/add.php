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
                    <h4 class="record-title">Add Data Barang</h4>
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
                    <div class=""><div>
                        <?php
                        if(isset($_POST['kode_barang'])){ 
                        $usrnam  = "".USER_NAME;
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        $idtrace = "$id_user$usrnam";
                        $kode_barang     = $_POST['kode_barang'];
                        $nama_barang     = $_POST['nama_barang'];
                        $satuan          = $_POST['satuan'];
                        $category_barang = $_POST['category_barang'];
                        $uname = $nama_barang;
                        if(!empty($uname)){
                        for($a = 0; $a < count($uname); $a++){
                        if(!empty($uname[$a])){
                        $unames    = $uname[$a];
                        $kodes     = $kode_barang[$a];
                        $satuans   = $satuan[$a];
                        $categorys = $category_barang[$a];
                        if($kodes=="Auto"){
                        $query = mysqli_query($koneksi, "SELECT * from category_barang where id='$categorys'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        // ambil jumlah baris data hasil query
                        $rows = mysqli_num_rows($query);
                        // cek hasil query
                        // jika "no_antrian" sudah ada
                        if ($rows <> 0) {// ambil data hasil query
                        $data = mysqli_fetch_assoc($query);
                        $cate  = $data['category'];
                        $categ  = substr($cate, 0, 2);
                        }
                        $categ=strtoupper("$categ");
                        mysqli_query($koneksi,"INSERT INTO `data_barang` (`nama_barang`,`satuan`,`category_barang`,`operator`) VALUES ('$unames','$satuans','$categorys','$id_user')");
                        mysqli_query($koneksi,"INSERT INTO `setok_barang` (`nama_barang`,`satuan`,`category_barang`,`operator`) VALUES ('$unames','$satuans','$categorys','$id_user')");
                        $querydt = mysqli_query($koneksi, "SELECT * from data_barang where nama_barang='$unames'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsdt = mysqli_num_rows($querydt);
                        if ($rowsdt <> 0) {// ambil data hasil query
                        $datadt = mysqli_fetch_assoc($querydt);
                        $idbarangt  = $datadt['id_barang'];
                        }
                        $kodeauto = "DT$categ$idbarangt";  
                        mysqli_query($koneksi,"UPDATE data_barang SET kode_barang='$kodeauto' WHERE nama_barang='$unames'");
                        mysqli_query($koneksi,"UPDATE setok_barang SET kode_barang='$kodeauto', id_data='$idbarangt' WHERE nama_barang='$unames'");
                        }else{
                        mysqli_query($koneksi,"INSERT INTO `data_barang` (`kode_barang`,`nama_barang`,`satuan`,`category_barang`,`operator`) VALUES ('$kodes','$unames','$satuans','$categorys','$id_user')");
                        $queryd = mysqli_query($koneksi, "SELECT * from data_barang where nama_barang='$unames'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsd = mysqli_num_rows($queryd);
                        if ($rowsd <> 0) {// ambil data hasil query
                        $datad = mysqli_fetch_assoc($queryd);
                        $idbarang  = $datad['id_barang'];
                        }
                        mysqli_query($koneksi,"INSERT INTO `setok_barang` (`id_data`,`kode_barang`,`nama_barang`,`satuan`,`category_barang`,`operator`) VALUES ('$idbarang','$kodes','$unames','$satuans','$categorys','$id_user')");
                        }
                        }
                        }
                        }
                        ?>
                        <script language="JavaScript">
                            alert('Data Barang Berhasil Di Simpan!!');
                            document.location='<?php print_link("data_barang"); ?>';
                        </script>
                        <?php 
                        }
                        ?>
                    </div></div>
                    <?php $this :: display_page_errors(); ?>
                    <div  class="bg-light p-3 animated fadeIn page-content">
                        <form id="data_barang-add-form"  novalidate role="form" enctype="multipart/form-data" class="form multi-form page-form" action="<?php print_link("data_barang/add?csrf_token=$csrf_token") ?>" method="post" >
                            <table id="dynamicTable" class="table  table-striped table-sm text-left"> 
                                <thead>
                                    <tr>
                                        <th class="bg-light"><label for="kode_barang">Kode Barang</label></th>
                                        <th class="bg-light"><label for="nama_barang">Nama Barang</label></th>
                                        <th class="bg-light"><label for="satuan">Satuan</label></th>
                                        <th class="bg-light"><label for="category_barang">Category Barang</label></th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>  
                                        <td>
                                            <div class="">
                                                <input value="Auto" type="text" placeholder="Enter Kode Barang"  required="" name="kode_barang[]"  data-url="api/json/data_barang_kode_barang_value_exist/" data-loading-msg="Checking availability ..." data-available-msg="Available" data-unavailable-msg="Not available" class="form-control  ctrl-check-duplicate" />
                                                <div class="check-status"></div> 
                                            </div>
                                        </td>  
                                        <td>
                                            <div class="">
                                                <input value="" type="text" placeholder="Enter Nama Barang"  required="" name="nama_barang[]"  data-url="api/json/data_barang_nama_barang_value_exist/" data-loading-msg="Checking availability ..." data-available-msg="Available" data-unavailable-msg="Not available" class="form-control  ctrl-check-duplicate" />
                                                <div class="check-status"></div> 
                                            </div>
                                        </td>
                                        <td>
                                            <div class="">
                                                <select required=""  name="satuan[]"  placeholder="Select a value ..."    class="custom-select" >
                                                    <option value="">Select a value ...</option>
                                                    <?php 
                                                    $satuan_options = $comp_model -> data_barang_satuan_option_list();
                                                    if(!empty($satuan_options)){
                                                    foreach($satuan_options as $option){
                                                    $value = (!empty($option['value']) ? $option['value'] : null);
                                                    $label = (!empty($option['label']) ? $option['label'] : $value);
                                                    $selected = $this->set_field_selected('satuan',$value, "");
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
                                            <div lass="">
                                                <select required=""   name="category_barang[]"  placeholder="Select a value ..."    class="custom-select" >
                                                    <option value="">Select a value ...</option>
                                                    <?php 
                                                    $category_barang_options = $comp_model -> data_barang_category_barang_option_list();
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
                                        </td>
                                        <td><button type="button" name="add" id="add" class="btn btn-primary"><i class="fa fa-plus "></i></button></td>                  
                                    </tr>  
                                </table> 
                                <div class="form-group form-submit-btn-holder text-center mt-3">
                                    <div class="form-ajax-status"></div>
                                    <button class="btn btn-primary" type="submit">
                                        Submit
                                        <i class="fa fa-send"></i>
                                    </button>
                                </div>
                            </form>
                            <script type="text/javascript">
                                var i = 0;
                                $("#add").click(function(){
                                ++i;
                                $("#dynamicTable").append('<tr><td><div class=""><input value="Auto" type="text" placeholder="Enter Kode Barang"  required="" name="kode_barang[]"  data-url="api/json/data_barang_kode_barang_value_exist/" data-loading-msg="Checking availability ..." data-available-msg="Available" data-unavailable-msg="Not available" class="form-control  ctrl-check-duplicate" /><div class="check-status"></div></div></td><td><div class=""><input value="" type="text" placeholder="Enter Nama Barang"  required="" name="nama_barang[]"  data-url="api/json/data_barang_nama_barang_value_exist/" data-loading-msg="Checking availability ..." data-available-msg="Available" data-unavailable-msg="Not available" class="form-control  ctrl-check-duplicate" /><div class="check-status"></div></div></td><td><div class=""><select required=""  name="satuan[]"  placeholder="Select a value ..."    class="custom-select" ><option value="">Select a value ...</option><?php 
                                    $satuan_options = $comp_model -> data_barang_satuan_option_list();
                                    if(!empty($satuan_options)){
                                    foreach($satuan_options as $option){
                                    $value = (!empty($option['value']) ? $option['value'] : null);
                                    $label = (!empty($option['label']) ? $option['label'] : $value);
                                    $selected = $this->set_field_selected('satuan',$value, "");
                                    ?><option <?php echo $selected; ?> value="<?php echo $value; ?>"><?php echo $label; ?></option><?php
                                    }
                                    }
                                    ?></select></div></td><td><div lass=""><select required=""   name="category_barang[]"  placeholder="Select a value ..."    class="custom-select" ><option value="">Select a value ...</option><?php 
                                    $category_barang_options = $comp_model -> data_barang_category_barang_option_list();
                                    if(!empty($category_barang_options)){
                                    foreach($category_barang_options as $option){
                                    $value = (!empty($option['value']) ? $option['value'] : null);
                                    $label = (!empty($option['label']) ? $option['label'] : $value);
                                    $selected = $this->set_field_selected('category_barang',$value, "");
                                    ?><option <?php echo $selected; ?> value="<?php echo $value; ?>"><?php echo $label; ?></option><?php
                                    }
                                    }
                                ?></select></div></td><td><button type="button" class="btn btn-danger remove-tr"><i class="fa fa-close "></i></button></td></tr>');
                                });
                                $(document).on('click', '.remove-tr', function(){  
                                $(this).parents('tr').remove();
                                });  
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
