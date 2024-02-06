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
                    <h4 class="record-title">Add New Transaksi Pembelian</h4>
                    <div class="">    <?php
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
                        $queryin = mysqli_query($koneksi, "SELECT * from transaksi_pembelian WHERE idtrace='$idtrace'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        while ($row=mysqli_fetch_array($queryin)){
                        if($row['type_pembelian']=="Langsung"){
                        $setatus="Closed";
                        }else{
                        $setatus="Pending";
                        }
                        ///////////////////////////////////////////////
                        if($row['databarang']=="True"){
                        $queryc = mysqli_query($koneksi, "SELECT * from category_barang where id='".$row['category_barang']."'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsc = mysqli_num_rows($queryc);
                        if ($rowsc <> 0) {
                        $datac        = mysqli_fetch_assoc($queryc);
                        $category=$datac['category'];
                        $categ  = substr($category, 0, 2);
                        }
                        $categ=strtoupper("$categ");
                        $query = mysqli_query($koneksi, "SELECT * from data_barang where nama_barang='".$row['nama_barang']."'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rows = mysqli_num_rows($query);
                        if ($rows <> 0) {
                        $data        = mysqli_fetch_assoc($query);
                        }else{
                        mysqli_query($koneksi,"INSERT INTO `data_barang` (`operator`,`nama_barang`,`satuan`,`category_barang`) VALUES ('$id_user','".$row['nama_barang']."','".$row['satuan']."','".$row['category_barang']."')"); 
                        $queryd = mysqli_query($koneksi, "SELECT * from data_barang where nama_barang='".$row['nama_barang']."'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsd = mysqli_num_rows($queryd);
                        if ($rowsd <> 0) {
                        $datad        = mysqli_fetch_assoc($queryd);
                        $id_barang=$datad['id_barang'];
                        } 
                        if($row['kode_barang']=="Auto") {
                        $kode="DT$categ$id_barang"; 
                        }else{
                        $kode= $row['kode_barang'];
                        }
                        $harga=$row['harga_beli'];
                        $hargajual=$harga * 20 / 100;
                        $jual=$hargajual + $harga;
                        mysqli_query($koneksi, "UPDATE data_barang SET kode_barang='$kode' WHERE id_barang='$id_barang'"); 
                        mysqli_query($koneksi,"INSERT INTO `setok_barang` (`id_data`,`harga_beli`,`harga_jual`,`kode_barang`,`operator`,`nama_barang`,`satuan`,`category_barang`) VALUES ('$id_barang','$harga','$jual','$kode','$id_user','".$row['nama_barang']."','".$row['satuan']."','".$row['category_barang']."')"); 
                        }
                        }else{
                        $kode=$row['kode_barang'];
                        }
                        ////////////////////////////////////////////////
                        mysqli_query($koneksi,"INSERT INTO `data_pembelian`(`id_pembelian`, `type_pembelian`, `id_suplier`, `nama_suplier`, `tanggal_pembelian`, `kode_barang`, `nama_barang`, `jumlah`, `harga_beli`, `diskon`, `total_diskon`, `ppn`, `total_harga`, `tanggal_expired`, `no_invoice`, `operator`, `idtrace`, `setatus`) VALUES ('".$row['id_pembelian']."','".$row['type_pembelian']."','".$row['id_suplier']."','".$row['nama_suplier']."','".$row['tanggal_pembelian']."','$kode','".$row['nama_barang']."','".$row['jumlah']."','".$row['harga_beli']."','".$row['diskon']."','".$row['total_diskon']."','".$row['ppn']."','".$row['total_harga']."','".$row['tanggal_expired']."','".$row['no_invoice']."','$id_user','".$row['idtrace']."','$setatus')"); 
                        $queryst = mysqli_query($koneksi, "SELECT * from setok_barang where kode_barang='$kode'") or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $rowsst = mysqli_num_rows($queryst);
                        if ($rowsst <> 0) {
                        $datast        = mysqli_fetch_assoc($queryst);
                        $idsetok=$datast['id_barang'];
                        $jumawal=$datast['jumlah'];
                        }
                        $hargabeli=$row['harga_beli'];
                        $hargajual=$hargabeli * 20 / 100;
                        $jual=$hargajual + $hargabeli;
                        $jumplus=$jumawal + $row['jumlah'];
                        if($setatus=="Closed"){
                        mysqli_query($koneksi, "UPDATE setok_barang SET harga_beli='$hargabeli', harga_jual='$jual', jumlah='$jumplus' WHERE id_barang='$idsetok'"); 
                        }else{
                        mysqli_query($koneksi, "UPDATE setok_barang SET harga_beli='$hargabeli', harga_jual='$jual' WHERE id_barang='$idsetok'");  
                        }
                        $id_pembelian=$row['id_pembelian'];
                        //$category=$row['category'];
                        }
                        $queryjum = mysqli_query($koneksi, "SELECT SUM(total_diskon) AS totdis, SUM(jumlah) AS jum, SUM(total_harga) AS hall from transaksi_pembelian WHERE idtrace='$idtrace'")
                        or die('Ada kesalahan pada query tampil data : ' . mysqli_error($koneksi));
                        $sumjum = mysqli_fetch_assoc($queryjum); 
                        $totharall=$sumjum['hall'];
                        $totdisall=$sumjum['totdis'];
                        $totjumall=$sumjum['jum'];
                        mysqli_query($koneksi, "UPDATE pembelian SET operator='$id_user', total_jumlah='$totjumall', setatus='$setatus', total_harga_beli='$totharall', total_diskon='$totdisall' WHERE id_pembelian='$id_pembelian'");
                        mysqli_query($koneksi, "DELETE FROM transaksi_pembelian WHERE idtrace='$idtrace'");     
                        $categoryses=$_SESSION["category"];
                        $categoryses=strtolower($categoryses)
                        ?>
                        <script language="JavaScript">
                            alert('Pembelian Berhasil Di Proses');
                            document.location='<?php print_link("pembelian/$categoryses?trx=finished"); ?>';
                        </script>
                        <?php 
                        }else{
                        ?>
                        <script language="JavaScript">
                            alert('Di Larang Akses!!');
                            document.location='<?php print_link(""); ?>';
                        </script>
                        <?php  
                        }
                        ?>
                        <div></div>
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
                        <form id="transaksi_pembelian-proses-form" role="form" novalidate enctype="multipart/form-data" class="form page-form form-horizontal needs-validation" action="<?php print_link("transaksi_pembelian/proses?csrf_token=$csrf_token") ?>" method="post">
                            <div>
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
                                                <label class="control-label" for="satuan">Satuan <span class="text-danger">*</span></label>
                                            </div>
                                            <div class="col-sm-8">
                                                <div class="">
                                                    <input id="ctrl-satuan"  value="<?php  echo $this->set_field_value('satuan',""); ?>" type="text" placeholder="Enter Satuan"  required="" name="satuan"  class="form-control " />
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
                                                        <input id="ctrl-category_barang"  value="<?php  echo $this->set_field_value('category_barang',""); ?>" type="number" placeholder="Enter Category Barang" step="1"  required="" name="category_barang"  class="form-control " />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group ">
                                                <div class="row">
                                                    <div class="col-sm-4">
                                                        <label class="control-label" for="category">Category <span class="text-danger">*</span></label>
                                                    </div>
                                                    <div class="col-sm-8">
                                                        <div class="">
                                                            <input id="ctrl-category"  value="<?php  echo $this->set_field_value('category',""); ?>" type="text" placeholder="Enter Category"  required="" name="category"  class="form-control " />
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
