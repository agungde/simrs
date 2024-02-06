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
                        $usrnam  = "".USER_NAME;
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        $idtrace = "$id_user$usrnam";
                        //$jumlah          = $_POST['jumlah'];
                        //$tanggal         = $_POST['tanggal'];
                        //$category_barang = $_POST['category_barang'];
                        //$nama_barang      = $_POST['nama_barang'];
                        if(!empty($_GET['precord'])){
                        //$precord=$_GET['precord']; 
                        $ciphertext = $_GET['precord'];
                        $ciphertext=str_replace(' ', '+', $ciphertext);
                        $resep=$ciphertext;
                        $key="dermawangroup";
                        $c = base64_decode($ciphertext);
                        $ivlen = openssl_cipher_iv_length($cipher="AES-128-CBC");
                        $iv = substr($c, 0, $ivlen);
                        $hmac = substr($c, $ivlen, $sha2len=32);
                        $ciphertext_raw = substr($c, $ivlen+$sha2len);
                        $original_plaintext = openssl_decrypt($ciphertext_raw, $cipher, $key, $options=OPENSSL_RAW_DATA, $iv);
                        $calcmac = hash_hmac('sha256', $ciphertext_raw, $key, $as_binary=true);
                        if (hash_equals($hmac, $calcmac))// timing attack safe comparison
                        {
                        // echo $original_plaintext."\n";
                        }
                        $query = mysqli_query($koneksi, "SELECT * from permintaan_barang where no_request='$original_plaintext'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rows = mysqli_num_rows($query);
                        if ($rows <> 0) {
                        $datab       = mysqli_fetch_assoc($query);
                        $category_barang = $datab['category_barang'];
                        $norequest = $datab['no_request'];
                        $divisi = $datab['divisi'];
                        $qu = mysqli_query($koneksi, "SELECT * from category_barang WHERE id='$category_barang'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $ro = mysqli_num_rows($qu);
                        if ($ro <> 0) {
                        $dat= mysqli_fetch_assoc($qu);
                        $namacat=$dat['category'];
                        } 
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses URL Tidak Valid');
                            document.location='<?php print_link("permintaan_barang"); ?>';
                        </script>
                        <?php      
                        }
                        }else{
                        $category_barang="";
                        $namacat="";
                        $norequest="";
                        }
                        ?>
                    </div>
                </div><h4 class="record-title">Add Permintaan Harga <?php echo $namacat;?> Divisi <?php echo $divisi;?></h4>
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
                <div class=""><div><?php 
                    if($norequest==""){}else{
                    echo"NO REQUEST $norequest";
                    }
                ?></div>
            </div>
            <?php $this :: display_page_errors(); ?>
            <div  class="bg-light p-3 animated fadeIn page-content">
                <form id="permintaan_harga-add-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("permintaan_harga/add?csrf_token=$csrf_token") ?>" method="post">
                    <div>
                        <div class="form-group ">
                            <div class="row">
                                <div class="col-sm-4">
                                    <label class="control-label" for="tanggal">Tanggal <span class="text-danger">*</span></label>
                                </div>
                                <div class="col-sm-8">
                                    <div class="input-group">
                                        <input id="ctrl-tanggal" class="form-control datepicker  datepicker"  required="" value="<?php  echo $this->set_field_value('tanggal',date_now()); ?>" type="datetime" name="tanggal" placeholder="Enter Tanggal" data-enable-time="false" data-min-date="" data-max-date="" data-date-format="Y-m-d" data-alt-format="F j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
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
                                        <label class="control-label" for="nama_suplier">Nama Suplier <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="">
                                            <select required=""  id="ctrl-nama_suplier" name="nama_suplier"  placeholder="Select a value ..."    class="custom-select" >
                                                <option value="">Select a value ...</option>
                                                <?php 
                                                $nama_suplier_options = $comp_model -> permintaan_harga_nama_suplier_option_list();
                                                if(!empty($nama_suplier_options)){
                                                foreach($nama_suplier_options as $option){
                                                $value = (!empty($option['value']) ? $option['value'] : null);
                                                $label = (!empty($option['label']) ? $option['label'] : $value);
                                                $selected = $this->set_field_selected('nama_suplier',$value, "");
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
                            <input id="ctrl-category_barang"  value="<?php echo $category_barang;?>" type="hidden" placeholder="Enter Category Barang" list="category_barang_list"  required="" name="category_barang"  class="form-control " />
                                <datalist id="category_barang_list">
                                    <?php 
                                    $category_barang_options = $comp_model -> permintaan_harga_category_barang_option_list();
                                    if(!empty($category_barang_options)){
                                    foreach($category_barang_options as $option){
                                    $value = (!empty($option['value']) ? $option['value'] : null);
                                    $label = (!empty($option['label']) ? $option['label'] : $value);
                                    ?>
                                    <option value="<?php echo $value; ?>"><?php echo $label; ?></option>
                                    <?php
                                    }
                                    }
                                    ?>
                                </datalist>
                                <input id="ctrl-no_request"  value="<?php echo $norequest;?>" type="hidden" placeholder="Enter No Request"  required="" name="no_request"  class="form-control " />
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
