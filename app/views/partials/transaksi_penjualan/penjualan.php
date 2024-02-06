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
                    <h4 class="record-title">Add New Transaksi Penjualan</h4>
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
                        $usrnam  = "".USER_NAME;
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        $idtrace = "$id_user$usrnam";
                        $queryin = mysqli_query($koneksi, "SELECT * from transaksi_penjualan WHERE id_jual='$idtrace'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsin = mysqli_num_rows($queryin);
                        if ($rowsin <> 0) {
                        $datain = mysqli_fetch_assoc($queryin);
                        $id_pelanggan=$datain['id_pelanggan'];
                        $no_invoice=$datain['no_invoice'];
                        $tanggal=$datain['tanggal'];
                        $no_hp=$datain['no_hp'];
                        $nama_pelanggan=$datain['nama_pelanggan'];
                        $alamat=$datain['alamat'];
                    $pelanggan="$nama_pelanggan</br>$alamat</br$no_hp>";
                    } else{
                    $no_invoice="";
                    $tanggal="";
                    $alamat="";
                    $id_pelanggan="";
                    }  
                    ?>
                    <?php if($no_invoice==""){?>
                    <div align="center"><span class="text-danger">*
                    Transaksi Penjualan Pakai Pelanggan/Member silahkan isi Pelanggan </br>
                Apabila Non Member Biarkan Kosong</span></div>
                <?php }?>
                <form id="transaksi_penjualan-penjualan-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-inline needs-validation" action="<?php print_link("transaksi_penjualan/penjualan?csrf_token=$csrf_token&redirect=$current_page") ?>" method="post">    
                    <table class="table  table-striped table-sm text-left">
                        <tbody class="page-data" id="page-data-list-page-pncu8qemil7z">
                            <!--record-->
                            <tr>
                                <td align="left" width="100px">
                                    <table><tr><td> 
                                        <div class="form-group ">                  
                                            <label class="control-label" for="tanggal">Tanggal<span class="text-danger">*</span></label>
                                        </div>           
                                        <div class="input-group">     
                                            <?php
                                            if($tanggal==""){
                                            ?>
                                            <input id="ctrl-tanggal" class="form-control datepicker  datepicker" required="" value="<?php  echo $this->set_field_value('tanggal',datetime_now()); ?>" type="datetime"  name="tanggal" placeholder="Enter Tanggal" data-enable-time="true" data-min-date="" data-max-date="" data-date-format="Y-m-d H:i:S" data-alt-format="F j, Y - H:i" data-inline="false" data-no-calendar="false" data-mode="single" /> 
                                                <div class="input-group-append">
                                                    <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                </div>
                                                <?php
                                                }else{?>
                                                <input class="form-control " id="ctrl-tanggal" name="tanggal"  value="<?php echo $tanggal;?>" readonly/>                            <?php
                                                    }
                                                ?>   </div></td></tr></table>
                                            </td>
                                            <td align="right" width="200px">
                                                <table><tr><td> 
                                                    <div class="form-group ">                  
                                                        <label class="control-label" for="pelanggan">Pelanggan</label>
                                                    </div>           
                                                    <div class="input-group"> 
                                                        <?php 
                                                        if($no_invoice==""){
                                                        ?>
                                                        <select data-endpoint="<?php print_link('api/json/pelanggan_nama_pelanggan_option_list') ?>" id="ctrl-nama_pelanggan" name="nama_pelanggan"  placeholder="Select a value ..."    class="selectize-ajax" >
                                                            <option value="">Select a value ...</option>
                                                        </select> <?php }else{ 
                                                        if($alamat==""){
                                                    echo "Non Pelanggan</br>"; 
                                                    ?>
                                                    <a class="btn btn-sm btn-info has-tooltip page-modal" title="Ganti Pelanggan" href="<?php print_link("transaksi_penjualan/pelanggan?csrf_token=$csrf_token&redirect=$current_page"); ?>">
                                                        <i class="fa fa-edit"></i> Ganti Pelanggan
                                                    </a> 
                                                    <input type="hidden" id="ctrl-tanggal" name="nama_pelanggan"  value="" readonly/>                    
                                                    <?php }else{
                                                    $queryi = mysqli_query($koneksi, "SELECT * from pelanggan WHERE id_pelanggan='$id_pelanggan'")
                                                    or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                                                    $rowsi = mysqli_num_rows($queryi);
                                                    if ($rowsi <> 0) {
                                                    $datai = mysqli_fetch_assoc($queryi);
                                                    $id=$datai['id'];
                                                    }            echo $pelanggan;           
                                                    ?>  
                                                    <input type="hidden" name="nama_pelanggan"  value="<?php echo $id;?>" readonly/>
                                                        <?php } } ?>            
                                                    </div>
                                                </td></tr></table>
                                            </td>
                                        </tr>
                                        <!--endrecord-->
                                    </tbody>
                                    <tbody class="search-data" id="search-data-list-page-pncu8qemil7z"></tbody>
                                </table>
                            </div>
                            </div><div class=""><div><?php
                            $queryt = mysqli_query($koneksi, "SELECT sum(total_harga) as tot from transaksi_penjualan WHERE id_jual='$idtrace'")
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
                                                    <td>
                                                        <b>Invoice</b> 
                                                    </td>
                                                    <td>
                                                        <?php if($no_invoice==""){
                                                        ?>
                                                        <input class="form-control "  id="ctrl-no_invoice" name="no_invoice"  placeholder="No Invoice" value="0" readonly/>
                                                        <?php
                                                        }else{
                                                        ?>
                                                        <input class="form-control "  id="ctrl-no_invoice" name="no_invoice"  placeholder="No Invoice" value="<?php echo $no_invoice;?>" readonly/>
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
                                                        <td>
                                                            <h1><b>Total</b></h1>
                                                        </td>
                                                        <td><h1><b>Rp. <?php echo number_format($totharga,0,",",".");?></b></h1>
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
                        <div  class=" animated fadeIn page-content">
                            <div>
                                <table class="table  table-striped table-sm text-left">
                                    <tr>
                                        <td>
                                            <div class="form-group ">
                                                <label class="control-label" for="cari">Cari Kode/Nama Barang / (Barcode)</label>
                                                <div id="ctrl-nama_barang" class=""> 
                                                    <input type="text" id="search" placeholder="Cari Barang / (Barcode)" name="nama_barang" class="form-control " required=""/> 
                                                </div>
                                            </div>   
                                        </td>                
                                        <td>
                                            <div class="form-group ">
                                                <label class="control-label" for="jumlah">Jumlah <span class="text-danger">*</span></label>
                                                <div id="ctrl-jumlah-holder" class=""> 
                                                    <input id="ctrl-jumlah"  value="1" type="number" placeholder="Enter Jumlah" step="1"  required="" name="jumlah"  class="form-control " />
                                                </div>
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
                                </tr>
                            </table>
                        </form>
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
                            url: "<?php print_link("caridatasetok.php") ?>",
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
                        <table class="table  table-striped table-sm text-left">
                            <thead class="table-header bg-success text-dark">   
                                <tr>
                                    <th  class="td-kode_barang"> Kode Barang</th>
                                    <th  class="td-nama_barang"> Nama Barang</th>
                                    <th  class="td-jumlah"> Jumlah</th>
                                    <th  class="td-harga"> Harga</th>
                                    <th  class="td-diskon"> Diskon</th>
                                    <th  class="td-ppn"> Ppn</th>
                                    <th  class="td-total_harga"> Total Harga</th>
                                    <th class="td-btn"></th>
                                </tr>
                            </thead>                             
                            <!--record-->
                            <?php
                            $query = mysqli_query($koneksi, "select * from transaksi_penjualan where id_jual='$idtrace'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                            // ambil jumlah baris data hasil query
                            $rows = mysqli_num_rows($query);
                            if ($rows <> 0) {
                            while ($row=mysqli_fetch_array($query)){
                            $id_transaksi_penjualan=$row['id_transaksi_penjualan'];
                            $kode_barang=$row['kode_barang'];
                            $nama_barang=$row['nama_barang'];
                            $jumlah=$row['jumlah'];
                            $harga=$row['harga'];
                            $diskon=$row['diskon'];
                            $ppn=$row['ppn'];
                            $total_harga=$row['total_harga'];
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
                                <td class="td-harga"><?php echo $harga;?></td>
                                <td class="td-diskon"><?php echo $diskon;?></td>
                                <td class="td-ppn"><?php echo $ppn;?></td>
                                <td class="td-total_harga"><?php echo $total_harga;?></td>
                                <th class="td-btn">
                                    <a class="btn btn-sm btn-info has-tooltip page-modal" title="Edit This Record" href="<?php print_link("transaksi_penjualan/edit/$id_transaksi_penjualan"); ?>">
                                        <i class="fa fa-edit"></i> Edit
                                    </a>                 
                                    <a class="btn btn-sm btn-danger has-tooltip record-delete-btn" title="Delete this record" href="<?php print_link("transaksi_penjualan/delete/$id_transaksi_penjualan/?csrf_token=$csrf_token&redirect=$current_page"); ?>" data-prompt-msg="Are you sure you want to delete this record?" data-display-style="modal">
                                        <i class="fa fa-times"></i>
                                        Delete
                                    </a>
                                </th>
                            </tr>
                            <?php
                            }
                            }
                            ?>
                            <!--endrecord-->
                            <tbody class="search-data" id="search-data-list-page-xr7t1upbsjod"></tbody>
                        </table>   
                    </div>
                    <div class=""><div> <form name="proses" id="proses" method="post" action="<?php print_link("transaksi_penjualan/proses?csrf_token=$csrf_token&redirect=$current_page") ?>">
                        <?php if($no_invoice==""){
                        }else{
                        ?>
                        <input class="form-control "  id="ctrl-no_invoice" name="no_invoice"  placeholder="No Invoice" value="<?php echo $no_invoice;?>" type="hidden"/>
                            <?php   
                            }
                            ?>   
                            <table class="table  table-striped table-sm text-left">
                                <tbody class="page-data" id="page-data-list-page-pncu8qemil7z">
                                    <!--record-->
                                    <tr>
                                        <td align="left" width="200px">
                                        </td>
                                        <td align="right" width="300px">
                                            <table>
                                                <tr>
                                                    <td>
                                                    </td>
                                                    <td>
                                                        <div class="form-ajax-status"></div>
                                                        <?php if ($totharga=="" or $totharga=="0"){}else{?>
                                                        <a class="btn btn-sm btn-info" onclick="prosestrx();" style="color: #fff;">
                                                            <i class="fa fa-send"></i> Proses Penjualan
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
                        var result = confirm("Proses Penjualam?");
                        if (result == true) {
                        //document.getElementById('autobtn').click();
                        document.getElementById("proses").submit();
                        return true;
                        }
                        else {
                        return false;
                        }
                        }
                        function startCalc(){
                        interval = setInterval("calc()",1);}
                        function calc(){
                        satu = document.proses.bayar.value;
                        dua = document.proses.totalall.value; 
                        //tiga = document.formid.total.value; 
                        document.proses.kembalian.value = (satu * 1) - (dua * 1);}
                        function stopCalc(){
                        clearInterval(interval);}
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
</section>
