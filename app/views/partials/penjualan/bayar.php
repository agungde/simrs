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
    <div  class="bg-light p-3 mb-3">
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
                        if(!empty($_GET['precord'])){
                        $noinvoice= $_GET['precord'];
                        $queryp = mysqli_query($koneksi, "SELECT * FROM penjualan
                        WHERE no_invoice='$noinvoice' and setatus='Register'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        // ambil jumlah baris data hasil query
                        $rowsp = mysqli_num_rows($queryp);
                        // cek hasil query
                        // jika data "no_antrian" ada
                        if ($rowsp <> 0) {
                        // ambil data hasil query
                        $datap = mysqli_fetch_assoc($queryp);
                        // buat variabel untuk menampilkan data
                        $id_penjualan = $datap['id_penjualan']; 
                        $tanggal = $datap['tanggal']; 
                        $totalharga = $datap['total_harga_jual']; 
                        // $tanggal = $datap['tanggal']; 
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses Data Tidak Valid');
                            document.location='<?php print_link(""); ?>';
                        </script>
                        <?php      
                        }
                        }else{
                        if(isset($_POST['noinvoice'])){   
                        $noinvoice=$_POST['noinvoice'];
                        $id_penjualan=$_POST['id_penjualan'];
                        ///////////////////////////////////////////////////////////////////////////////////////////////
                        $tanggaltrx    = $_POST['tanggal_transaksi'];
                        $type_transaksi=$_POST['type_transaksi'];
                        $siatag=$_POST['bayar'] - $_POST['kembalian'];
                        $keterangan="Pembayaran Invoice $noinvoice";
                        $queryn = mysqli_query($koneksi, "SELECT * FROM `kas` where transaksi='2' ORDER BY `id` DESC")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsn = mysqli_num_rows($queryn);
                        if ($rowsn <> 0) {
                        $datacekn= mysqli_fetch_assoc($queryn);
                        $saldoawaln = $datacekn['saldo_cash'];
                        }else{
                        $saldoawaln = "0";
                        }
                        if($type_transaksi==2){
                        $saldocash=$saldoawaln + $siatag;
                        }else{
                        $saldocash="0";
                        }
                        $query = mysqli_query($koneksi, "SELECT * FROM `kas` ORDER BY `id` DESC")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rows = mysqli_num_rows($query);
                        if ($rows <> 0) {
                        $datacek= mysqli_fetch_assoc($query);
                        $saldoawal = $datacek['saldo'];
                        }else{
                        $saldoawal = "0";
                        }
                        $saldoahir = $saldoawal + $siatag;
                        $keterangan="Pembayaran No Invoice $noinvoice";
                        mysqli_query($koneksi, "INSERT INTO `kas`(`tanggal`, `debet`, `keterangan`, `saldo`, `kasir`, `setatus`, `transaksi`, `saldo_cash`) VALUES ('$tanggaltrx','$siatag','$keterangan','$saldoahir','$id_user','Register','$type_transaksi','$saldocash')"); 
                        mysqli_query($koneksi, "UPDATE penjualan
                        SET setatus='Closed', date_updated='".date("Y-m-d H:i:s")."' 
                        WHERE id_penjualan='$id_penjualan'")
                        or die('Ada kesalahan pada query update : ' . mysqli_error($koneksi));
                        mysqli_query($koneksi, "UPDATE data_penjualan
                        SET setatus='Slosed', date_updated='".date("Y-m-d H:i:s")."' 
                        WHERE id_penjualan='$id_penjualan")
                        or die('Ada kesalahan pada query update : ' . mysqli_error($koneksi));                                     
                        ?>
                        <script language="JavaScript">
                            alert('Proses Bayar Berhasil');
                            document.location='<?php print_link("penjualan/bayar"); ?>';
                        </script>
                        <?php 
                        }   
                        ?>
                        <script language="JavaScript">
                            alert('Dilarang Akses');
                            document.location='<?php print_link(""); ?>';
                        </script>
                        <?php      
                        }
                        ?>
                    </div>
                </div><h4 class="record-title">Pembayaran Penjualan Resep Luar</h4>
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
                            </tr>
                        </thead>                             
                        <!--record-->
                        <?php
                        $query = mysqli_query($koneksi, "select * from data_penjualan where id_penjualan='$id_penjualan'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        // ambil jumlah baris data hasil query
                        $rows = mysqli_num_rows($query);
                        if ($rows <> 0) {
                        while ($row=mysqli_fetch_array($query)){
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
                        </tr>
                        <?php
                        }
                        }
                        ?>
                        <!--endrecord-->
                        <tbody class="search-data" id="search-data-list-page-xr7t1upbsjod"></tbody>
                    </table>
                    <form  name="proses" id="proses"  role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("penjualan/bayar?csrf_token=$csrf_token") ?>" method="post"><input type="hidden" name="noinvoice" value="<?php echo $noinvoice;?>"><input type="hidden" name="id_penjualan" value="<?php echo $id_penjualan;?>">
                        <div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="tanggal">Tanggal <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input id="ctrl-tanggal"  value="<?php echo $tanggal;?>" type="text" placeholder="Enter Tanggal"  readonly required="" name="tanggal"  class="form-control " />
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
                                            <label class="control-label" for="no_invoice">No Invoice <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="ctrl-no_invoice"  value="<?php echo $noinvoice;?>" type="text" placeholder="Enter No Invoice"  readonly required="" name="no_invoice"  class="form-control " />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="total_harga_jual">Total Harga <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <input onFocus="startCalc();" onBlur="stopCalc();" id="ctrl-total_harga_jual"  value="<?php echo $totalharga;?>" type="number" placeholder="Enter Total Harga" step="1"  readonly required="" name="total_harga_jual"  class="form-control " />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-group ">
                                            <div class="row">
                                                <div class="col-sm-4">
                                                    <label class="control-label" for="bayar">Bayar <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="">
                                                        <input onFocus="startCalc();" onBlur="stopCalc();" id="ctrl-bayar"  value="<?php  echo $this->set_field_value('bayar',""); ?>" type="number" placeholder="Enter Bayar" step="1"  required="" name="bayar"  class="form-control " />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label class="control-label" for="kembalian">Kembalian <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="">
                                                            <input onFocus="startCalc();" onBlur="stopCalc();" id="ctrl-kembalian"  value="<?php  echo $this->set_field_value('kembalian',""); ?>" type="number" placeholder="Enter Kembalian" step="1"  readonly required="" name="kembalian"  class="form-control " />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label class="control-label" for="type_transaksi">Type Transaksi<span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="">
                                                                <select required=""  id="ctrl-type_transaksi" name="type_transaksi"  placeholder="Select Transaksi..."    class="custom-select" >
                                                                    <option value="">Select Transaksi...</option>
                                                                    <option value="2" >Cash</option>  
                                                                    <option value="0" >Transfer / Debet (Non Cash)</option>
                                                                </select>                  
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>                            
                                                <div class="form-group ">
                                                    <div class="row">
                                                        <div class="col-sm-4">
                                                            <label class="control-label" for="tanggal_transaksi">Tanggal Transaksi<span class="text-danger">*</span></label>
                                                        </div>
                                                        <div class="col-sm-8">
                                                            <div class="input-group">
                                                                <input id="ctrl-tanggal_transaksi" class="form-control datepicker  datepicker"  required="" value="<?php  echo $this->set_field_value('tanggal_transaksi',date_now()); ?>" type="datetime" name="tanggal_transaksi" placeholder="Enter Tanggal" data-enable-time="false" data-min-date="" data-max-date="" data-date-format="Y-m-d" data-alt-format="F j, Y" data-inline="false" data-no-calendar="false" data-mode="single" />
                                                                    <div class="input-group-append">
                                                                        <span class="input-group-text"><i class="fa fa-calendar"></i></span>
                                                                    </div>
                                                                </div> 
                                                            </div>
                                                        </div>
                                                    </div>                          
                                                </div>
                                                <div class="form-group form-submit-btn-holder text-center mt-3">
                                                    <div class="form-ajax-status"></div>
                                                    <button class="btn btn-primary" type="button" onclick="prosestrx();" >
                                                        Proses Bayar
                                                        <i class="fa fa-send"></i>
                                                    </button>
                                                </div>
                                            </form>
                                            <script>
                                                function prosestrx() {
                                                let x = document.forms["proses"]["bayar"].value;
                                                let b = document.forms["proses"]["type_transaksi"].value;
                                                if (x == "") {
                                                alert("Bayar Dulu!!");
                                                return false;
                                                }
                                                if (b == "") {
                                                alert("Silahkan Pilih Type Transaksi!!");
                                                return false;
                                                }
                                                var result = confirm("Proses Pembayaran?");
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
                                                dua = document.proses.total_harga_jual.value; 
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
