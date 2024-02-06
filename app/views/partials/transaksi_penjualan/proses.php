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
                    <h4 class="record-title">Proses Penjualan</h4>
                    <div class=""><div>
                        <?php
                        if(isset($_POST['no_invoice'])){
                        $usrnam  = "".USER_NAME;
                        $id_user = "".USER_ID;
                        $dbhost  = "".DB_HOST;
                        $dbuser  = "".DB_USERNAME;
                        $dbpass  = "".DB_PASSWORD;
                        $dbname  = "".DB_NAME;
                        $koneksi = new mysqli($dbhost, $dbuser,$dbpass, $dbname);
                        $idtrace = "$id_user$usrnam";
                        $no_invoice=$_POST['no_invoice'];
                        $bayar=$_POST['bayar'];
                        $kembalian=$_POST['kembalian'];
                        $queryin = mysqli_query($koneksi, "SELECT * from transaksi_penjualan WHERE id_jual='$idtrace'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $totbeli="0";                            
                        while ($row=mysqli_fetch_array($queryin)){
                        mysqli_query($koneksi,"INSERT INTO `data_penjualan` (`divisi`,`bagian`,`trx`,`id_penjualan`,`id_pelanggan`,`tanggal`,`nama_pelanggan`,`alamat`,`no_hp`,`kode_barang`,`nama_barang`,`jumlah`,`harga`,`total_harga`,`diskon`,`total_bayar`,`ppn`,`operator`,`id_jual`) VALUES ('FARMASI','FARMASI','Jual','".$row['id_penjualan']."','".$row['id_pelanggan']."','".$row['tanggal']."','".$row['nama_pelanggan']."','".$row['alamat']."','".$row['no_hp']."','".$row['kode_barang']."','".$row['nama_barang']."','".$row['jumlah']."','".$row['harga']."','".$row['total_harga']."','".$row['diskon']."','".$row['total_bayar']."','".$row['ppn']."','$id_user','$no_invoice')");
                        $querybeli = mysqli_query($koneksi, "SELECT harga_beli from setok_barang WHERE id_barang='".$row['id_barang']."'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        while ($dabeli=mysqli_fetch_array($querybeli)){
                        $subbeli=$dabeli['harga_beli'] * $row['jumlah'];
                        }
                        $totbeli=$totbeli + $subbeli;
                        }                               
                        $queryjum = mysqli_query($koneksi, "SELECT SUM(jumlah) AS jum, SUM(total_harga) AS hall from transaksi_penjualan WHERE id_jual='$idtrace'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $sumjum = mysqli_fetch_assoc($queryjum); 
                        $untung=$sumjum['hall'] - $totbeli;
                        mysqli_query($koneksi, "UPDATE penjualan SET id_jual='$no_invoice', kembalian='$kembalian', bayar='$bayar', total_untung='$untung', operator='$id_user', total_jumlah='".$sumjum['jum']."', setatus='Register', total_harga_beli='$totbeli', total_harga_jual='".$sumjum['hall']."' WHERE no_invoice='$no_invoice'");
                        ///////////////////////////////////////////////////////////////////////////////////////////////
                        /*
                        $tanggaltrx    = $_POST['tanggal_transaksi'];
                        $type_transaksi=$_POST['type_transaksi'];
                        $siatag=$_POST['bayar'] - $_POST['kembalian'];
                        $keterangan="Pembayaran Invoice $no_invoice";
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
                        $keterangan="Pembayaran No Invoice $no_invoice";
                        mysqli_query($koneksi, "INSERT INTO `kas`(`tanggal`, `debet`, `keterangan`, `saldo`, `kasir`, `setatus`, `transaksi`, `saldo_cash`) VALUES ('$tanggaltrx','$siatag','$keterangan','$saldoahir','$id_user','Register','$type_transaksi','$saldocash')"); 
                        */
                        mysqli_query($koneksi, "DELETE FROM transaksi_penjualan WHERE id_jual='$idtrace'");     
                        ?>
                        <script language="JavaScript">
                            alert('Proses Penjualan Berhasil!!');
                            document.location='<?php print_link("transaksi_penjualan/penjualan"); ?>';
                        </script>
                        <?php 
                        }
                        ?>
                    </div>
                </div>
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
                    <form id="transaksi_penjualan-proses-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("transaksi_penjualan/proses?csrf_token=$csrf_token") ?>" method="post">
                        <div>
                            <div class="form-group ">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <label class="control-label" for="id_penjualan">Id Penjualan <span class="text-danger">*</span></label>
                                    </div>
                                    <div class="col-sm-8">
                                        <div class="">
                                            <input id="ctrl-id_penjualan"  value="<?php  echo $this->set_field_value('id_penjualan',""); ?>" type="text" placeholder="Enter Id Penjualan"  required="" name="id_penjualan"  class="form-control " />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group ">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="control-label" for="id_pelanggan">Id Pelanggan <span class="text-danger">*</span></label>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="">
                                                <input id="ctrl-id_pelanggan"  value="<?php  echo $this->set_field_value('id_pelanggan',""); ?>" type="text" placeholder="Enter Id Pelanggan"  required="" name="id_pelanggan"  class="form-control " />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group ">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="control-label" for="tanggal">Tanggal <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <input id="ctrl-tanggal" class="form-control datepicker  datepicker" required="" value="<?php  echo $this->set_field_value('tanggal',""); ?>" type="datetime"  name="tanggal" placeholder="Enter Tanggal" data-enable-time="true" data-min-date="" data-max-date="" data-date-format="Y-m-d H:i:S" data-alt-format="F j, Y - H:i" data-inline="false" data-no-calendar="false" data-mode="single" /> 
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
                                                    <label class="control-label" for="nama_pelanggan">Nama Pelanggan <span class="text-danger">*</span></label>
                                                </div>
                                                <div class="col-sm-8">
                                                    <div class="">
                                                        <input id="ctrl-nama_pelanggan"  value="<?php  echo $this->set_field_value('nama_pelanggan',""); ?>" type="text" placeholder="Enter Nama Pelanggan"  required="" name="nama_pelanggan"  class="form-control " />
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
                                                                <label class="control-label" for="kode_barang">Kode Barang <span class="text-danger">*</span></label>
                                                            </div>
                                                            <div class="col-sm-8">
                                                                <div class="">
                                                                    <input id="ctrl-kode_barang"  value="<?php  echo $this->set_field_value('kode_barang',""); ?>" type="text" placeholder="Enter Kode Barang"  required="" name="kode_barang"  class="form-control " />
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group ">
                                                            <div class="row">
                                                                <div class="col-sm-4">
                                                                    <label class="control-label" for="nama_barang">Nama Barang <span class="text-danger">*</span></label>
                                                                </div>
                                                                <div class="col-sm-8">
                                                                    <div class="">
                                                                        <input id="ctrl-nama_barang"  value="<?php  echo $this->set_field_value('nama_barang',""); ?>" type="text" placeholder="Enter Nama Barang"  required="" name="nama_barang"  class="form-control " />
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group ">
                                                                <div class="row">
                                                                    <div class="col-sm-4">
                                                                        <label class="control-label" for="jumlah">Jumlah <span class="text-danger">*</span></label>
                                                                    </div>
                                                                    <div class="col-sm-8">
                                                                        <div class="">
                                                                            <input id="ctrl-jumlah"  value="<?php  echo $this->set_field_value('jumlah',""); ?>" type="number" placeholder="Enter Jumlah" step="1"  required="" name="jumlah"  class="form-control " />
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
                                                                                <input id="ctrl-harga"  value="<?php  echo $this->set_field_value('harga',""); ?>" type="number" placeholder="Enter Harga" step="1"  required="" name="harga"  class="form-control " />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group ">
                                                                        <div class="row">
                                                                            <div class="col-sm-4">
                                                                                <label class="control-label" for="total_harga">Total Harga <span class="text-danger">*</span></label>
                                                                            </div>
                                                                            <div class="col-sm-8">
                                                                                <div class="">
                                                                                    <input id="ctrl-total_harga"  value="<?php  echo $this->set_field_value('total_harga',""); ?>" type="number" placeholder="Enter Total Harga" step="1"  required="" name="total_harga"  class="form-control " />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group ">
                                                                            <div class="row">
                                                                                <div class="col-sm-4">
                                                                                    <label class="control-label" for="diskon">Diskon <span class="text-danger">*</span></label>
                                                                                </div>
                                                                                <div class="col-sm-8">
                                                                                    <div class="">
                                                                                        <input id="ctrl-diskon"  value="<?php  echo $this->set_field_value('diskon',""); ?>" type="number" placeholder="Enter Diskon" step="1"  required="" name="diskon"  class="form-control " />
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                            <div class="form-group ">
                                                                                <div class="row">
                                                                                    <div class="col-sm-4">
                                                                                        <label class="control-label" for="total_bayar">Total Bayar <span class="text-danger">*</span></label>
                                                                                    </div>
                                                                                    <div class="col-sm-8">
                                                                                        <div class="">
                                                                                            <input id="ctrl-total_bayar"  value="<?php  echo $this->set_field_value('total_bayar',""); ?>" type="number" placeholder="Enter Total Bayar" step="1"  required="" name="total_bayar"  class="form-control " />
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="form-group ">
                                                                                    <div class="row">
                                                                                        <div class="col-sm-4">
                                                                                            <label class="control-label" for="ppn">Ppn <span class="text-danger">*</span></label>
                                                                                        </div>
                                                                                        <div class="col-sm-8">
                                                                                            <div class="">
                                                                                                <input id="ctrl-ppn"  value="<?php  echo $this->set_field_value('ppn',""); ?>" type="number" placeholder="Enter Ppn" step="1"  required="" name="ppn"  class="form-control " />
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="form-group ">
                                                                                        <div class="row">
                                                                                            <div class="col-sm-4">
                                                                                                <label class="control-label" for="nama_poli">Nama Poli <span class="text-danger">*</span></label>
                                                                                            </div>
                                                                                            <div class="col-sm-8">
                                                                                                <div class="">
                                                                                                    <input id="ctrl-nama_poli"  value="<?php  echo $this->set_field_value('nama_poli',""); ?>" type="text" placeholder="Enter Nama Poli"  required="" name="nama_poli"  class="form-control " />
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="form-group ">
                                                                                            <div class="row">
                                                                                                <div class="col-sm-4">
                                                                                                    <label class="control-label" for="operator">Operator <span class="text-danger">*</span></label>
                                                                                                </div>
                                                                                                <div class="col-sm-8">
                                                                                                    <div class="">
                                                                                                        <input id="ctrl-operator"  value="<?php  echo $this->set_field_value('operator',""); ?>" type="number" placeholder="Enter Operator" step="1"  required="" name="operator"  class="form-control " />
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div>
                                                                                            <div class="form-group ">
                                                                                                <div class="row">
                                                                                                    <div class="col-sm-4">
                                                                                                        <label class="control-label" for="date_created">Date Created <span class="text-danger">*</span></label>
                                                                                                    </div>
                                                                                                    <div class="col-sm-8">
                                                                                                        <div class="input-group">
                                                                                                            <input id="ctrl-date_created" class="form-control datepicker  datepicker" required="" value="<?php  echo $this->set_field_value('date_created',""); ?>" type="datetime"  name="date_created" placeholder="Enter Date Created" data-enable-time="true" data-min-date="" data-max-date="" data-date-format="Y-m-d H:i:S" data-alt-format="F j, Y - H:i" data-inline="false" data-no-calendar="false" data-mode="single" /> 
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
                                                                                                            <label class="control-label" for="date_updated">Date Updated <span class="text-danger">*</span></label>
                                                                                                        </div>
                                                                                                        <div class="col-sm-8">
                                                                                                            <div class="input-group">
                                                                                                                <input id="ctrl-date_updated" class="form-control datepicker  datepicker" required="" value="<?php  echo $this->set_field_value('date_updated',""); ?>" type="datetime"  name="date_updated" placeholder="Enter Date Updated" data-enable-time="true" data-min-date="" data-max-date="" data-date-format="Y-m-d H:i:S" data-alt-format="F j, Y - H:i" data-inline="false" data-no-calendar="false" data-mode="single" /> 
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
                                                                                                                <label class="control-label" for="id_jual">Id Jual <span class="text-danger">*</span></label>
                                                                                                            </div>
                                                                                                            <div class="col-sm-8">
                                                                                                                <div class="">
                                                                                                                    <input id="ctrl-id_jual"  value="<?php  echo $this->set_field_value('id_jual',""); ?>" type="text" placeholder="Enter Id Jual"  required="" name="id_jual"  class="form-control " />
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
                                                                                                                        <input id="ctrl-no_invoice"  value="<?php  echo $this->set_field_value('no_invoice',""); ?>" type="text" placeholder="Enter No Invoice"  required="" name="no_invoice"  class="form-control " />
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                            </div>
                                                                                                            <div class="form-group ">
                                                                                                                <div class="row">
                                                                                                                    <div class="col-sm-4">
                                                                                                                        <label class="control-label" for="id_barang">Id Barang <span class="text-danger">*</span></label>
                                                                                                                    </div>
                                                                                                                    <div class="col-sm-8">
                                                                                                                        <div class="">
                                                                                                                            <input id="ctrl-id_barang"  value="<?php  echo $this->set_field_value('id_barang',""); ?>" type="number" placeholder="Enter Id Barang" step="1"  required="" name="id_barang"  class="form-control " />
                                                                                                                            </div>
                                                                                                                        </div>
                                                                                                                    </div>
                                                                                                                </div>
                                                                                                                <div class="form-group ">
                                                                                                                    <div class="row">
                                                                                                                        <div class="col-sm-4">
                                                                                                                            <label class="control-label" for="id_data_setok">Id Data Setok <span class="text-danger">*</span></label>
                                                                                                                        </div>
                                                                                                                        <div class="col-sm-8">
                                                                                                                            <div class="">
                                                                                                                                <input id="ctrl-id_data_setok"  value="<?php  echo $this->set_field_value('id_data_setok',""); ?>" type="number" placeholder="Enter Id Data Setok" step="1"  required="" name="id_data_setok"  class="form-control " />
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
