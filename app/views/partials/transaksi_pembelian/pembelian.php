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
                    <h4 class="record-title"><?php
                        if(!empty($_GET['category'])){
                        $category=$_GET['category'];
                        $_SESSION["category"] = "$category";
                        }else{
                        $category="";
                        }
                        if(!empty($_GET['databarang'])){
                        if(!empty($_GET['category'])){
                        }
                        echo "Add Pembelian + Add Data Barang";
                        }else{
                        echo "Add Pembelian $category";
                        }
                    ?></h4>
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
                <div class="col-md-5 comp-grid">
                    <div class=""><div>
                        <?php
                        if(!empty($_GET['databarang'])){
                        ?>  
                        <a class="btn btn-sm btn-primary has-tooltip"  href="<?php print_link("transaksi_pembelian/pembelian?category=$category"); ?>">                         
                            <i class="fa fa-plus "></i>
                            Add Pembelian
                        </a>  
                        <?php
                        }else{
                        ?>
                        <table><tr><td>
                            <?php
                            if(!empty($_GET['pembelian'])){
                            ?>  
                            <a class="btn btn-sm btn-primary has-tooltip"  href="<?php print_link("transaksi_pembelian/pembelian?category=$category"); ?>">                         
                                <i class="fa fa-plus "></i>
                                Add Pembelian
                            </a>  
                            <?php }else{?>
                            <?php }?>
                            </td><td>
                            <a class="btn btn-sm btn-primary has-tooltip"  href="<?php print_link("transaksi_pembelian/pembelian?databarang=true&category=$category"); ?>">                      
                                <i class="fa fa-plus "></i>
                                Add Pembelian + Add Data Barang
                            </a>
                        </td></tr></table>
                        <?php }?>
                    </div>
                </div>
            </div>
            <div class="col-md-12 comp-grid">
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
                    $queryin = mysqli_query($koneksi, "SELECT * from transaksi_pembelian WHERE idtrace='$idtrace'")
                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                    $rowsin = mysqli_num_rows($queryin);
                    if ($rowsin <> 0) {
                    $datain = mysqli_fetch_assoc($queryin);
                    $id_suplier=$datain['id_suplier'];
                    $no_invoice=$datain['no_invoice'];
                    $tanggal_pembelian=$datain['tanggal_pembelian'];
                    $databarang=$datain['databarang'];
                    $nama_suplier=$datain['nama_suplier'];
                    $type_pembelian=$datain['type_pembelian'];
                    $categorybarang=$datain['category_barang'];
                    $namasuplier="$nama_suplier";
                    } else{
                    $no_invoice="";
                    $tanggal_pembelian="";
                    $nama_suplier="";
                    $id_suplier="";
                    $type_pembelian="";
                    $databarang="";
                    $type_pembelian="";
                    $categorybarang="";
                    }  
                    if($categorybarang=="" or $categorybarang=="0"){}else{
                    if(!empty($_GET['category'])){}else{
                    ?>
                    <script language="JavaScript">
                        document.location='<?php print_link("transaksi_pembelian/pembelian?category=$category"); ?>';
                    </script>
                    <?php
                    }
                    }
                    if($type_pembelian=="PO"){
                    if(!empty($_GET['pembelian'])){}else{
                    ?>
                    <script language="JavaScript">
                        document.location='<?php print_link("transaksi_pembelian/pembelian?pembelian=PO&category=$category"); ?>';
                    </script>
                    <?php
                    }
                    }
                    if($databarang=="" or $databarang=="0"){
                    }else{
                    if(!empty($_GET['databarang'])){}else{
                    ?>
                    <script language="JavaScript">
                        document.location='<?php print_link("transaksi_pembelian/pembelian?databarang=true&category=$category"); ?>';
                    </script>
                    <?php
                    }
                    }
                    ?>
                    <?php    if(!empty($_GET['pembelian'])){?>
                    <div align="center"><span class="text-danger">* Transaksi Pembelian PO/Pesan Berarti Barang Belum Ada Setok Pending Updated</span></div>
                    <?php }else{?>
                    <div align="center"><span class="text-danger">*
                    Transaksi Pembelian Langsung Berarti Ada Barang Dan Updated Setok</span></div>
                    <?php } 
                    $category=trim($category);
                    if($category==""){}else{
                    $queryc = mysqli_query($koneksi, "SELECT * FROM `category_barang` WHERE `category`='$category'")
                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                    $rowsc = mysqli_num_rows($queryc);
                    if ($rowsc <> 0) {
                    $datac = mysqli_fetch_assoc($queryc);
                    $idcate=$datac['id'];
                    }else{
                    $idcate="";
                    }
                    }
                    ?>
                    <form id="data_barang-add-form"  novalidate role="form" enctype="multipart/form-data" class="form multi-form page-form" action="<?php print_link("transaksi_pembelian/pembelian?csrf_token=$csrf_token") ?>" method="post" ><?php
                        if($category==""){
                        ?><input id="cate" type="hidden" name="category_barang"  value="0" /><?php
                        }else{?><input id="cate" type="hidden" name="category_barang"  value="<?php echo $idcate;?>" /><?php }?><input type="hidden" name="category"  value="<?php echo $category;?>" /><table class="table  table-striped table-sm text-left">
                            <tbody class="page-data" id="page-data-list-page-pncu8qemil7z">
                                <!--record-->
                                <tr>
                                    <td align="left" width="100px">
                                        <table><tr>
                                            <td>
                                                <div class="form-group ">                  
                                                    <label class="control-label" for="tanggal_pembelian">Tanggal Pembelian<span class="text-danger">*</span></label>
                                                </div>           
                                                <div class="input-group">
                                                    <?php
                                                    if($tanggal_pembelian==""){
                                                    ?>
                                                    <input id="ctrl-tanggal" class="form-control datepicker  datepicker" required="" value="" type="date"  name="tanggal_pembelian" placeholder="Enter Tanggal" data-enable-time="false" data-min-date="" data-max-date="" data-date-format="Y-m-d" data-alt-format="F j, Y" data-inline="false" data-no-calendar="false" data-mode="single" required="" /> 
                                                    <div class="input-group-append">
                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                    </div>
                                                    <?php
                                                    }else{?>
                                                    <input class="form-control " id="ctrl-tanggal" name="tanggal_pembelian"  value="<?php echo $tanggal_pembelian;?>" readonly/>                            <?php
                                                        }
                                                        ?>
                                                    </div>                                             
                                                </td></tr></table>
                                            </td>
                                            <td align="right" width="200px" >
                                                <table><tr>
                                                    <td>
                                                    Type Pembelian<span class="text-danger">*</span></br>
                                                    <?php    if(!empty($_GET['databarang'])){
                                                    //$type_pembelian="Langsung";
                                                    ?>
                                                    <input class="form-control " id="ctrl-type_pembelian" name="type_pembelian"  value="Langsung" readonly/>  
                                                    <?php
                                                    }else{ 
                                                    if(!empty($_GET['pembelian'])){
                                                    ?>                                      
                                                    <input class="form-control " id="ctrl-type_pembelian" name="type_pembelian"  value="PO" readonly/>  
                                                    <?php }else{?>
                                                    <input class="form-control " id="ctrl-type_pembelian" name="type_pembelian"  value="Langsung" readonly/> 
                                                    <?php } }?>
                                                </td></tr></table>
                                            </td>
                                        </tr>
                                        <!--endrecord-->
                                    </tbody>
                                    <tbody class="search-data" id="search-data-list-page-pncu8qemil7z"></tbody>
                                </table>
                            </div>
                            </div><div class=""><div>
                            <?php
                            $queryt = mysqli_query($koneksi, "SELECT sum(total_harga) as tot from transaksi_pembelian WHERE idtrace='$idtrace'")
                            or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                            // ambil jumlah baris data hasil query
                            $rowst = mysqli_num_rows($queryt);
                            // cek hasil query
                            // jika "no_antrian" sudah ada
                            if ($rowst <> 0) {
                            // ambil data hasil query
                            $datat = mysqli_fetch_assoc($queryt);
                            $totharga=$datat['tot'];
                            }else{
                            $totharga="";
                            }
                            ?>
                            <table class="table  table-striped table-sm text-left">
                                <tbody class="page-data" id="page-data-list-page-pncu8qemil7z">
                                    <!--record-->
                                    <tr>
                                        <td align="left" width="200px">
                                            <table>
                                                <tr>
                                                    <td> <div><b>No Invoice <?php    if(!empty($_GET['pembelian'])){ echo $_GET['pembelian']; }?></b><span class="text-danger">*</span> </div>
                                                        <?php if($no_invoice==""){
                                                        ?>
                                                        <input class="form-control " required="" id="ctrl-no_invoice" name="no_invoice"  placeholder="No Invoice" value=""/>
                                                        <?php
                                                        }else{
                                                        ?>
                                                        <input class="form-control " required="" id="ctrl-no_invoice" name="no_invoice"  placeholder="No Invoice" value="<?php echo $no_invoice;?>" readonly/>
                                                            <?php   
                                                            }
                                                            ?>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                            <td align="right" width="300px">
                                                <table>
                                                    <tr>
                                                        <td ><div><b>Suplier</b></div>
                                                            <?php 
                                                            if($no_invoice==""){
                                                            ?>
                                                            <select name="suplier" class="form-control">
                                                                <option value="">Pilih Nama Suplier</option>
                                                                <?php
                                                                $sql = mysqli_query($koneksi,"select * from data_suplier");
                                                                while ($row=mysqli_fetch_array($sql)){
                                                                $idsup=$row['id_suplier'];
                                                                $nama=$row['nama'];
                                                                echo"<option value=\"$idsup\" >$nama</option>";
                                                                }
                                                                ?>
                                                            </select>
                                                            <?php }else{ 
                                                            if($nama_suplier==""){
                                                        echo "Non Suplier</br>"; 
                                                        ?>
                                                        <a class="btn btn-sm btn-info has-tooltip page-modal" title="Ganti Suplier" href="<?php print_link("transaksi_pembelian/suplier?csrf_token=$csrf_token&redirect=$current_page&category=".$_GET['category']); ?>">
                                                            <i class="fa fa-edit"></i> Ganti Suplier
                                                        </a> 
                                                        <input type="hidden" id="ctrl-suplier" name="suplier"  value="" readonly/>                    
                                                        <?php }else{
                                                        $queryi = mysqli_query($koneksi, "SELECT * from data_suplier WHERE id_suplier='$id_suplier'")
                                                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                        $rowsi = mysqli_num_rows($queryi);
                                                        if ($rowsi <> 0) {
                                                        $datai = mysqli_fetch_assoc($queryi);
                                                        $id=$datai['id_suplier'];
                                                        }            echo $namasuplier;           
                                                        ?>  
                                                        <input type="hidden" name="suplier"  value="<?php echo $id;?>" readonly/>
                                                            <?php } } ?>            
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <!--endrecord-->
                                    </tbody>
                                    <tbody class="search-data" id="search-data-list-page-pncu8qemil7z"></tbody>
                                </table>
                            </div>
                        </div>
                        <?php $this :: display_page_errors(); ?>
                        <div  class="bg-white p-1 animated fadeIn page-content">
                            <table class="table  table-striped table-sm text-left">
                                <tbody class="page-data" id="page-data-list-page-pncu8qemil7z">
                                    <!--record-->
                                    <?php
                                    if(!empty($_GET['databarang'])){
                                    ?>
                                    <input type="hidden"  name="databarang" value="True" required=""/> 
                                    <tr>
                                        <td>
                                            <div class="form-group ">
                                                <label class="control-label" for="Kode Barang">Kode Barang<span class="text-danger">*</span></label>
                                                <div class=""> 
                                                    <input type="text" placeholder="Kode Barang" name="kode_barang" class="form-control" required="" value="Auto"/> 
                                                </div>
                                            </div>   
                                        </td>  
                                        <td>
                                            <div class="form-group ">
                                                <label class="control-label" for="nama_barang">Nama Barang<span class="text-danger">*</span></label>
                                                <div class=""> 
                                                    <input type="text"  placeholder="Nama Barang" name="nama_barang" class="form-control" required=""/> 
                                                </div>
                                            </div>   
                                        </td>  
                                        <td>
                                            <div class="form-group ">
                                                <label class="control-label" for="jumlah">Jumlah <span class="text-danger">*</span></label>
                                                <div  class=""> 
                                                    <input id="ctrl-jumlah"  value="1" type="number" placeholder="Enter Jumlah" step="1"  required="" name="jumlah"  class="form-control" width="20px"/>
                                                </div>
                                            </div>
                                        </td>
                                        </tr><tr>
                                        <td> <div class="form-group ">
                                            <label class="control-label" for="satuan">Satuan<span class="text-danger">*</span></label>
                                            <div class="">
                                                <select required=""  name="satuan"  placeholder="Select a value ..."    class="custom-select" >
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
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group "><label class="control-label" for="category_barang">Category Barang<span class="text-danger">*</span></label>
                                            <div class="">
                                                <select required=""   name="category_barang"  placeholder="Select a value ..."    class="custom-select" >
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
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group ">
                                            <label class="control-label" for="harga_beli">Harga Beli <span class="text-danger">*</span></label>
                                            <div class=""> 
                                                <input id="ctrl-harga_beli"  value="<?php  echo $this->set_field_value('harga_beli',""); ?>" type="number" placeholder="Enter Harga Beli" step="1"  required="" name="harga_beli"  class="form-control" />
                                                </div>    
                                            </div>
                                        </td><td></td>
                                    </tr> 
                                    <?php
                                    }else{ ?>
                                    <input type="hidden"  name="databarang" value="0" required=""/>
                                    <tr>
                                        <td>
                                            <div class="form-group ">
                                                <label class="control-label" for="cari">Cari/(Barcode)<span class="text-danger">*</span></label>
                                                <div class=""> 
                                                    <input type="text" id="search" placeholder="Cari Kode/Nama Barang" name="nama_barang" class="form-control" required=""/> 
                                                </div>
                                            </div>   
                                        </td>                
                                        <td>
                                            <div class="form-group ">
                                                <label class="control-label" for="jumlah">Jumlah <span class="text-danger">*</span></label>
                                                <div class=""> 
                                                    <input id="ctrl-jumlah"  value="1" type="number" placeholder="Enter Jumlah" step="1"  required="" name="jumlah"  class="form-control" width="20px"/>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group ">
                                                <label class="control-label" for="harga_beli">Harga Beli <span class="text-danger">*</span></label>
                                                <div class=""> 
                                                    <input id="ctrl-harga_beli"  value="<?php  echo $this->set_field_value('harga_beli',""); ?>" type="number" placeholder="Enter Harga Beli" step="1"  required="" name="harga_beli"  class="form-control" />
                                                    </div>    
                                                </div>
                                            </td><td></td>
                                        </tr>
                                        <?php }?>
                                    </tbody>
                                </table>  <div id="display"></div>
                                <table class="table  table-striped table-sm text-left">
                                    <tbody class="page-data" id="page-data-list-page-pncu8qemil7z">
                                        <!--record-->     
                                        <tr>
                                            <td>
                                                <div class="form-group ">
                                                    <label class="control-label" for="tanggal_expired">Tanggal Expired <span class="text-danger">*</span></label>
                                                    <div class="input-group">
                                                        <input id="ctrl-tanggal_expired" class="form-control datepicker  datepicker"  required="" value="<?php  echo $this->set_field_value('tanggal_expired',""); ?>" type="datetime" name="tanggal_expired" placeholder="Enter Tanggal Expired" data-enable-time="false" data-min-date="" data-max-date="" data-date-format="Y-m-d" data-alt-format="F j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>              
                                            </td>                    
                                            <td>
                                                <div class="form-group ">
                                                    <label class="control-label" for="discount">Diskon (Per Item/PCS)<span class="text-danger">*</span></label>
                                                    <div class="">
                                                        <input id="ctrl-diskon"  value="0" type="text" placeholder="Enter Discount"  required="" name="diskon"  class="form-control" />
                                                    </div>
                                                </div>                    
                                            </td> 
                                            <td>
                                                <div class="form-group ">
                                                    <label class="control-label" for="ppn">Ppn <span class="text-danger">*</span></label>
                                                    <div class="">
                                                        <input id="ctrl-ppn"  value="0" type="text" placeholder="Enter Ppn"  required="" name="ppn"  class="form-control" />
                                                    </div>
                                                </div>                    
                                            </td>
                                            <td>
                                                <div class="form-group form-submit-btn-holder text-center mt-3">
                                                    <div class="form-ajax-status"></div>
                                                    <button class="btn btn-primary" type="submit">
                                                        <i class="fa fa-plus "></i>
                                                        <i class="fa fa-shopping-cart "></i>
                                                    </button>  
                                                </div>           
                                            </td>
                                        </tr>  </tbody>
                                    </table>                      
                                </form>                 
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
                                    <?php if($category==""){ }else{?>
                                    var cate = $('#cate').val();
                                    var beli="beli";
                                    <?php }?>
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
                                    <?php
                                    if($category==""){
                                    ?>search:name
                                    <?php
                                    }else{?>search:name,cate:cate,beli:beli<?php }?>
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
                                <table class="table  table-striped table-sm text-left">
                                    <thead class="table-header bg-success text-dark">
                                        <tr>
                                            <th  class="td-kode_barang"> Kode Barang</th>
                                            <th  class="td-nama_barang"> Nama Barang</th>
                                            <th  class="td-jumlah"> Jumlah</th>
                                            <th  class="td-harga_beli"> Harga Beli</th>
                                            <th  class="td-discount"> Diskon</th>
                                            <th  class="td-discount">Total Diskon</th>
                                            <th  class="td-ppn"> Ppn</th>
                                            <th  class="td-total_harga"> Total Harga</th>
                                            <th  class="td-tanggal_expired"> Tanggal Expired</th>
                                            <th class="td-btn"></th>
                                        </tr>                                                             </thead>        
                                        <!--record-->
                                        <tbody class="page-data" id="page-data-list-page-8rt4hbl3u9f5">
                                            <?php
                                            $query = mysqli_query($koneksi, "select * from transaksi_pembelian where idtrace='$idtrace'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                            // ambil jumlah baris data hasil query
                                            $rows = mysqli_num_rows($query);
                                            if ($rows <> 0) {
                                            while ($row=mysqli_fetch_array($query)){
                                            $id_transaksi_pembelian=$row['id_transaksi_pembelian'];
                                            $kode_barang=$row['kode_barang'];
                                            $nama_barang=$row['nama_barang'];
                                            $jumlah=$row['jumlah'];
                                            $harga_beli=$row['harga_beli'];
                                            $diskon=$row['diskon'];
                                            $total_diskon=$row['total_diskon'];
                                            $ppn=$row['ppn'];
                                            $total_harga=$row['total_harga'];
                                            $tanggal_expired=$row['tanggal_expired'];
                                            ?>
                                            <tr>
                                                <td class="td-kode_barang">
                                                    <span>
                                                        <?php echo $kode_barang;?>
                                                    </span>
                                                </td>
                                                <td class="td-nama_barang"> 
                                                    <?php echo $nama_barang;?>
                                                </td>
                                                <td class="td-jumlah"><?php echo $jumlah;?></td>
                                                <td class="td-harga"><?php echo $harga_beli;?></td>
                                                <td class="td-diskon"><?php echo $diskon;?></td>
                                                <td class="td-diskon"><?php echo $total_diskon;?></td>
                                                <td class="td-ppn"><?php echo $ppn;?></td>
                                                <td class="td-total_harga"><?php echo $total_harga;?></td>
                                                <td class="td-total_harga"><?php echo $tanggal_expired;?></td>
                                                <th class="td-btn">
                                                    <a class="btn btn-sm btn-info has-tooltip page-modal" title="Edit This Record" href="<?php print_link("transaksi_pembelian/edit/$id_transaksi_pembelian"); ?>">
                                                        <i class="fa fa-edit"></i> Edit
                                                    </a>                 
                                                    <a class="btn btn-sm btn-danger has-tooltip record-delete-btn" title="Delete this record" href="<?php print_link("transaksi_pembelian/delete/$id_transaksi_pembelian/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">                       
                                                        <i class="fa fa-times"></i>
                                                        Delete
                                                    </a>
                                                </th>
                                            </tr>
                                            <?php
                                            }
                                            }
                                            ?>
                                        </tbody>      <!--endrecord-->
                                        <tbody class="search-data" id="search-data-list-page-xr7t1upbsjod"></tbody>
                                    </table> 
                                </td></tr></tbody>
                            </table> 
                        </td>
                    </tr> </tbody>
                </table> 
            </div>
            <div class=""><div> <form name="proses" id="proses" method="post" action="<?php print_link("transaksi_pembelian/proses?csrf_token=$csrf_token") ?>"><?php if($no_invoice==""){
                }else{
                ?><input name="no_invoice" value="<?php echo $no_invoice;?>" type="hidden"/><?php   
                    }
                    ?><table class="table  table-striped table-sm text-left">
                        <tbody class="page-data" id="page-data-list-page-pncu8qemil7z">
                            <!--record-->
                            <tr>
                                <td align="left" width="200px">
                                </td>
                                <td align="right" width="300px">
                                    <table>
                                        <tr>
                                            <td>
                                                <h1><b>Total</b></h1>
                                            </td>
                                            <td><h1><b>Rp. <?php echo number_format($totharga,0,",",".");?></b></h1>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div class="form-ajax-status"></div>
                                                <?php if ($totharga=="" or $totharga=="0"){}else{?>
                                                <a class="btn btn-sm btn-info" onclick="prosestrx();" style="color: #fff;">
                                                    <i class="fa fa-send"></i> Proses Pebelian
                                                </a><?php }?>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            <!--endrecord-->
                        </tbody>
                        <tbody class="search-data" id="search-data-list-page-pncu8qemil7z"></tbody>
                    </table>
                </form>
            </div> 
            <a id="autobtn" type="hidden" class="page-modal"  href="<?php print_link("transaksi_penjualan/proses?csrf_token=$csrf_token&redirect=$current_page");?>" ></a>
            <script>
                function prosestrx() {
                var result = confirm("Proses Pembeliam <?php echo $category;?>?");
                if (result == true) {
                //document.getElementById('autobtn').click();
                document.getElementById("proses").submit();
                return true;
                }
                else {
                return false;
                }
                }
            </script>
        </div>
    </div>
</div>
</div>
</div>
</section>
