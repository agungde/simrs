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
    <div  class=" p-2 mb-2">
        <div class="container">
            <div class="row ">
                <div class="col ">
                    <div class=""><div>
                        <?php
                        if(USER_ROLE==8){
                        $divisi = "IGD";
                        $bagian    = "IGD";    
                        }else if(USER_ROLE==6){
                        $divisi = "POLI";
                        $bagian    = $_SESSION[APP_ID.'user_data']['admin_poli'];
                        }else  if(USER_ROLE==13){
                        $divisi = "RANAP";
                        $bagian    = $_SESSION[APP_ID.'user_data']['admin_ranap'];   
                        }else  if(USER_ROLE==5){
                        $divisi = "FARMASI";
                        $bagian    = "FARMASI";     
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses!! Halaman Kusus!!');
                            document.location='<?php print_link(""); ?>';
                        </script>
                        <?php           
                        }
                        $usrnam  = "".USER_NAME;
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        $idtrace = "$id_user$usrnam";
                        $linksite="".SITE_ADDR;    
                        $tanggal = gmdate("Y-m-d", time() + 60 * 60 * 7);
                        if(isset($_POST['datacatat'])){
                        $idcat=$_POST['datacatat'];
                        $jum=$_POST['jum'];
                        $dtsid=$_POST['dtsid'];
                        for($a = 0; $a < count($idcat); $a++){  
                        $idcats=trim($idcat[$a]);
                        $jums=trim($jum[$a]);
                        $dtsids=trim($dtsid[$a]);
                        $query = mysqli_query($koneksi, "select * from data_setok where id='$dtsids' ") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rows = mysqli_num_rows($query);
                        if ($rows <> 0) {
                        while ($row=mysqli_fetch_array($query)){
                        // $idreq=$row['id'];
                        //$kode_barang=$row['kode_barang'];
                        //$nama_barang=$row['nama_barang'];
                        $jumlah=$row['jumlah'];
                        }
                        }
                        $sisjum= $jumlah - $jums;
                        mysqli_query($koneksi, "UPDATE `data_setok` SET `jumlah`='$sisjum' WHERE `id`='$dtsids'"); 
                        mysqli_query($koneksi, "UPDATE `catatan_barang` SET `setatus`='Closed' WHERE `id`='$idcats'"); 
                        }
                        ?>
                        <script language="JavaScript">
                            alert('Proses Simpan Catatan Barang Berhasil !!');
                            document.location='<?php print_link("catatan_barang"); ?>';
                        </script>
                        <?php 
                        }
                        ?>
                    </div></div><h4 class="record-title">Add New Catatan Barang Keluar Divisi <?php echo $divisi;?></h4>
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
                <div class="col-md-10 comp-grid">
                    <?php $this :: display_page_errors(); ?>
                    <div  class=" p-2 animated fadeIn page-content">
                        <form id="catatan_barang-add-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("catatan_barang/add?csrf_token=$csrf_token") ?>" method="post">
                            <div>
                                <input type="hidden" name="divisi" value="<?php echo $divisi;?>">    
                                    <input type="hidden" name="idtrace" value="<?php echo $idtrace;?>">
                                        <input type="hidden" name="bagian" value="<?php echo $bagian;?>">
                                            <input type="hidden" name="operator" value="<?php echo USER_ID;?>">
                                                <input  id="ctrl-id_data_setok" name="id_data_setok"  value="" type="hidden"/> 
                                                <input  id="ctrl-kode_barang" name="kode_barang"  value="" type="hidden"/> 
                                                <input  id="ctrl-category_barang" name="category_barang"  value="" type="hidden"/> 
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label class="control-label" for="tanggal">Tanggal <span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="input-group">
                                                                <input class="form-control " id="ctrl-tanggal" name="tanggal"  value="<?php echo $tanggal;?>" readonly/> 
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>   
                                                    <table class="table  table-striped table-sm text-left">
                                                        <tbody class="page-data" id="page-data-list-page-pncu8qemil7z">
                                                            <tr>
                                                                <td>
                                                                    <div class="form-group ">
                                                                        <div class="">
                                                                            <label class="control-label" for="nama_barang">Cari Kode/Nama Barang/Barcode <span class="text-danger">*</span></label>
                                                                        </div>
                                                                        <div class="">
                                                                            <input id="ctrl-nama_barang"  value="<?php  echo $this->set_field_value('nama_barang',""); ?>" type="text" placeholder="Cari Kode/Nama Barang/Barcode"  required="" name="nama_barang"  class="form-control " />
                                                                            </div>
                                                                        </div> 
                                                                    </td>
                                                                    <td width="10%">
                                                                        <div class="form-group ">
                                                                            <div class="">
                                                                                <label class="control-label" for="jumlah">Jumlah <span class="text-danger">*</span></label>
                                                                            </div>
                                                                            <div class="">
                                                                                <input id="ctrl-jumlah"  value="<?php  echo $this->set_field_value('jumlah',""); ?>" type="number" placeholder="Enter Jumlah" step="1"  required="" name="jumlah"  class="form-control " />
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                        <td>
                                                                            <div class="form-group ">
                                                                                <div class="">
                                                                                    <label class="control-label" for="jumlah">Keterangan<span class="text-danger">*</span></label>
                                                                                </div>
                                                                                <div class="">
                                                                                    <input id="ctrl-keterangan"  value="<?php  echo $this->set_field_value('keterangan',""); ?>" type="text" placeholder="keterangan"  required="" name="keterangan"  class="form-control " />
                                                                                    </div>
                                                                                </div>
                                                                            </td>                                                                       
                                                                            <td>
                                                                                <button class="btn btn-primary" type="submit">
                                                                                    <i class="fa fa-plus "></i>
                                                                                    <i class="fa fa-shopping-cart "></i>
                                                                                </button>
                                                                            </td>
                                                                        </tr></tbody>
                                                                    </table>  
                                                                    <div id="display" ></div>           
                                                                </div>
                                                            </form>
                                                            <form id="catatan_barang-add-form-simpan" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("catatan_barang/add?csrf_token=$csrf_token") ?>" method="post">                                                       
                                                                <table class="table  table-striped table-sm text-left">
                                                                    <thead class="table-header bg-success text-dark">
                                                                        <tr>
                                                                            <th  class="td-kode_barang"> Kode Barang</th>
                                                                            <th  class="td-nama_barang"> Nama Barang</th>
                                                                            <th  class="td-jumlah"> Jumlah</th>
                                                                            <th  class="td-jumlah"> Keterangan</th>
                                                                            <th class="td-btn"></th>
                                                                        </tr>                                                             </thead>  
                                                                        <tbody class="page-data" id="page-data-list-page-8rt4hbl3u9f5">
                                                                            <?php
                                                                            $query = mysqli_query($koneksi, "select * from catatan_barang where setatus='' and divisi='$divisi' and bagian='$bagian'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                                            $rows = mysqli_num_rows($query);
                                                                            if ($rows <> 0) {
                                                                            while ($row=mysqli_fetch_array($query)){
                                                                            $idreq=$row['id'];
                                                                            $kode_barang=$row['kode_barang'];
                                                                            $nama_barang=$row['nama_barang'];
                                                                            $jumlah=$row['jumlah'];
                                                                            $dtsid=$row['id_data_setok'];
                                                                            $keterangan=$row['keterangan'];
                                                                            ?>
                                                                            <tr>
                                                                                <td class="td-kode_barang">
                                                                                    <span>
                                                                                        <input type="hidden" name="datacatat[]" value="<?php echo $idreq;?>"> 
                                                                                            <input type="hidden" name="jum[]" value="<?php echo $jumlah;?>"> 
                                                                                                <input type="hidden" name="dtsid[]" value="<?php echo $dtsid;?>"> 
                                                                                                    <?php echo $kode_barang;?>
                                                                                                </span>
                                                                                            </td>
                                                                                            <td class="td-nama_barang"> 
                                                                                                <?php echo $nama_barang;?>
                                                                                            </td>
                                                                                            <td class="td-jumlah"><?php echo $jumlah;?></td>
                                                                                            <td class="td-jumlah"><?php echo $keterangan;?></td>
                                                                                            <th class="td-btn">
                                                                                                <a class="btn btn-sm btn-info has-tooltip page-modal" title="Edit This Record" href="<?php print_link("catatan_barang/catatan/$idreq"); ?>">
                                                                                                    <i class="fa fa-edit"></i> Edit
                                                                                                </a>                 
                                                                                            </th>
                                                                                        </tr>
                                                                                        <?php
                                                                                        }
                                                                                        }
                                                                                        ?>
                                                                                    </tbody> 
                                                                                </table>  </form>
                                                                                <style>
                                                                                    a:hover {
                                                                                    cursor: pointer;
                                                                                    background-color: #F5F5DC;
                                                                                    }
                                                                                </style>
                                                                                <script>
                                                                                    function fill(Value) {
                                                                                    $('#ctrl-nama_barang').val(Value);
                                                                                    //Hiding "display" div in "search.php" file.
                                                                                    $('#display').hide();
                                                                                    }
                                                                                    function idfill(Value) {
                                                                                    $('#ctrl-id_data_setok').val(Value);
                                                                                    //Hiding "display" div in "search.php" file.
                                                                                    $('#display').hide();
                                                                                    }
                                                                                    function kodefill(Value) {
                                                                                    $('#ctrl-kode_barang').val(Value);
                                                                                    //Hiding "display" div in "search.php" file.
                                                                                    $('#display').hide();
                                                                                    } 
                                                                                    function catefill(Value) {
                                                                                    $('#ctrl-category_barang').val(Value);
                                                                                    //Hiding "display" div in "search.php" file.
                                                                                    $('#display').hide();
                                                                                    }                                                                
                                                                                    $(document).ready(function() {
                                                                                    //On pressing a key on "Search box" in "search.php" file. This function will be called.
                                                                                    $('#ctrl-nama_barang').val("").focus();
                                                                                    $('#ctrl-nama_barang').keyup(function(e){
                                                                                    var tex = $(this).val();
                                                                                    console.log(tex);
                                                                                    if(tex !=="" && e.keyCode===13){
                                                                                    }
                                                                                    e.preventDefault();
                                                                                    //Assigning search box value to javascript variable named as "name".
                                                                                    var name = $('#ctrl-nama_barang').val();
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
                                                                                    url: "<?php print_link("caribarangunit.php") ?>",
                                                                                    //Data, that will be sent to "ajax.php".
                                                                                    // data: { search: name },
                                                                                    data: $('#catatan_barang-add-form').serialize(),
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
                                                                                <div> 
                                                                                    <table class="table  table-striped table-sm text-left">
                                                                                        <tbody class="page-data" id="page-data-list-page-pncu8qemil7z">
                                                                                            <!--record-->
                                                                                            <tr>
                                                                                                <td align="right">
                                                                                                    <div class="form-ajax-status"></div>
                                                                                                    <?php if ($idreq==""){}else{?>
                                                                                                    <a class="btn btn-sm btn-info" onclick="prosestrx();" style="color: #fff;">
                                                                                                    <i class="fa fa-send"></i> Simpan Catatan Barang</a><?php }?>
                                                                                                </td>
                                                                                            </tr>
                                                                                        </table>
                                                                                    </div> 
                                                                                    <script>
                                                                                        function prosestrx() {
                                                                                        var result = confirm("Proses Simpan Catatan Barang Divisi <?php echo $divisi;?>?");
                                                                                        if (result == true) {
                                                                                        //document.getElementById('autobtn').click();
                                                                                        document.getElementById("catatan_barang-add-form-simpan").submit();
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
